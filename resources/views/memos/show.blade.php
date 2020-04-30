@inject('request', 'Illuminate\Http\Request')
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
                            @lang('dashboard.memo.title')
                        </li>
                        <li class="breadcrumb-item active">@lang('dashboard.memo.view')</li>
                    </ol>
                </div>
                <h4 class="page-title">@lang('dashboard.memo.view')</h4>
            </div>
        </div>
    </div>
    <div class="card">
        <embed src="{{url('/assets/' . $one->file_path)}}#toolbar=0" style="width:100%;min-height:640px;" />
    </div>
@stop

