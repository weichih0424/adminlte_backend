@extends('adminlte::page')
@section('title', 'AdminLTE｜權限創建')
@section('content_header')
    <h1>權限創建</h1>
@stop
@section('content')
<div class="col-md-12">
    <div class="card">
        @if (count($errors) > 0)
        <div class="alert alert-danger">
            {{-- <strong>警告!</strong> 有些欄位未填寫<br><br> --}}
            <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul> 
        </div>
        @endif
        {!! Form::open(array('route' => 'roles.store','method'=>'POST')) !!}
        <div class="card-body">
            <div class="form-group">
                <label for="inputName">群組名稱</label>
                {!! Form::text('name', null, array('placeholder' => 'Name','class' =>'form-control', 'id' => 'inputName')) !!}
            </div>
            <div class="form-group">
                <label for="inputPermission">權限</label>
                <div class="row">
                    @foreach($permission as $key => $value)
                    {{-- {{!! dd($value); !!}} --}}
                        @if ($key % 3 == 0)
                            </div>
                            <div class="row">
                        @endif
                        <div class="col-3">
                            {{ Form::checkbox('permission[]', $value->id, false, array('class' =>'', 'id' => 'inputPermission')) }}
                            {{ $value->name }}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary btn-flat">確認</button>
            <a href="{{ route('roles.index') }}"><button type="button" class="btn btn-outline-infobtn-flat">返回</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@stop
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop
@section('js')
    <script> console.log('Hi!'); </script>
@stop