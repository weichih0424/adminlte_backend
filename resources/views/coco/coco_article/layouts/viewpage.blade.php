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
    {{-- select_category start --}}
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.2.13/dist/semantic.min.css">
	<link rel="stylesheet" href="{{ URL::asset('/css/multiselect-02/style.css') }}">
    {{-- select_category end --}}
@stop
@section('js')
    <script type="text/javascript" src="{{ URL::asset('/js/fileupload/fileinput.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/fileupload/locales/zh-TW.js') }}"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $(document).ready(function() {
        $('#intro').summernote({
            height: 400, 
            // placeholder: '請輸入',
        });
    });
        ajax_fileupload();

        $('#s').change(function () {
            var select=document.getElementById('s');
            var str=[];
            for (i=0;i<select.length;i++){
                if (select.options[i].selected){
                str.push(select[i].value);
                }
            }
            console.log(str);
            $('#select').attr("value",str);
        })

    </script>
@stop