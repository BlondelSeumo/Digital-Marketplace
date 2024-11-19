@extends('installer::layouts.app')
@section('title', installer_trans('Requirements'))
@section('content')
    <div class="vironeer-steps-body">
        @foreach ($extensions as $extension)
            <div class="vironeer-steps-req">
                <p class="mb-0">{{ $extension }}</p>
                @if (extensionAvailability($extension))
                    <div class="vironeer-steps-req-success">
                        <i class="fa fa-check"></i>
                    </div>
                @else
                    <div class="vironeer-steps-req-fail">
                        <i class="fa fa-times"></i>
                    </div>
                @endif
            </div>
        @endforeach
        <div class="mt-3">
            @if (!$error)
                <div class="alert alert-success">
                    <i class="fa fa-check-circle me-2"></i>
                    {{ installer_trans('All extensions are enabled you can continue to next step') }}
                </div>
                <form action="{{ route('installer.requirements') }}" method="POST">
                    @csrf
                    <button class="btn btn-primary btn-md">{{ installer_trans('Continue') }}<i
                            class="fas fa-arrow-right ms-2"></i></button>
                </form>
            @else
                <div class="alert alert-danger">
                    <i class="fa fa-times-circle me-2"></i>
                    {{ installer_trans('Some extensions are required please enable them before you can continue.') }}
                </div>
                <button class="btn btn-primary btn-md" disabled>{{ installer_trans('Continue') }}<i
                        class="fas fa-arrow-right ms-2"></i></button>
            @endif
        </div>
    </div>
@endsection
