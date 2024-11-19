<?php

namespace App\Http\Controllers\Admin\Tickets;

use App\Http\Controllers\Controller;
use App\Models\TicketCategory;
use Illuminate\Http\Request;
use Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = TicketCategory::query();

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $categories->where('name', 'like', $searchTerm);
        }

        $categories = $categories->get();

        return view('admin.tickets.categories.index', ['categories' => $categories]);
    }

    public function sortable(Request $request)
    {
        if (!$request->has('ids') || is_null($request->ids)) {
            return response()->json(['error' => translate('Failed to sort the table')]);
        }

        $ids = explode(',', $request->ids);
        foreach ($ids as $sortOrder => $id) {
            $category = TicketCategory::find($id);
            $category->sort_id = ($sortOrder + 1);
            $category->save();
        }

        return response()->json(['success' => true]);
    }

    public function create()
    {
        return view('admin.tickets.categories.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:ticket_categories'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        $request->status = ($request->has('status')) ? 1 : 0;

        $category = new TicketCategory();
        $category->name = $request->name;
        $category->status = $request->status;
        $category->save();

        toastr()->success(translate('Created Successfully'));
        return redirect()->route('admin.tickets.categories.index');
    }

    public function edit(TicketCategory $category)
    {
        return view('admin.tickets.categories.edit', ['category' => $category]);
    }

    public function update(Request $request, TicketCategory $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:ticket_categories,name,' . $category->id],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        $request->status = ($request->has('status')) ? 1 : 0;

        $category->name = $request->name;
        $category->status = $request->status;
        $category->save();

        toastr()->success(translate('Updated Successfully'));
        return back();
    }

    public function destroy(TicketCategory $category)
    {
        if ($category->tickets->count() > 0) {
            toastr()->error(translate('The selected category has tickets, it cannot be deleted'));
            return back();
        }

        $category->delete();
        toastr()->success(translate('Deleted Successfully'));
        return back();
    }
}
