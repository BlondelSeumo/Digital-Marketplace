<?php

namespace App\Http\Controllers\Admin\Sections;

use App\Http\Controllers\Controller;
use App\Models\HomeCategory;
use Illuminate\Http\Request;
use Validator;

class HomeCategoryController extends Controller
{
    public function index()
    {
        $homeCategories = HomeCategory::all();
        return view('admin.sections.home-categories.index', ['homeCategories' => $homeCategories]);
    }

    public function sortable(Request $request)
    {
        if (!$request->has('ids') || is_null($request->ids)) {
            return response()->json(['error' => translate('Failed to sort the data')]);
        }
        $ids = explode(',', $request->ids);
        foreach ($ids as $sortOrder => $id) {
            $homeCategory = HomeCategory::find($id);
            $homeCategory->sort_id = ($sortOrder + 1);
            $homeCategory->update();
        }
        return response()->json(['success' => true]);
    }

    public function create()
    {
        return view('admin.sections.home-categories.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'icon' => ['required', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
            'link' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        try {
            $icon = imageUpload($request->file('icon'), 'images/home-categories/');
            $homeCategory = new HomeCategory();
            $homeCategory->name = $request->name;
            $homeCategory->icon = $icon;
            $homeCategory->link = $request->link;
            $homeCategory->save();
            toastr()->success(translate('Created Successfully'));
            return redirect()->route('admin.sections.home-categories.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return back()->withInput();
        }
    }

    public function edit(HomeCategory $homeCategory)
    {
        return view('admin.sections.home-categories.edit', ['homeCategory' => $homeCategory]);
    }

    public function update(Request $request, HomeCategory $homeCategory)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
            'link' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        try {
            $icon = ($request->has('icon')) ? imageUpload($request->file('icon'), 'images/home-categories/', null, null, $homeCategory->icon) : $homeCategory->icon;
            $homeCategory->name = $request->name;
            $homeCategory->icon = $icon;
            $homeCategory->link = $request->link;
            $homeCategory->update();
            toastr()->success(translate('Updated Successfully'));
            return back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return back()->withInput();
        }
    }

    public function destroy(HomeCategory $homeCategory)
    {
        removeFile(public_path($homeCategory->icon));
        $homeCategory->delete();
        toastr()->success(translate('Deleted Successfully'));
        return back();
    }
}