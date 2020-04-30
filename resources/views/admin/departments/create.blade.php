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
                            <a href="{{ route('admin.departments.index') }}"> @lang('user_control.department.title') </a>
                        </li>
                        <li class="breadcrumb-item active">@lang('user_control.department.create_title')</li>
                    </ol>
                </div>
                <h4 class="page-title">@lang('user_control.department.create_title')</h4>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="pt-4 pl-4">
            <a href="{{ route('admin.departments.index') }}"><i class="mdi mdi-arrow-left-drop-circle"></i> @lang('user_control.department.back') </a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.departments.store') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group row mb-3">
                            <label class="col-md-3 col-form-label text-right" for="department_name">@lang('user_control.department.name')</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="department_name" value="{{ old('department_name') }}" maxlength="50">
                                @if ($errors->has('department_name'))
                                    <strong class="text-danger">{{ $errors->first('department_name') }}</strong>
                                @endif
                            </div>
                        </div>

                        <div id="customerDiv" class="form-group row mb-3">
                            {!! Form::label('companies', trans('user_control.department.company_name'), ['class' => 'col-md-3 text-right']) !!}
                            <div class="col-md-9">
                                {!! Form::select('company_name', $companies, old('companies'), ['class' => 'form-control']) !!}
                                @if($errors->has('company_name'))
                                    <strong class="text-danger">{{ $errors->first('company_name') }}</strong>
                                @endif
                            </div>
                        </div>

                        <div class="form-group mb-0 justify-content-end row">
                            <div class="col-9">
                                <button type="submit" class="btn btn-block btn-primary waves-effect waves-light">@lang('user_control.department.save')</button>
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
        var validator;
        $("document").ready(function(){
            $('.js-example-basic-multiple').select2();

        });
    </script>
@endsection
