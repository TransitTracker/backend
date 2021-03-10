@extends('errors::illustrated-layout')

@section('title', __('Not Found'))
@section('code', '404')
@section('message', __('Not Found'))
@section('image')
<div class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center" style="background-image: url({{ asset('/svg/404.svg') }})"></div>
@endsection
