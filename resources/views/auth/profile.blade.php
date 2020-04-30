@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-md-6 col-xs-12 offset-md-3">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                </ol>
            </div>
            <h4 class="page-title">Profile</h4>
        </div>
    </div>
</div>
<!-- end page title -->
<div class="row">
    <div class="col-md-6 col-xs-12 offset-md-3">
        <div class="card-box">
            @if(isset($message))
                <div class="alert alert-success bg-success text-white border-0">{{ $message }}</div>
            @endif
            <ul class="nav nav-pills navtab-bg nav-justified">
                @if(!$errors->has('password') && !$errors->has('password_confirmation'))
                    <li class="nav-item">
                        <a href="#settings" data-toggle="tab" aria-expanded="true" class="nav-link active">
                            Settings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#password" data-toggle="tab" aria-expanded="false" class="nav-link">
                            Password
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="#settings" data-toggle="tab" aria-expanded="false" class="nav-link">
                            Settings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#password" data-toggle="tab" aria-expanded="true" class="nav-link active">
                            Password
                        </a>
                    </li>
                @endif

            </ul>
            <div class="tab-content">
                @if(!$errors->has('password') && !$errors->has('password_confirmation'))
                <div class="tab-pane show active" id="settings">
                @else
                <div class="tab-pane" id="settings">
                @endif
                    {!! Form::open(array('url' => array('/savepro', Auth::user()->id), 'files' => true)) !!}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <img src="{{ asset(Auth::user()->photo) }}" id="imgPhoto" class="rounded-circle img-thumbnail"
                                     alt="profile-image" style="width: 6.5rem; height: 6.7rem; background-color: white">
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" value="{{ Auth::user()->name==''?old('name'):Auth::user()->name }}" id="name" name="name" placeholder="Enter name">
                                    @if($errors->has('name'))
                                        <div class="alert alert-danger bg-danger text-white border-0">{{ $errors->first('name') }}</div>
                                    @endif
                                </div>
                            </div>
{{--                            <div class="col-md-12">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="fullname">Full Name</label>--}}
{{--                                    <input type="text" class="form-control" value="{{ Auth::user()->fullname==''?old('fullname'):Auth::user()->fullname }}" id="fullname" name="fullname">--}}
{{--                                    @if($errors->has('fullname'))--}}
{{--                                        <div class="alert alert-danger bg-danger text-white border-0">{{ $errors->first('fullname') }}</div>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input type="email" class="form-control" value="{{ Auth::user()->email==''?old('email'):Auth::user()->email }}" id="email" name="email">
                                    @if($errors->has('email'))
                                    <div class="alert alert-danger bg-danger text-white border-0">{{ $errors->first('email') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="birth">Birth Date</label>
                                    <input type="text" class="form-control" value="{{ Auth::user()->birth==''?old('birth'):Auth::user()->birth }}" id="birth" name="birth">
                                    @if($errors->has('birth'))
                                        <div class="alert alert-danger bg-danger text-white border-0">{{ $errors->first('birth') }}</div>
                                    @endif
                                </div>
                            </div>
{{--                            <div class="col-md-12">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="title">Title</label>--}}
{{--                                    <input type="text" class="form-control" value="{{ Auth::user()->title }}" id="title" name="title" readonly="" />--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-12">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="rank">Rank</label>--}}
{{--                                    <input type="text" class="form-control" value="{{ Auth::user()->rank }}" id="rank" name="rank" readonly="" />--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="contact_number">Office Number</label>
                                    <input type="text" class="form-control" value="{{ Auth::user()->contact_number==''?old('contact_number'):Auth::user()->contact_number }}" id="contact_number" name="contact_number">
                                    @if($errors->has('contact_number'))
                                        <div class="alert alert-danger bg-danger text-white border-0">{{ $errors->first('contact_number') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="extension_number">Extension Number</label>
                                    <input type="text" class="form-control" value="{{ Auth::user()->extension_number==''?old('extension_number'):Auth::user()->extension_number }}" id="extension_number" name="extension_number">
                                    @if($errors->has('extension_number'))
                                        <div class="alert alert-danger bg-danger text-white border-0">{{ $errors->first('extension_number') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="mobile_number">Mobile Number</label>
                                    <input type="text" class="form-control" value="{{ Auth::user()->mobile_number==''?old('mobile_number'):Auth::user()->mobile_number }}" id="mobile_number" name="mobile_number">
                                    @if($errors->has('mobile_number'))
                                        <div class="alert alert-danger bg-danger text-white border-0">{{ $errors->first('mobile_number') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div> <!-- end row -->
                        <div class="row col-md-12">
                            <div class="col-md-6 text-left col-xs-12 mb-2">
                                <input type="file" class="custom-file-input" id="customFile" name="customFile" accept='image/*' onchange='openFile(this)'>
                                <label class="custom-file-label" for="customFile">Choose photo</label>
                            </div>
                            <div class="col-md-6 text-right col-xs-12">
                                <button type="submit" class="btn btn-success waves-effect waves-light"><i class="mdi mdi-content-save"></i> Save</button>
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>
                <!-- end settings content-->
                @if(!$errors->has('password') && !$errors->has('password_confirmation'))
                <div class="tab-pane" id="password">
                @else
                <div class="tab-pane show active" id="password">
                @endif
                    {!! Form::open(array('url' => array('changepwd', Auth::user()->id), 'files' => true)) !!}
                        <div class="row">
                            <div class="col-md-6 offset-sm-0 offset-md-3">
                                <div class="form-group">
                                    <label for="userpassword">New Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password">
                                    @if($errors->has('password'))
                                        <div class="alert alert-danger bg-danger text-white border-0">{{ $errors->first('password') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div> <!-- end row -->
                        <div class="row">
                            <div class="col-md-6 offset-sm-0 offset-md-3">
                                <div class="form-group">
                                    <label for="confirmpassword">Confirm Password</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Re-enter password">
                                    @if($errors->has('password_confirmation'))
                                        <div class="alert alert-danger bg-danger text-white border-0">{{ $errors->first('password_confirmation') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div> <!-- end row -->

                        <div class="text-right">
                            <button type="submit" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Save</button>
                        </div>
                    {{ Form::close() }}
                </div>
                <!-- end password content-->
            </div>
        </div>
    </div>
</div>
@stop

@section('javascript')
    <script>
        $(document).ready(function(){
            $(".custom-file-input").on("change", function() {
                console.log($(this).val());
                var file = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(file);
            });
            $("#birth").flatpickr();
        });
        var openFile = function(event) {
            var reader = new FileReader();
            reader.onload = function(e){
                console.log(e.target.result);
                document.querySelector('#imgPhoto').src = e.target.result;
            };
            reader.readAsDataURL(event.files[0]);
        };
    </script>
@endsection
