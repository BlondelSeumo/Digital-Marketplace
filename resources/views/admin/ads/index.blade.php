@extends('admin.layouts.grid')
@section('title', translate('Advertisements'))
@section('content')
    <div class="card">
        <table class="table datatable2 w-100">
            <thead>
                <tr>
                    <th class="tb-w-2x">#</th>
                    <th class="tb-w-7x">{{ translate('Position') }}</th>
                    <th class="tb-w-5x">{{ translate('Size') }}</th>
                    <th class="tb-w-5x">{{ translate('Status') }}</th>
                    <th class="tb-w-3x">{{ translate('Last update') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ads as $ad)
                    <tr>
                        <td>{{ $ad->id }}</td>
                        <td>
                            <a href="{{ route('admin.ads.edit', $ad->id) }}" class="text-dark">
                                <i class="fas fa-ad me-2"></i>{{ translate($ad->position) }}
                            </a>
                        </td>
                        <td>{{ $ad->size ?? '--' }}</td>
                        <td>
                            @if ($ad->isActive())
                                <span class="badge bg-success">{{ translate('Active') }}</span>
                            @else
                                <span class="badge bg-danger">{{ translate('Disabled') }}</span>
                            @endif
                        </td>
                        <td>{{ dateFormat($ad->updated_at) }}</td>
                        <td>
                            <div class="text-end">
                                <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown"
                                    aria-expanded="true">
                                    <i class="fa fa-ellipsis-v fa-sm text-muted"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-sm-end" data-popper-placement="bottom-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.ads.edit', $ad->id) }}"><i
                                                class="fa fa-edit me-2"></i>{{ translate('Edit') }}</a>
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
