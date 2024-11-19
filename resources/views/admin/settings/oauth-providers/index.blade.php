@extends('admin.layouts.grid')
@section('section', translate('Settings'))
@section('title', translate('OAuth Providers'))
@section('container', 'container-max-lg')
@section('content')
    <div class="card">
        <table class="table datatable w-100">
            <thead>
                <tr>
                    <th class="tb-w-1x">#</th>
                    <th class="tb-w-3x">{{ translate('Logo') }}</th>
                    <th class="tb-w-3x">{{ translate('name') }}</th>
                    <th class="tb-w-3x">{{ translate('Status') }}</th>
                    <th class="tb-w-7x">{{ translate('Last Update') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($oauthProviders as $oauthProvider)
                    <tr>
                        <td>{{ $oauthProvider->id }}</td>
                        <td>
                            <a href="{{ route('admin.settings.oauth-providers.edit', $oauthProvider->id) }}">
                                <img src="{{ asset($oauthProvider->logo) }}" height="40px" width="40px">
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('admin.settings.oauth-providers.edit', $oauthProvider->id) }}"
                                class="text-dark">
                                <i class="{{ $oauthProvider->icon }} me-2"></i>
                                {{ translate($oauthProvider->name) }}
                            </a>
                        </td>
                        <td>
                            @if ($oauthProvider->isActive())
                                <span class="badge bg-success">{{ translate('Enabled') }}</span>
                            @else
                                <span class="badge bg-danger">{{ translate('Disabled') }}</span>
                            @endif
                        </td>
                        <td>{{ dateFormat($oauthProvider->updated_at) }}</td>
                        <td>
                            <div class="text-end">
                                <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown"
                                    aria-expanded="true">
                                    <i class="fa fa-ellipsis-v fa-sm text-muted"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-sm-end" data-popper-placement="bottom-end">
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('admin.settings.oauth-providers.edit', $oauthProvider->id) }}"><i
                                                class="fa-regular fa-pen-to-square me-2"></i>{{ translate('Edit') }}</a>
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
