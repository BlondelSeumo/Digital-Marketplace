<?php

namespace App\Http\Controllers\Admin\Premium;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        $plans = Plan::all();

        $subscriptions = Subscription::query();

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $subscriptions->where(function ($query) use ($searchTerm) {
                $query->where('id', 'like', $searchTerm)
                    ->orWhereHas('user', function ($query) use ($searchTerm) {
                        $query->Where('firstname', 'like', $searchTerm)
                            ->OrWhere('lastname', 'like', $searchTerm)
                            ->OrWhere('username', 'like', $searchTerm)
                            ->OrWhere('email', 'like', $searchTerm)
                            ->OrWhere('address', 'like', $searchTerm);
                    });
            });
        }

        if (request()->filled('plan')) {
            $subscriptions->where('plan_id', request('plan'));
        }

        $subscriptions = $subscriptions->orderbyDesc('id')->paginate(20);
        $subscriptions->appends(request()->only(['search', 'plan']));

        return view('admin.premium.subscriptions.index', [
            'plans' => $plans,
            'subscriptions' => $subscriptions,
        ]);
    }

    public function show(Subscription $subscription)
    {
        return view('admin.premium.subscriptions.show', ['subscription' => $subscription]);
    }

    public function cancel(Request $request, Subscription $subscription)
    {
        $subscription->delete();

        toastr()->success(translate('Subscription has been cancelled successfully'));
        return redirect()->route('admin.premium.subscriptions.index');
    }
}