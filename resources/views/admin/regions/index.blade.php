@extends('layouts.admin')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin">Admin</a></li>
                <li class="breadcrumb-item active" aria-current="page">Regions</li>
            </ol>
        </nav>

        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif

        <div class="d-flex">
            <h1 class="flex-fill">Regions list</h1>
            <a href="{{ route('regions.create') }}" class="btn btn-primary float-right align-self-center"><i class="fas fa-plus"></i> Create</a>
        </div>
        <table class="table table-sm">
            <thead class="thead-dark">
                <tr>
                    <th>Slug</th>
                    <th>Name</th>
                    <th colspan="2"></th>
                </tr>
            </thead>
            <tbody>
            @foreach($regions as $region)
                <tr>
                    <td>{{ strtoupper($region->slug) }}</td>
                    <td>{{ $region->name }}</td>
                    <td class="actions">
                        <a href="{{ route('regions.edit', $region->slug) }}" class="btn btn-dark btn-sm"><i class="fas fa-edit"></i></a>
                    </td>
                    <td class="actions">
                        <form action="{{ route('regions.destroy', $region->slug) }}" method="post">
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