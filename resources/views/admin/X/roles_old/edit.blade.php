@extends('adminlte::page')
@section('title', 'AdminLTE｜權限修改')
@section('content_header')
    <h1>Roles Update</h1>
@stop
@section('content')
<div class="col-md-12">
    <div class="card">
        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul> 
        </div>
        @endif
    {!! Form::model($role, ['method' => 'PATCH','route' => ['roles.update', $role->id]]) !!}
            <div class="card-body">
                <div class="form-group">
                    <label for="inputName">Name</label>
                    {!! Form::text('name', null, array('placeholder' => 'Name','class' =>'form-control', 'id' => 'inputName')) !!}
                </div>
                <div class="form-group">
                    <label for="inputPermission">Permissions</label>
                    <div class="row">
                    @foreach($permission as $key => $value)
                        @if ($key % 3 == 0)
                            </div>
                            <div class="row">
                        @endif
                        <div class="col-3">
                        {{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions)? true : false, array('class' => '')) }}
                        {{ $value->name }}
                        </div>
                    @endforeach
                            </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-flat">Save</button>
                <a href="{{ route('roles.index') }}"><button type="button" class="btn btn-outline-infobtn-flat">Back</button>
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