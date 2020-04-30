@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
            <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('document.index') }}"> <i class="fe-book"></i><span>@lang('document.title') </span></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('revision.index', $revision->docu_id) }}"><span>@lang('document.revision.title') </span></a>
                        </li>
                        <li class="breadcrumb-item active">@lang('document.revision.edit')</li>
                    </ol>
                </div>
                <h4 class="page-title">@lang('document.revision.edit')</h4>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="pt-4 pl-4">
            <a href="{{ route('revision.index', $revision->docu_id) }}"><i class="mdi mdi-arrow-left-drop-circle"></i> @lang('document.revision.back') </a>
        </div>
        <div class="card-body">
            <form action="{{ route('revision.update', $revision->id) }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="row">
                    <div class="col-md-10">
                    <div class="form-group row mb-3">
                            <label class="col-md-3 col-form-label text-right" for="revision_no">@lang('document.revision.no')</label>
                            <div class="col-md-9">
                                <input type="text" class="col-md-12 form-control" name="revision_no" value="{{ $revision->revision_no }}" maxlength="50">
                                @if ($errors->has('revision_no'))
                                    <strong class="text-danger">{{ $errors->first('revision_no') }}</strong>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label class="col-md-3 col-form-label text-right" for="user_key"> @lang('document.revision.user_key')</label>
                            <div class="col-md-9">
                                <input type="text" id="user_key" name="user_key" required="" class="form-control" value="{{ $revision->user_key }}">
                                @if ($errors->has('user_key'))
                                    <strong class="text-danger">{{ $errors->first('user_key') }}</strong>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label class="col-md-3 col-form-label text-right" for="document">@lang('document.revision.document')</label>
                            <div class="col-md-9">
                                <input type="file" class="custom-file-input" id="document" name="document" accept='.doc, .docx, .xls, .xlsx, .pdf,.jpeg, .pptx' onchange='openFile1(this)'>
                                <label class="custom-file-label" for="document">@lang('document.revision.choose_document')</label>
                            </div>
                        </div>

                        <div class="form-group mb-0 justify-content-end row">
                            <div class="col-9">
                                <button type="submit" class="btn btn-block btn-primary waves-effect waves-light">@lang('document.revision.change')</button>
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
            $("#document").on("change", function() {
                var file = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(file);
            });
        });
    </script>
@endsection
