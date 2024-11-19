@extends('admin.layouts.grid')
@section('section', translate('Settings'))
@section('title', translate('Captcha Providers'))
@section('container', 'container-max-xl')
@section('content')
    <div class="card">
        <table class="table datatable2 w-100">
            <thead>
                <tr>
                    <th class="tb-w-1x">#</th>
                    <th class="tb-w-3x">{{ translate('Logo') }}</th>
                    <th class="tb-w-7x">{{ translate('name') }}</th>
                    <th class="tb-w-3x">{{ translate('Status') }}</th>
                    <th class="tb-w-3x">{{ translate('Last Update') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($captchaProviders as $captchaProvider)
                    <tr>
                        <td>{{ $captchaProvider->id }}</td>
                        <td>
                            <a href="{{ route('admin.settings.captcha-providers.edit', $captchaProvider->id) }}">
                                <img src="{{ asset($captchaProvider->logo) }}" height="40px" width="40px">
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('admin.settings.captcha-providers.edit', $captchaProvider->id) }}"
                                class="text-dark">
                                {{ translate($captchaProvider->name) }}
                            </a>
                            {{ $captchaProvider->isDefault() ? translate('(Default)') : '' }}
                        </td>
                        <td>
                            @if ($captchaProvider->isActive())
                                <span class="badge bg-success">{{ translate('Enabled') }}</span>
                            @else
                                <span class="badge bg-danger">{{ translate('Disabled') }}</span>
                            @endif
                        </td>
                        <td>{{ dateFormat($captchaProvider->updated_at) }}</td>
                        <td>
                            <div class="text-end">
                                <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown"
                                    aria-expanded="true">
                                    <i class="fa fa-ellipsis-v fa-sm text-muted"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-sm-end" data-popper-placement="bottom-end">
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('admin.settings.captcha-providers.edit', $captchaProvider->id) }}"><i
                                                class="fa-regular fa-pen-to-square me-2"></i>{{ translate('Edit') }}</a>
                                    </li>
                                    @if (!$captchaProvider->isDefault())
                                        <li>
                                            <form
                                                action="{{ route('admin.settings.captcha-providers.default', $captchaProvider->id) }}"
                                                method="POST">
                                                @csrf
                                                <button class="vironeer-form-confirm dropdown-item action-confirm">
                                                    <i class="far fa-bookmark me-2"></i>
                                                    {{ translate('Make default') }}
                                                </button>
                                            </form>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
