<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Validator;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = BlogCategory::all();
        return view('admin.blog.categories.index', ['categories' => $categories]);
    }

    public function slug(Request $request)
    {
        $slug = null;
        if ($request->content != null) {
            $slug = SlugService::createSlug(BlogCategory::class, 'slug', $request->content);
        }
        return response()->json(['slug' => $slug]);
    }

    public function create()
    {
        return view('admin.blog.categories.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:255', 'min:2'],
            'slug' => ['required', 'unique:blog_categories', 'alpha_dash'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        $category = BlogCategory::create([
            'name' => $request->name,
            'slug' => $request->slug,
        ]);

        if ($category) {
            toastr()->success(translate('Created Successfully'));
            return redirect()->route('admin.blog.categories.edit', $category->id);
        }
    }

    public function edit(BlogCategory $category)
    {
        return view('admin.blog.categories.edit', ['category' => $category]);
    }

    public function update(Request $request, BlogCategory $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:255', 'min:2'],
            'slug' => ['required', 'alpha_dash', 'unique:blog_categories,slug,' . $category->id],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $category->update([
            'name' => $request->name,
            'slug' => $request->slug,
        ]);

        toastr()->success(translate('Updated Successfully'));
        return back();

    }

    public function destroy(BlogCategory $category)
    {
        if ($category->articles->count() > 0) {
            toastr()->error(translate('The selected category has articles, it cannot be deleted'));
            return back();
        }

        $category->delete();
        toastr()->success(translate('Deleted Successfully'));
        return back();
    }
}
