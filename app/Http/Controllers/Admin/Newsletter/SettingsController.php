<?php

namespace App\Http\Controllers\Admin\Newsletter;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;
use Validator;

class SettingsController extends Controller
{
    public function index()
    {
        return view('admin.newsletter.settings');
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'newsletter.popup_image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp'],
            'newsletter.popup_reminder_time' => ['required', 'integer', 'min:1', 'max:8760'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $requestData = $request->except('_token');
        $newsletter = $requestData['newsletter'];

        if ($request->has('newsletter.popup_image')) {
            $popupImage = imageUpload($request->file('newsletter.popup_image'), 'images/newsletter/', null, null, @settings('newsletter')->popup_image);
            $newsletter['popup_image'] = $popupImage;
        } else {
            $newsletter['popup_image'] = @settings('newsletter')->popup_image;
        }

        $newsletter['status'] = ($request->has('newsletter.status')) ? 1 : 0;
        $newsletter['popup_status'] = ($request->has('newsletter.popup_status')) ? 1 : 0;
        $newsletter['footer_status'] = ($request->has('newsletter.footer_status')) ? 1 : 0;
        $newsletter['register_new_users'] = ($request->has('newsletter.register_new_users')) ? 1 : 0;

        $update = Settings::updateSettings('newsletter', $newsletter);
        if (!$update) {
            toastr()->error(translate('Updated Error'));
            return back();
        }

        toastr()->success(translate('Updated Successfully'));
        return back();
    }
}