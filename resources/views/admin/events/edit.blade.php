@extends('layouts.app')

@section('content')
<div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <i class="fe-clock"></i><span> @lang('global.event.title') </span>
                        </li>
                        <li class="breadcrumb-item active">@lang('global.event.edit')</li>
                    </ol>
                </div>
                <h4 class="page-title">@lang('global.event.edit')</h4>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="pt-4 pl-4">
            <a href="{{ route('admin.events.index') }}"><i class="mdi mdi-arrow-left-drop-circle"></i> @lang('global.event.back') </a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.events.update', $one->id) }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group row mb-3">
                            <label class="col-md-3 col-form-label text-right" for="name">@lang('global.event.field.name')</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="name" value="{{ $one->name }}">
                                @if ($errors->has('name'))
                                    <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label class="col-md-3 col-form-label text-right" for="thumbnail">@lang('global.event.field.thumbnail')</label>
                            <div class="col-md-9">
                                <input type="file" class="custom-file-input" id="thumbnail" name="thumbnail" accept='image/*'>
                                <label class="custom-file-label" for="thumbnail">@lang('dashboard.memo.choose_file')</label>
                                @if ($errors->has('thumbnail'))
                                    <strong class="text-danger">{{ $errors->first('thumbnail') }}</strong>
                                @endif
                            </div>
                        </div>

                        <div class="form-group mb-0 justify-content-end row">
                            <div class="col-9">
                                <button type="submit" class="btn btn-block btn-primary waves-effect waves-light">@lang('global.event.change')</button>
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
            $("#thumbnail").on("change", function() {
                var file = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(file);
            });
        });
    </script>
@endsection
