@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <i class="fe-bar-chart"></i><span> @lang('global.organisation.title') </span>
                        </li>
                        <li class="breadcrumb-item active">@lang('global.organisation.view')</li>
                    </ol>
                </div>
                <h4 class="page-title">@lang('global.organisation.view')</h4>
            </div>
        </div>
    </div>
    
    <div class="card">
        <embed src="{{url('/assets/' . $one->organisation_chart)}}#toolbar=0" style="width:100%;min-height:640px;" />
        <div class="row">
            <div class="col-md-2 offset-md-5 text-center">
                <span class="badge badge-danger width-lg font-14" style="margin-top: 5px;">Team members</span>
                <div class="avatar-group mt-2">
                    @foreach ($users as $user)
                        <a href="{{ url('/organisations/profile/' . $user->id) }}" class="avatar-group-item pr-1" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ $user->name }}">
                            <img src="/{{ $user->photo }}" class="rounded-circle avatar-sm" alt="friend">
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@stop

