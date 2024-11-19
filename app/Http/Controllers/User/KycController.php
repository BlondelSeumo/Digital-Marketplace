<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Jobs\Admin\SendAdminKycPendingNotification;
use App\Models\KycVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KycController extends Controller
{
    public function index()
    {
        return theme_view('user.kyc');
    }

    public function kycSubmit(Request $request)
    {
        $rules = [
            'document_type' => ['required', 'string', 'in:national_id,passport'],
        ];

        if (@settings('kyc')->selfie_verification) {
            $rules['selfie'] = ['required', 'image', 'mimes:jpeg,jpg,png', 'max:4096'];
        }

        if ($request->document_type == KycVerification::DOCUMENT_TYPE_NATIONAL_ID) {
            $rules['front_of_id'] = ['required', 'image', 'mimes:jpeg,jpg,png', 'max:4096'];
            $rules['back_of_id'] = ['required', 'image', 'mimes:jpeg,jpg,png', 'max:4096'];
            $rules['national_id_number'] = ['required', 'string', 'block_patterns', 'max:30'];
            $documentNumber = $request->national_id_number;
        } elseif ($request->document_type == KycVerification::DOCUMENT_TYPE_PASSPORT) {
            $rules['passport'] = ['required', 'image', 'mimes:jpeg,jpg,png', 'max:4096'];
            $rules['passport_number'] = ['required', 'string', 'block_patterns', 'max:30'];
            $documentNumber = $request->passport_number;
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $user = authUser();

        if ($user->isKycVerified() || $user->isKycPending()) {
            return back();
        }

        $documents = ['front_of_id' => null, 'back_of_id' => null, 'passport' => null, 'selfie' => null];

        $hashId = strtolower(hash_encode($user->id));

        if ($request->document_type == KycVerification::DOCUMENT_TYPE_NATIONAL_ID) {
            $documents['front_of_id'] = storageFileUpload($request->file('front_of_id'), "kyc/docs/{$hashId}/", 'local');
            $documents['back_of_id'] = storageFileUpload($request->file('back_of_id'), "kyc/docs/{$hashId}/", 'local');
        } elseif ($request->document_type == KycVerification::DOCUMENT_TYPE_PASSPORT) {
            $documents['passport'] = storageFileUpload($request->file('passport'), "kyc/docs/{$hashId}/", 'local');
        }

        if (@settings('kyc')->selfie_verification) {
            $documents['selfie'] = storageFileUpload($request->file('selfie'), "kyc/docs/{$hashId}/", 'local');
        }

        $kycVerification = new KycVerification();
        $kycVerification->user_id = $user->id;
        $kycVerification->document_type = $request->document_type;
        $kycVerification->document_number = $documentNumber;
        $kycVerification->documents = $documents;
        $kycVerification->save();

        dispatch(new SendAdminKycPendingNotification($kycVerification));

        toastr()->success(translate('Your documents has been submitted successfully'));
        return back();
    }
}
