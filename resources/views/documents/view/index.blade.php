@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('document.index') }}"><i class="fe-book"></i><span> @lang('document.title') </span></a>
                        </li>
                        <li class="breadcrumb-item active">@lang('document.view.title')</li>
                    </ol>
                </div>
                <h4 class="page-title">@lang('document.view.title')</h4>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">

                <div class="col-md-8 col-xs-12 offset-md-2">
                    @php
                        $filename = \App\Models\Revision::find($notification->revision_id)->file_name;
                        $extension = explode('.', $filename)[sizeof(explode('.', $filename)) - 1];
                    @endphp
                    @if(strtolower($extension) == "pdf" || strtolower($extension) == "jpeg")
                    <embed id="memo_content" src="{{url('/assets/' . \App\Models\Revision::find($notification->revision_id)->file_name)}}"
                           style="width:100%; height:500px;" />
                    @else
                    <iframe src='https://view.officeapps.live.com/op/embed.aspx?src=http://127.0.0.1:8080/assets/documents/J6TaFm1RSCIT72C1B6IvGgshrLpRQDF0YbBqfmEG.xlsx' width='100%' height='500px' frameborder='0'> </iframe>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-xs-12 offset-md-2">
                    <div class="row">
                        <p class="text-muted mb-2 font-15 col-md-6">
                            <strong>@lang('document.category.name') :</strong>
                            <span class="ml-2">{{ \App\Models\Category::find(\App\Models\Document::find($notification->docu_id)->category_id)->category_name }}</span>
                        </p>
                        <p class="text-muted mb-2 font-15 col-md-6">
                            <strong>@lang('document.fields.doc no') :</strong>
                            <span class="ml-2">{{ \App\Models\Document::find($notification->docu_id)->docu_no }}</span>
                        </p>
                    </div>
                </div>
                <div class="col-md-8 col-xs-12 offset-md-2">
                    <div class="row">
                        <p class="text-muted mb-2 font-15 col-md-6">
                            <strong>@lang('document.fields.doc name') :</strong>
                            <span class="ml-2">{{ \App\Models\Document::find($notification->docu_id)->docu_name }}</span>
                        </p>
                        <p class="text-muted mb-2 font-15 col-md-6">
                            <strong>@lang('document.fields.revision no') :</strong>
                            <span class="ml-2">{{ \App\Models\Revision::find($notification->revision_id)->revision_no }}</span>
                        </p>
                    </div>
                </div>
                <div class="col-md-8 col-xs-12 offset-md-2">
                    <p class="text-muted mb-2 font-15">
                        <strong>@lang('document.revision.user_key') :</strong>
                        <span class="ml-2">{{ \App\Models\Revision::find($notification->revision_id)->user_key }}</span>
                    </p>
                </div>

                <div class="col-md-8 col-xs-12 offset-md-2">
                    <form action="{{ url('/document/confirm', $notification->id) }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                    <div class="custom-control custom-checkbox">
                        @if(intval($notification->confirm) == 1)
                            <input type="checkbox" class="custom-control-input" checked="" id="customCheck3" name="customCheck3" required="" />
                        @else
                            <input type="checkbox" class="custom-control-input" id="customCheck3" name="customCheck3" required="" />
                        @endif
                        <label class="custom-control-label font-15" for="customCheck3">I acknowledge that I have read and understood the above document in its entirety and agree to abide by them.</label>
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

@section('javascript') 
    <script>

    </script>
@endsection
