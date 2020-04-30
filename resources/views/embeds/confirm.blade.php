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
            <div class="row">
                <div class="col-md-8 col-xs-12 offset-md-2 text-center">
                    @php echo \App\Models\Embed::find($notification->embed_id)->embed_html; @endphp
                </div>
                <div class="col-md-8 col-xs-12 offset-md-2 text-center">
                    <form action="{{ url('/embeds/confirm', $notification->id) }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                    <div class="custom-control custom-checkbox">
                        @if(intval($notification->confirm) == 1)
                            <input type="checkbox" class="custom-control-input" checked="" id="customCheck3" name="customCheck3" required="" />
                        @else
                            <input type="checkbox" class="custom-control-input" id="customCheck3" name="customCheck3" required="" />
                        @endif
                        <label class="custom-control-label font-15" for="customCheck3">
                                I acknowledge that I have responded and submitted on the forms.
                        </label>
                    </div>
                    @if ($errors->has('customCheck3'))
                        <strong class="text-danger">{{ $errors->first('customCheck3') }}</strong>
                    @endif
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-primary waves-effect waves-light mt-2">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>            
        </div>
    </div>
@stop
