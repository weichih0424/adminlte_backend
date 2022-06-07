@extends('adminlte::page')

@section('title', '分類管理')

@section('content_header')
    <h1>{{$header}}</h1>
@stop

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h5><div class="float-left mr-3">請以拖曳的方式移動欄位</div></h5>
        </div>
        <div class="card-body p-0">
            <div class="card-text">
                <div class="list-group-item d-flex">
                    <div class="mx-4 col-1">ID</div>
                    <div class="mx-4 col-3">分類名稱</div>
                    <div class="mx-4 col-3">url</div>
                    <div class="mx-4 col-3">狀態</div>
                </div>
                {!! Form::open(['url' => $action, 'method' => $method]) !!}
                <x-laravel-blade-sortable::sortable as="div" name="sort_order">
                    @foreach ($datas as $key => $data)
                    <x-laravel-blade-sortable::sortable-item as="div"
                    class="list-group-item list-group-item-action mb-1" sort-key="{{ $data->id }}">
                    <div class="d-flex">
                        <div class="mx-4 col-1 align-middle">{{ $data->id }}</div>
                        <div class="mx-4 col-3 align-middle">{{ $data->name }}</div>
                        <div class="mx-4 col-3 align-middle">{{ $data->url }}</div>
                        <div class="mx-4 col-3 status_color align-middle">{{ ($data->status==1)?'上架':'下架' }}</div>
                    </div>
                    </x-laravel-blade-sortable::sortable-item>
                    @endforeach
                </x-laravel-blade-sortable::sortable>
            </div>
        </div>
        <div class="card-footer">
            {!! Form::input('hidden', 'table', $table) !!}
            <button type="submit" class="btn btn-primary btn-flat mr-4">儲存</button>
            <a class="btn btn-outline-info btn-flat mr-4"
                href="{{ route('coco_category.index') }}">返回</a>
        </div>
    </div>
</div>
@stop
@section('css')
@stop
@section('js')
<script src="{{ asset('./js/alpine.min.js') }}"></script>
<x-laravel-blade-sortable::scripts />
<script src="{{ asset('./js/sortable.js') }}"></script>
@stop
