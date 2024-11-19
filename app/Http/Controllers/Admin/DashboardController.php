<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\PremiumEarning;
use App\Models\Refund;
use App\Models\Sale;
use App\Models\Subscription;
use App\Models\SupportEarning;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Jenssegers\Date\Date;

class DashboardController extends Controller
{
    public function index()
    {
        $counters = $this->getCountersData();

        $users = User::user()->orderbyDesc('id')->limit(6)->get();

        $charts['users'] = $this->generateUsersChartData();
        $charts['sales'] = $this->generateSalesChartData();

        $topSellingItems = $this->getTopSellingItems();
        $geoCountries = $this->getGeoCountries();
        $topPurchasingCountries = $this->getTopPurchasingCountries();

        return view('admin.dashboard', [
            'counters' => $counters,
            'users' => $users,
            'charts' => $charts,
            'topSellingItems' => $topSellingItems,
            'geoCountries' => $geoCountries,
            'topPurchasingCountries' => $topPurchasingCountries,
        ]);
    }

    public function getCountersData()
    {
        $counters['total_sales'] = Sale::active()->count();
        $counters['total_sales_amount'] = Sale::active()->sum('total');
        $counters['support_sales'] = SupportEarning::active()->count();
        $counters['support_sales_amount'] = SupportEarning::active()->sum('total');

        $counters['total_items'] = Item::count();
        $counters['total_sales'] = Sale::active()->count();
        $counters['total_refunds'] = Refund::accepted()->count();
        $counters['total_users'] = User::user()->count();
        $counters['total_transactions'] = Transaction::count();
        $counters['total_tickets'] = Ticket::count();

        if (licenseType(2) && @settings('premium')->status) {
            $counters['premium_free_subscriptions'] = Subscription::whereHas('plan', function ($query) {
                $query->free();
            })->count();
            $counters['premium_paid_subscriptions'] = Subscription::whereHas('plan', function ($query) {
                $query->notFree();
            })->count();
            $counters['premium_total_earnings'] = PremiumEarning::sum('total');
        }
        return $counters;
    }

    private function generateUsersChartData()
    {
        $chart['title'] = translate('Users');

        $startDate = Date::now()->startOfMonth();
        $endDate = Date::now()->endOfMonth();
        $dates = chartDates($startDate, $endDate);

        $usersRecord = User::where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');

        $usersRecordData = $dates->merge($usersRecord);

        $chart['labels'] = [];
        $chart['data'] = [];
        foreach ($usersRecordData as $key => $value) {
            $chart['labels'][] = Date::parse($key)->format('d F');
            $chart['data'][] = $value;
        }

        $chart['max'] = (max($chart['data']) > 9) ? max($chart['data']) + 2 : 10;

        return $chart;
    }

    private function generateSalesChartData()
    {
        $chart['title'] = translate('Sales');

        $startDate = Date::now()->startOfMonth();
        $endDate = Date::now()->endOfMonth();
        $dates = chartDates($startDate, $endDate);

        $salesRecord = Sale::active()
            ->where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');

        $salesRecordData = $dates->merge($salesRecord);

        $chart['labels'] = [];
        $chart['data'] = [];
        foreach ($salesRecordData as $key => $value) {
            $chart['labels'][] = Date::parse($key)->format('d F');
            $chart['data'][] = $value;
        }

        $chart['max'] = (max($chart['data']) > 9) ? max($chart['data']) + 2 : 10;

        return $chart;
    }

    private function getTopSellingItems()
    {
        return Sale::active()
            ->select('item_id', DB::raw('COUNT(*) as total_sales'))
            ->groupBy('item_id')
            ->orderByDesc(DB::raw('COUNT(*)'))
            ->limit(6)
            ->get();

    }

    private function getGeoCountries()
    {
        return Sale::active()
            ->whereNotNull('country')
            ->select('country', DB::raw('COUNT(*) as total_sales'))
            ->groupBy('country')
            ->orderbyDesc('total_sales')
            ->get();
    }

    private function getTopPurchasingCountries()
    {
        return Sale::active()
            ->whereNotNull('country')
            ->select('country', DB::raw('SUM(price) as total_spend'))
            ->groupBy('country')
            ->orderbyDesc('total_spend')
            ->limit(7)
            ->get();
    }
}