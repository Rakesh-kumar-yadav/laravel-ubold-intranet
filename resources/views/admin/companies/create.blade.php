@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}"><i class="fe-users"></i><span> @lang('templates.user control') </span></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.companies.index') }}"> @lang('user_control.company.title') </a>
                        </li>
                        <li class="breadcrumb-item active">@lang('user_control.company.create_title')</li>
                    </ol>
                </div>
                <h4 class="page-title">@lang('user_control.company.create_title')</h4>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="pt-4 pl-4">
            <a href="{{ route('admin.companies.index') }}"><i class="mdi mdi-arrow-left-drop-circle"></i> @lang('user_control.company.back') </a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.companies.store') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group row mb-3">
                            <label class="col-md-3 col-form-label text-right" for="company_code">@lang('user_control.company.code')</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="company_code" value="{{ old('company_code') }}" maxlength="50">
                                @if ($errors->has('company_code'))
                                    <strong class="text-danger">{{ $errors->first('company_code') }}</strong>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label class="col-md-3 col-form-label text-right" for="company_name">@lang('user_control.company.name')</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="company_name" value="{{ old('company_name') }}" maxlength="50">
                                @if ($errors->has('company_name'))
                                    <strong class="text-danger">{{ $errors->first('company_name') }}</strong>
                                @endif
                            </div>
                        </div>

                        <div class="form-group mb-0 justify-content-end row">
                            <div class="col-9">
                                <button type="submit" class="btn btn-block btn-primary waves-effect waves-light">@lang('user_control.company.save')</button>
                            </div>
                        </div>                        
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

