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
                    <label for="inputName">姓名</label>
                    {!! Form::text('name', null, array('placeholder' => 'Name','class' =>'form-control', 'id' => 'inputName')) !!}
                </div>
                <div class="form-group">
                    <label for="inputEmail">帳號</label>
                    {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control', 'id' => 'inputEmail')) !!}
                </div>
                <div class="form-group">
                    <label for="inputEmployee_id">員編</label>
                    {!! Form::text('employee_id', null, array('placeholder' => '請輸入員工編號','class' => 'form-control', 'id' => 'inputEmployee_id')) !!}
                </div>
                <div class="form-group">
                    <label for="inputPhone_extension">分機</label>
                    {!! Form::text('phone_extension', null, array('placeholder' => '請輸入分機號碼','class' => 'form-control', 'id' => 'inputPhone_extension')) !!}
                </div>
                <div class="form-group">
                    <label for="inputDepartment_name">部門名稱</label>
                    {!! Form::select('department_name',[
                        0 =>'--請選擇--',
                        1 => '董事會',
                        2=> '總經理室',
                        3=> '頻道發行部',
                        4=> '財務部',
                        5=> '新聞部',
                        6=> '人力資源部',
                        7=> '管理部',
                        8=> '版權業務部',
                        9=> '工程技術部',
                        10=> '海外發展部',
                        11=> '法律事務部',
                        12=> '節目部',
                        13=> '策略與新創事業部',
                        14=> '品牌公關部',
                        15=> '業務部',
                        16=> '數位事業部',
                        17=> '製作資源部',
                        18=> '趨勢發展部',
                    ],NULL, array('class' => 'form-control', 'id' => 'inputDepartment_name')) !!}
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
                    <label for="inputRoles">群組權限</label>
                    {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','multiple', 'id' => 'inputRoles')) !!}
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-flat">送出</button>
                {{-- <a href="{{ route('users.index') }}"><button type="button" class="btn btn-outline-infobtn-flat">返回</button> --}}
                <input type="button"name="back" class="btn btn-outline-info" value="返回"onClick="javascript:history.back()">
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