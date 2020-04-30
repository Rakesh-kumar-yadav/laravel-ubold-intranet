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
                        <a href="{{ route('admin.messages.index') }}"> @lang('dashboard.message.title') </a>
                    </li>
                    <li class="breadcrumb-item active">@lang('dashboard.message.edit')</li>
                </ol>
            </div>
            <h4 class="page-title">@lang('dashboard.message.edit')</h4>
        </div>
    </div>
</div>
    
    <div class="card">
        <div class="pt-4 pl-4">
            <a href="{{ route('admin.messages.index') }}"><i class="mdi mdi-arrow-left-drop-circle"></i> @lang('dashboard.message.back') </a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.messages.update', $one->id) }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group row mb-3">
                            <label class="col-md-3 col-form-label text-right" for="admin_title">Title</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="admin_title" value="{{ $one->admin_title }}" maxlength="255">
                                @if ($errors->has('admin_title'))
                                    <strong class="text-danger">{{ $errors->first('admin_message') }}</strong>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label class="col-md-3 col-form-label text-right" for="admin_message">@lang('dashboard.message.field.admin_message')</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="admin_message" value="{{ $one->admin_message }}" maxlength="255">
                                @if ($errors->has('admin_message'))
                                    <strong class="text-danger">{{ $errors->first('admin_message') }}</strong>
                                @endif
                            </div>
                        </div>

                        <div class="form-group mb-0 justify-content-end row">
                            <div class="col-9">
                                <button type="submit" class="btn btn-block btn-primary waves-effect waves-light">@lang('dashboard.message.save')</button>
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

    </script>
@endsection
