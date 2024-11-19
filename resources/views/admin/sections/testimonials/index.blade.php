@extends('admin.layouts.grid')
@section('section', translate('Sections'))
@section('title', translate('Testimonials'))
@section('create', route('admin.sections.testimonials.create'))
@section('container', 'container-max-lg')
@section('content')
    @if ($testimonials->count() > 0)
        <div class="card mb-3">
            <ul class="sortable-list custom-list-group list-group list-group-flush">
                @foreach ($testimonials as $testimonial)
                    <li class="list-group-item" data-id="{{ $testimonial->id }}">
                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                                <span class="sortable-list-handle text-muted">
                                    <i class="fas fa-arrows-alt fa-lg"></i>
                                </span>
                            </div>
                            <div class="col">
                                <div class="item-title">
                                    <a href="{{ route('admin.sections.testimonials.edit', $testimonial->id) }}"
                                        class="text-dark">
                                        <div class="row g-3 align-items-center">
                                            <div class="col-auto">
                                                <img src="{{ $testimonial->getAvatar() }}" alt="{{ $testimonial->name }}"
                                                    class="rounded-3" width="50px" height="50px">
                                            </div>
                                            <div class="col">
                                                <p class="mb-1">{{ $testimonial->name }}</p>
                                                <small class="text-muted">{{ $testimonial->title }}</small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="row g-3">
                                    <div class="col">
                                        <a href="{{ route('admin.sections.testimonials.edit', $testimonial->id) }}"
                                            class="btn btn-secondary btn-md">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <form action="{{ route('admin.sections.testimonials.destroy', $testimonial->id) }}"
                                            method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button class="action-confirm btn btn-danger btn-md"><i
                                                    class="far fa-trash-alt"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @else
        <div class="card">
            <div class="card-body">
                @include('admin.partials.empty', ['empty_classes' => 'empty-lg'])
            </div>
        </div>
    @endif
    @push('top_scripts')
        <script>
            const sortingRoute = "{{ route('admin.sections.testimonials.sortable') }}";
        </script>
    @endpush
    @push('styles_libs')
        <link href="{{ asset('vendor/libs/jquery/jquery-ui.min.css') }}" />
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/jquery/jquery-ui.min.js') }}"></script>
    @endpush
@endsection
