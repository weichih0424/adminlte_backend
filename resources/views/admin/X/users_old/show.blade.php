@extends('adminlte::page')
@section('title', 'AdminLTE｜角色展示')
@section('content_header')
    <h1>角色展示</h1>
@stop
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label for="inputName">Name</label>
                {{ $user->name }}
            </div>
            <div class="form-group">
                <label for="inputEmail">Email</label>
                {{ $user->email }}
            </div>
            <div class="form-group">
                <label for="inputRoles">Roles</label>
                @if(!empty($user->getRoleNames()))
                    @foreach($user->getRoleNames() as $v)
                    <label class="badge badge-success">{{ $v }}</label>
                    @endforeach
                @endif
            </div>
            <a href="{{ route('users.index') }}"><button type="button" class="btn btn-outline-info btn-flat">返回</button>
        </div>
    </div>
</div>
@stop
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop
@section('js')
    <script> console.log('Hi!'); </script>
@stop