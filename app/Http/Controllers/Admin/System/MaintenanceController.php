<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Validator;

class MaintenanceController extends Controller
{
    public function index()
    {
        return view('admin.system.maintenance');
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'maintenance.image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,svg'],
            'maintenance.title' => ['required_if:maintenance.status,on', 'nullable', 'string', 'max:150'],
            'maintenance.body' => ['required_if:maintenance.status,on', 'nullable', 'string', 'max:500'],
            'maintenance.password' => ['required_if:maintenance.status,on', 'nullable', 'string', 'min:3', 'max:50'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $requestData = $request->except('_token');
        $maintenance = $requestData['maintenance'];

        if ($request->filled('maintenance.status') && !$request->filled('maintenance.password') && !@settings('maintenance')->password) {
            toastr()->error(translate('Password cannot be empty'));
            return back();
        }

        if ($request->has('maintenance.image')) {
            $image = imageUpload($request->file('maintenance.image'), 'images/maintenance/', null, null, @settings('maintenance')->image);
            $maintenance['image'] = $image;
        } else {
            $maintenance['image'] = @settings('maintenance')->image;
        }

        $maintenance['status'] = ($request->has('maintenance.status')) ? 1 : 0;

        $maintenance['password'] = Hash::make($maintenance['password']);

        $update = Settings::updateSettings('maintenance', $maintenance);
        if (!$update) {
            toastr()->error(translate('Updated Error'));
            return back();
        }

        if ($maintenance['status']) {
            Cookie::queue('maintenance', true, 43200);
        }
        toastr()->success(translate('Updated Successfully'));
        return back();
    }
}