<?php

namespace App\Http\Controllers\Admin\Premium;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    public function index()
    {
        return view('admin.premium.settings');
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'premium.terms_link' => ['nullable', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $requestData = $request->except('_token');

        $requestData['premium']['status'] = ($request->has('premium.status')) ? 1 : 0;

        $update = Settings::updateSettings('premium', $requestData['premium']);
        if (!$update) {
            toastr()->error(translate('Updated Error'));
            return back();
        }

        toastr()->success(translate('Updated Successfully'));
        return back();
    }
}