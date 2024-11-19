@extends('admin.layouts.grid')
@section('section', translate('Users'))
@section('title', translate(':name Login logs', ['name' => $user->getName()]))
@section('back', route('admin.members.users.index'))
@section('content')
    @include('admin.members.users.includes.elements')
    <div class="row g-3">
        @include('admin.members.users.includes.sidebar')
        <div class="col-lg-9">
            <div class="card">
                <table class="table datatable w-100">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ translate('IP') }}</th>
                            <th>{{ translate('Country') }}</th>
                            <th>{{ translate('Location') }}</th>
                            <th>{{ translate('Browser') }}</th>
                            <th>{{ translate('OS') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($loginLogs as $loginLog)
                            <tr>
                                <td>{{ $loginLog->id }}</td>
                                <td><strong>{{ demo($loginLog->ip) }}</strong></td>
                                <td>{{ $loginLog->country }}</td>
                                <td><i class="fa-solid fa-map-location-dot me-2"></i>{{ $loginLog->location }}</td>
                                <td>{{ $loginLog->browser }}</td>
                                <td>{{ $loginLog->os }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
