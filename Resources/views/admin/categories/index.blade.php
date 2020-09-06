{{-- @extends('user::layouts.master') --}}

@extends('layouts.app')

@section('content')

    <category-index
        title="{{ __("vblog::categories.title.categories") }}"
        module-name="{!! config('vblog.name') !!}"
        init-msj="{{ __("vblog::common.messages.welcome") }}">
    </category-index>

@endsection
