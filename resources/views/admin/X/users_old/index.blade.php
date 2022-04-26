@extends('adminlte::page')
@section('title', 'AdminLTE｜角色管理')
@section('content_header')
    <h1>角色管理</h1>
@stop
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="card-tools">
                <a href="{{ route('users.create') }}">
                    <button type="button" class="btn btn-block btn-success btn-flat float-right">新增</button>
                </a>
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
                        <th style="width: 10px">#</th>
                        <th>角色名稱</th>
                        <th>電子信箱</th>
                        <th>權限</th>
                        <th>動作</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($data as $key => $user)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if(!empty($user->getRoleNames()))
                                @foreach($user->getRoleNames() as $v)
                                    <button type="button" class="btn btn-outline-success btn-xs">{{ $v }}</button>
                                @endforeach
                            @endif 
                        </td>
                        <td>
                            <a class="btn btn-info btn-flat" href="{{ route('users.show',$user->id) }}">展示</a>
                            @can('product-edit')
                            {{-- @can('user-edit') --}}
                            <a class="btn btn-primary btn-flat" href="{{ route('users.edit', $user->id) }}">編輯</a>
                            @endcan
                            @can('product-delete')
                            {{-- @can('user-delete') --}}
                            {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
                            {!! Form::submit('刪除', ['class' => 'btn btn-danger btn-fla']) !!}
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
{!! $data->render() !!}
@stop
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop
@section('js')
    <script> console.log('Hi!'); </script>
@stop