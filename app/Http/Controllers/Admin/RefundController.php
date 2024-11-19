<?php

namespace App\Http\Controllers\Admin;

use App\Events\RefundAccepted;
use App\Http\Controllers\Controller;
use App\Jobs\SendRefundDeclinedNotification;
use App\Jobs\SendRefundReplyNotification;
use App\Models\Refund;
use App\Models\RefundReply;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RefundController extends Controller
{
    public function index()
    {
        $refunds = Refund::query();

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $refunds->where(function ($query) use ($searchTerm) {
                $query->where('id', 'like', $searchTerm)
                    ->OrWhereHas('purchase', function ($query) use ($searchTerm) {
                        $query->where('id', 'like', $searchTerm)
                            ->orWhereHas('item', function ($query) use ($searchTerm) {
                                $query->where('id', 'like', $searchTerm)
                                    ->OrWhere('name', 'like', $searchTerm)
                                    ->OrWhere('slug', 'like', $searchTerm)
                                    ->OrWhere('description', 'like', $searchTerm)
                                    ->OrWhere('options', 'like', $searchTerm)
                                    ->OrWhere('demo_link', 'like', $searchTerm)
                                    ->OrWhere('tags', 'like', $searchTerm)
                                    ->OrWhere('regular_price', 'like', $searchTerm)
                                    ->OrWhere('extended_price', 'like', $searchTerm);
                            });
                    })
                    ->orWhereHas('user', function ($query) use ($searchTerm) {
                        $query->where('id', 'like', $searchTerm)
                            ->OrWhere('firstname', 'like', $searchTerm)
                            ->OrWhere('lastname', 'like', $searchTerm)
                            ->OrWhere('username', 'like', $searchTerm)
                            ->OrWhere('email', 'like', $searchTerm)
                            ->OrWhere('address', 'like', $searchTerm);
                    });
            });
        }

        if (request()->filled('user')) {
            $refunds->where('user_id', request('user'));
        }

        if (request()->filled('date_from')) {
            $dateFrom = Carbon::parse(request('date_from'))->startOfDay();
            $refunds->where('created_at', '>=', $dateFrom);
        }

        if (request()->filled('date_to')) {
            $dateTo = Carbon::parse(request('date_to'))->endOfDay();
            $refunds->where('created_at', '<=', $dateTo);
        }

        $filteredRefunds = $refunds->get();
        $counters['pending'] = $filteredRefunds->where('status', Refund::STATUS_PENDING)->count();
        $counters['accepted'] = $filteredRefunds->where('status', Refund::STATUS_ACCEPTED)->count();
        $counters['declined'] = $filteredRefunds->where('status', Refund::STATUS_DECLINED)->count();

        $refunds = $refunds->orderbyDesc('id')->paginate(50);
        $refunds->appends(request()->only(['search', 'user', 'date_from', 'date_to']));

        return view('admin.refunds.index', [
            'counters' => $counters,
            'refunds' => $refunds,
        ]);
    }

    public function show(Refund $refund)
    {
        return view('admin.refunds.show', ['refund' => $refund]);
    }

    public function reply(Request $request, Refund $refund)
    {
        $validator = Validator::make($request->all(), [
            'reply' => ['required', 'string', 'max:5000'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        abort_if(!$refund->isPending(), 404);

        $user = authUser();

        $refundReply = new RefundReply();
        $refundReply->refund_id = $refund->id;
        $refundReply->user_id = $user->id;
        $refundReply->body = $request->reply;
        $refundReply->save();

        dispatch(new SendRefundReplyNotification($refundReply));

        toastr()->success(translate('Your reply has been sent successfully'));
        return back();
    }

    public function decline(Request $request, Refund $refund)
    {
        $validator = Validator::make($request->all(), [
            'reason' => ['required', 'string', 'max:5000'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        abort_if(!$refund->isPending(), 404);

        $user = authUser();

        $refundReply = new RefundReply();
        $refundReply->refund_id = $refund->id;
        $refundReply->user_id = $user->id;
        $refundReply->body = $request->reason;
        $refundReply->save();

        $refund->status = Refund::STATUS_DECLINED;
        $refund->update();

        dispatch(new SendRefundDeclinedNotification($refund, $refundReply));

        toastr()->success(translate('The refund request has been declined'));
        return back();
    }

    public function accept(Request $request, Refund $refund)
    {
        abort_if(!$refund->isPending(), 404);

        $refund->status = Refund::STATUS_ACCEPTED;
        $refund->update();

        event(new RefundAccepted($refund));

        toastr()->success(translate('The refund request has been accepted'));
        return back();
    }

    public function destroy(Refund $refund)
    {
        $refund->delete();
        toastr()->success(translate('Deleted Successfully'));
        return back();
    }
}