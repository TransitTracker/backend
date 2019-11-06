@extends('layouts.admin')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin">Admin</a></li>
                <li class="breadcrumb-item active" aria-current="page">Alerts</li>
            </ol>
        </nav>

        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif

        <div class="d-flex">
            <h1 class="flex-fill">Alerts list</h1>
            <a href="{{ route('alerts.create') }}" class="btn btn-primary float-right align-self-center"><i class="fas fa-plus"></i> Create</a>
        </div>
        <table class="table table-sm">
            <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Title in english</th>
                <th colspan="3"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($alerts as $alert)
                <tr
                        @if($alert->is_active)
                        class="table-success"
                        @endif
                >
                    <td>{{ $alert->id }}</td>
                    <td>{{ $alert->title_en }}</td>
                    <td class="actions">
                        <form action="/admin/alerts/{{ $alert->id }}/active/" method="post">
                            @csrf
                            @if($alert->is_active)
                                <button class="btn btn-warning btn-sm" type="submit"><i class="fas fa-times"></i> Remove from active</button>
                            @else
                                <button class="btn btn-info btn-sm" type="submit"><i class="fas fa-star"></i> Make active</button>
                            @endif
                        </form>
                    </td>
                    <td class="actions">
                        <a href="{{ route('alerts.edit', $alert->id) }}" class="btn btn-dark btn-sm"><i class="fas fa-edit"></i> Edit</a>
                    </td>
                    <td class="actions">
                        <form action="{{ route('alerts.destroy', $alert->id) }}" method="post">
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