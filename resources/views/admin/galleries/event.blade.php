@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">
                            <i class="fe-image"></i><span> @lang('global.gallery.title') </span>
                        </li>
                    </ol>
                </div>
                <h4 class="page-title">@lang('global.gallery.title')</h4>
            </div>
        </div>
    </div>

    <div class="row filterable-content">
        @foreach ($ones as $item)
            <div class="col-sm-6 col-xl-4">
                <div class="gal-box">
                    <a href="{{ url('/galleries/gallery/'.$item->id) }}">
                        <img src="{{ url('/assets/'.$item->thumbnail) }}" alt="work-thumbnail" width="100%" height="300px;">
                    </a>
                    <div class="gall-info">
                        <h4 class="font-16 mt-0">{{ $item->name }}</h4>
                    </div> <!-- gallery info -->
                </div> <!-- end gal-box -->
            </div> <!-- end col -->
        @endforeach
    </div>
@stop

@section('javascript') 
    <script>
        $(document).ready(function(){

        });
    </script>
@endsection
