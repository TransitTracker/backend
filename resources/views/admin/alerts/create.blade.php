@extends('layouts.admin')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin">Admin</a></li>
                <li class="breadcrumb-item"><a href="{{ route('alerts.index') }}">Alerts</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create</li>
            </ol>
        </nav>

        <h1>Create an alert</h1>
        @if ($errors->any())
            <div class="alert alert-danger mb-3">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="post" action="{{ route('alerts.store') }}">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-5">
                    <label for="title_en">Title in english*</label>
                    <input type="text" class="form-control" name="title_en" required>
                </div>
                <div class="form-group col-md-5">
                    <label for="title_fr">Title in french*</label>
                    <input type="text" class="form-control" name="title_fr" required>
                </div>
                <div class="form-group col-md-2">
                    <label for="realtime_type">Can be closed?*</label>
                    <select name="can_be_closed" class="custom-select">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="color">Color*</label>
                    <select name="color" class="custom-select">
                        <option value="dark">Dark</option>
                        <option value="accent">Accent (aqua)</option>
                        <option value="error">Error</option>
                        <option value="info">Info</option>
                        <option value="success">Success</option>
                        <option value="warning">Warning</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="icon">Icon*</label>
                    <input type="text" class="form-control" name="icon" required>
                    <small class="form-text text-muted">Select from <a href="https://materialdesignicons.com/">Material Design Icons</a></small>
                </div>
            </div>
            <div class="form-group">
                <label for="body_en">Body in english*</label>
                <textarea name="body_en" id="body_en"></textarea>
            </div>
            <div class="form-group">
                <label for="body_fr">Body in french*</label>
                <textarea name="body_fr" id="body_fr"></textarea>
            </div>

            <button type="submit" class="btn btn-outline-primary">Create alert</button>
        </form>
    </div>
@endsection
@section('after_script')
    <script src="https://cdn.ckeditor.com/ckeditor5/15.0.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
          .create(document.querySelector('#body_en'))
          .catch(error => {
            console.log(error);
          });
        ClassicEditor
          .create(document.querySelector('#body_fr'))
          .catch(error => {
            console.log(error);
          });
    </script>
@endsection