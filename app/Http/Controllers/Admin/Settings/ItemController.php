<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use App\Models\StorageProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;

class ItemController extends Controller
{
    public function index()
    {
        $storageProviders = StorageProvider::all();
        return view('admin.settings.item', ['storageProviders' => $storageProviders]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item.trending_number' => ['required', 'integer', 'min:1'],
            'item.best_selling_number' => ['required', 'integer', 'min:1'],
            'item.file_duration' => ['required', 'integer', 'min:1'],
            'item.convert_images_webp' => ['required', 'boolean'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $requestData = $request->except('_token');
        $itemSettings = $requestData['item'];

        $storageProvider = StorageProvider::where('alias', $request->storage_provider)->firstOrFail();
        if (!$storageProvider->isLocal()) {
            $credentials = $request->credentials[$storageProvider->alias];
            foreach ($credentials as $key => $value) {
                if (!array_key_exists($key, (array) $storageProvider->credentials)) {
                    toastr()->error(translate('Mismatch credentials'));
                    return back();
                }
            }
        }

        $itemSettings['item_total_sales'] = ($request->has('item.item_total_sales')) ? 1 : 0;
        $itemSettings['free_item_total_downloads'] = ($request->has('item.free_item_total_downloads')) ? 1 : 0;
        $itemSettings['free_items_require_login'] = ($request->has('item.free_items_require_login')) ? 1 : 0;
        $itemSettings['buy_now_button'] = $request->has('item.buy_now_button') ? 1 : 0;
        $itemSettings['reviews_status'] = ($request->has('item.reviews_status')) ? 1 : 0;
        $itemSettings['comments_status'] = ($request->has('item.comments_status')) ? 1 : 0;
        $itemSettings['support_status'] = ($request->has('item.support_status')) ? 1 : 0;
        $itemSettings['changelogs_status'] = ($request->has('item.changelogs_status')) ? 1 : 0;

        $update = Settings::updateSettings('item', $itemSettings);
        if (!$update) {
            toastr()->error(translate('Updated Error'));
            return back();
        }

        if (!$storageProvider->isLocal()) {
            $storageProvider->credentials = $credentials;
            $storageProvider->update();
            $storageProvider->processor::setCredentials($storageProvider->credentials);
        }

        setEnv('FILESYSTEM_DRIVER', $storageProvider->alias);
        toastr()->success(translate('Updated Successfully'));
        return back();

    }

    public function storageTest(Request $request)
    {
        $defaultStorage = config('filesystems.default');
        if ($defaultStorage != "local") {
            try {
                $disk = Storage::disk($defaultStorage);
                $upload = $disk->put('test.txt', 'public');
                if (!$upload) {
                    toastr()->error(translate('Connection Failed'));
                    return back();
                }
                $disk->delete('test.txt');
                toastr()->success(translate('Connected successfully'));
                return back();
            } catch (\Exception $e) {
                toastr()->error(translate('Connection Failed'));
                return back();
            }
        }
    }
}