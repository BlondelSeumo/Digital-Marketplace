<?php

namespace App\Http\Controllers\Admin\Financial;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    public function index()
    {
        return view('admin.financial.settings');
    }

    public function update(Request $request)
    {
        $rules = [
            'currency.code' => ['required', 'string', 'max:4'],
            'currency.symbol' => ['required', 'string', 'max:4'],
            'currency.position' => ['required', 'integer', 'min:1', 'max:2'],
        ];

        if ($request->has('deposit.status')) {
            $rules['deposit.minimum'] = ['required', 'integer', 'min:1'];
            $rules['deposit.maximum'] = ['required', 'integer', 'min:1'];
        } else {
            $rules['deposit.minimum'] = ['nullable', 'integer', 'min:1'];
            $rules['deposit.maximum'] = ['nullable', 'integer', 'min:1'];
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $requestData = $request->except('_token');

        $requestData['deposit']['status'] = $request->has('deposit.status') ? 1 : 0;

        foreach ($requestData as $key => $value) {
            $update = Settings::updateSettings($key, $value);
            if (!$update) {
                toastr()->error(translate('Updated Error'));
                return back();
            }
        }

        toastr()->success(translate('Updated Successfully'));
        return back();
    }
}
