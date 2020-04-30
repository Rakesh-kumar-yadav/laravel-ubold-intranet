@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')
<link href="{{ url('assets/erp/gijgo.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/erp/bootstrap4.1.3.min.css') }}" rel="stylesheet" type="text/css" />

<style>
    .dropdown-toggle::after{
        display: none;
    }
    .notification-list{
        height: 70px;
    }
    .notification-a
    {
        padding-top: 24px !important;
        height: 70px;
    }
    @media (max-width: 640px) {
        .profile-notification{
            top:16px;
        }
    }
}
</style>
@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-md-6 col-xs-12 offset-md-3">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                </ol>
            </div>
            <h4 class="page-title">@lang('user_control.usersetting.title')</h4>
        </div>
    </div>
</div>
<!-- end page title -->
<div class="row">
    <div class="card col-md-6 col-xs-12 offset-md-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row mb-3">
                        {!! Form::label('user', trans('user_control.usersetting.choose_user'), ['class' => 'col-form-label col-md-4 text-right', 'onchange'=>'gettree()']) !!}
                        <div class="col-md-8">
                            <select id = 'userlist' class="form-control" onchange="gettree()">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('user'))
                                <strong class="text-danger">{{ $errors->first('user') }}</strong>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div id="tree"></div>
                </div>
                <div class="col-md-12 text-right">
                    <button type="button" class="btn btn-success waves-effect waves-light btn-outline-primary" onclick="save();"><i class="mdi mdi-content-save"></i> Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('javascript')
<script src="{{ url('assets/erp/gijgo.min.js') }}" type="text/javascript"></script>

    <script>
        var tree;
        $(document).ready(function(){
            $(".custom-file-input").on("change", function() {
                var file = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(file);
            });
            $("#birth").flatpickr();

            tree = $('#tree').tree({
                primaryKey: 'id',
                uiLibrary: 'bootstrap4',
                dataSource: '{{ url("getdeparttree") }}' + '?user_id=' + $("#userlist").val(),
                checkboxes: true
            });
        });
        var openFile = function(event) {
            var reader = new FileReader();
            reader.onload = function(e){
                document.querySelector('#imgPhoto').src = e.target.result;
            };
            reader.readAsDataURL(event.files[0]);
        };
        var gettree = function () {
            tree.destroy();
            tree = $('#tree').tree({
                primaryKey: 'id',
                uiLibrary: 'bootstrap4',
                dataSource: '{{ url("getdeparttree") }}' + '?user_id=' + $("#userlist").val(),
                checkboxes: true
            });
        }
        var save = function () {
            var checkedIds = tree.getCheckedNodes();
            $.ajax({
                url: "{{ url('savedeparttree') }}",
                data:{"depart_ids": checkedIds, "user_id":document.getElementById('userlist').value},
                type: 'get',
                success: function(data) {
                    if(data == "OK")
                    {
                        toastr.options.closeButton = true;
                        toastr.options.closeMethod = 'fadeOut';
                        toastr.options.timeOut = 2000; // How long the toast will display without user interaction
                        toastr.options.progressBar = true;
                        toastr.success("Successfully changed.", "Congratulation!");
                    }
                }
            });
        }
    </script>
@endsection
