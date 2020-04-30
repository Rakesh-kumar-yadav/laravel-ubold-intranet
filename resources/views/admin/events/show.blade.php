@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.events.index') }}"><i class="fe-clock"></i><span> @lang('global.event.title') </span></a>
                        </li>
                        <li class="breadcrumb-item active">@lang('global.event.view')</li>
                    </ol>
                </div>
                <h4 class="page-title">@lang('global.event.view')</h4>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="pt-4 pl-4">
            <a href="{{ route('admin.events.index') }}"><i class="mdi mdi-arrow-left-drop-circle"></i> @lang('global.event.back') </a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-10">
                    <div class="form-group row mb-3">
                        <label class="col-md-3 col-form-label text-right" for="name">@lang('global.event.field.name')</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="name" value="{{ $one->name }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-md-3 col-form-label text-right" for="name">@lang('global.event.field.thumbnail')</label>
                        <div class="col-md-9">
                            <img src="{{ url('/assets/'.$one->thumbnail) }}" alt="" width="100%">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

