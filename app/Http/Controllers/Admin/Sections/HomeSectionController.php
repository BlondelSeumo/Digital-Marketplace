<?php

namespace App\Http\Controllers\Admin\Sections;

use App\Http\Controllers\Controller;
use App\Models\HomeSection;
use Illuminate\Http\Request;
use Validator;

class HomeSectionController extends Controller
{
    public function index()
    {
        if (licenseType(2) && @settings('premium')->status) {
            $homeSections = HomeSection::all();
        } else {
            $homeSections = HomeSection::whereNot('alias', 'premium_items')->get();
        }

        return view('admin.sections.home-sections.index', ['homeSections' => $homeSections]);
    }

    public function sortable(Request $request)
    {
        if (!$request->has('ids') || is_null($request->ids)) {
            return response()->json(['error' => translate('Failed to sort the data')]);
        }
        $ids = explode(',', $request->ids);
        foreach ($ids as $sortOrder => $id) {
            $homeSection = HomeSection::find($id);
            $homeSection->sort_id = ($sortOrder + 1);
            $homeSection->update();
        }
        return response()->json(['success' => true]);
    }

    public function edit(HomeSection $homeSection)
    {
        return view('admin.sections.home-sections.edit', ['homeSection' => $homeSection]);
    }

    public function update(Request $request, HomeSection $homeSection)
    {
        $rules = [
            'name' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
        ];

        if ($homeSection->items_number) {
            $rules['items_number'] = ['required', 'integer', 'min:1', 'max:100'];
        } else {
            $request->items_number = null;
        }

        if ($homeSection->cache_expiry_time) {
            $rules['cache_expiry_time'] = ['required', 'integer', 'min:1', 'max:525600'];
        } else {
            $request->cache_expiry_time = null;
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        $homeSection->name = $request->name;
        $homeSection->description = $request->description;
        $homeSection->items_number = $request->items_number;
        $homeSection->cache_expiry_time = $request->cache_expiry_time;
        $homeSection->status = $request->has('status') ? HomeSection::STATUS_ACTIVE : HomeSection::STATUS_DISABLED;
        $homeSection->update();

        toastr()->success(translate('Updated Successfully'));
        return back();
    }

}
