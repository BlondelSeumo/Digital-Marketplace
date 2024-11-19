<?php

namespace App\Http\Controllers\Admin\Sections;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        $faqs = Faq::all();
        return view('admin.sections.faqs.index', ['faqs' => $faqs]);
    }

    public function sortable(Request $request)
    {
        if (!$request->has('ids') || is_null($request->ids)) {
            return response()->json(['error' => translate('Failed to sort the data')]);
        }
        $ids = explode(',', $request->ids);
        foreach ($ids as $sortOrder => $id) {
            $faq = Faq::find($id);
            $faq->sort_id = ($sortOrder + 1);
            $faq->update();
        }
        return response()->json(['success' => true]);
    }

    public function create()
    {
        return view('admin.sections.faqs.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }
        $faq = Faq::create([
            'title' => $request->title,
            'body' => $request->body,
        ]);
        if ($faq) {
            toastr()->success(translate('Created Successfully'));
            return redirect()->route('admin.sections.faqs.index');
        }
    }

    public function edit(Faq $faq)
    {
        return view('admin.sections.faqs.edit', ['faq' => $faq]);
    }

    public function update(Request $request, Faq $faq)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }
        $update = $faq->update([
            'title' => $request->title,
            'body' => $request->body,
        ]);
        if ($update) {
            toastr()->success(translate('Updated Successfully'));
            return back();
        }
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        toastr()->success(translate('Deleted Successfully'));
        return back();
    }
}
