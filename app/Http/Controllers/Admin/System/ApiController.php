<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function index()
    {
        return view('admin.system.api.index');
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'api.key' => ['required', 'string', 'max:50'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $requestData = $request->except('_token');
        $api = $requestData['api'];

        if ($request->has('api.status')) {
            $api['status'] = 1;
        } else {
            $api['status'] = 0;
            $api['key'] = null;
        }

        $update = Settings::updateSettings('api', $api);
        if (!$update) {
            toastr()->error(translate('Updated Error'));
            return back();
        }

        toastr()->success(translate('Updated Successfully'));
        return back();
    }
}