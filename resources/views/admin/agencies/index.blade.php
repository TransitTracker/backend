@extends('layouts.admin')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin">Admin</a></li>
                <li class="breadcrumb-item active" aria-current="page">Agencies</li>
            </ol>
        </nav>

        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif

        <div class="d-flex">
            <h1 class="flex-fill">Agencies list</h1>
            <a href="{{ route('agencies.create') }}" class="btn btn-primary float-right align-self-center"><i class="fas fa-plus"></i> Create</a>
        </div>
        <table class="table table-sm">
            <thead class="thead-dark">
                <tr>
                    <th>Slug</th>
                    <th>Name</th>
                    <th>Vehicles type</th>
                    <th>Realtime type</th>
                    <th colspan="4"></th>
                </tr>
            </thead>
            <tbody>
            @foreach($agencies as $agency)
                <tr
                @if(!$agency->is_active)
                    class="table-dark"
                @endif
                >
                    <td>{{ strtoupper($agency->slug) }}</td>
                    <td>{{ $agency->name }}</td>
                    <td>{{ ucfirst(trans($agency->vehicles_type)) }}</td>
                    <td>{{ $agency->realtime_type }}</td>
                    <td class="actions">
                        <div class="dropdown">
                            <a href="#" class="btn btn-success btn-sm dropdown-toggle" role="button" id="dropdownGtfsAction" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-database"></i> GTFS Actions
                            </a>

                            <div class="dropdown-menu" aria-labelledby="dropdownGtfsAction">
                                <form action="/admin/agencies/{{ $agency->slug }}/gtfsCleanAndUpdate/" method="post">
                                    @csrf
                                    <button class="dropdown-item" type="submit"><i class="fas fa-sync"></i> Clean and update</button>
                                </form>
                                <form action="/admin/agencies/{{ $agency->slug }}/gtfsDelete/" method="post">
                                    @csrf
                                    <button class="dropdown-item" type="submit"><i class="fas fa-trash"></i> Delete all data</button>
                                </form>
                                <form action="/admin/agencies/{{ $agency->slug }}/gtfsClean/" method="post">
                                    @csrf
                                    <button class="dropdown-item" type="submit"><i class="fas fa-calendar-times"></i> Clean</button>
                                </form>
                            </div>
                        </div>
                    </td>
                    <td class="actions">
                        <form action="/admin/agencies/{{ $agency->slug }}/refresh" method="post">
                            @csrf
                            <button class="btn btn-primary btn-sm" type="submit"><i class="fas fa-sync"></i></button>
                        </form>
                    </td>
                    <td class="actions">
                        <a href="{{ route('agencies.edit', $agency->slug) }}" class="btn btn-dark btn-sm"><i class="fas fa-edit"></i></a>
                    </td>
                    <td class="actions">
                        <form action="{{ route('agencies.destroy', $agency->slug) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" type="submit"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <style>
        .actions {
            white-space: nowrap;
            width: 1%;
        }
    </style>
@endsection