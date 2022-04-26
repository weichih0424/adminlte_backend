@extends('adminlte::page')
@section('title', 'AdminLTE｜權限管理')
@section('content_header')
    <h1>權限管理</h1>
@stop
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="float-left mr-3">
                <a href="{{ route('roles.create') }}"><button type="button" class="btn btn-block btn-success btn-flat float-right">新增</button></a>
            </div>
        </div>
        @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
        @endif
        <div class="card-body p-0">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 10px">ID</th>
                        <th>群組名稱</th>
                        <th>動作</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($roles as $key => $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->name }}</td>
                    <td>
                        <a class="btn btn-info btn-flat" href="{{ route('roles.show', $role->id) }}">預覽</a>
                        @can('role-edit')
                        <a class="btn btn-primary btn-flat" href="{{ route('roles.edit', $role->id) }}">編輯</a>
                        @endcan
                        @can('role-delete')
                            {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
                            {!! Form::submit('刪除', ['class' => 'btn btn-danger btn-flat']) !!}
                            {!! Form::close() !!}
                        @endcan
                    </td> 
                </tr>
                @endforeach
            </tbody>
        </table>
                </div>
            </div>
        </div>
        {!! $roles->render() !!}
        @stop
        @section('css')
            <link rel="stylesheet" href="/css/admin_custom.css">
        @stop
        @section('js')
            <script> console.log('Hi!'); </script>
        @stop
