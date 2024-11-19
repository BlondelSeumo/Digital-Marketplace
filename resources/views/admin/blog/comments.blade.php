@extends('admin.layouts.grid')
@section('section', translate('Blog'))
@section('title', translate('Blog Comments'))
@section('content')
    <div class="card">
        <table class="table datatable w-100">
            <thead>
                <tr>
                    <th class="tb-w-2x">#</th>
                    <th class="tb-w-7x">{{ translate('Posted by') }}</th>
                    <th class="tb-w-7x">{{ translate('Article') }}</th>
                    <th class="tb-w-3x">{{ translate('Status') }}</th>
                    <th class="tb-w-7x">{{ translate('Posted date') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($comments as $comment)
                    <tr>
                        <td>{{ $comment->id }}</td>
                        <td>
                            <a href="{{ route('admin.members.users.edit', $comment->user->id) }}" class="text-dark">
                                <i class="fa fa-user me-2"></i>{{ $comment->user->getName() }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('admin.blog.articles.edit', $comment->article->id) }}" class="text-dark"><i
                                    class="fa-solid fa-file-lines me-2"></i>{{ shorterText($comment->article->title, 30) }}</a>
                        </td>
                        <td>
                            @if ($comment->status)
                                <span class="badge bg-success">{{ translate('Published') }}</span>
                            @else
                                <span class="badge bg-warning">{{ translate('Pending') }}</span>
                            @endif
                        </td>
                        <td>{{ dateFormat($comment->created_at) }}</td>
                        <td>
                            <div class="text-end">
                                <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown"
                                    aria-expanded="true">
                                    <i class="fa fa-ellipsis-v fa-sm text-muted"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-sm-end" data-popper-placement="bottom-end">
                                    <li>
                                        <a class="vironeer-view-comment dropdown-item" data-id="{{ $comment->id }}"
                                            href="#"><i class="fa fa-eye me-2"></i>{{ translate('View') }}</a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider" />
                                    </li>
                                    <li>
                                        <form action="{{ route('admin.blog.comments.destroy', $comment->id) }}"
                                            method="POST">
                                            @csrf @method('DELETE')
                                            <button class="action-confirm dropdown-item text-danger"><i
                                                    class="far fa-trash-alt me-2"></i>{{ translate('Delete') }}</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="viewComment" tabindex="-1" aria-labelledby="viewCommentLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewCommentLabel">{{ translate('View Comment') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <textarea id="comment" class="form-control" rows="10" disabled></textarea>
                </div>
                <div class="modal-footer">
                    <form id="deleteCommentForm" class="d-inline" action="#" method="POST">
                        @csrf @method('DELETE')
                        <button class="action-confirm btn btn-danger"><i
                                class="far fa-trash-alt me-2"></i>{{ translate('Delete') }}</button>
                    </form>
                    <form id="publishCommentForm" class="d-inline" action="#" method="POST">
                        @csrf
                        <button class="action-confirm publish-comment-btn btn btn-success"><i
                                class="far fa-check-circle me-2"></i>{{ translate('Publish') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
