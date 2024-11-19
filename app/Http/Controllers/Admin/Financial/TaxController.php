<?php

namespace App\Http\Controllers\Admin\Financial;

use App\Classes\Country;
use App\Http\Controllers\Controller;
use App\Models\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaxController extends Controller
{
    public function index()
    {
        $taxes = Tax::all();
        return view('admin.financial.taxes.index', [
            'taxes' => $taxes,
        ]);
    }

    public function create()
    {
        return view('admin.financial.taxes.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'block_patterns', 'max:255'],
            'rate' => ['required', 'integer', 'min:1', 'max:100'],
            'countries' => ['required', 'array'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        foreach ($request->countries as $country) {
            if (!array_key_exists($country, countries())) {
                toastr()->error(translate('Invalid Country'));
                return back()->withInput();
            }

            $countryExists = Tax::whereJsonContains('countries', $country)->first();
            if ($countryExists) {
                toastr()->error(translate(':country is already exists', ['country' => countries($country)]));
                return back()->withInput();
            }
        }

        $tax = new Tax();
        $tax->name = $request->name;
        $tax->rate = $request->rate;
        $tax->countries = $request->countries;
        $tax->save();

        toastr()->success(translate('Created Successfully'));
        return redirect()->route('admin.financial.taxes.index');
    }

    public function edit(Tax $tax)
    {
        return view('admin.financial.taxes.edit', [
            'tax' => $tax,
        ]);
    }

    public function update(Request $request, Tax $tax)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'block_patterns', 'max:255'],
            'rate' => ['required', 'integer', 'min:1', 'max:100'],
            'countries' => ['required', 'array'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        foreach ($request->countries as $country) {
            if (!array_key_exists($country, Country::all())) {
                toastr()->error(translate('Invalid Country'));
                return back()->withInput();
            }

            $countryExists = Tax::whereNot('id', $tax->id)
                ->whereJsonContains('countries', $country)->first();
            if ($countryExists) {
                toastr()->error(translate(':country is already exists', ['country' => Country::get($country)]));
                return back()->withInput();
            }
        }

        $tax->name = $request->name;
        $tax->rate = $request->rate;
        $tax->countries = $request->countries;
        $tax->update();

        toastr()->success(translate('Updated Successfully'));
        return back();
    }

    public function destroy(Tax $tax)
    {
        $tax->delete();
        toastr()->success(translate('Deleted Successfully'));
        return back();
    }
}
