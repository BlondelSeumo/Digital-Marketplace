@extends('admin.layouts.grid')
@section('section', translate('Blog'))
@section('title', translate('Blog Categories'))
@section('create', route('admin.blog.categories.create'))
@section('container', 'container-max-lg')
@section('content')
    <div class="card">
        <table class="table datatable w-100">
            <thead>
                <tr>
                    <th class="tb-w-2x">#</th>
                    <th class="tb-w-7x">{{ translate('Name') }}</th>
                    <th class="tb-w-3x">{{ translate('Views') }}</th>
                    <th class="tb-w-7x">{{ translate('Published date') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>
                            <a href="{{ route('admin.blog.categories.edit', $category->id) }}" class="text-dark">
                                <i class="fa-solid fa-tag me-2"></i>{{ $category->name }}
                            </a>
                        </td>
                        <td><span class="badge bg-dark">{{ $category->views }}</span></td>
                        <td>{{ dateFormat($category->created_at) }}</td>
                        <td>
                            <div class="text-end">
                                <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown"
                                    aria-expanded="true">
                                    <i class="fa fa-ellipsis-v fa-sm text-muted"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-sm-end" data-popper-placement="bottom-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ $category->getLink() }}" target="_blank"><i
                                                class="fa fa-eye me-2"></i>{{ translate('View') }}</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('admin.blog.categories.edit', $category->id) }}"><i
                                                class="fa-regular fa-pen-to-square me-2"></i>{{ translate('Edit') }}</a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider" />
                                    </li>
                                    <li>
                                        <form action="{{ route('admin.blog.categories.destroy', $category->id) }}"
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
@endsection
