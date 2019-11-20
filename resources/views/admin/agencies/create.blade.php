@extends('layouts.admin')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.0.0-beta.3/css/bootstrap-colorpicker.min.css">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin">Admin</a></li>
                <li class="breadcrumb-item"><a href="{{ route('agencies.index') }}">Agencies</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create</li>
            </ol>
        </nav>

        <h1>Add an agency</h1>
        @if ($errors->any())
            <div class="alert alert-danger mb-3">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="post" action="{{ route('agencies.store') }}">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-8">
                    <label for="name">Name*</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="slug">Slug*</label>
                    <input type="text" class="form-control" name="slug" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="vehicles_type">Vehicles type*</label>
                    <select name="vehicles_type" class="custom-select">
                        <option value="bus" selected>Bus</option>
                        <option value="train">Train</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="color">Color*</label>
                    <input id="color" type="text" class="form-control" name="color" value="#FFFFFF" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="text_color">Color*</label>
                    <input id="text_color" type="text" class="form-control" name="text_color" value="#000000" required>
                </div>
                <div class="col-md-1">
                    <label>Preview</label>
                    <div class="color-preview">TEST</div>
                </div>
            </div>
            <div class="form-group">
                <label for="static_gtfs_url">Static GTFS Url*</label>
                <input type="text" class="form-control" name="static_gtfs_url" required>
            </div>
            <div class="form-group">
                <label for="realtime_url">Realtime URL*</label>
                <input type="text" class="form-control" name="realtime_url" required>
            </div>
            <div class="form-group">
                <label for="realtime_type">Realtime type (connector)*</label>
                <select name="realtime_type" class="custom-select">
                    <option value="gtfsrt" selected>GTFS Realtime</option>
                    <option value="nextbus">Nextbus</option>
                </select>
            </div>
            <div class="form-row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="name">Header name</label>
                        <input type="text" class="form-control" name="realtime_options_header_name">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="name">Header value</label>
                        <input type="text" class="form-control" name="realtime_options_header_value">
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="name">Parameter name</label>
                        <input type="text" class="form-control" name="realtime_options_param_name">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="name">Parameter value</label>
                        <input type="text" class="form-control" name="realtime_options_param_value">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-outline-primary">Add agency</button>
        </form>
    </div>
    <style>
        .color-preview {
            height: calc(1.5em + .75rem + 2px);
            line-height: calc(1.5em + .75rem + 2px);
            text-align: center;
            width: 100%;
            border-radius: .25rem;
            border-width: 1px;
            border-style: solid;
        }
    </style>
@endsection
@section('after_script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.0.0-beta.3/js/bootstrap-colorpicker.min.js"></script>
    <script>
      $(function () {
        $('.color-preview').css('background-color', $('#color').val());
        $('.color-preview').css('color', $('#text_color').val());
        $('.color-preview').css('border-color', $('#text_color').val());
        $('#color').colorpicker();
        $('#text_color').colorpicker();
        $('#color').on('colorpickerChange', function (event) {
          $('.color-preview').css('background-color', event.color.toString());
        });
        $('#text_color').on('colorpickerChange', function (event) {
          $('.color-preview').css('color', event.color.toString());
          $('.color-preview').css('border-color', $('#text_color').val());
        });
      })
    </script>
@endsection