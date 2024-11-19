<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Jobs\Admin\SendAdminRefundNotification;
use App\Jobs\Admin\SendAdminRefundReplyNotification;
use App\Models\Purchase;
use App\Models\Refund;
use App\Models\RefundReply;
use Illuminate\Http\Request;
use Validator;

class RefundController extends Controller
{
    public function index()
    {
        $refunds = Refund::where(function ($query) {
            $query->where('user_id', authUser()->id);
        });

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $refunds->where(function ($query) use ($searchTerm) {
                $query->where('id', 'like', $searchTerm)
                    ->OrWhereHas('purchase', function ($query) use ($searchTerm) {
                        $query->where('id', 'like', $searchTerm)
                            ->OrWhereHas('item', function ($query) use ($searchTerm) {
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
                    });
            });

        }

        if (request()->filled('status')) {
            $refunds->where('status', request('status'));
        }

        $refunds = $refunds->with('purchase')->orderbyDesc('id')->paginate(20);
        $refunds->appends(request()->only(['search', 'status']));

        return theme_view('user.refunds.index', [
            'refunds' => $refunds,
        ]);
    }

    public function create()
    {
        $purchases = Purchase::where('user_id', authUser()->id)
            ->active()->orderbyDesc('id')
            ->get();

        return theme_view('user.refunds.create', [
            'purchases' => $purchases,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'purchase' => ['required', 'integer'],
            'reason' => ['required', 'string', 'max:5000'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $user = authUser();

        $purchase = Purchase::where('id', $request->purchase)
            ->where('user_id', $user->id)
            ->active()
            ->firstOrFail();

        $refund = Refund::where('purchase_id', $purchase->id)->pending()->first();
        if ($refund) {
            toastr()->error(translate('You have pending refund request for that item already'));
            return back();
        }

        $item = $purchase->item;

        $refund = new Refund();
        $refund->user_id = $user->id;
        $refund->purchase_id = $purchase->id;
        $refund->save();

        $refundReply = new RefundReply();
        $refundReply->refund_id = $refund->id;
        $refundReply->user_id = $user->id;
        $refundReply->body = $request->reason;
        $refundReply->save();

        dispatch(new SendAdminRefundNotification($refund, $refundReply));

        toastr()->success(translate('Your refund request has been submitted successfully'));
        return redirect()->route('user.refunds.index');
    }

    public function show($id)
    {
        $refund = Refund::where('id', $id)
            ->where('user_id', authUser()->id)
            ->with(['purchase', 'user', 'replies'])
            ->firstOrFail();

        return theme_view('user.refunds.show', [
            'refund' => $refund,
        ]);
    }

    public function reply(Request $request, $id)
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

        $user = authUser();

        $refund = Refund::where('id', $id)
            ->where('user_id', $user->id)
            ->pending()
            ->firstOrFail();

        $refundReply = new RefundReply();
        $refundReply->refund_id = $refund->id;
        $refundReply->user_id = $user->id;
        $refundReply->body = $request->reply;
        $refundReply->save();

        dispatch(new SendAdminRefundReplyNotification($refundReply));

        toastr()->success(translate('Your reply has been sent successfully'));
        return back();
    }
}