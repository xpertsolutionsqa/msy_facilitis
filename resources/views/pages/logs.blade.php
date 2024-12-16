@extends('layouts.app')

@section('content')
    <div class="wrapper">
        @include('layouts.sidebar')
        <div class="iq-top-navbar-{{ app()->getLocale() }}">
            @include('layouts.header')
        </div>
        <div class="content-page">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-wrap align-items-center justify-content-between breadcrumb-content">
                                    <h5>{{ __('Logs') }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">

                    </div>
                    <div class="col-md-4">
                        <input id="myInput" onkeyup="myFunction(1,[2,3,4,5]);" type="text"
                            placeholder="{{ __('Search') }}" class="form-control">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card p-2">
                            <table id="myTable" class="table table-bordered  ">
                                <thead>
                                    <tr>
                                        <th>User Type</th>
                                        <th>User ID</th>
                                        <th>User Number</th>
                                        <th>User Name</th>
                                        <th>Query</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($logs as $log)
                                        <tr>
                                            <td>{{ $log->user_type }}</td>
                                            <td>{{ $log->user_id }}</td>
                                            <td>{{ $log->user_number }}</td>
                                            <td>{{ $log->user_name }}</td>
                                            <td>{{ $log->query }}</td>
                                            <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No logs available</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="p-3"  >
                                {{ $logs->links('pagination.bootstrap-5') }}
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection
