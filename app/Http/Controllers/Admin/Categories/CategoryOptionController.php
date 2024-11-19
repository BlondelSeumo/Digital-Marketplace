<?php

namespace App\Http\Controllers\Admin\Categories;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryOption;
use Illuminate\Http\Request;
use Validator;

class CategoryOptionController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        $categoryOptions = CategoryOption::query();

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $categoryOptions->where('name', 'like', $searchTerm)
                ->OrWhere('slug', 'like', $searchTerm);
        }

        if (request()->filled('category')) {
            $categoryOptions->where('category_id', request('category'));
        }

        $categoryOptions = $categoryOptions->with('category')->get();

        return view('admin.categories.category-options.index', [
            'categories' => $categories,
            'categoryOptions' => $categoryOptions,
        ]);
    }

    public function sortable(Request $request)
    {
        if (!$request->has('ids') || is_null($request->ids)) {
            return response()->json(['error' => translate('Failed to sort the table')]);
        }

        $ids = explode(',', $request->ids);
        foreach ($ids as $sortOrder => $id) {
            $categoryOption = CategoryOption::find($id);
            $categoryOption->sort_id = ($sortOrder + 1);
            $categoryOption->save();
        }

        return response()->json(['success' => true]);
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.categories.category-options.create', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => ['required', 'integer', 'exists:categories,id'],
            'type' => ['required', 'integer', 'min:1', 'max:2'],
            'name' => ['required', 'string', 'max:255'],
            'options.*' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        if (count($request->options) < 1) {
            toastr()->success(translate('Options required'));
            return back();
        }

        $request->required = ($request->has('required')) ? 1 : 0;

        $categoryOption = new CategoryOption();
        $categoryOption->category_id = $request->category;
        $categoryOption->type = $request->type;
        $categoryOption->name = $request->name;
        $categoryOption->options = array_values($request->options);
        $categoryOption->is_required = $request->required;
        $categoryOption->save();

        toastr()->success(translate('Created Successfully'));
        return redirect()->route('admin.categories.category-options.index');
    }

    public function edit(CategoryOption $categoryOption)
    {
        $categories = Category::all();
        return view('admin.categories.category-options.edit', [
            'categoryOption' => $categoryOption,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, CategoryOption $categoryOption)
    {
        $validator = Validator::make($request->all(), [
            'type' => ['required', 'integer', 'min:1', 'max:2'],
            'name' => ['required', 'string', 'max:255'],
            'options.*' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        if (count($request->options) < 1) {
            toastr()->success(translate('Options required'));
            return back();
        }

        $request->required = ($request->has('required')) ? 1 : 0;

        $categoryOption->type = $request->type;
        $categoryOption->name = $request->name;
        $categoryOption->options = array_values($request->options);
        $categoryOption->is_required = $request->required;
        $categoryOption->update();

        toastr()->success(translate('Created Successfully'));
        return back();
    }

    public function destroy(CategoryOption $categoryOption)
    {
        $categoryOption->delete();
        toastr()->success(translate('Deleted Successfully'));
        return back();
    }
}