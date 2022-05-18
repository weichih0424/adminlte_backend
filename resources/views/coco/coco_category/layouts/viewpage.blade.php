@extends('adminlte::page')

@section('title', '分類管理')

@section('content_header')
    <h1>{{ $header }}</h1>
@stop

@section('content')
    @include('coco.backdesign.formbase')

@stop
@section('css')
    <link rel="stylesheet" href="{{ URL::asset('/css/fileupload/fileinput.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css">
@stop
@section('js')
    <script type="text/javascript" src="{{ URL::asset('/js/fileupload/fileinput.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/fileupload/locales/zh-TW.js') }}"></script>
    <script>
        ajax_fileupload();
    </script>
@stop
