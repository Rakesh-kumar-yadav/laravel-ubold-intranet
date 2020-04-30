@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <i class="fe-image"></i><span> @lang('global.gallery.title') </span>
                        </li>
                        <li class="breadcrumb-item active">@lang('global.gallery.add')</li>
                    </ol>
                </div>
                <h4 class="page-title">@lang('global.gallery.add')</h4>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="pt-4 pl-4">
            <a href="{{ route('admin.galleries.index') }}"><i class="mdi mdi-arrow-left-drop-circle"></i> @lang('global.gallery.back') </a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.galleries.store') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group row mb-3">
                            <label class="col-md-3 col-form-label text-right" for="event">@lang('global.gallery.field.event')</label>
                            <div class="col-md-9">
                                <select name="event" id="event" class="form-control">
                                    @foreach ($ones as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('event'))
                                    <strong class="text-danger">{{ $errors->first('event') }}</strong>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label class="col-md-3 col-form-label text-right" for="title">@lang('global.gallery.field.title')</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                                @if ($errors->has('title'))
                                    <strong class="text-danger">{{ $errors->first('title') }}</strong>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label class="col-md-3 col-form-label text-right" for="gallery">@lang('global.gallery.field.gallery')</label>
                            <div class="col-md-9">
                                <input type="file" class="custom-file-input" id="gallery" name="gallery" accept='image/*'>
                                <label class="custom-file-label" for="gallery">@lang('dashboard.memo.choose_file')</label>
                                @if ($errors->has('gallery'))
                                    <strong class="text-danger">{{ $errors->first('gallery') }}</strong>
                                @endif
                            </div>
                        </div>
                        <div class="form-group mb-0 justify-content-end row">
                            <div class="col-9">
                                <button type="submit" class="btn btn-block btn-primary waves-effect waves-light">@lang('global.gallery.save')</button>
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
            $("#gallery").on("change", function() {
                var file = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(file);
            });
        });
    </script>
@endsection
