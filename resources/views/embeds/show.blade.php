@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <i class="fe-box"></i><span> @lang('global.embed.title') </span>
                        </li>
                        <li class="breadcrumb-item active">@lang('global.embed.view')</li>
                    </ol>
                </div>
                <h4 class="page-title">@lang('global.embed.view')</h4>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="text-center">
                @php echo $one->embed_html; @endphp
            </div>
        </div>
    </div>
@stop
