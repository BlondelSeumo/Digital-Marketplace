@extends('admin.layouts.grid')
@section('section', translate('Settings'))
@section('title', translate('Mail Templates'))
@section('content')
    <div class="card">
        <table class="table datatable2 w-100">
            <thead>
                <tr>
                    <th class="tb-w-2x">#</th>
                    <th class="tb-w-5x">{{ translate('Name') }}</th>
                    <th class="tb-w-5x">{{ translate('Subject') }}</th>
                    <th class="tb-w-5x">{{ translate('Status') }}</th>
                    <th class="tb-w-2x"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mailTemplates as $mailTemplate)
                    <tr>
                        <td>{{ $mailTemplate->id }}</td>
                        <td>
                            <a class="text-dark" href="{{ route('admin.settings.mail-templates.edit', $mailTemplate->id) }}">
                                <i class="fa fa-envelope me-2"></i>
                                {{ translate($mailTemplate->name) }}
                            </a>
                        </td>
                        <td>
                            <a class="text-dark"
                                href="{{ route('admin.settings.mail-templates.edit', $mailTemplate->id) }}">
                                {{ $mailTemplate->subject }}
                            </a>
                        </td>
                        <td>
                            @if ($mailTemplate->status)
                                <span class="badge bg-success">{{ translate('Active') }}</span>
                            @else
                                <span class="badge bg-danger">{{ translate('Disabled') }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="text-end">
                                <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown"
                                    aria-expanded="true">
                                    <i class="fa fa-ellipsis-v fa-sm text-muted"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-sm-end" data-popper-placement="bottom-end">
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('admin.settings.mail-templates.edit', $mailTemplate->id) }}"><i
                                                class="fa-regular fa-pen-to-square me-1"></i>
                                            {{ translate('Edit') }}
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
@endsection
