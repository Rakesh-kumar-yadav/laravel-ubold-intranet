@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <i class="fe-bar-chart"></i><span> @lang('global.goal.title') </span>
                        </li>
                        <li class="breadcrumb-item active">@lang('global.goal.add')</li>
                    </ol>
                </div>
                <h4 class="page-title">@lang('global.goal.add')</h4>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="pt-4 pl-4">
            <a href="{{ route('admin.goals.index') }}"><i class="mdi mdi-arrow-left-drop-circle"></i> @lang('global.goal.back') </a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.goals.store') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group row mb-3">
                            <label class="col-md-3 col-form-label text-right" for="our_goal">@lang('global.goal.field.goal')</label>
                            <div class="col-md-9">
                                <input type="file" class="custom-file-input" id="our_goal" name="our_goal" accept='.jpg, .pdf'>
                                <label class="custom-file-label" for="our_goal">@lang('dashboard.memo.choose_file')</label>
                                @if ($errors->has('our_goal'))
                                    <strong class="text-danger">{{ $errors->first('our_goal') }}</strong>
                                @endif
                            </div>
                        </div>
                        <div class="form-group mb-0 justify-content-end row">
                            <div class="col-9">
                                <button type="submit" class="btn btn-block btn-primary waves-effect waves-light">@lang('global.goal.save')</button>
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
            $("#our_goal").on("change", function() {
                var file = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(file);
            });
        });
    </script>
@endsection
