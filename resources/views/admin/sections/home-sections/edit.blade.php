@extends('admin.layouts.form')
@section('section', translate('Sections'))
@section('title', translate('Edit Home Section'))
@section('back', route('admin.sections.home-sections.index'))
@section('container', 'container-max-lg')
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.sections.home-sections.update', $homeSection->id) }}"
        method="POST">
        @csrf
        <div class="card p-2 pb-3">
            <div class="card-body">
                <div class="mb-3 col-lg-4">
                    <label class="form-label">{{ translate('Status') }}</label>
                    <input type="checkbox" name="status" data-toggle="toggle" data-height="40" @checked($homeSection->isActive())>
                </div>
                <div class="row g-3 row-cols-1">
                    <div class="col">
                        <label class="form-label">{{ translate('Name') }}</label>
                        <input type="text" name="name" class="form-control form-control-lg"
                            value="{{ $homeSection->name }}" />
                    </div>
                    <div class="col">
                        <label class="form-label">{{ translate('Description') }}</label>
                        <textarea name="description" class="form-control" rows="7">{{ $homeSection->description }}</textarea>
                    </div>
                    @if ($homeSection->items_number)
                        <div class="col">
                            <label class="form-label">{{ translate('Items Number') }}</label>
                            <input type="number" name="items_number" class="form-control form-control-lg" min="1"
                                max="100" value="{{ $homeSection->items_number }}" required>
                            <div class="form-text">{{ translate('Between 1 to 100 maximum') }}</div>
                        </div>
                    @endif
                    @if ($homeSection->cache_expiry_time)
                        <div class="col">
                            <label class="form-label">{{ translate('Cache Expiry time') }}</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="cache_expiry_time" min="1"
                                    max="525600" value="{{ $homeSection->cache_expiry_time }}" required>
                                <span class="input-group-text">
                                    <i class="fa-regular fa-clock me-2"></i>{{ translate('Minutes') }}</span>
                            </div>
                            <div class="form-text">{{ translate('From 1 to 525600 minutes') }}</div>
                            <div class="alert alert-warning mb-0 mt-3">
                                <i class="fa-regular fa-circle-question me-1"></i>
                                <span>
                                    {{ translate('You must clear the cache every time you changed the "Items Number" or "Cache Expiry time"') }}
                                </span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </form>
@endsection
