@extends('admin.layouts.grid')
@section('section', translate('Reports'))
@section('title', translate('Reported Item Comments'))
@section('container', 'container-max-xxl')
@section('content')
    <div class="card">
        <div class="card-header p-3 border-bottom-small">
            <form action="{{ url()->current() }}" method="GET">
                <div class="row g-3">
                    <div class="col-12 col-lg-10">
                        <input type="text" name="search" class="form-control" placeholder="{{ translate('Search...') }}"
                            value="{{ request('search') ?? '' }}">
                    </div>
                    <div class="col">
                        <button class="btn btn-primary w-100"><i class="fa fa-search"></i></button>
                    </div>
                    <div class="col">
                        <a href="{{ url()->current() }}" class="btn btn-secondary w-100">{{ translate('Reset') }}</a>
                    </div>
                </div>
            </form>
        </div>
        <div>
            @if ($itemCommentReports->count() > 0)
                <div class="overflow-hidden">
                    <div class="table-custom-container">
                        <table class="table-custom table">
                            <thead>
                                <tr class="bg-light">
                                    <th>{{ translate('ID') }}</th>
                                    <th>{{ translate('Comment ID') }}</th>
                                    <th class="text-center">{{ translate('Reported By') }}</th>
                                    <th>{{ translate('Reason') }}</th>
                                    <th class="text-center">{{ translate('Date') }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($itemCommentReports as $itemCommentReport)
                                    <tr>
                                        <td>
                                            <a
                                                href="{{ route('admin.reports.item-comments.show', $itemCommentReport->id) }}"><i
                                                    class="fa-solid fa-hashtag me-1"></i>{{ $itemCommentReport->id }}</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('items.comment', [
                                                $itemCommentReport->commentReply->comment->item->slug,
                                                $itemCommentReport->commentReply->comment->item->id,
                                                $itemCommentReport->commentReply->comment->id,
                                            ]) }}"
                                                target="_blank" class="text-dark">
                                                <i
                                                    class="fa-solid fa-up-right-from-square me-1"></i>#{{ $itemCommentReport->commentReply->comment->id }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.members.users.edit', $itemCommentReport->user->id) }}"
                                                class="text-dark" target="_blank">
                                                <i class="fa-regular fa-user me-1"></i>
                                                {{ $itemCommentReport->user->username }}
                                            </a>
                                        </td>
                                        <td>
                                            <textarea class="form-control" rows="2" readonly>{{ $itemCommentReport->reason }}</textarea>
                                        </td>
                                        <td class="text-center">{{ dateFormat($itemCommentReport->created_at) }}</td>
                                        <td>
                                            <div class="text-end">
                                                <button type="button" class="btn btn-sm rounded-3"
                                                    data-bs-toggle="dropdown" aria-expanded="true">
                                                    <i class="fa fa-ellipsis-v fa-sm text-muted"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-sm-end"
                                                    data-popper-placement="bottom-end">
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('items.comment', [
                                                                $itemCommentReport->commentReply->comment->item->slug,
                                                                $itemCommentReport->commentReply->comment->item->id,
                                                                $itemCommentReport->commentReply->comment->id,
                                                            ]) }}"
                                                            target="_blank">
                                                            <i class="fa-solid fa-up-right-from-square me-1"></i>
                                                            {{ translate('View Comment') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <hr class="dropdown-divider" />
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item text-success"
                                                            href="{{ route('admin.reports.item-comments.show', $itemCommentReport->id) }}">
                                                            <i class="fa-solid fa-gavel me-1"></i>
                                                            {{ translate('Take Action') }}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                @include('admin.partials.empty', ['empty_classes' => 'empty-lg'])
            @endif
        </div>
    </div>
    {{ $itemCommentReports->links() }}
@endsection
