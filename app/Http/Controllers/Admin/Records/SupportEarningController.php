<?php

namespace App\Http\Controllers\Admin\Records;

use App\Http\Controllers\Controller;
use App\Models\SupportEarning;
use Carbon\Carbon;

class SupportEarningController extends Controller
{
    public function index()
    {
        $supportEarnings = SupportEarning::query();

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $supportEarnings->where(function ($query) use ($searchTerm) {
                $query->where('id', 'like', $searchTerm)
                    ->OrWhere('purchase_id', 'like', $searchTerm)
                    ->OrWhere('name', 'like', $searchTerm)
                    ->OrWhere('title', 'like', $searchTerm)
                    ->OrWhere('support_expiry_at', 'like', $searchTerm);
            });
        }

        if (request()->filled('date_from')) {
            $dateFrom = Carbon::parse(request('date_from'))->startOfDay();
            $supportEarnings->where('created_at', '>=', $dateFrom);
        }

        if (request()->filled('date_to')) {
            $dateTo = Carbon::parse(request('date_to'))->endOfDay();
            $supportEarnings->where('created_at', '<=', $dateTo);
        }

        $filteredSupportEarnings = $supportEarnings->get();
        $counters['active'] = $filteredSupportEarnings->where('status', SupportEarning::STATUS_ACTIVE)->count();
        $counters['refunded'] = $filteredSupportEarnings->where('status', SupportEarning::STATUS_REFUNDED)->count();
        $counters['cancelled'] = $filteredSupportEarnings->where('status', SupportEarning::STATUS_CANCELLED)->count();

        $supportEarnings = $supportEarnings->orderbyDesc('id')->paginate(50);
        $supportEarnings->appends(request()->only(['search', 'date_from', 'date_to']));

        return view('admin.records.support-earnings.index', [
            'counters' => $counters,
            'supportEarnings' => $supportEarnings,
        ]);
    }

    public function show(SupportEarning $supportEarning)
    {
        return view('admin.records.support-earnings.show', [
            'supportEarning' => $supportEarning,
        ]);
    }
}