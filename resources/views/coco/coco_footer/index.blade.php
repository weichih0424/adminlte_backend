@extends('adminlte::page')

@section('title', '分類管理')

@section('content_header')
    <h1>{{$header}}</h1>
@stop

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            @can('coco_footer-create')
            <div class="float-left mr-3">
                <a href="{{ route('coco_footer.create') }}">
                    <button type="button" class="btn btn-block btn-success btn-flat float-right px-4">新增</button></a>
            </div>
            @endcan
            <div class="float-left mr-3">
                <a href="{{ url('admin/coco/coco_footer_sort/reorder') }}">
                    <button type="button" class="btn btn-block btn-secondary btn-flat float-right px-4">排序</button></a>
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
                            <td style="width:15%;" class="align-middle">{{ $data->url }}</td>
                            <td style="width:15%;" class="status_color align-middle">{{ ($data->status==1)?'上架':'下架' }}</td>
                            <td style="width:15%;" class="align-middle">{{ ($data->blank==1)?'開新分頁':'同頁開啟' }}</td>
                            <td style="width:15%;" class="align-middle">
                                @can('coco_footer-edit')
                                    <a class="btn btn-primary btn-flat mr-4"
                                        href="{{ route('coco_footer.edit', $data->id) }}">編輯</a>
                                @endcan
                                @can('coco_footer-delete')
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['coco_footer.destroy', $data->id], 'style' => 'display:inline', 'class' => 'deleteItem']) !!}
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
{!! $datas->links() !!}
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
