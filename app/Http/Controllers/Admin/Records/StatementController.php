<?php

namespace App\Http\Controllers\Admin\Records;

use App\Http\Controllers\Controller;
use App\Models\Statement;
use Carbon\Carbon;

class StatementController extends Controller
{
    public function index()
    {
        $statements = Statement::query();

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $statements->where(function ($query) use ($searchTerm) {
                $query->where('id', 'like', $searchTerm)
                    ->OrWhere('title', 'like', $searchTerm)
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
            $statements->where('user_id', request('user'));
        }

        if (request()->filled('date_from')) {
            $dateFrom = Carbon::parse(request('date_from'))->startOfDay();
            $statements->where('created_at', '>=', $dateFrom);
        }

        if (request()->filled('date_to')) {
            $dateTo = Carbon::parse(request('date_to'))->endOfDay();
            $statements->where('created_at', '<=', $dateTo);
        }

        $filteredStatements = $statements->get();
        $counters['credit']['total'] = $filteredStatements->where('type', Statement::TYPE_CREDIT)->count();
        $counters['credit']['amount'] = $filteredStatements->where('type', Statement::TYPE_CREDIT)->sum('amount');
        $counters['debit']['total'] = $filteredStatements->where('type', Statement::TYPE_DEBIT)->count();
        $counters['debit']['amount'] = $filteredStatements->where('type', Statement::TYPE_DEBIT)->sum('amount');

        $statements = $statements->orderbyDesc('id')->paginate(50);
        $statements->appends(request()->only(['search', 'user', 'date_from', 'date_to']));

        return view('admin.records.statements', [
            'counters' => $counters,
            'statements' => $statements,
        ]);
    }

    public function destroy(Statement $statement)
    {
        $statement->delete();
        toastr()->success(translate('Deleted Successfully'));
        return back();
    }
}