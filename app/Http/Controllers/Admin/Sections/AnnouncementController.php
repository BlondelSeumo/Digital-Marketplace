<?php

namespace App\Http\Controllers\Admin\Sections;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;
use Validator;

class AnnouncementController extends Controller
{
    public function index()
    {
        return view('admin.sections.announcement');
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'announcement.body' => ['required_if:announcement.status,on', 'nullable', 'string', 'block_patterns', 'max:500'],
            'announcement.button_title' => ['required_with:announcement.button_link', 'nullable', 'string', 'block_patterns', 'max:100'],
            'announcement.button_link' => ['required_with:announcement.button_title', 'nullable', 'string', 'block_patterns'],
            'announcement.background_color' => ['required_if:announcement.status,on', 'string', 'regex:/^#[A-Fa-f0-9]{6}$/'],
            'announcement.button_background_color' => ['required_if:announcement.status,on', 'string', 'regex:/^#[A-Fa-f0-9]{6}$/'],
            'announcement.button_text_color' => ['required_if:announcement.status,on', 'string', 'regex:/^#[A-Fa-f0-9]{6}$/'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $requestData = $request->except('_token');

        $requestData['announcement']['status'] = ($request->has('announcement.status')) ? 1 : 0;

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
