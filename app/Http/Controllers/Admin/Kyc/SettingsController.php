<?php

namespace App\Http\Controllers\Admin\Kyc;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;
use Validator;

class SettingsController extends Controller
{
    public function index()
    {
        return view('admin.kyc.settings');
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kyc.id_front_image' => ['nullable', 'mimes:jpeg,jpg,png,svg'],
            'kyc.id_back_image' => ['nullable', 'mimes:jpeg,jpg,png,svg'],
            'kyc.passport_image' => ['nullable', 'mimes:jpeg,jpg,png,svg'],
            'kyc.selfie_image' => ['nullable', 'mimes:jpeg,jpg,png,svg'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $requestData = $request->except('_token');

        $requestData['kyc']['status'] = ($request->has('kyc.status')) ? 1 : 0;
        $requestData['kyc']['required'] = ($request->has('kyc.required')) ? 1 : 0;
        $requestData['kyc']['selfie_verification'] = ($request->has('kyc.selfie_verification')) ? 1 : 0;

        if ($request->has('kyc.id_front_image')) {
            $idFrontImage = imageUpload($request->file('kyc.id_front_image'), 'images/kyc/', null, null, @settings('kyc')->id_front_image);
            $requestData['kyc']['id_front_image'] = $idFrontImage;
        } else {
            $requestData['kyc']['id_front_image'] = @settings('kyc')->id_front_image;
        }

        if ($request->has('kyc.id_back_image')) {
            $idBackImage = imageUpload($request->file('kyc.id_back_image'), 'images/kyc/', null, null, @settings('kyc')->id_back_image);
            $requestData['kyc']['id_back_image'] = $idBackImage;
        } else {
            $requestData['kyc']['id_back_image'] = @settings('kyc')->id_back_image;
        }

        if ($request->has('kyc.passport_image')) {
            $passportImage = imageUpload($request->file('kyc.passport_image'), 'images/kyc/', null, null, @settings('kyc')->passport_image);
            $requestData['kyc']['passport_image'] = $passportImage;
        } else {
            $requestData['kyc']['passport_image'] = @settings('kyc')->passport_image;
        }

        if ($request->has('kyc.selfie_image')) {
            $selfieImage = imageUpload($request->file('kyc.selfie_image'), 'images/kyc/', null, null, @settings('kyc')->selfie_image);
            $requestData['kyc']['selfie_image'] = $selfieImage;
        } else {
            $requestData['kyc']['selfie_image'] = @settings('kyc')->selfie_image;
        }

        $update = Settings::updateSettings('kyc', $requestData['kyc']);
        if (!$update) {
            toastr()->error(translate('Updated Error'));
            return back();
        }

        toastr()->success(translate('Updated Successfully'));
        return back();
    }
}