<div class="col-md-12">
    <div class="card">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        {!! Form::open(['route' => $route, 'method' => $method, 'files' => true]) !!}
        <div class="card-body">
            @foreach ($field as $value)
                @if($value['type'] !== 'hidden')
                <div class="form-group">
                    <label for="{{ $value['name'] }}" 
                        @error($value['name'])class="text-red"@enderror>{{ $value['title'] }}
                        @if ( (isset($value['required']) && $value['required'] == true) || (isset($_GET['parent_id']) && (isset($value['sub_required']) && $value['sub_required'] == true)) )
                            <span class="text-danger">*</span>
                        @endif 
                        @if(isset($value['hint']))<span class="text-muted">{{$value['hint']}}</span>@endif
                    </label>
                @endif
                    @switch($value['type'])
                        @case('text')
                            {!! Form::input('text', $value['name'], isset($data) ? $data[$value['name']] : old($value['name']), 
                            ['placeholder' => isset($value['placeholder'])?$value['placeholder']:$value['name'], 'class' => isset($value['class'])?'form-control '.$value['class']:'form-control' , 'id' => isset($value['id'])?$value['id']:'', ((isset($value['required']) && $value['required'] == 1)) ? 'required' : '']) !!}
                            {{-- 增加搜尋欄位用按鈕 --}}
                            @if (isset($value['search']) && $value['search'] == true)
                                {!! Form::button('搜尋', ['class' => 'search_' . $value['name'] . ' mt-2 btn btn-outline-info btn-flat', 'data-id' => $value['name']]) !!}
                                <div id="result_box" class="card mt-2">
                                    <div class="error"></div>
                                    <div class="result_data list-group" style=''></div>
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination justify-content-center"></ul>
                                    </nav>
                                </div>
                            @endif
                        @break
                        @case('textarea')
                            {!! Form::textarea($value['name'], isset($data) ? $data[$value['name']] : old($value['name']), ['placeholder' => isset($value['placeholder'])?$value['placeholder']:$value['name'], 'class' => isset($value['class'])?'form-control '.$value['class']:'form-control' , 'id' => isset($value['id'])?$value['id']:'','rows' => isset($value['row'])?$value['row']:'10', 'cols' => isset($value['col'])?$value['col']:'30', ((isset($value['required']) && $value['required'] == 1)) ? 'required' : '']) !!}
                        @break
                        @case('fileupload')
                            {!! Form::input('hidden', 'img_src', url('/'), ['id' => 'img_src']) !!}
                            {!! Form::input('hidden', $value['name'], isset($data) && $data[$value['name']] != '' ? '["' . $data[$value['name']] . '"]' : null, [
                                'class' => 'file ajaxfileuplod',
                                'data-theme' => 'fas',
                                'data-min-file-count' => $value['set']['data-min-file-count'],
                                'folder' => $value['set']['folder'],
                                'verify' => isset($value['set']['verify'])?$value['set']['verify']:'', //增加自訂規則 語法： 規則1|規則2:參數1,參數2...
                                isset($value['required']) && $value['required'] == 1 ? 'required' : '',
                            ]) !!}
                        @break
                        @case("cropimage")
                            <div id="crop_image"
                                style="background-image: url({{ old('image') ? old('image') : $data[$value['name']] }})">
                            </div>
                            {!! Form::input('hidden', $value['name'], $data[$value['name']], ['class' => isset($value['class'])?'form-control '.$value['class']:'form-control', 'id' => 'cropOutput']) !!}
                        @break
                        @case('start-end')
                            <div class="d-flex">
                                {!! Form::input('datetime-local', 'start_at', isset($data->start_at) ? $data->start_at : old('start_at'), ['class' => isset($value['class'])?'form-control w-50 '.$value['class']:'form-control', 'id' => isset($value['id'])?$value['id'][0]:'', isset($value['required']) && $value['required'] == 1 ? 'required' : '']) !!}
                                {!! Form::input('datetime-local', 'end_at', isset($data->end_at) ? $data->end_at : old('end_at'), ['class' => isset($value['class'])?'form-control w-50 '.$value['class']:'form-control', 'id' => isset($value['id'])?$value['id'][1]:'', isset($value['required']) && $value['required'] == 1 ? 'required' : '']) !!}
                            </div>
                        @break
                        @case('datetime')
                            {!! Form::input('datetime-local', $value['name'], isset($data) ? $data[$value['name']] : old($value['name']), ['class' => isset($value['class'])?'form-control w-25 '.$value['class']:'form-control','id' => isset($value['id'])?$value['id'][1]:'', isset($value['required']) && $value['required'] == 1 ? 'required' : '']) !!}
                        @break
                        @case("date")
                            {!! Form::input('date', $value['name'], $data[$value['name']], ['class' => isset($value['class'])?'form-control w-25 '.$value['class']:'form-control','id' => isset($value['id'])?$value['id'][1]:'',isset($value['required']) && $value['required'] == 1 ? 'required' : '']) !!}
                        @break
                        @case('select')
                            <div class="input-group">
                                {!! Form::select($value['name'], $value['option'], isset($data) ? $data[$value['name']] : old($value['name']), ['class' => isset($value['class'])?'form-control '.$value['class']:'form-control' , 'id' => isset($value['id'])?$value['id']:'', isset($value['required']) && $value['required'] == 1 ? 'required' : '']) !!}
                            </div>
                        @break
                        @case('hidden')
                            {!! Form::input('hidden', $value['name'], $value['value']) !!}
                        @break
                        @case('custom')
                            @include($value['include'])
                        @break
                    @endswitch
                @if($value['type'] !== 'hidden')
                </div>
                @endif
            @endforeach
            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-flat mr-4">儲存</button>
                {{-- @if(isset($_GET['parent_id']) || (isset($data->parent_id) && $data->parent_id == 2)) --}}
                    <input type="button"name="back" class="btn btn-outline-info" value="返回"onClick="javascript:history.back()">
                {{-- @else
                <a href="{{ route($root.'.index') }}">
                    <button type="button" class="btn btn-outline-info btn-flat">返回</button>
                </a>
                @endif --}}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>