<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Statement;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WalletController extends Controller
{
    public function index()
    {
        $statements = Statement::where('user_id', authUser()->id);

        if (request()->filled('date_from')) {
            $statements->where('created_at', '>=', Carbon::parse(request('date_from'))->startOfDay());
        }

        if (request()->filled('date_to')) {
            $statements->where('created_at', '<=', Carbon::parse(request('date_to'))->endOfDay());
        }

        $statements = $statements->orderbyDesc('id')->paginate(20);
        $statements->appends(request()->only(['date_from', 'date_to']));

        return theme_view('user.wallet', [
            'statements' => $statements,
        ]);
    }

    public function deposit(Request $request)
    {
        $depositSettings = settings('deposit');

        $validator = Validator::make($request->all(), [
            'amount' => ['required', 'integer', 'min:' . @$depositSettings->minimum, 'max:' . @$depositSettings->maximum],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $transaction = new Transaction();
        $transaction->user_id = authUser()->id;
        $transaction->amount = $request->amount;
        $transaction->total = $request->amount;
        $transaction->type = Transaction::TYPE_DEPOSIT;
        $transaction->save();

        return redirect()->route('checkout.index', hash_encode($transaction->id));
    }
}