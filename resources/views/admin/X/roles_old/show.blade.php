@extends('adminlte::page')
@section('title', 'AdminLTE｜權限展示')
@section('content_header')
    <h1>Role Info</h1>
@stop
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label for="inputName">Name</label>
    <div>{{ $role->name }}</div>
            </div>
            <div class="form-group">
                <label for="inputRoles">Roles</label>
    <div>
    @if(!empty($rolePermissions))
                    @foreach($rolePermissions as $v)
                    <button type="button" class="btn btn-sm btn-outline-secondary btn-flat">{{ $v->name }}</button>
        @endforeach
                @endif
    </div>
            </div>
        <a href="{{ route('roles.index') }}"><button type="button" class="btn btn-outline-info btn-flat">Back</button>
        </div>
    </div>
</div> @stop
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop
@section('js')
    <script> console.log('Hi!'); </script>
@stop