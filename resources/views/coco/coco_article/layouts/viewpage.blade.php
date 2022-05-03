@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')
    <h1>{{ $header }}</h1>
@stop

@section('content')
    @include('coco.backdesign.formbase')
@stop
@section('css')
    <link rel="stylesheet" href="{{ URL::asset('/css/fileupload/fileinput.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css">

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    
@stop
@section('js')
    <script type="text/javascript" src="{{ URL::asset('/js/fileupload/fileinput.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/fileupload/locales/zh-TW.js') }}"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $(document).ready(function() {
        $('#intro').summernote({
            height: 400, 
            placeholder: '請輸入',
        });
    });
        ajax_fileupload();

    </script>
@stop