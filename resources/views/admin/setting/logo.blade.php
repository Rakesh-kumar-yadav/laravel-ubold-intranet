@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-md-8 col-xs-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                </ol>
            </div>
            <h4 class="page-title">@lang("global.setting.title")</h4>
        </div>
    </div>
</div>

<div class="card col-md-12 col-xs-12">
    <div class="card-title">

    </div>
    <div class="card-body">
        {!! Form::open(array('url' => 'admin/setting/update_logo', 'files' => true)) !!}
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="row">
                <div class="col-md-4 col-xs-12 text-right mt-1">
                    <label class="col-form-label text-right pt-2" for="hr_link">HR Link</label>
                </div>
                <div class="col-md-8 text-left col-xs-12 mt-2">
                    <input type="text" class="custom-file-label col-md-12" name="hr_link" value="{{ $hr_link }}">
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-4 col-xs-12 text-right mt-1">
                    <label class="col-form-label text-right pt-2" for="title">Title</label>
                </div>
                <div class="col-md-8 text-left col-xs-12 mt-2">
                    <input type="text" class="custom-file-label col-md-12" name="title" value="{{ $title }}" maxlength="50">
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-4 col-xs-12 text-right mt-1">
                    <label class="col-form-label text-right pt-2" for="footername">@lang('global.setting.footer')</label>
                </div>
                <div class="col-md-8 text-left col-xs-12 mt-2">
                    <input type="text" class="custom-file-label col-md-12" name="footername" value="{{ $footername }}" maxlength="50">
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-4 col-xs-12 text-center mt-1">
                    <img src="{{ url('assets/images/favicon.png') }}" id="img_favicon" alt="" height="57" style="">
                </div>
                <div class="col-md-8 text-left col-xs-12 mt-2">
                    <input type="file" class="custom-file-input" id="favicon" name="favicon" accept='image/png' onchange='openFile5(this)'>
                    <label class="custom-file-label" for="favicon">@lang('global.setting.change_favicon')</label>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-4 col-xs-12 text-center mt-1">
                    <img src="{{ url('assets/images/logo.png') }}" id="imgPhoto" alt="" height="57" style="">
                </div>
                <div class="col-md-8 text-left col-xs-12 mt-2">
                    <input type="file" class="custom-file-input" id="photo" name="photo" accept='image/png' onchange='openFile1(this)'>
                    <label class="custom-file-label" for="photo">@lang('global.setting.change_photo')</label>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-4 col-xs-12 text-center mt-1">
                    <img src="{{ url('assets/images/logo_login.png') }}" id="imgPhoto_login" alt="" height="57" style="">
                </div>
                <div class="col-md-8 text-left col-xs-12 mt-2">
                    <input type="file" class="custom-file-input" id="photo_login" name="photo_login" accept='image/png' onchange='openFile3(this)'>
                    <label class="custom-file-label" for="photo_login">@lang('global.setting.change_photo_login')</label>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-4 col-xs-12 text-center mt-1">
                    <img src="{{ url('assets/images/logo_sm.png') }}" id="imgPhoto_sm" alt="" height="57" style="">
                </div>
                <div class="col-md-8 text-left col-xs-12 mt-2">
                    <input type="file" class="custom-file-input" id="photo_sm" name="photo_sm" accept='image/png' onchange='openFile2(this)'>
                    <label class="custom-file-label" for="photo_sm">@lang('global.setting.change_photo_sm')</label>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-4 col-xs-12 text-center mt-1">
                    <img src="{{ url('assets/images/login_background.jpeg') }}" id="login_background" alt="" width="100%" style="">
                </div>
                <div class="col-md-8 text-left col-xs-12 mt-2">
                    <input type="file" class="custom-file-input" id="login_background" name="login_background" accept='image/jpeg' onchange='openFile4(this)'>
                    <label class="custom-file-label" for="login_background">@lang('global.setting.change_background')</label>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-success waves-effect waves-light"><i class="mdi mdi-content-save"></i> Save</button>
                </div>
            </div>
        {{ Form::close() }}
    </div>
</div>
@stop

@section('javascript')
    <script>
        $(document).ready(function(){
            $(".custom-file-input").on("change", function() {
                // console.log($(this).val());
                var file = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(file);
            });
        });
        var openFile1 = function(event) {
            var reader = new FileReader();
            reader.onload = function(e){
                document.querySelector('#imgPhoto').src = e.target.result;
            };
            reader.readAsDataURL(event.files[0]);
        };
        var openFile3 = function(event) {
            var reader = new FileReader();
            reader.onload = function(e){
                document.querySelector('#imgPhoto_login').src = e.target.result;
            };
            reader.readAsDataURL(event.files[0]);
        };
        var openFile2 = function(event) {
            var reader = new FileReader();
            reader.onload = function(e){
                document.querySelector('#imgPhoto_sm').src = e.target.result;
            };
            reader.readAsDataURL(event.files[0]);
        };
        var openFile4 = function(event) {
            var reader = new FileReader();
            reader.onload = function(e){
                document.querySelector('#login_background').src = e.target.result;
            };
            reader.readAsDataURL(event.files[0]);
        };
        var openFile5 = function(event) {
            var reader = new FileReader();
            reader.onload = function(e){
                document.querySelector('#img_favicon').src = e.target.result;
            };
            reader.readAsDataURL(event.files[0]);
        };
    </script>
@endsection
