<?php

namespace App\Http\Controllers\Admin\Records;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::query();

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $purchases->where(function ($query) use ($searchTerm) {
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
            $purchases->where('user_id', request('user'));
        }

        if (request()->filled('item')) {
            $purchases->where('item_id', request('item'));
        }

        if (request()->filled('date_from')) {
            $dateFrom = Carbon::parse(request('date_from'))->startOfDay();
            $purchases->where('created_at', '>=', $dateFrom);
        }

        if (request()->filled('date_to')) {
            $dateTo = Carbon::parse(request('date_to'))->endOfDay();
            $purchases->where('created_at', '<=', $dateTo);
        }

        $filteredPurchases = $purchases->get();
        $counters['active'] = $filteredPurchases->where('status', Purchase::STATUS_ACTIVE)->count();
        $counters['refunded'] = $filteredPurchases->where('status', Purchase::STATUS_REFUNDED)->count();
        $counters['cancelled'] = $filteredPurchases->where('status', Purchase::STATUS_CANCELLED)->count();

        $purchases = $purchases->orderbyDesc('id')->paginate(50);
        $purchases->appends(request()->only(['search', 'user', 'item', 'date_from', 'date_to']));

        return view('admin.records.purchases.index', [
            'counters' => $counters,
            'purchases' => $purchases,
        ]);
    }

    public function show(Purchase $purchase)
    {
        return view('admin.records.purchases.show', ['purchase' => $purchase]);
    }
}