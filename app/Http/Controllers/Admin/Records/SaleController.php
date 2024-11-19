<?php

namespace App\Http\Controllers\Admin\Records;

use App\Events\SaleCancelled;
use App\Http\Controllers\Controller;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::query();

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $sales->where(function ($query) use ($searchTerm) {
                $query->where('id', 'like', $searchTerm)
                    ->OrWhere('country', 'like', $searchTerm)
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
            $sales->where('user_id', request('user'));
        }

        if (request()->filled('item')) {
            $sales->where('item_id', request('item'));
        }

        if (request()->filled('date_from')) {
            $dateFrom = Carbon::parse(request('date_from'))->startOfDay();
            $sales->where('created_at', '>=', $dateFrom);
        }

        if (request()->filled('date_to')) {
            $dateTo = Carbon::parse(request('date_to'))->endOfDay();
            $sales->where('created_at', '<=', $dateTo);
        }

        $filteredSales = $sales->get();
        $counters['active']['total'] = $filteredSales->where('status', Sale::STATUS_ACTIVE)->count();
        $counters['active']['amount'] = $filteredSales->where('status', Sale::STATUS_ACTIVE)->sum('price');
        $counters['refunded']['total'] = $filteredSales->where('status', Sale::STATUS_REFUNDED)->count();
        $counters['refunded']['amount'] = $filteredSales->where('status', Sale::STATUS_REFUNDED)->sum('price');
        $counters['cancelled']['total'] = $filteredSales->where('status', Sale::STATUS_CANCELLED)->count();
        $counters['cancelled']['amount'] = $filteredSales->where('status', Sale::STATUS_CANCELLED)->sum('price');

        $sales = $sales->orderbyDesc('id')->paginate(50);
        $sales->appends(request()->only(['search', 'user', 'item', 'date_from', 'date_to']));

        return view('admin.records.sales.index', [
            'counters' => $counters,
            'sales' => $sales,
        ]);
    }

    public function show(Sale $sale)
    {
        return view('admin.records.sales.show', ['sale' => $sale]);
    }

    public function cancel(Request $request, Sale $sale)
    {
        abort_if(!$sale->isActive(), 404);
        event(new SaleCancelled($sale));
        toastr()->success(translate('Cancelled Successfully'));
        return back();
    }

    public function destroy(Sale $sale)
    {
        $sale->delete();
        toastr()->success(translate('Deleted Successfully'));
        return back();
    }
}