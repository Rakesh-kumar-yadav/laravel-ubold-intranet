@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <i class="fe-bar-chart"></i><span> @lang('global.organisation.title') </span>
                        </li>
                        <li class="breadcrumb-item">
                            <span> @lang('global.organisation.view') </span>
                        </li>
                        <li class="breadcrumb-item active">@lang('global.organisation.profile')</li>
                    </ol>
                </div>
                <h4 class="page-title">@lang('global.organisation.profile')</h4>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-xs-12 offset-md-3">
        <div class="card-box">
            <div class="tab-content">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <img src="{{ asset($one->photo) }}" id="imgPhoto" class="rounded-circle img-thumbnail"
                                    alt="profile-image" style="width: 6.5rem; height: 6.7rem; background-color: white">
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" value="{{ $one->name }}" id="name" name="name" readonly>
                            </div>
                        </div>
{{--                        <div class="col-md-12">--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="fullname">Full Name</label>--}}
{{--                                <input type="text" class="form-control" value="{{ $one->fullname }}" id="fullname" name="fullname" readonly>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control" value="{{ $one->email }}" id="email" name="email" readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="birth">Birth Date</label>
                                <input type="text" class="form-control" value="{{ $one->birth }}" id="birth" name="birth" readonly>
                            </div>
                        </div>
{{--                        <div class="col-md-12">--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="title">Title</label>--}}
{{--                                <input type="text" class="form-control" value="{{ $one->title }}" id="title" name="title" readonly="" />--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-12">--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="rank">Rank</label>--}}
{{--                                <input type="text" class="form-control" value="{{ $one->rank }}" id="rank" name="rank" readonly="" />--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="contact_number">Office Number</label>
                                <input type="text" class="form-control" value="{{ $one->contact_number }}" id="contact_number" name="contact_number" readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="extension_number">Extension Number</label>
                                <input type="text" class="form-control" value="{{ $one->extension_number }}" id="extension_number" name="extension_number" readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="mobile_number">Mobile Number</label>
                                <input type="text" class="form-control" value="{{ $one->mobile_number }}" id="mobile_number" name="mobile_number" readonly>
                            </div>
                        </div>
                    </div> <!-- end row -->
                </div>
                <!-- end settings content-->
            </div>
        </div>
    </div>
@stop

