@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('category.index') }}"> <i class="fe-book"></i><span>@lang('document.category.title') </span></a>
                        </li>
                        <li class="breadcrumb-item active">@lang('document.category.add new')</li>
                    </ol>
                </div>
                <h4 class="page-title">@lang('document.category.add new')</h4>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="pt-4 pl-4">
            <a href="{{ route('category.index') }}"><i class="mdi mdi-arrow-left-drop-circle"></i> @lang('document.category.back') </a>
        </div>
        <div class="card-body">
            <form action="{{ route('category.store') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-10">

                        <div class="form-group row mb-3">
                            <label class="col-md-3 col-form-label text-right" for="company_name">@lang('document.category.name')</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="category_name" value="{{ old('category_name') }}" maxlength="50">
                                @if ($errors->has('category_name'))
                                    <strong class="text-danger">{{ $errors->first('category_name') }}</strong>
                                @endif
                            </div>
                        </div>

                        <div class="form-group mb-0 justify-content-end row">
                            <div class="col-9">
                                <button type="submit" class="btn btn-block btn-primary waves-effect waves-light">@lang('document.category.save')</button>
                            </div>
                        </div>                        
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

