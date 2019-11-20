@extends('layouts.admin')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.0.0-beta.3/css/bootstrap-colorpicker.min.css">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin">Admin</a></li>
                <li class="breadcrumb-item"><a href="{{ route('agencies.index') }}">Agencies</a></li>
                <li class="breadcrumb-item active" aria-current="page">Update</li>
            </ol>
        </nav>
        <div class="d-flex">
            <h1 class="flex-fill">Update an agency</h1>
            @if(!$agency->is_active)
                <div class="alert alert-danger">
                    This agency is inactive!
                </div>
            @endif
        </div>
        @if ($errors->any())
            <div class="alert alert-danger mb-3">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="post" action="{{ route('agencies.update', $agency->slug) }}">
            @csrf
            @method('PATCH')
            <div class="form-row">
                <div class="form-group col-md-7">
                    <label for="name">Name*</label>
                    <input type="text" class="form-control" name="name" value="{{ $agency->name }}" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="slug">Slug*</label>
                    <input type="text" class="form-control" name="slug" value="{{ $agency->slug }}" required>
                </div>
                <div class="form-group col-md-2">
                    <label for="realtime_type">Is active?*</label>
                    <select name="is_active" class="custom-select" id="is_active">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="vehicles_type">Vehicles type*</label>
                    <select name="vehicles_type" class="custom-select"id="vehicles_type">
                        <option value="bus" selected>Bus</option>
                        <option value="train">Train</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="color">Color*</label>
                    <input id="color" type="text" class="form-control" name="color" value="{{ $agency->color }}" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="text_color">Color*</label>
                    <input id="text_color" type="text" class="form-control" name="text_color" value="{{ $agency->text_color }}" required>
                </div>
                <div class="col-md-1">
                    <label>Preview</label>
                    <div class="color-preview">TEST</div>
                </div>
            </div>
            <div class="form-group">
                <label for="static_gtfs_url">Static GTFS Url*</label>
                <input type="text" class="form-control" name="static_gtfs_url" value="{{ $agency->static_gtfs_url }}" required>
            </div>
            <div class="form-row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="realtime_method">Method*</label>
                        <select name="realtime_method" class="custom-select" id="realtime_method">
                            <option value="GET" selected>GET</option>
                            <option value="POST">POST</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="form-group">
                        <label for="realtime_url">Realtime URL*</label>
                        <input type="text" class="form-control" name="realtime_url" value="{{ $agency->realtime_url }}" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="realtime_type">Realtime type (connector)*</label>
                <select name="realtime_type" class="custom-select" id="realtime_type">
                    <option value="gtfsrt" selected>GTFS Realtime (VehiclePosition)</option>
                    <option value="nextbus">Nextbus</option>
                </select>
            </div>
            <div class="form-row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="name">Header name</label>
                        <input type="text" class="form-control" name="realtime_options_header_name"  value="{{ $agency->header_name }}">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="name">Header value</label>
                        <input type="text" class="form-control" name="realtime_options_header_value" value="{{ $agency->header_value }}">
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="name">Parameter name</label>
                        <input type="text" class="form-control" name="realtime_options_param_name"  value="{{ $agency->param_name }}">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="name">Parameter value</label>
                        <input type="text" class="form-control" name="realtime_options_param_value"  value="{{ $agency->param_value }}">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-outline-primary">Update agency</button>
        </form>
        <input type="hidden" value="{{ $agency->is_active }}" id="valueIsActive">
        <input type="hidden" value="{{ $agency->vehicles_type }}" id="valueVehiclesType">
        <input type="hidden" value="{{ $agency->realtime_method }}" id="valueRealtimeMethod">
        <input type="hidden" value="{{ $agency->realtime_type }}" id="valueRealtimeType">
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
        $('#is_active').val($('#valueIsActive').val());
        $('#vehicles_type').val($('#valueVehiclesType').val());
        $('#realtime_method').val($('#valueRealtimeMethod').val());
        $('#realtime_type').val($('#valueRealtimeType').val());

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