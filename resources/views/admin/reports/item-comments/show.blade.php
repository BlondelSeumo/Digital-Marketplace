@extends('admin.layouts.grid')
@section('section', translate('Reported Item Comments'))
@section('title',
    translate('Reported Item Comments #:item_comment_report_id', [
    'item_comment_report_id' => $itemCommentReport->id,
    ]))
@section('back', route('admin.reports.item-comments.index'))
@section('container', 'container-max-lg')
@section('content')
    @php
        $commentReply = $itemCommentReport->commentReply;
    @endphp
    <div class="conversation mb-4">
        <div class="card">
            <div class="card-header">{{ translate('Reported Comment') }}</div>
            <div class="card-body p-4">
                <div class="mb-4">
                    <div class="row row-cols-auto justify-content-between align-items-center g-3">
                        <div class="col">
                            <a href="{{ route('admin.members.users.edit', $commentReply->user->id) }}"
                                class="conversation-user">
                                <img src="{{ $commentReply->user->getAvatar() }}" alt="Vironeer">
                                <span class="h6 mb-0">{{ $commentReply->user->username }}</span>
                            </a>
                        </div>
                        <div class="col">
                            <time class="text-muted small">{{ dateFormat($commentReply->created_at) }}</time>
                        </div>
                    </div>
                </div>
                <div class="conversation-content">
                    <div class="bg-light p-3 border rounded-2">
                        {!! purifier($commentReply->body) !!}
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('items.comment', [
                            $itemCommentReport->commentReply->comment->item->slug,
                            $itemCommentReport->commentReply->comment->item->id,
                            $itemCommentReport->commentReply->comment->id,
                        ]) }}"
                            target="_blank" class="btn btn-outline-secondary"><i
                                class="fa-solid fa-up-right-from-square me-2"></i>{{ translate('View Comment') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">{{ translate('Report details') }}</div>
        <div class="card-body p-4">
            <div class="mb-3">
                <label class="form-label">{{ translate('Report By') }}</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control form-control-md" readonly
                        value="{{ $itemCommentReport->user->username }}">
                    <button class="btn btn-outline-primary"><a
                            href="{{ route('admin.members.users.edit', $itemCommentReport->user->id) }}" target="_blank"><i
                                class="fa-solid fa-up-right-from-square"></i></a>
                    </button>
                </div>
            </div>
            <div>
                <label class="form-label">{{ translate('Report Reason') }}</label>
                <textarea class="form-control" rows="8" readonly>{{ $itemCommentReport->reason }}</textarea>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">{{ translate('Take Action') }}</div>
        <div class="card-body p-4">
            <div class="row row-cols-1 row-cols-lg-2">
                <div class="col">
                    <form action="{{ route('admin.reports.item-comments.delete', $itemCommentReport->id) }}"
                        method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger action-confirm btn-md w-100">
                            <i class="fa-regular fa-trash-can me-1"></i>
                            {{ translate('Delete Comment') }}
                        </button>
                    </form>
                </div>
                <div class="col">
                    <form action="{{ route('admin.reports.item-comments.keep', $itemCommentReport->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-success action-confirm btn-md w-100">
                            <i class="fa-regular fa-circle-check me-1"></i>
                            {{ translate('Keep Comment') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
