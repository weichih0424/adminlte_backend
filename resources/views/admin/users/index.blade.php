@extends('adminlte::page')
@section('title', 'AdminLTE｜角色管理')
@section('content_header')
    <h1>角色管理</h1>
@stop
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="float-left mr-3">
                @can('admin_users-create')
                <a href="{{ route('users.create') }}">
                    <button type="button" class="btn btn-block btn-success btn-flat float-right px-4">新增</button></a>
                @endcan
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
                        <th>姓名</th>
                        <th>帳號</th>
                        <th>員編</th>
                        <th>分機</th>
                        <th>部門名稱</th>
                        <th>所屬群組</th>
                        <th>動作</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($datas as $key => $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->employee_id }}</td>
                        <td>{{ $user->phone_extension }}</td>
                        <td>{{ isset($user->department_data)?$user->department_data->department_name:'' }}</td>
                        <td>
                            @if(!empty($user->getRoleNames()))
                                @foreach($user->getRoleNames() as $v)
                                    <button type="button" class="btn btn-outline-success btn-xs">{{ $v }}</button>
                                @endforeach
                            @endif 
                        </td>
                        <td>
                            {{-- <a class="btn btn-info btn-flat mr-4" href="{{ route('users.show', $user->id) }}">檢視</a> --}}
                            @can('admin_users-edit')
                            <a class="btn btn-primary btn-flat mr-4" href="{{ route('users.edit', $user->id) }}">編輯</a>
                            @endcan

                            @can('admin_users-delete')
                            {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
                            {!! Form::submit('刪除', ['class' => 'delete btn btn-danger btn-flat']) !!}
                            {{-- {!! Form::submit('刪除', ['class' => 'btn btn-danger btn-fla']) !!} --}}
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
{!! $datas->render() !!}
@stop
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop
@section('js')
    <script> console.log('Hi!'); </script>
@stop