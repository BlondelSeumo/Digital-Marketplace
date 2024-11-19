@extends('admin.layouts.form')
@section('section', translate('Sections'))
@section('title', translate('Edit FAQ'))
@section('container', 'container-max-lg')
@section('back', route('admin.sections.faqs.index'))
@section('content')
    <form id="vironeer-submited-form" action="{{ route('admin.sections.faqs.update', $faq->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card p-2 mb-3">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">{{ translate('Title') }}</label>
                    <input type="text" name="title" class="form-control form-control-lg" value="{{ $faq->title }}"
                        required />
                </div>
                <div class="mb-2">
                    <label class="form-label">{{ translate('Body') }}</label>
                    <textarea name="body" class="ckeditor">{{ $faq->body }}</textarea>
                </div>
            </div>
        </div>
    </form>
    @include('admin.partials.ckeditor')
@endsection
