<?php

namespace App\Http\Controllers\Admin\Items;

use App\Http\Controllers\Controller;
use App\Jobs\SendBuyersItemUpdateNotification;
use App\Jobs\SendSubscribersNewItemNotification;
use App\Models\Category;
use App\Models\Item;
use App\Models\ItemChangeLog;
use App\Models\ItemComment;
use App\Models\ItemDiscount;
use App\Models\ItemReview;
use App\Models\ItemView;
use App\Models\Sale;
use App\Models\SubCategory;
use App\Models\UploadedFile;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Jenssegers\Date\Date;

class ItemController extends Controller
{
    private $imageMimeTypes = ['image/png', 'image/jpg', 'image/jpeg'];

    private $videoMimeTypes = ['video/mp4', 'video/webm'];

    private $audioMimeTypes = ['audio/mpeg', 'audio/wav'];

    public function index()
    {
        $categories = Category::all();

        $items = Item::query();

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $searchTermStart = request('search') . '%';

            $items->where(function ($query) use ($searchTerm, $searchTermStart) {
                $query->where('name', 'like', $searchTermStart)
                    ->orWhere(function ($query) use ($searchTerm) {
                        $query->where('id', 'like', $searchTerm)
                            ->orWhere('name', 'like', $searchTerm)
                            ->orWhere('slug', 'like', $searchTerm)
                            ->orWhere('description', 'like', $searchTerm)
                            ->orWhere('options', 'like', $searchTerm)
                            ->orWhere('demo_link', 'like', $searchTerm)
                            ->orWhere('tags', 'like', $searchTerm)
                            ->OrWhere('regular_price', 'like', $searchTerm)
                            ->OrWhere('extended_price', 'like', $searchTerm)
                            ->orWhereHas('category', function ($query) use ($searchTerm) {
                                $query->where('name', 'like', $searchTerm)
                                    ->OrWhere('slug', 'like', $searchTerm);
                            })
                            ->orWhereHas('subCategory', function ($query) use ($searchTerm) {
                                $query->where('name', 'like', $searchTerm)
                                    ->OrWhere('slug', 'like', $searchTerm);
                            });
                    });
            });
        }

        if (request()->filled('category')) {
            $items->where('category_id', request('category'));
        }

        $filteredItems = $items->get();
        $counters['videos'] = $filteredItems->where('preview_type', Item::PREVIEW_FILE_TYPE_AUDIO)->count();
        $counters['audios'] = $filteredItems->where('preview_type', Item::PREVIEW_FILE_TYPE_VIDEO)->count();
        $counters['others'] = $filteredItems->where('preview_type', Item::PREVIEW_FILE_TYPE_IMAGE)->count();

        if (isset($searchTermStart)) {
            $items->orderByRaw("CASE WHEN name LIKE ? THEN 1 ELSE 2 END", [$searchTermStart])->orderByDesc('id');
        } else {
            $items->orderByDesc('id');
        }

        $items = $items->paginate(50);
        $items->appends(request()->only(['search', 'category']));

        return view('admin.items.index', [
            'counters' => $counters,
            'categories' => $categories,
            'items' => $items,
        ]);
    }

    public function create()
    {
        $categories = Category::all();

        $category = Category::where('slug', request('category'))
            ->with(['subCategories', 'categoryOptions'])
            ->firstOrFail();

        $uploadedFiles = UploadedFile::where('category_id', $category->id)
            ->notExpired()->get();

        return view('admin.items.create', [
            'categories' => $categories,
            'category' => $category,
            'uploadedFiles' => $uploadedFiles,
        ]);
    }

    public function slug(Request $request)
    {
        $slug = null;
        if ($request->content != null) {
            $slug = SlugService::createSlug(Item::class, 'slug', $request->content);
        }
        return response()->json(['slug' => $slug]);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'block_patterns', 'unique:items', 'max:255'],
            'slug' => ['required', 'string', 'block_patterns', 'unique:items', 'max:255'],
            'description' => ['required'],
            'category' => ['required', 'string', 'exists:categories,id'],
            'sub_category' => ['nullable', 'string', 'exists:sub_categories,id'],
            'version' => ['nullable', 'string', 'max:100'],
            'demo_type' => ['required', 'string', 'in:' . implode(',', array_keys(Item::demoTypeOptions()))],
            'demo_link' => ['nullable', 'url', 'block_patterns'],
            'tags' => ['required', 'block_patterns'],
            'main_file_source' => ['required', 'string', 'in:' . implode(',', array_keys(Item::mainFileSourceOptions()))],
            'purchase_method' => ['required', 'integer', 'in:' . implode(',', array_keys(Item::purchaseMethodOptions()))],
        ];

        if ($request->main_file_source == Item::MAIN_FILE_SOURCE_EXTERNAL) {
            $rules['main_file'] = ['required', 'url'];
        }
        if (@settings('item')->support_status && $request->support == Item::SUPPORTED) {
            $rules['support_instructions'] = ['required'];
            $request->support = Item::SUPPORTED;

            if (supportPeriods()->count() < 1) {
                toastr()->error(translate('You do not have any support periods to support this item'));
                return back()->withInput();
            }
        } else {
            $request->support = Item::NOT_SUPPORTED;
            $request->support_instructions = null;
        }

        if (!$request->has('free_item')) {
            $rules['regular_license_price'] = ['required', 'numeric', 'min:0'];
            $rules['extended_license_price'] = ['nullable', 'numeric', 'min:0'];

            if ($request->regular_license_price == 0) {
                toastr()->error(translate('Regular license price must be greater than 0'));
                return back();
            }

            $request->extended_license_price = $request->extended_license_price == 0 ? null : $request->extended_license_price;
            $request->free_item = Item::NOT_FREE;
        } else {
            $request->free_item = Item::FREE;
            $request->regular_license_price = null;
            $request->extended_license_price = null;
        }

        if ($request->purchase_method == Item::PURCHASE_METHOD_EXTERNAL) {
            $rules['purchase_url'] = ['required', 'url'];
        } else {
            $request->purchase_url = null;
        }

        try {
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                foreach ($validator->errors()->all() as $error) {
                    toastr()->error($error);
                }
                return back()->withInput();
            }

            $category = Category::where('id', $request->category)->with('categoryOptions')->firstOrFail();
            $options = $this->handleItemOptions($request, $category);

            $subCategory = null;
            if ($request->filled('sub_category')) {
                $subCategory = SubCategory::where('id', $request->sub_category)
                    ->where('category_id', $category->id)->firstOrFail();
            }

            $itemFiles = $this->handleItemFiles($request, $category);
            $thumbnail = $itemFiles->thumbnail;
            $previewType = $itemFiles->preview_type;
            $previewImage = $itemFiles->preview_image;
            $previewVideo = $itemFiles->preview_video;
            $previewAudio = $itemFiles->preview_audio;
            $mainFile = $itemFiles->main_file;
            $screenshots = $itemFiles->screenshots;

            $itemFilesValues = collect([
                $itemFiles->thumbnail,
                $itemFiles->preview_type,
                $itemFiles->preview_image,
                $itemFiles->preview_video,
                $itemFiles->preview_audio,
                $itemFiles->main_file,
            ])->filter();

            if ($itemFilesValues->unique()->count() !== $itemFilesValues->count()) {
                toastr()->error(translate('You cannot use the same file in two different fields'));
                return back()->withInput();
            }

            if (!$request->filled('demo_link')) {
                $request->demo_type = null;
                $request->demo_link = null;
            }

            $request->status = ($request->has('status')) ? Item::STATUS_ACTIVE : Item::STATUS_DISABLED;

            $item = new Item();
            $item->name = $request->name;
            $item->slug = $request->slug;
            $item->description = $request->description;
            $item->category_id = $category->id;
            $item->sub_category_id = $subCategory ? $subCategory->id : null;
            $item->options = $options;
            $item->version = $request->version;
            $item->demo_type = $request->demo_type;
            $item->demo_link = $request->demo_link;
            $item->tags = $request->tags;
            $item->thumbnail = $thumbnail;
            $item->preview_type = $previewType;
            $item->preview_image = $previewImage;
            $item->preview_video = $previewVideo;
            $item->preview_audio = $previewAudio;
            $item->main_file = $mainFile;
            $item->main_file_source = $request->main_file_source;
            $item->screenshots = $screenshots;
            $item->regular_price = $request->regular_license_price;
            $item->extended_price = $request->extended_license_price;
            $item->is_supported = $request->support;
            $item->support_instructions = $request->support_instructions;
            $item->purchase_method = $request->purchase_method;
            $item->purchase_url = $request->purchase_url;
            $item->status = $request->status;
            $item->save();

            $this->handleFileDeletionAfterInsert($request);

            if ($request->has('subscribers_notification')) {
                dispatch(new SendSubscribersNewItemNotification($item));
            }

            toastr()->success(translate('Your item has been added successfully.'));
            return redirect()->route('admin.items.index');
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back()->withInput();
        }
    }

    public function edit(Item $item)
    {
        $categories = Category::all();
        $category = $item->category->load(['subCategories', 'categoryOptions']);

        $uploadedFiles = UploadedFile::where('category_id', $category->id)
            ->notExpired()->get();

        return view('admin.items.edit', [
            'item' => $item,
            'categories' => $categories,
            'category' => $category,
            'uploadedFiles' => $uploadedFiles,
        ]);
    }

    public function update(Request $request, Item $item)
    {
        $rules = [
            'name' => ['required', 'string', 'block_patterns', 'max:255', 'unique:items,name,' . $item->id],
            'slug' => ['required', 'string', 'block_patterns', 'max:255', 'unique:items,name,' . $item->id],
            'description' => ['required'],
            'sub_category' => ['nullable', 'string', 'exists:sub_categories,id'],
            'version' => ['nullable', 'string', 'max:100'],
            'demo_type' => ['required', 'string', 'in:' . implode(',', array_keys(Item::demoTypeOptions()))],
            'demo_link' => ['nullable', 'url', 'block_patterns'],
            'tags' => ['required', 'block_patterns'],
            'main_file_source' => ['required', 'string', 'in:' . implode(',', array_keys(Item::mainFileSourceOptions()))],
            'purchase_method' => ['required', 'integer', 'in:' . implode(',', array_keys(Item::purchaseMethodOptions()))],
        ];

        if ($request->main_file_source == Item::MAIN_FILE_SOURCE_EXTERNAL) {
            $rules['main_file'] = ['required', 'url'];
        }

        if (@settings('item')->support_status && $request->support == Item::SUPPORTED) {
            $rules['support_instructions'] = ['required'];
            $request->support = Item::SUPPORTED;

            if (supportPeriods()->count() < 1) {
                toastr()->error(translate('You do not have any support periods to support this item'));
                return back();
            }
        } else {
            $request->support = Item::NOT_SUPPORTED;
            $request->support_instructions = null;
        }

        if (!$item->hasDiscount()) {
            if (!$request->has('free_item')) {
                $rules['regular_license_price'] = ['required', 'numeric', 'min:0'];
                $rules['extended_license_price'] = ['nullable', 'numeric', 'min:0'];

                if ($request->regular_license_price == 0) {
                    toastr()->error(translate('Regular license price must be greater than 0'));
                    return back();
                }

                $request->extended_license_price = $request->extended_license_price == 0 ? null : $request->extended_license_price;
                $request->free_item = Item::NOT_FREE;
            } else {
                $request->free_item = Item::FREE;
                $request->regular_license_price = null;
                $request->extended_license_price = null;
            }
        } else {
            $request->free_item = Item::NOT_FREE;
            $request->regular_license_price = $item->regular_price;
            $request->extended_license_price = $item->extended_price;
        }

        if ($request->purchase_method == Item::PURCHASE_METHOD_EXTERNAL) {
            $rules['purchase_url'] = ['required', 'url'];
        } else {
            $request->purchase_url = null;
        }

        try {
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                foreach ($validator->errors()->all() as $error) {
                    toastr()->error($error);
                }
                return back()->withInput();
            }

            $category = $item->category->load('categoryOptions');
            $options = $this->handleItemOptions($request, $category);

            $subCategory = null;
            if ($request->filled('sub_category')) {
                $subCategory = SubCategory::where('id', $request->sub_category)
                    ->where('category_id', $category->id)->firstOrFail();
            }

            $itemFiles = $this->handleItemFiles($request, $category, false);
            $thumbnail = $itemFiles->thumbnail;
            $previewType = $itemFiles->preview_type;
            $previewImage = $itemFiles->preview_image;
            $previewVideo = $itemFiles->preview_video;
            $previewAudio = $itemFiles->preview_audio;
            $mainFile = $itemFiles->main_file;
            $screenshots = $itemFiles->screenshots;

            $itemFilesValues = collect([
                $itemFiles->thumbnail,
                $itemFiles->preview_type,
                $itemFiles->preview_image,
                $itemFiles->preview_video,
                $itemFiles->preview_audio,
                $itemFiles->main_file,
            ])->filter();

            if ($itemFilesValues->unique()->count() !== $itemFilesValues->count()) {
                toastr()->error(translate('You cannot use the same file in two different fields'));
                return back()->withInput();
            }

            if (!$request->filled('demo_link')) {
                $request->demo_type = null;
                $request->demo_link = null;
            }

            $request->status = ($request->has('status')) ? Item::STATUS_ACTIVE : Item::STATUS_DISABLED;

            $itemClone = clone $item;

            $item->name = $request->name;
            $item->slug = $request->slug;
            $item->description = $request->description;
            $item->sub_category_id = $subCategory ? $subCategory->id : null;
            $item->options = $options;
            $item->version = $request->version;
            $item->demo_type = $request->demo_type;
            $item->demo_link = $request->demo_link;
            $item->tags = $request->tags;

            if ($thumbnail) {
                $item->thumbnail = $thumbnail;
            }

            if ($previewImage) {
                $item->preview_image = $previewImage;
            }

            if ($previewVideo) {
                $item->preview_video = $previewVideo;
            }

            if ($previewAudio) {
                $item->preview_audio = $previewAudio;
            }

            if ($mainFile) {
                $item->main_file = $mainFile;
                $item->main_file_source = $request->main_file_source;
                $item->last_update_at = Carbon::now();
            }

            if ($screenshots) {
                $item->screenshots = $screenshots;
            }

            $item->regular_price = $request->regular_license_price;
            $item->extended_price = $request->extended_license_price;
            $item->is_supported = $request->support;
            $item->support_instructions = $request->support_instructions;
            $item->purchase_method = $request->purchase_method;
            $item->purchase_url = $request->purchase_url;
            $item->is_free = $request->free_item;
            $item->status = $request->status;
            $item->update();

            $this->handleFileDeletionAfterInsert($request, $itemClone);

            if ($request->has('update_notification')) {
                dispatch(new SendBuyersItemUpdateNotification($item));
            }

            toastr()->success(translate('Your item has been updated successfully'));
            return back();
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back()->withInput();
        }
    }

    public function changelogs(Item $item)
    {
        $changelogs = ItemChangeLog::where('item_id', $item->id)
            ->orderbyDesc('id')->paginate(10);

        return view('admin.items.changelogs', [
            'item' => $item,
            'changelogs' => $changelogs,
        ]);
    }

    public function changelogStore(Request $request, Item $item)
    {
        $validator = Validator::make($request->all(), [
            'version' => ['required', 'regex:/^\d+\.\d+(\.\d+)?$/', 'max:100'],
            'body' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        $changelogExists = ItemChangeLog::where('item_id', $item->id)
            ->where('version', $request->version)
            ->first();
        if ($changelogExists) {
            toastr()->error(translate('The changelog version already exists'));
            return back();
        }

        $changelog = new ItemChangeLog();
        $changelog->item_id = $item->id;
        $changelog->version = $request->version;
        $changelog->body = $request->body;
        $changelog->save();

        toastr()->success(translate('Created successfully'));
        return back();
    }

    public function changelogDelete(Item $item, ItemChangeLog $itemChangeLog)
    {
        abort_if($item->id != $itemChangeLog->item_id, 403);
        $itemChangeLog->delete();
        toastr()->success(translate('Deleted successfully'));
        return back();
    }

    public function discount(Item $item)
    {
        return view('admin.items.discount', [
            'item' => $item,
        ]);
    }

    public function discountStore(Request $request, Item $item)
    {
        abort_if($item->hasDiscount(), 403);

        $validator = Validator::make($request->all(), [
            'regular_percentage' => ['required', 'integer', 'min:1', 'max:90'],
            'extended_percentage' => ['nullable', 'integer', 'min:1', 'max:90'],
            'starting_date' => ['required', 'date'],
            'ending_date' => ['required', 'date'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        $startingDate = Carbon::parse($request->starting_date)->format('Y-m-d');
        $endingDate = Carbon::parse($request->ending_date)->format('Y-m-d');

        if ($startingDate < Carbon::now()->format('Y-m-d')) {
            toastr()->error(translate('The starting date cannot be in the past'));
            return back()->withInput();
        }

        if ($startingDate == $endingDate) {
            toastr()->error(translate('The discount cannot start and end at same day'));
            return back()->withInput();
        }

        $regularDiscountAmount = ($item->regular_price * $request->regular_percentage) / 100;
        $regularPrice = intval(ceil(($item->regular_price - $regularDiscountAmount)), 0);

        $extendedPrice = null;
        if ($request->filled('extended_percentage')) {
            $extendedDiscountAmount = ($item->extended_price * $request->extended_percentage) / 100;
            $extendedPrice = intval(ceil(($item->extended_price - $extendedDiscountAmount)), 0);
        }

        $discount = new ItemDiscount();
        $discount->item_id = $item->id;
        $discount->regular_percentage = $request->regular_percentage;
        $discount->regular_price = $regularPrice;
        $discount->extended_percentage = $request->extended_percentage ?? null;
        $discount->extended_price = $extendedPrice;
        $discount->starting_at = $startingDate;
        $discount->ending_at = $endingDate;

        if (Carbon::parse($startingDate)->isToday()) {
            $discount->status = ItemDiscount::STATUS_ACTIVE;
        }

        $discount->save();

        if ($discount->isActive()) {
            $item->is_on_discount = Item::DISCOUNT_ON;
            $item->update();
        }

        toastr()->success(translate('The discount has been created successfully'));
        return back();
    }

    public function discountDelete(Request $request, Item $item)
    {
        if ($item->hasDiscount()) {
            $item->discount->delete();
            toastr()->success(translate('The discount has been deleted successfully'));
        }

        return back();
    }

    public function reviews($id)
    {
        $item = Item::where('id', $id)->firstOrFail();

        $reviews = ItemReview::where('item_id', $id);

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $reviews->where('id', 'like', $searchTerm)
                ->OrWhere('body', 'like', $searchTerm)
                ->orWhereHas('user', function ($query) use ($searchTerm) {
                    $query->where('firstname', 'like', $searchTerm)
                        ->OrWhere('lastname', 'like', $searchTerm)
                        ->OrWhere('username', 'like', $searchTerm)
                        ->OrWhere('email', 'like', $searchTerm)
                        ->OrWhere('address', 'like', $searchTerm);
                });
        }

        $reviews = $reviews->with('user')->orderbyDesc('id')->paginate(10);
        $reviews->appends(request()->only(['search']));

        return view('admin.items.reviews', [
            'item' => $item,
            'reviews' => $reviews,
        ]);
    }

    public function reviewsDelete($id, $review_id)
    {
        $item = Item::where('id', $id)->firstOrFail();

        $review = ItemReview::where('id', $review_id)
            ->where('item_id', $id)
            ->firstOrFail();

        $review->delete();
        toastr()->success(translate('Deleted Successfully'));
        return back();
    }

    public function comments($id)
    {
        $item = Item::where('id', $id)->firstOrFail();

        $comments = ItemComment::where('item_id', $id);

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $comments->where('id', 'like', $searchTerm)
                ->orWhereHas('replies', function ($query) use ($searchTerm) {
                    $query->where('id', 'like', $searchTerm)
                        ->OrWhere('body', 'like', $searchTerm);
                })
                ->orWhereHas('user', function ($query) use ($searchTerm) {
                    $query->where('firstname', 'like', $searchTerm)
                        ->OrWhere('lastname', 'like', $searchTerm)
                        ->OrWhere('username', 'like', $searchTerm)
                        ->OrWhere('email', 'like', $searchTerm)
                        ->OrWhere('address', 'like', $searchTerm);
                });
        }

        $comments = $comments->with('user')->orderbyDesc('id')->paginate(10);
        $comments->appends(request()->only(['search']));

        return view('admin.items.comments', [
            'item' => $item,
            'comments' => $comments,
        ]);
    }

    public function commentsDelete($id, $comment_id)
    {
        $item = Item::where('id', $id)->firstOrFail();

        $comment = ItemComment::where('id', $comment_id)
            ->where('item_id', $id)
            ->firstOrFail();

        $comment->delete();
        toastr()->success(translate('Deleted Successfully'));
        return back();
    }

    public function statistics($id)
    {
        $item = Item::where('id', $id)->firstOrFail();

        if (request()->filled('period')) {
            $period = request()->input('period');
            $startDate = Date::parse($period)->startOfMonth();
            $endDate = Date::parse($period)->endOfMonth();
        } else {
            $startDate = Date::now()->startOfMonth();
            $endDate = Date::now()->endOfMonth();
        }

        $counters = $this->generateCounters($item, $startDate, $endDate);
        $charts['sales'] = $this->generateSalesChartData($item, $startDate, $endDate);
        $topPurchasingCountries = $this->getTopPurchasingCountries($item, $startDate, $endDate);
        $geoCountries = $this->getGeoCountries($item, $startDate, $endDate);
        $charts['views'] = $this->generateViewsChartData($item, $startDate, $endDate);
        $referrals = $this->generateReferralsData($item, $startDate, $endDate);

        return view('admin.items.statistics', [
            'item' => $item,
            'counters' => $counters,
            'charts' => $charts,
            'topPurchasingCountries' => $topPurchasingCountries,
            'geoCountries' => $geoCountries,
            'referrals' => $referrals,
        ]);
    }

    public function makeFeatured(Request $request, Item $item)
    {
        $item->is_featured = Item::FEATURED;
        $item->update();

        toastr()->success(translate('The item marked as featured successfully'));
        return back();
    }

    public function removeFeatured(Request $request, Item $item)
    {
        $item->is_featured = Item::NOT_FEATURED;
        $item->update();

        toastr()->success(translate('The item marked as not featured successfully'));
        return back();
    }

    public function makePremium(Request $request, Item $item)
    {
        $item->is_premium = Item::PREMIUM;
        $item->update();

        toastr()->success(translate('The item added to premium successfully'));
        return back();
    }

    public function removePremium(Request $request, Item $item)
    {
        $item->is_premium = Item::NOT_PREMIUM;
        $item->update();

        toastr()->success(translate('The item removed from premium successfully'));
        return back();
    }

    public function download(Item $item)
    {
        try {
            $response = $item->download();
            if (isset($response->type) && $response->type == "error") {
                throw new Exception($response->message);
            }
            return $response;
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }

    public function destroy(Item $item)
    {
        $item->delete();
        toastr()->success(translate('Item has deleted successfully'));
        return redirect()->route('admin.items.index');
    }

    private function handleItemOptions($request, $category)
    {
        $options = null;
        if ($category->categoryOptions->count() > 0) {
            $options = [];
            foreach ($category->categoryOptions as $categoryOption) {
                $option = isset($request->options[$categoryOption->id]) ? $request->options[$categoryOption->id] : null;
                if ($categoryOption->isMultiple()) {
                    $requestOptions = $option ? $option : [];
                    if ($categoryOption->isRequired() && count($requestOptions) < 1) {
                        throw new Exception(translate(':field Cannot be empty', ['field' => $categoryOption->name]));
                    }
                    foreach ($requestOptions as $requestOption) {
                        if ($requestOption && !in_array($requestOption, $categoryOption->options)) {
                            throw new Exception(translate('Something went wrong, please refresh the page and try again.'));
                        }
                    }
                } else {
                    $requestOption = $option ? $option : null;
                    if ($categoryOption->isRequired() && empty($requestOption)) {
                        throw new Exception(translate(':field Cannot be empty', ['field' => $categoryOption->name]));
                    }
                    if ($requestOption && !in_array($requestOption, $categoryOption->options)) {
                        throw new Exception(translate('Something went wrong, please refresh the page and try again.'));
                    }
                }
                if ($option) {
                    $options[$categoryOption->name] = $option;
                }
            }
        }
        return $options;
    }

    private function handleItemFiles($request, $category, $required = true)
    {
        $response['thumbnail'] = null;
        $response['preview_type'] = 'image';
        $response['preview_image'] = null;
        $response['preview_video'] = null;
        $response['preview_audio'] = null;
        $response['main_file'] = null;
        $response['screenshots'] = null;

        if ($request->filled('thumbnail')) {
            $thumbnail = UploadedFile::where('id', $request->thumbnail)->notExpired()->first();
            if (!$thumbnail) {
                throw new Exception(translate('One or more of the selected files are expired or not exist'));
            }
            if (!in_array($thumbnail->mime_type, $this->imageMimeTypes)) {
                throw new Exception(translate('Thumbnail must be the type of JPG or PNG'));
            }
            $response['thumbnail'] = $thumbnail->path;
        } else {
            if ($required) {
                throw new Exception(translate(':field Cannot be empty', ['field' => 'Thumbnail']));
            }
        }

        if (!$category->isFileTypeFileWithAudioPreview()) {
            if ($request->filled('preview_image')) {
                $previewImage = UploadedFile::where('id', $request->preview_image)->notExpired()->first();
                if (!$previewImage) {
                    throw new Exception(translate('One or more of the selected files are expired or not exist'));
                }
                if (!in_array($previewImage->mime_type, $this->imageMimeTypes)) {
                    throw new Exception(translate('Preview image must be the type of JPG or PNG'));
                }
                $response['preview_image'] = $previewImage->path;
            } else {
                if ($required) {
                    throw new Exception(translate(':field Cannot be empty', ['field' => 'Preview image']));
                }
            }
        }

        if ($category->isFileTypeFileWithVideoPreview()) {
            if ($request->filled('preview_video')) {
                $previewVideo = UploadedFile::where('id', $request->preview_video)->notExpired()->first();
                if (!$previewVideo) {
                    throw new Exception(translate('One or more of the selected files are expired or not exist'));
                }
                if (!in_array($previewVideo->mime_type, $this->videoMimeTypes)) {
                    throw new Exception(translate('Video preview must be the type of MP4 or WEBM'));
                }
                $response['preview_type'] = 'video';
                $response['preview_video'] = $previewVideo->path;
            } else {
                if ($required) {
                    throw new Exception(translate(':field Cannot be empty', ['field' => 'Video preview']));
                }
            }
        }

        if ($category->isFileTypeFileWithAudioPreview()) {
            if ($request->filled('preview_audio')) {
                $previewAudio = UploadedFile::where('id', $request->preview_audio)->notExpired()->first();
                if (!$previewAudio) {
                    throw new Exception(translate('One or more of the selected files are expired or not exist'));
                }
                if (!in_array($previewAudio->mime_type, $this->audioMimeTypes)) {
                    throw new Exception(translate('Video preview must be the type of MP3 or WAV'));
                }
                $response['preview_type'] = 'audio';
                $response['preview_audio'] = $previewAudio->path;
            } else {
                if ($required) {
                    throw new Exception(translate(':field Cannot be empty', ['field' => 'Audio preview']));
                }
            }
        }

        if ($request->filled('main_file')) {
            if ($request->main_file_source == Item::MAIN_FILE_SOURCE_UPLOAD) {
                $mainFile = UploadedFile::where('id', $request->main_file)->notExpired()->first();
                if (!$mainFile) {
                    throw new Exception(translate('One or more of the selected files are expired or not exist'));
                }
                $response['main_file'] = $mainFile->path;
            } else {
                $response['main_file'] = $request->main_file;
            }
        } else {
            if ($required) {
                throw new Exception(translate(':field Cannot be empty', ['field' => 'Main file']));
            }
        }

        if ($category->isFileTypeFileWithImagePreview()) {
            if ($request->filled('screenshots')) {
                if ($required && count($request->screenshots) < 0) {
                    throw new Exception(translate(':field Cannot be empty', ['field' => 'Screenshots']));
                }
                $screenshots = [];
                foreach ($request->screenshots as $screenshot) {
                    $screenshot = UploadedFile::where('id', $screenshot)->notExpired()->first();
                    if (!$screenshot) {
                        throw new Exception(translate('One or more of the selected files are expired or not exist'));
                    }
                    if (!in_array($screenshot->mime_type, $this->imageMimeTypes)) {
                        throw new Exception(translate('Screenshots must be the type of JPG or PNG'));
                    }
                    $screenshots[] = $screenshot->path;
                }
                $response['screenshots'] = $screenshots;
            }
        }

        return (object) $response;
    }

    private function handleFileDeletionAfterInsert($request, $item = null)
    {
        if ($request->filled('thumbnail')) {
            if ($item) {
                $item->deleteThumbnail();
            }
            $this->deleteUploadedFile($request->thumbnail);
        }

        if ($request->filled('preview_image')) {
            if ($item) {
                $item->deletePreviewImage();
            }
            $this->deleteUploadedFile($request->preview_image);
        }

        if ($request->filled('preview_video')) {
            if ($item) {
                $item->deletePreviewVideo();
            }
            $this->deleteUploadedFile($request->preview_video);
        }

        if ($request->filled('preview_audio')) {
            if ($item) {
                $item->deletePreviewAudio();
            }
            $this->deleteUploadedFile($request->preview_audio);
        }

        if ($request->filled('main_file')) {
            if ($item) {
                $item->deleteMainFile();
            }

            if ($request->main_file_source == Item::MAIN_FILE_SOURCE_UPLOAD) {
                $this->deleteUploadedFile($request->main_file);
            }
        }

        if ($request->filled('screenshots')) {
            if ($item) {
                $item->deleteScreenshots();
            }
            foreach ($request->screenshots as $screenshot) {
                $this->deleteUploadedFile($screenshot);
            }
        }
    }

    private function deleteUploadedFile($fileId)
    {
        $uploadedFile = UploadedFile::where('id', $fileId)->notExpired()->first();
        if ($uploadedFile) {
            $uploadedFile->delete();
        }
    }

    private function generateCounters($item, $startDate, $endDate)
    {
        $sales = Sale::active()
            ->where('item_id', $item->id)
            ->where('created_at', '>=', $startDate)
            ->where('created_at', '<=', $endDate);

        $counters['total_sales'] = $sales->count();
        $counters['total_sales_amount'] = $sales->sum('price');

        $counters['total_views'] = ItemView::where('item_id', $item->id)
            ->where('created_at', '>=', $startDate)
            ->where('created_at', '<=', $endDate)
            ->count();

        return $counters;
    }

    private function generateSalesChartData($item, $startDate, $endDate)
    {
        $chart['title'] = translate('Sales');
        $dates = chartDates($startDate, $endDate);

        $sales = Sale::active()
            ->where('item_id', $item->id)
            ->where('created_at', '>=', $startDate)
            ->where('created_at', '<=', $endDate)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');

        $salesData = $dates->merge($sales);

        $chart['labels'] = [];
        $chart['data'] = [];
        foreach ($salesData as $date => $count) {
            $label = Date::parse($date)->format('d M');
            $chart['labels'][] = $label;
            $chart['data'][] = $count;
        }

        $chart['max'] = (max($chart['data']) > 9) ? max($chart['data']) + 2 : 10;

        return $chart;
    }

    private function getGeoCountries($item, $startDate, $endDate)
    {
        return Sale::active()
            ->where('item_id', $item->id)
            ->whereNotNull('country')
            ->where('created_at', '>=', $startDate)
            ->where('created_at', '<=', $endDate)
            ->select('country', DB::raw('COUNT(*) as total_sales'))
            ->groupBy('country')
            ->orderbyDesc('total_sales')
            ->get();
    }

    private function getTopPurchasingCountries($item, $startDate, $endDate)
    {
        return Sale::active()
            ->where('item_id', $item->id)
            ->whereNotNull('country')
            ->where('created_at', '>=', $startDate)
            ->where('created_at', '<=', $endDate)
            ->select('country', DB::raw('SUM(price) as total_spend'))
            ->groupBy('country')
            ->orderbyDesc('total_spend')
            ->limit(6)
            ->get();
    }

    private function generateViewsChartData($item, $startDate, $endDate)
    {
        $chart['title'] = translate('Views');
        $dates = chartDates($startDate, $endDate);

        $sales = ItemView::where('item_id', $item->id)
            ->where('created_at', '>=', $startDate)
            ->where('created_at', '<=', $endDate)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');

        $salesData = $dates->merge($sales);

        $chart['labels'] = [];
        $chart['data'] = [];
        foreach ($salesData as $date => $count) {
            $label = Date::parse($date)->format('d M');
            $chart['labels'][] = $label;
            $chart['data'][] = $count;
        }

        $chart['max'] = (max($chart['data']) > 9) ? max($chart['data']) + 2 : 10;

        return $chart;
    }

    private function generateReferralsData($item, $startDate, $endDate)
    {
        return ItemView::where('item_id', $item->id)
            ->whereNotNull('referrer')
            ->where('created_at', '>=', $startDate)
            ->where('created_at', '<=', $endDate)
            ->select('referrer', DB::raw('COUNT(*) as total_views'))
            ->groupBy('referrer')
            ->orderbyDesc('total_views')
            ->limit(10)
            ->get();
    }
}
