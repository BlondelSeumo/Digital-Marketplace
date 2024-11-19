<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Models\ItemCommentReport;

class ItemCommentsController extends Controller
{
    public function index()
    {
        $itemCommentReports = ItemCommentReport::query();

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $itemCommentReports->where(function ($query) use ($searchTerm) {
                $query->where('id', 'like', $searchTerm)
                    ->OrWhere('reason', 'like', $searchTerm)
                    ->orWhereHas('user', function ($query) use ($searchTerm) {
                        $query->where('firstname', 'like', $searchTerm)
                            ->OrWhere('lastname', 'like', $searchTerm)
                            ->OrWhere('username', 'like', $searchTerm)
                            ->OrWhere('email', 'like', $searchTerm)
                            ->OrWhere('address', 'like', $searchTerm);
                    })
                    ->orWhereHas('commentReply', function ($query) use ($searchTerm) {
                        $query->where('id', 'like', $searchTerm)
                            ->OrWhere('body', 'like', $searchTerm)
                            ->orWhereHas('user', function ($query) use ($searchTerm) {
                                $query->where('firstname', 'like', $searchTerm)
                                    ->OrWhere('lastname', 'like', $searchTerm)
                                    ->OrWhere('username', 'like', $searchTerm)
                                    ->OrWhere('email', 'like', $searchTerm)
                                    ->OrWhere('address', 'like', $searchTerm);
                            })
                            ->orWhereHas('comment', function ($query) use ($searchTerm) {
                                $query->where('id', 'like', $searchTerm)
                                    ->OrWhere('body', 'like', $searchTerm)
                                    ->orWhereHas('user', function ($query) use ($searchTerm) {
                                        $query->where('firstname', 'like', $searchTerm)
                                            ->OrWhere('lastname', 'like', $searchTerm)
                                            ->OrWhere('username', 'like', $searchTerm)
                                            ->OrWhere('email', 'like', $searchTerm)
                                            ->OrWhere('address', 'like', $searchTerm);
                                    });
                            });
                    });
            });
        }

        $itemCommentReports = $itemCommentReports->with('commentReply')->orderbyDesc('id')->paginate(20);
        $itemCommentReports->appends(request()->only(['search']));

        return view('admin.reports.item-comments.index', [
            'itemCommentReports' => $itemCommentReports,
        ]);
    }

    public function show(ItemCommentReport $itemCommentReport)
    {
        return view('admin.reports.item-comments.show', [
            'itemCommentReport' => $itemCommentReport,
        ]);
    }

    public function keep(ItemCommentReport $itemCommentReport)
    {
        $itemCommentReport->delete();
        toastr()->success(translate('The comment has been kept successfully'));
        return redirect()->route('admin.reports.item-comments.index');
    }

    public function delete(ItemCommentReport $itemCommentReport)
    {
        $itemCommentReply = $itemCommentReport->commentReply;
        $itemComment = $itemCommentReply->comment;
        $replies = $itemComment->replies;

        if ($replies->first()->id === $itemCommentReply->id) {
            $itemCommentReply->comment->delete();
        } else {
            $itemCommentReply->delete();
        }

        $itemCommentReport->delete();
        toastr()->success(translate('The comment has been deleted successfully'));
        return redirect()->route('admin.reports.item-comments.index');
    }
}