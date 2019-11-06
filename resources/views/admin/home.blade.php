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
                <div class="mt-4">
                    <a href="/horizon" class="btn btn-success"><i class="fas fa-tasks-alt"></i> Horizon</a>
                </div>
                <div class="mt-2">
                    <a href="/admin/agencies" class="btn btn-success"><i class="fas fa-warehouse"></i> Manage agencies</a>
                    <a href="/admin/refresh-now" class="btn btn-info"><i class="fas fa-sync"></i> Refresh all agencies now</a>
                </div>
                <div class="mt-2">
                    <a href="/admin/alerts" class="btn btn-success"><i class="fas fa-exclamation-triangle"></i> Manage alerts</a>
                </div>
            </div>
        </div>
    </div>
@endsection
