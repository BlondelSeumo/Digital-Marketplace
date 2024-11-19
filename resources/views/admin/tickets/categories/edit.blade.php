@extends('admin.layouts.form')
@section('section', translate('Ticket Categories'))
@section('title', translate('Edit Ticket Category'))
@section('back', route('admin.tickets.categories.index'))
@section('container', 'container-max-md')
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.tickets.categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card p-3 pb-4">
            <div class="card-body">
                <div class="row g-3 row-cols-1">
                    <div class="col">
                        <div class="col-lg-6">
                            <label class="form-label">{{ translate('Status') }}</label>
                            <input type="checkbox" name="status" data-toggle="toggle" data-height="35px"
                                @checked($category->isActive())>
                        </div>
                    </div>
                    <div class="col">
                        <label class="form-label">{{ translate('Name') }} </label>
                        <input type="text" name="name" class="form-control form-control-md"
                            value="{{ $category->name }}" required autofocus />
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
