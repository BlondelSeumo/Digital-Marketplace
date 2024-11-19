<?php

namespace App\Http\Controllers\Admin\Premium;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::query();

        if (request()->filled('status')) {
            $plans->where('status', request('status'));
        }

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $plans->where('name', 'like', $searchTerm)
                ->OrWhere('description', 'like', $searchTerm)
                ->OrWhere('price', 'like', $searchTerm)
                ->OrWhere('custom_features', 'like', $searchTerm);
        }

        $plans = $plans->get();

        return view('admin.premium.plans.index', [
            'plans' => $plans,
        ]);
    }

    public function sortable(Request $request)
    {
        if (!$request->has('ids') || is_null($request->ids)) {
            return response()->json(['error' => translate('Failed to sort the table')]);
        }

        $ids = explode(',', $request->ids);
        foreach ($ids as $sortOrder => $id) {
            $plan = Plan::find($id);
            $plan->sort_id = ($sortOrder + 1);
            $plan->save();
        }

        return response()->json(['success' => true]);
    }

    public function create()
    {
        return view('admin.premium.plans.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'interval' => ['required', 'string', 'in:' . implode(',', array_keys(Plan::getIntervalOptions()))],
            'price' => ['nullable', 'numeric', 'regex:/^\d*(\.\d{2})?$/'],
            'downloads' => ['nullable', 'integer', 'min:1'],
            'custom_features.*' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        $request->price = $request->has('price') && !is_null($request->price) ? $request->price : null;
        $request->downloads = $request->has('downloads') && !is_null($request->downloads) ? $request->downloads : null;

        $request->status = $request->has('status') ? Plan::STATUS_ACTIVE : Plan::STATUS_DISABLED;
        $request->featured = $request->has('featured') ? Plan::FEATURED : Plan::NOT_FEATURED;

        $plan = new Plan();
        $plan->name = $request->name;
        $plan->description = $request->description;
        $plan->price = $request->price;
        $plan->interval = $request->interval;
        $plan->downloads = $request->downloads;
        $plan->custom_features = $request->custom_features;
        $plan->status = $request->status;
        $plan->featured = $request->featured;
        $plan->save();

        if ($plan->isFeatured()) {
            $plans = Plan::where('interval', $plan->interval)
                ->whereNot('id', $plan->id)
                ->update(['featured' => Plan::NOT_FEATURED]);
        }

        toastr()->success(translate('Created Successfully'));
        return redirect()->route('admin.premium.plans.edit', $plan->id);
    }

    public function edit(Plan $plan)
    {
        return view('admin.premium.plans.edit', ['plan' => $plan]);
    }

    public function update(Request $request, Plan $plan)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'price' => ['nullable', 'numeric', 'regex:/^\d*(\.\d{2})?$/'],
            'downloads' => ['nullable', 'integer', 'min:1'],
            'custom_features.*' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        $request->price = $request->has('price') && !is_null($request->price) ? $request->price : null;
        $request->downloads = $request->has('downloads') && !is_null($request->downloads) ? $request->downloads : null;

        $request->status = $request->has('status') ? Plan::STATUS_ACTIVE : Plan::STATUS_DISABLED;
        $request->featured = $request->has('featured') ? Plan::FEATURED : Plan::NOT_FEATURED;

        $plan->name = $request->name;
        $plan->description = $request->description;
        $plan->price = $request->price;
        $plan->downloads = $request->downloads;
        $plan->custom_features = $request->custom_features;
        $plan->status = $request->status;
        $plan->featured = $request->featured;
        $plan->update();

        if ($plan->isFeatured()) {
            $plans = Plan::where('interval', $plan->interval)
                ->whereNot('id', $plan->id)
                ->update(['featured' => Plan::NOT_FEATURED]);
        }

        toastr()->success(translate('Updated Successfully'));
        return back();
    }

    public function destroy(Plan $plan)
    {
        if ($plan->subscriptions->count() > 0) {
            toastr()->error(translate('This plan has subscriptions it cannot be deleted'));
            return back();
        }

        $plan->delete();
        toastr()->success(translate('Deleted Successfully'));
        return back();
    }
}