<?php

namespace App\Http\Controllers\Admin\Sections;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Validator;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        $testimonials = Testimonial::all();
        return view('admin.sections.testimonials.index', ['testimonials' => $testimonials]);
    }

    public function sortable(Request $request)
    {
        if (!$request->has('ids') || is_null($request->ids)) {
            return response()->json(['error' => translate('Failed to sort the data')]);
        }

        $ids = explode(',', $request->ids);
        foreach ($ids as $sortOrder => $id) {
            $testimonial = Testimonial::find($id);
            $testimonial->sort_id = ($sortOrder + 1);
            $testimonial->update();
        }

        return response()->json(['success' => true]);
    }

    public function create()
    {
        return view('admin.sections.testimonials.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'avatar' => ['required', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
            'name' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'stars' => ['required', 'integer', 'min:1', 'max:5'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        try {
            $avatar = imageUpload($request->file('avatar'), 'images/sections/testimonials/');
            $testimonial = Testimonial::create([
                'name' => $request->name,
                'avatar' => $avatar,
                'title' => $request->title,
                'body' => $request->body,
                'stars' => $request->stars,
            ]);
            if ($testimonial) {
                toastr()->success(translate('Created Successfully'));
                return redirect()->route('admin.sections.testimonials.index');
            }
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return back()->withInput();
        }
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.sections.testimonials.edit', ['testimonial' => $testimonial]);
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $validator = Validator::make($request->all(), [
            'avatar' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
            'name' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'stars' => ['required', 'integer', 'min:1', 'max:5'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        try {
            if ($request->has('avatar')) {
                $avatar = imageUpload($request->file('avatar'), 'images/sections/testimonials/', null, null, $testimonial->avatar);
            } else {
                $avatar = $testimonial->avatar;
            }
            $testimonial->update([
                'name' => $request->name,
                'avatar' => $avatar,
                'title' => $request->title,
                'body' => $request->body,
                'stars' => $request->stars,
            ]);
            toastr()->success(translate('Updated Successfully'));
            return back();
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return back()->withInput();
        }
    }

    public function destroy(Testimonial $testimonial)
    {
        removeFile($testimonial->avatar);
        $testimonial->delete();
        toastr()->success(translate('Deleted Successfully'));
        return back();
    }
}
