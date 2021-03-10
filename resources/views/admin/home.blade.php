@extends('layouts.admin')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Admin</li>
            </ol>
        </nav>

        <div class="card">
            <div class="card-header bg-secondary text-white">Dashboard</div>

            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                Welcome back {{ Auth::User()->name }}!

                <div class="row row-cols-1 row-cols-lg-3">
                    <div class="col mb-4">
                        <div class="card bg-secondary text-light">
                            <div class="card-body">
                                <i class="fad fa-external-link"></i>
                                <h5 class="card-title">Horizon</h5>
                                <a href="{{ route('horizon.index') }}" class="card-link stretched-link" target="_blank">Access</a>
                            </div>
                        </div>
                    </div>
                    <div class="col mb-4">
                        <div class="card bg-success">
                            <div class="card-body">
                                <i class="fad fa-map-marked"></i>
                                <h5 class="card-title">Regions</h5>
                                <a href="{{ route('regions.index') }}" class="card-link stretched-link">Manage</a>
                            </div>
                        </div>
                    </div>
                    <div class="col mb-4">
                        <div class="card bg-success">
                            <div class="card-body">
                                <i class="fad fa-warehouse"></i>
                                <h5 class="card-title">Agencies</h5>
                                <a href="{{ route('agencies.index') }}" class="card-link stretched-link">Manage</a>
                            </div>
                        </div>
                    </div>
                    <div class="col mb-4">
                        <div class="card bg-success">
                            <div class="card-body">
                                <i class="fad fa-bus"></i>
                                <h5 class="card-title">Vehicles</h5>
                                <a href="" class="card-link disabled">Manage</a>
                            </div>
                        </div>
                    </div>
                    <div class="col mb-4">
                        <div class="card bg-success">
                            <div class="card-body">
                                <i class="fad fa-exclamation-triangle"></i>
                                <h5 class="card-title">Alerts</h5>
                                <a href="{{ route('alerts.index') }}" class="card-link stretched-link">Manage</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card-link {
            color: #000000;
        }
        .text-light .card-link {
            color: #ffffff !important;
        }
    </style>
@endsection
