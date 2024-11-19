<?php

namespace App\Http\Controllers\Admin\Categories;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Validator;

class SubCategoryController extends Controller
{
    public function index()
    {
        $subCategories = SubCategory::query();

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $subCategories->where('name', 'like', $searchTerm)
                ->OrWhere('slug', 'like', $searchTerm);
        }

        if (request()->filled('category')) {
            $subCategories->where('category_id', request('category'));
        }

        $subCategories = $subCategories->with('category')->get();

        $categories = Category::all();

        return view('admin.categories.sub-categories.index', [
            'categories' => $categories,
            'subCategories' => $subCategories,
        ]);
    }

    public function sortable(Request $request)
    {
        if (!$request->has('ids') || is_null($request->ids)) {
            return response()->json(['error' => translate('Failed to sort the table')]);
        }

        $ids = explode(',', $request->ids);
        foreach ($ids as $sortOrder => $id) {
            $subCategory = SubCategory::find($id);
            $subCategory->sort_id = ($sortOrder + 1);
            $subCategory->save();
        }

        return response()->json(['success' => true]);
    }

    public function slug(Request $request)
    {
        $slug = null;
        if ($request->content != null) {
            $slug = SlugService::createSlug(SubCategory::class, 'slug', $request->content);
        }
        return response()->json(['slug' => $slug]);
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.categories.sub-categories.create', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'alpha_dash', 'unique:sub_categories'],
            'category' => ['required', 'integer', 'exists:categories,id'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        $subCategory = new SubCategory();
        $subCategory->name = $request->name;
        $subCategory->slug = $request->slug;
        $subCategory->category_id = $request->category;
        $subCategory->save();

        toastr()->success(translate('Created Successfully'));
        return redirect()->route('admin.categories.sub-categories.index');
    }

    public function edit(SubCategory $subCategory)
    {
        $categories = Category::all();
        return view('admin.categories.sub-categories.edit', [
            'subCategory' => $subCategory,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, SubCategory $subCategory)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'alpha_dash', 'unique:sub_categories,slug,' . $subCategory->id],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $subCategory->name = $request->name;
        $subCategory->slug = $request->slug;
        $subCategory->update();

        toastr()->success(translate('Updated Successfully'));
        return back();
    }

    public function destroy(SubCategory $subCategory)
    {
        if ($subCategory->items->count() > 0) {
            toastr()->error(translate('The selected sub category has items, it cannot be deleted'));
            return back();
        }

        $subCategory->delete();
        toastr()->success(translate('Deleted Successfully'));
        return back();
    }
}