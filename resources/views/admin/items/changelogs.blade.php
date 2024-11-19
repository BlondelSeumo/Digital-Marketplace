@extends('admin.layouts.grid')
@section('title', $item->name)
@section('item_view', true)
@section('back', route('admin.items.index'))
@section('content')
    <div class="dashboard-tabs">
        @include('admin.items.includes.tabs-nav')
        <div class="dashboard-tabs-content">
            <div class="row g-3">
                <div class="col-lg-7 col-xxl-8 order-2 order-sm-0">
                    <div class="row g-3 row-cols-1">
                        <div class="col">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">{{ translate('New Log') }}</h5>
                                </div>
                                <div class="card-body p-4">
                                    <form action="{{ route('admin.items.changelogs.store', $item->id) }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">{{ translate('Version') }}</label>
                                            <input type="text" name="version" class="form-control form-control-md"
                                                value="{{ old('version') }}" placeholder="{{ translate('1.0 or 1.0.0') }}"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">{{ translate('Body') }}</label>
                                            <textarea name="body" class="form-control" rows="6" required>{{ old('body') }}</textarea>
                                        </div>
                                        <button
                                            class="btn btn-primary btn-md action-confirm">{{ translate('Submit') }}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @foreach ($changelogs as $changelog)
                            <div class="col">
                                <div class="card">
                                    <div class="card-body p-4">
                                        <div class="row align-items-center g-3 mb-3">
                                            <div class="col">
                                                <h6 class="mb-0">
                                                    {{ translate('Version :version', ['version' => $changelog->version]) }}
                                                    -
                                                    <span class="text-muted">{{ dateFormat($changelog->created_at) }}</span>
                                                </h6>
                                            </div>
                                            <div class="col-auto">
                                                <form
                                                    action="{{ route('admin.items.changelogs.delete', [$item->id, $changelog->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        class="btn btn-outline-danger btn-padding btn-sm action-confirm"><i
                                                            class="fa-regular fa-trash-can"></i></button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="changelogs">
                                            <pre>{{ $changelog->body }}</pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{ $changelogs->links() }}
                </div>
                <div class="col-lg-5 col-xxl-4">
                    @include('admin.items.includes.sidebar')
                </div>
            </div>
        </div>
    </div>
@endsection
