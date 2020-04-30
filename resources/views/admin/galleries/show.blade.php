@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.galleries.index') }}"><i class="fe-image"></i><span> @lang('global.gallery.title') </span></a>
                        </li>
                        <li class="breadcrumb-item active">@lang('global.gallery.view')</li>
                    </ol>
                </div>
                <h4 class="page-title">@lang('global.gallery.view')</h4>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="pt-4 pl-4">
            <a href="{{ route('admin.galleries.index') }}"><i class="mdi mdi-arrow-left-drop-circle"></i> @lang('global.gallery.back') </a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-10">
                    <div class="form-group row mb-3">
                        <label class="col-md-3 col-form-label text-right" for="event">@lang('global.gallery.field.event')</label>
                        <div class="col-md-9">
                            <select name="event" id="event" class="form-control" disabled="true">
                                @foreach ($ones as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-md-3 col-form-label text-right" for="title">@lang('global.gallery.field.title')</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="title" value="{{ $one->title }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-md-3 col-form-label text-right" for="name">@lang('global.gallery.field.gallery')</label>
                        <div class="col-md-9">
                            <img src="{{ url('/assets/'.$one->gallery) }}" alt="" width="100%">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('javascript') 
    <script>
        $(document).ready(function(){
            $('#event').val({{ $one->event_id }});
        });
    </script>
@endsection
