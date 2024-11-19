<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class PremiumController extends Controller
{
    public function index()
    {
        $countPlans = Plan::active()->count();

        $weeklyPlans = Plan::weekly()->active()->get();
        $monthlyPlans = Plan::monthly()->active()->get();
        $yearlyPlans = Plan::yearly()->active()->get();
        $lifetimePlans = Plan::lifetime()->active()->get();

        return theme_view('premium', [
            'countPlans' => $countPlans,
            'weeklyPlans' => $weeklyPlans,
            'monthlyPlans' => $monthlyPlans,
            'yearlyPlans' => $yearlyPlans,
            'lifetimePlans' => $lifetimePlans,
        ]);
    }

    public function subscribe(Request $request, $id)
    {
        $plan = Plan::where('id', $id)->active()->firstOrFail();

        $user = authUser();

        try {
            $subscription = $user->subscription;

            if ($subscription) {
                if ($subscription->plan->isLifetime()) {
                    toastr()->error(translate('You are in a lifetime plan it cannot be renewed'));
                    return back();
                }

                if ($subscription->plan->id == $plan->id) {
                    if (!$subscription->isAboutToExpire() && !$subscription->isExpired()) {
                        toastr()->error(translate('You have subscribed in this plan already'));
                        return back();
                    }

                    if ($subscription->plan->isFree()) {
                        if ($subscription->isExpired()) {
                            toastr()->error(translate('Your free plan has already expired and it cannot be renewed'));
                        }
                        return back();
                    }
                } else {
                    if ($plan->isFree()) {
                        toastr()->error(translate('You are not eligible for the free plan subscription'));
                        return back();
                    }
                }
            }

            if ($plan->isFree() && $user->wasSubscribed()) {
                toastr()->error(translate('You are not eligible for the free plan subscription'));
                return back();
            }

            if ($plan->isFree()) {
                $subscription = self::handleSubscription($user, $plan);
                if ($subscription) {
                    return redirect()->route('user.settings.index');
                }
            }

            $transaction = new Transaction();
            $transaction->user_id = $user->id;
            $transaction->amount = $plan->price;
            $transaction->total = $plan->price;
            $transaction->type = Transaction::TYPE_SUBSCRIPTION;
            $transaction->plan_id = $plan->id;
            $transaction->save();

            return redirect()->route('checkout.index', hash_encode($transaction->id));

        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }

    public static function handleSubscription($user, $plan)
    {
        $subscription = $user->subscription;

        $expiryDate = null;

        if (!$plan->isLifetime()) {
            if ($subscription) {
                if ($plan->id == $subscription->plan->id) {
                    $expiryDate = $subscription->isExpired()
                    ? Carbon::now()->addDays($plan->getIntervalDays())
                    : Carbon::parse($subscription->expiry_at)->addDays($plan->getIntervalDays());
                } else {
                    $expiryDate = Carbon::now()->addDays($plan->getIntervalDays());
                }
            } else {
                $expiryDate = Carbon::now()->addDays($plan->getIntervalDays());
            }
        }

        $subscription = $user->subscription()->updateOrCreate(['user_id' => $user->id],
            [
                'plan_id' => $plan->id,
                'total_downloads' => 0,
                'expiry_at' => $expiryDate,
                'last_notification_at' => null,
            ]
        );

        $user->was_subscribed = User::WAS_SUBSCRIBED;
        $user->update();

        return $subscription;
    }
}
