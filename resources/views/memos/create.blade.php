@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <i class="fe-settings"></i><span> @lang('global.setting.title') </span>
                        </li>
                        <li class="breadcrumb-item">
                            @lang('dashboard.memo.title')
                        </li>
                        <li class="breadcrumb-item active">@lang('dashboard.memo.add')</li>
                    </ol>
                </div>
                <h4 class="page-title">@lang('dashboard.memo.add')</h4>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="pt-4 pl-4">
            <a href="{{ route('memos.index') }}"><i class="mdi mdi-arrow-left-drop-circle"></i> @lang('dashboard.memo.back') </a>
        </div>
        <div class="card-body">
            <form action="{{ route('memos.store') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group row mb-3">
                            <label class="col-md-3 col-form-label text-right" for="title">@lang('dashboard.memo.field.title')</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="title" value="{{ old('title') }}" maxlength="50">
                                @if ($errors->has('title'))
                                    <strong class="text-danger">{{ $errors->first('title') }}</strong>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label class="col-md-3 col-form-label text-right" for="addtional_file">@lang('dashboard.memo.add_file')</label>
                            <div class="col-md-9">
                                <input type="file" class="custom-file-input" id="addtional_file" name="addtional_file" accept='.jpg, .pdf'>
                                <label class="custom-file-label" for="addtional_file">@lang('dashboard.memo.choose_file')</label>
                                @if ($errors->has('addtional_file'))
                                    <strong class="text-danger">{{ $errors->first('addtional_file') }}</strong>
                                @endif
                            </div>
                        </div>
                        <div class="form-group mb-0 justify-content-end row">
                            <div class="col-9">
                                <button type="submit" class="btn btn-block btn-primary waves-effect waves-light">@lang('dashboard.memo.save')</button>
                            </div>
                        </div>                        
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('javascript') 
    <script>
        $(document).ready(function(){
            $("#addtional_file").on("change", function() {
                var file = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(file);
            });
        });
    </script>
@endsection