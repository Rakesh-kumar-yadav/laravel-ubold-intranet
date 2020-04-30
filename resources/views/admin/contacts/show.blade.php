@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">
                            <i class="fe-message-circle"></i><span> @lang('global.contact.title') </span>
                        </li>
                    </ol>
                </div>
                <h4 class="page-title">@lang('global.contact.title')</h4>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="row">
            @can('documents_manage')
                <div class="col-md-4 pt-4 pl-4">
                    <a href="{{ url('/admin/contacts/create') }}" class="btn btn-primary"><i class="icon-plus"></i> @lang('global.contact.add') </a>
                </div>
            @endcan
        </div>
        <div class="card-body">
            @if ($one->contact != '')
                <embed src="{{url('/assets/' . $one->contact)}}#toolbar=0" style="width:100%;min-height:640px;" />
            @endif
        </div>
    </div>
@stop

