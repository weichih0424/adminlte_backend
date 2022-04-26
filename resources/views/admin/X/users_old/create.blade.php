@extends('adminlte::page')
@section('title', 'AdminLTE｜角色新增')
@section('content_header')
    <h1>角色新增</h1>
@stop
@section('content')
<div class="col-md-12">
    <div class="card">
        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>警告！</strong> 有些選項還沒填寫喔！<br><br>
            <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
        @endif
        {!! Form::open(array('route' => 'users.store','method'=>'POST')) !!}
            <div class="card-body">
                <div class="form-group">
                    <label for="inputName">角色名稱</label>
                    {!! Form::text('name', null, array('placeholder' => 'Name','class' =>'form-control', 'id' => 'inputName')) !!}
                </div>
                <div class="form-group">
                    <label for="inputEmail">電子信箱</label>
                    {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control', 'id' => 'inputEmail')) !!}
                </div>
                <div class="form-group">
                    <label for="inputPass">密碼</label>
                    {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control', 'id' => 'inputPass')) !!}
                </div>
                <div class="form-group">
                    <label for="inputConfirm">確認密碼</label>
                    {!! Form::password('confirm-password', array('placeholder' => 'ConfirmPassword','class' => 'form-control', 'id' => 'inputConfirm')) !!}
                </div>
                <div class="form-group">
                    <label for="inputRoles">權限</label>
                    {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','multiple', 'id' => 'inputRoles')) !!}
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-flat">送出</button>
                <a href="{{ route('users.index') }}"><button type="button" class="btn btn-outline-infobtn-flat">返回</button>
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