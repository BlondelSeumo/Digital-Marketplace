<?php

namespace App\Http\Controllers\Admin;

use App\Events\TransactionPaid;
use App\Http\Controllers\Controller;
use App\Jobs\SendTransactionCancelledNotification;
use App\Models\PaymentGateway;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function index()
    {
        $paymentGateways = PaymentGateway::all();

        $transactions = Transaction::whereNot('status', Transaction::STATUS_UNPAID);

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $transactions->where(function ($query) use ($searchTerm) {
                $query->where('id', 'like', $searchTerm)
                    ->orWhere('payment_id', 'like', $searchTerm)
                    ->orWhere('payer_id', 'like', $searchTerm)
                    ->orWhere('payer_email', 'like', $searchTerm)
                    ->orWhereHas('user', function ($query) use ($searchTerm) {
                        $query->where('firstname', 'like', $searchTerm)
                            ->OrWhere('lastname', 'like', $searchTerm)
                            ->OrWhere('username', 'like', $searchTerm)
                            ->OrWhere('email', 'like', $searchTerm)
                            ->OrWhere('address', 'like', $searchTerm);
                    })
                    ->orWhereHas('paymentGateway', function ($query) use ($searchTerm) {
                        $query->where('name', 'like', $searchTerm);
                    });
            });
        }

        if (request()->filled('date_from')) {
            $dateFrom = Carbon::parse(request('date_from'));
            $transactions->where('created_at', '>=', $dateFrom);
        }

        if (request()->filled('date_to')) {
            $dateTo = Carbon::parse(request('date_to'));
            $transactions->where('created_at', '<=', $dateTo);
        }

        if (request()->filled('user')) {
            $transactions->where('user_id', request('user'));
        }

        if (request()->filled('status')) {
            $transactions->where('status', request('status'));
        }

        if (request()->filled('payment_method')) {
            $transactions->where('payment_gateway_id', request('payment_method'));
        }

        $filteredTransactions = $transactions->get();
        $counters['pending']['total'] = $filteredTransactions->where('status', Transaction::STATUS_PENDING)->count();
        $counters['pending']['amount'] = $filteredTransactions->where('status', Transaction::STATUS_PENDING)->sum('total');
        $counters['paid']['total'] = $filteredTransactions->where('status', Transaction::STATUS_PAID)->count();
        $counters['paid']['amount'] = $filteredTransactions->where('status', Transaction::STATUS_PAID)->sum('total');
        $counters['cancelled']['total'] = $filteredTransactions->where('status', Transaction::STATUS_CANCELLED)->count();
        $counters['cancelled']['amount'] = $filteredTransactions->where('status', Transaction::STATUS_CANCELLED)->sum('total');

        $transactions = $transactions->orderbyDesc('id')->paginate(20);
        $transactions->appends(request()->only(['search', 'date_from', 'date_to', 'user', 'status', 'payment_method']));

        return view('admin.transactions.index', [
            'paymentGateways' => $paymentGateways,
            'counters' => $counters,
            'transactions' => $transactions,
        ]);
    }

    public function review(Transaction $transaction)
    {
        return view('admin.transactions.review', ['trx' => $transaction]);
    }

    public function paymentProof(Transaction $transaction)
    {
        abort_if(!$transaction->payment_proof, 404);

        try {
            $disk = Storage::disk('local');
            $file = $disk->get($transaction->payment_proof);
            $response = \Response::make($file, 200);
            $response->header("Content-Type", $disk->mimeType($transaction->payment_proof));
            return $response;
        } catch (\Exception $e) {
            return abort(404);
        }
    }

    public function paid(Request $request, Transaction $transaction)
    {
        if ($transaction->isPending()) {
            $transaction->status = Transaction::STATUS_PAID;
            $transaction->save();
            event(new TransactionPaid($transaction));
            toastr()->success(translate('Transaction has been paid successfully'));
        }

        return back();
    }

    public function cancel(Request $request, Transaction $transaction)
    {
        $validator = Validator::make($request->all(), [
            'cancellation_reason' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        if (!$transaction->isCancelled()) {
            $transaction->cancellation_reason = $request->cancellation_reason;
            $transaction->status = Transaction::STATUS_CANCELLED;
            $transaction->save();

            if ($request->has('email_notification')) {
                dispatch(new SendTransactionCancelledNotification($transaction));
            }

            toastr()->success(translate('Transaction has been cancelled successfully'));
        }

        return back();
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        toastr()->success(translate('Deleted Successfully'));
        return back();
    }
}