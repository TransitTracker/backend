@extends('layouts.admin')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.0.0-beta.3/css/bootstrap-colorpicker.min.css">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin">Admin</a></li>
                <li class="breadcrumb-item"><a href="{{ route('regions.index') }}">Regions</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create</li>
            </ol>
        </nav>

        <h1>Create a region</h1>
        @if ($errors->any())
            <div class="alert alert-danger mb-3">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="post" action="{{ route('regions.store') }}">
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
                <div class="form-group col-md-5">
                    <label for="color">Color*</label>
                    <input id="color" type="text" class="form-control" name="color" value="#FFFFFF" required>
                </div>
                <div class="form-group col-md-5">
                    <label for="text_color">Color*</label>
                    <input id="text_color" type="text" class="form-control" name="text_color" value="#000000" required>
                </div>
                <div class="col-md-2">
                    <label>Preview</label>
                    <div class="color-preview">TEST</div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-8">
                    <label for="map_box">Map box*</label>
                    <input type="text" class="form-control" name="map_box" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="map_zoom">Map zoom*</label>
                    <input type="text" class="form-control" name="map_zoom" required>
                </div>
            </div>
            <div class="form-group">
                <label for="info_body">Body in english*</label>
                <textarea name="body_en" id="body_en"></textarea>
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