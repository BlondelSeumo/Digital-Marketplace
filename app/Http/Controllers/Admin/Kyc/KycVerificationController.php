<?php

namespace App\Http\Controllers\Admin\Kyc;

use App\Http\Controllers\Controller;
use App\Jobs\SendKycApprovedNotification;
use App\Models\KycVerification;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class KycVerificationController extends Controller
{
    public function index()
    {
        $kycVerifications = KycVerification::query();

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $kycVerifications->where(function ($query) use ($searchTerm) {
                $query->where('id', 'like', $searchTerm)
                    ->orWhere('user_id', 'like', $searchTerm)
                    ->orWhere('document_type', 'like', $searchTerm)
                    ->orWhere('document_number', 'like', $searchTerm);
            });
        }

        if (request()->filled('user')) {
            $kycVerifications->where('user_id', request('user'));
        }

        if (request()->filled('status')) {
            $kycVerifications->where('status', request('status'));
        }

        if (request()->filled('document_type')) {
            $kycVerifications->where('document_type', request('document_type'));
        }

        $filteredKycVerifications = $kycVerifications->get();

        $counters['pending'] = $filteredKycVerifications->where('status', KycVerification::STATUS_PENDING)->count();
        $counters['approved'] = $filteredKycVerifications->where('status', KycVerification::STATUS_APPROVED)->count();
        $counters['rejected'] = $filteredKycVerifications->where('status', KycVerification::STATUS_REJECTED)->count();

        $kycVerifications = $kycVerifications->orderbyDesc('id')->paginate(50);
        $kycVerifications->appends(request()->only(['search', 'user', 'status', 'document_type']));

        return view('admin.kyc.kyc-verifications.index', [
            'counters' => $counters,
            'kycVerifications' => $kycVerifications,
        ]);
    }

    public function document(KycVerification $kycVerification, $document)
    {
        try {
            $document = $kycVerification->documents->$document;
            abort_if(!$document, 404);
            $file = Storage::disk('local')->get($document);
            $response = \Response::make($file, 200);
            $response->header("Content-Type", Storage::mimeType($document));
            return $response;
        } catch (Exception $e) {
            return abort(404);
        }
    }

    public function review(KycVerification $kycVerification)
    {
        return view('admin.kyc.kyc-verifications.review', ['kycVerification' => $kycVerification]);
    }

    public function download(KycVerification $kycVerification, $document)
    {
        try {
            $document = $kycVerification->documents->$document;
            abort_if(!$document, 404);
            return Storage::disk('local')->download($document);
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }

    public function approve(Request $request, KycVerification $kycVerification)
    {
        abort_if(!$kycVerification->isPending(), 403);

        $kycVerification->status = KycVerification::STATUS_APPROVED;
        $kycVerification->update();

        dispatch(new SendKycApprovedNotification($kycVerification));

        $user = $kycVerification->user;
        $user->kyc_status = User::KYC_STATUS_VERIFIED;
        $user->update();

        toastr()->success(translate('KYC Verification has been Approved'));
        return back();
    }

    public function reject(Request $request, KycVerification $kycVerification)
    {
        abort_if(!$kycVerification->isPending(), 403);

        $validator = Validator::make($request->all(), [
            'rejection_reason' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $kycVerification->status = KycVerification::STATUS_REJECTED;
        $kycVerification->rejection_reason = $request->rejection_reason;
        $kycVerification->update();

        if ($request->has('email_notification')) {
            dispatch(new SendKycRejectedNotification($kycVerification));
        }

        toastr()->success(translate('KYC Verification has been Rejected'));
        return back();
    }

    public function destroy(KycVerification $kycVerification)
    {
        $kycVerification->delete();
        toastr()->success(translate('Deleted Successfully'));
        return back();
    }
}