@extends('adminlte::page')

@section('title', '文章管理')

@section('content_header')
    <h1>{{$header}}</h1>
@stop

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="float-left mr-3">
                @can('coco_nav-create')
                    @if (isset($_GET['parent_id']))
                    <a href="{{ route('coco_nav.create',['parent_id' => $_GET['parent_id']]) }}">
                        <button type="button" class="btn btn-block btn-success btn-flat float-right px-4">新增</button></a>
                    @else
                    <a href="{{ route('coco_nav.create') }}">
                        <button type="button" class="btn btn-block btn-success btn-flat float-right px-4">新增</button></a>
                    @endif
                @endcan
            </div>
            @if(isset($_GET['parent_id']))
                <div class="float-left mr-3">
                    <a href="{{ route('coco_nav.index') }}">
                        <button type="button" class="btn btn-block btn-outline-secondary btn-flat float-right px-4">返回主分類頁</button></a>
                </div>
            @endif
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
                        @foreach ($field as $value)
                            <th>{{ $value }}</th>
                        @endforeach
                        <th>動作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datas as $key => $data)
                            <tr>
                                <td style="width:5%;" class="align-middle">{{ $data->id }}</td>
                                <td style="width:15%;" class="align-middle">{{ $data->name }}</td>
                                <td style="width:15%;" class="align-middle">
                                    {{ str_limit($data->url,40,'...') }}
                                    {!! ($data->position == 1)?
                                    Form::open(['method' => 'GET', 'route' => ['coco_nav.index']]).
                                    '<input name="parent_id" type="hidden" value="'.$data->id.'">'.
                                    Form::submit('編輯次分類', ['class' => 'btn btn-outline-info']):"";
                                    !!}
                                    {!! Form::close() !!}
                                </td>
                                <td style="width:20%;" class="align-middle">{{ ($data->position!==2)?'第一層':'第二層' }}</td>
                                <td style="width:10%;" class="status_color align-middle">{{ ($data->status==1)?'上架':'下架' }}</td>
                                <td style="width:20%;" class="align-middle">{{ $data->updated_at }}</td>
                                <td style="width:15%;" class="align-middle">
                                    @can('coco_nav-edit')
                                        <a class="btn btn-primary btn-flat mr-4"
                                            href="{{ route('coco_nav.edit', $data->id) }}">編輯</a>
                                    @endcan
                                    @can('coco_nav-delete')
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['coco_nav.destroy', $data->id], 'style' => 'display:inline', 'class' => 'deleteItem']) !!}
                                        {!! Form::button('刪除', ['class' => 'delete btn btn-danger btn-flat']) !!}
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

@stop
@section('css')
@stop
@section('js')
<script>
    $(document).ready(function() {
        $('.delete').on('click', function() {
            item = $(this).parent('form')
            Swal.fire({
                title: '確定要刪除這筆資料？',
                icon: 'question',
                iconColor: '#f87e6c',
                showDenyButton: true,
                confirmButtonText: `刪除！`,
                confirmButtonColor: '#f87e6c',
                denyButtonText: `取消`,
                denyButtonColor: '#9c9996'
            }).then((result) => {
                if (result.isConfirmed) {
                    item.submit();
                }
            })
        })
    });

</script>
@stop
