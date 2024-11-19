<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use File;
use Illuminate\Http\Request;
use Validator;

class AdminPanelStyleController extends Controller
{
    public function index()
    {
        $customCssFile = public_path(config('system.admin.custom_css'));
        if (!File::exists($customCssFile)) {
            File::put($customCssFile, '');
        }
        $customCssFile = File::get($customCssFile);
        return view('admin.system.admin-panel-style', ['customCssFile' => $customCssFile]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'system_admin.colors.*' => 'required|regex:/^#[A-Fa-f0-9]{6}$/',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {toastr()->error($error);}
            return back();
        }

        $requestData = $request->except(['_token', 'custom_css']);
        foreach ($requestData as $key => $value) {
            $update = Settings::updateSettings($key, $value);
            if (!$update) {
                toastr()->error(translate('Updated Error'));
                return back();
            }
        }

        $this->updateAdminColors($requestData['system_admin']['colors']);
        $this->updateAdminCustomCss($request->custom_css);

        toastr()->success(translate('Updated Successfully'));
        return back();
    }

    public function updateAdminColors($colors)
    {
        $output = ':root {' . PHP_EOL;
        foreach ($colors as $key => $value) {
            $output .= '  --' . $key . ':' . $value . ';' . PHP_EOL;
        }
        $output .= '}' . PHP_EOL;
        $colorsFile = public_path(config('system.admin.colors'));
        if (!File::exists($colorsFile)) {
            File::put($colorsFile, '');
        }
        File::put($colorsFile, $output);
    }

    private function updateAdminCustomCss($content)
    {
        $customCssFile = public_path(config('system.admin.custom_css'));
        if (!File::exists($customCssFile)) {
            File::put($customCssFile, '');
        }
        File::put($customCssFile, $content);
        toastr()->success(translate('Updated Successfully'));
        return back();
    }
}
