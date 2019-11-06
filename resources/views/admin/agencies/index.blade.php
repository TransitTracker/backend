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
                    <th colspan="2"></th>
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
                        <a href="{{ route('agencies.edit', $agency->slug) }}" class="btn btn-dark btn-sm"><i class="fas fa-edit"></i> Edit</a>
                    </td>
                    <td class="actions">
                        <form action="{{ route('agencies.destroy', $agency->slug) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" type="submit"><i class="fas fa-trash-alt"></i> Delete</button>
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