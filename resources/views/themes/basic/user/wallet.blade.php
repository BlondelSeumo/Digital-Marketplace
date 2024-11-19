@extends('themes.basic.user.layouts.app')
@section('title', translate('My Wallet'))
@section('breadcrumbs', Breadcrumbs::render('user.wallet.index'))
@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <div class="box box-padding h-100">
                <div class="counter counter-green">
                    <div class="counter-icon">
                        <i class="fa-solid fa-dollar-sign"></i>
                    </div>
                    <div class="counter-info">
                        <h5 class="counter-title">{{ translate('Available Balance') }}</h5>
                        <p class="counter-text fw-medium">{{ getAmount(authUser()->balance) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <h3 class="mb-4">{{ translate('Statements') }}</h3>
    @if (($statements->count() > 0) | request()->input('date_from') || request()->input('date_to'))
        <div class="dashboard-table">
            <div class="table-search p-4">
                <form action="{{ url()->current() }}" method="GET">
                    <div class="row g-3 align-items-center">
                        <div class="col-12 col-lg-5 col-xxl-5">
                            <input type="date" name="date_from" class="form-control form-control-md"
                                value="{{ request('date_from') }}">
                        </div>
                        <div class="col-12 col-lg-4 col-xxl-5">
                            <input type="date" name="date_to" class="form-control form-control-md"
                                value="{{ request('date_to') }}">
                        </div>
                        <div class="col">
                            <button class="btn btn-primary w-100 btn-md"><i class="fa fa-search"></i></button>
                        </div>
                        <div class="col">
                            <a href="{{ url()->current() }}" class="btn btn-outline-primary w-100 btn-md"><i
                                    class="fa-solid fa-rotate"></i></a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="table-container">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>{{ translate('ID') }}</th>
                            <th>{{ translate('Details') }}</th>
                            <th class="text-center">{{ translate('Total') }}</th>
                            <th class="text-center">{{ translate('Date') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($statements as $statement)
                            <tr>
                                <td><i class="fa-solid fa-hashtag me-1"></i>{{ $statement->id }}</td>
                                <td>{{ $statement->title }}</td>
                                <td
                                    class="text-center {{ $statement->isCredit() ? 'text-success' : 'text-danger' }} fw-bold">
                                    {{ $statement->getAmount() }}
                                </td>
                                <td class="text-center">
                                    {{ dateFormat($statement->created_at) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    <div class="text-muted p-4">{{ translate('No data found') }}</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {{ $statements->links() }}
    @else
        <div class="box box-empty">
            <div class="mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="150px" height="150px" viewBox="0 0 647.63626 632.17383"
                    xmlns:xlink="http://www.w3.org/1999/xlink">
                    <path
                        d="M687.3279,276.08691H512.81813a15.01828,15.01828,0,0,0-15,15v387.85l-2,.61005-42.81006,13.11a8.00676,8.00676,0,0,1-9.98974-5.31L315.678,271.39691a8.00313,8.00313,0,0,1,5.31006-9.99l65.97022-20.2,191.25-58.54,65.96972-20.2a7.98927,7.98927,0,0,1,9.99024,5.3l32.5498,106.32Z"
                        transform="translate(-276.18187 -133.91309)" fill="#f2f2f2" />
                    <path
                        d="M725.408,274.08691l-39.23-128.14a16.99368,16.99368,0,0,0-21.23-11.28l-92.75,28.39L380.95827,221.60693l-92.75,28.4a17.0152,17.0152,0,0,0-11.28028,21.23l134.08008,437.93a17.02661,17.02661,0,0,0,16.26026,12.03,16.78926,16.78926,0,0,0,4.96972-.75l63.58008-19.46,2-.62v-2.09l-2,.61-64.16992,19.65a15.01489,15.01489,0,0,1-18.73-9.95l-134.06983-437.94a14.97935,14.97935,0,0,1,9.94971-18.73l92.75-28.4,191.24024-58.54,92.75-28.4a15.15551,15.15551,0,0,1,4.40966-.66,15.01461,15.01461,0,0,1,14.32032,10.61l39.0498,127.56.62012,2h2.08008Z"
                        transform="translate(-276.18187 -133.91309)" fill="#3f3d56" />
                    <path
                        d="M398.86279,261.73389a9.0157,9.0157,0,0,1-8.61133-6.3667l-12.88037-42.07178a8.99884,8.99884,0,0,1,5.9712-11.24023l175.939-53.86377a9.00867,9.00867,0,0,1,11.24072,5.9707l12.88037,42.07227a9.01029,9.01029,0,0,1-5.9707,11.24072L401.49219,261.33887A8.976,8.976,0,0,1,398.86279,261.73389Z"
                        transform="translate(-276.18187 -133.91309)" fill="{{ $themeSettings->colors->primary_color }}" />
                    <circle cx="190.15351" cy="24.95465" r="20" fill="{{ $themeSettings->colors->primary_color }}" />
                    <circle cx="190.15351" cy="24.95465" r="12.66462" fill="#fff" />
                    <path
                        d="M878.81836,716.08691h-338a8.50981,8.50981,0,0,1-8.5-8.5v-405a8.50951,8.50951,0,0,1,8.5-8.5h338a8.50982,8.50982,0,0,1,8.5,8.5v405A8.51013,8.51013,0,0,1,878.81836,716.08691Z"
                        transform="translate(-276.18187 -133.91309)" fill="#e6e6e6" />
                    <path
                        d="M723.31813,274.08691h-210.5a17.02411,17.02411,0,0,0-17,17v407.8l2-.61v-407.19a15.01828,15.01828,0,0,1,15-15H723.93825Zm183.5,0h-394a17.02411,17.02411,0,0,0-17,17v458a17.0241,17.0241,0,0,0,17,17h394a17.0241,17.0241,0,0,0,17-17v-458A17.02411,17.02411,0,0,0,906.81813,274.08691Zm15,475a15.01828,15.01828,0,0,1-15,15h-394a15.01828,15.01828,0,0,1-15-15v-458a15.01828,15.01828,0,0,1,15-15h394a15.01828,15.01828,0,0,1,15,15Z"
                        transform="translate(-276.18187 -133.91309)" fill="#3f3d56" />
                    <path
                        d="M801.81836,318.08691h-184a9.01015,9.01015,0,0,1-9-9v-44a9.01016,9.01016,0,0,1,9-9h184a9.01016,9.01016,0,0,1,9,9v44A9.01015,9.01015,0,0,1,801.81836,318.08691Z"
                        transform="translate(-276.18187 -133.91309)" fill="{{ $themeSettings->colors->primary_color }}" />
                    <circle cx="433.63626" cy="105.17383" r="20" fill="{{ $themeSettings->colors->primary_color }}" />
                    <circle cx="433.63626" cy="105.17383" r="12.18187" fill="#fff" />
                </svg>
            </div>
            <h4>{{ translate('You do not have any statements') }}</h4>
            <p class="mb-0">
                {{ translate('You do not have any statements, when you have statements you will see them here.') }}
            </p>
        </div>
    @endif
    @if (@$settings->deposit->status)
        <div class="modal fade" id="depositModel" tabindex="-1" aria-labelledby="depositModelLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-4">
                    <div class="modal-header border-0 p-0 mb-3">
                        <h1 class="modal-title fs-5" id="depositModelLabel">{{ translate('Deposit') }}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <form action="{{ route('user.wallet.deposit') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                @include('themes.basic.user.partials.input-price', [
                                    'name' => 'amount',
                                    'min' => @$settings->deposit->minimum,
                                    'max' => @$settings->deposit->maximum,
                                    'required' => true,
                                ])
                            </div>
                            <button class="btn btn-primary btn-md w-100">{{ translate('Continue') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
