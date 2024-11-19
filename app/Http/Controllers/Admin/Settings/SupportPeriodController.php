<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\SupportPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupportPeriodController extends Controller
{
    public function index(Request $request)
    {
        $supportPeriods = SupportPeriod::all();
        return view('admin.settings.support-periods.index', [
            'supportPeriods' => $supportPeriods,
        ]);
    }

    public function sortable(Request $request)
    {
        if (!$request->has('ids') || is_null($request->ids)) {
            return response()->json(['error' => translate('Failed to sort the data')]);
        }

        $ids = explode(',', $request->ids);
        foreach ($ids as $sortOrder => $id) {
            $supportPeriod = SupportPeriod::find($id);
            $supportPeriod->sort_id = ($sortOrder + 1);
            $supportPeriod->update();
        }

        return response()->json(['success' => true]);
    }

    public function create()
    {
        return view('admin.settings.support-periods.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:support_periods'],
            'title' => ['required', 'string', 'max:255'],
            'days' => ['required', 'integer', 'min:1'],
            'percentage' => ['required', 'integer', 'min:0', 'max:100'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        $isDefault = $request->has('make_default') ? SupportPeriod::DEFAULT : SupportPeriod::NOT_DEFAULT;

        if (!$isDefault && !defaultSupportPeriod()) {
            toastr()->error(translate('You must have one default support'));
            return back()->withInput();
        }

        $supportPeriod = SupportPeriod::create([
            'name' => $request->name,
            'title' => $request->title,
            'days' => $request->days,
            'percentage' => $request->percentage,
            'is_default' => $isDefault,
        ]);

        if ($supportPeriod) {
            if ($isDefault) {
                SupportPeriod::whereNot('id', $supportPeriod->id)
                    ->update(['is_default' => SupportPeriod::NOT_DEFAULT]);
            }
            toastr()->success(translate('Created Successfully'));
            return redirect()->route('admin.settings.support-periods.index');
        }
    }

    public function edit(SupportPeriod $supportPeriod)
    {
        return view('admin.settings.support-periods.edit', [
            'supportPeriod' => $supportPeriod,
        ]);
    }

    public function update(Request $request, SupportPeriod $supportPeriod)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:support_periods,id,' . $supportPeriod->id],
            'title' => ['required', 'string', 'max:255'],
            'days' => ['required', 'integer', 'min:1'],
            'percentage' => ['required', 'integer', 'min:0', 'max:100'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $isDefault = $request->has('make_default') ? SupportPeriod::DEFAULT : SupportPeriod::NOT_DEFAULT;

        if (!$isDefault && !SupportPeriod::whereNot('id', $supportPeriod->id)->default()->first()) {
            toastr()->error(translate('You must have one default support'));
            return back()->withInput();
        }

        $update = $supportPeriod->update([
            'name' => $request->name,
            'title' => $request->title,
            'days' => $request->days,
            'percentage' => $request->percentage,
            'is_default' => $isDefault,
        ]);

        if ($update) {
            if ($isDefault) {
                SupportPeriod::whereNot('id', $supportPeriod->id)
                    ->update(['is_default' => SupportPeriod::NOT_DEFAULT]);
            }
            toastr()->success(translate('Updated Successfully'));
            return back();
        }
    }

    public function destroy(SupportPeriod $supportPeriod)
    {
        if ($supportPeriod->isDefault()) {
            toastr()->error(translate('The default support period cannot be deleted'));
            return back();
        }

        if (supportPeriods()->count() == 1) {
            $supportedItems = Item::supported()->count();
            if ($supportedItems > 0) {
                toastr()->error(translate('You have some supported items you cannot delete all support periods'));
                return back();
            }
        }

        $supportPeriod->delete();
        toastr()->success(translate('Deleted Successfully'));
        return back();
    }
}
