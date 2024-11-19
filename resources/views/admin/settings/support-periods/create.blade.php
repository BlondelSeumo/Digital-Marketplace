@extends('admin.layouts.form')
@section('section', translate('Settings'))
@section('title', translate('New Support Period'))
@section('container', 'container-max-lg')
@section('back', route('admin.settings.support-periods.index'))
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.settings.support-periods.store') }}" method="POST">
        @csrf
        <div class="card p-2 mb-3">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">{{ translate('Name') }}</label>
                    <input type="text" name="name" class="form-control form-control-lg" value="{{ old('name') }}"
                        required />
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ translate('Title') }}</label>
                    <input type="text" name="title" class="form-control form-control-lg" value="{{ old('title') }}"
                        required />
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ translate('Days of support') }}</label>
                    <div class="input-group">
                        <input type="number" name="days" class="form-control form-control-lg"
                            value="{{ old('days') }}" required />
                        <span class="input-group-text px-3">{{ translate('Days') }}</span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ translate('Percentage') }}</label>
                    <div class="input-group">
                        <input type="number" name="percentage" class="form-control form-control-lg"
                            value="{{ old('percentage') }}" min="0" max="100" required />
                        <span class="input-group-text px-3">{{ translate('%') }}</span>
                    </div>
                    <div class="form-text">
                        {{ translate('Support percentage from item price, enter 0 to make support free.') }}
                    </div>
                </div>
                <div class="mb-2">
                    <div class="bg-light rounded-2 p-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="make_default" id="default">
                            <label class="form-check-label" for="default">{{ translate('Make default') }}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
