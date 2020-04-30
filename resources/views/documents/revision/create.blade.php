@extends('layouts.app')
<link href="{{ url('assets/erp/gijgo.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/erp/bootstrap4.1.3.min.css') }}" rel="stylesheet" type="text/css" />
<style>
    .row {
        margin: 10px;
    }
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
</style>
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('document.index') }}"> <i class="fe-book"></i><span>@lang('document.title') </span></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('revision.index', $id) }}"><span>@lang('document.revision.title') </span></a>
                        </li>
                        <li class="breadcrumb-item active">@lang('document.revision.add new')</li>
                    </ol>
                </div>
                <h4 class="page-title">@lang('document.revision.add new')</h4>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="pt-4 pl-4">
            <a href="{{ route('revision.index', $id) }}"><i class="mdi mdi-arrow-left-drop-circle"></i> @lang('document.revision.back') </a>
        </div>
        <div class="card-body">
            <form id="add_form" action="{{ route('revision.save', $id) }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div id="progressbarwizard">
                    <ul class="nav nav-pills bg-light nav-justified form-wizard-header mb-3">
                        <li class="nav-item" tab-index="1">
                            <a href="#revision-tab" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                <i class="fe-book mr-1"></i>
                                <span class="d-none d-sm-inline">Revision</span>
                            </a>
                        </li>
                        <li class="nav-item" tab-index="2">
                            <a href="#department-tab" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                <i class="fa fa-history mr-1"></i>
                                <span class="d-none d-sm-inline">Mandatory reads by departments</span>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content b-0 mb-0">
                        <div id="bar" class="progress mb-3" style="height: 7px;">
                            <div class="bar progress-bar progress-bar-striped progress-bar-animated bg-success"></div>
                        </div>

                        <div class="tab-pane" id="revision-tab">
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group row mb-3">
                                        <label class="col-md-3 col-form-label text-right" for="revision_no">@lang('document.revision.no')</label>
                                        <div class="col-md-9">
                                            <input type="text" class="col-md-12 form-control" required="" name="revision_no" value="{{ old('revision_no') }}" maxlength="50">
                                            @if ($errors->has('revision_no'))
                                                <strong class="text-danger">{{ $errors->first('revision_no') }}</strong>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label class="col-md-3 col-form-label text-right" for="user_key"> @lang('document.revision.user_key')</label>
                                        <div class="col-md-9">
                                            <input type="text" id="user_key" name="user_key" required="" class="form-control" value="">
                                            @if ($errors->has('user_key'))
                                                <strong class="text-danger">{{ $errors->first('user_key') }}</strong>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label class="col-md-3 col-form-label text-right" for="document">@lang('document.revision.document')</label>
                                        <div class="col-md-9" style="padding-left: 12px !important;">
                                            <input type="file" class="custom-file-input" id="document" name="document" accept='.doc, .docx, .xls, .xlsx, .pdf,.jpeg, .pptx' onchange='openFile1(this)'>
                                            <label class="custom-file-label" for="document">@lang('document.revision.choose_document')</label>
                                            @if ($errors->has('document'))
                                                <strong class="text-danger">{{ $errors->first('document') }}</strong>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="department-tab">
                            <div class="row">
                                <div class="col-12">
                                    <div class="text-center">
                                        <div class="mb-3 col-md-4 offset-md-4 text-center">
                                            <div id="tree" style="text-align: left"></div>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->
                        </div>
                        <input type="hidden" id="depart_ids" name="depart_ids" />
                        <ul class="list-inline mb-0 wizard">
                            <li class="previous list-inline-item">
                                <a href="javascript: void(0);" class="btn btn-secondary">Previous</a>
                            </li>
                            <li class="next list-inline-item float-right">
                                <button type="button" id="btnSubmit" class="btn btn-success">Save</button>
                                <a href="javascript: void(0);" id="btnNext" class="btn btn-secondary">Next</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('javascript')
    <script src="{{ url('assets/erp/gijgo.min.js') }}" type="text/javascript"></script>

    <script>
        var tree;
        $(document).ready(function(){
            $("#document").on("change", function() {
                var file = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(file);
            });
            tree = $('#tree').tree({
                primaryKey: 'id',
                uiLibrary: 'bootstrap4',
                dataSource: '{{ url("getdeparttree") }}',
                checkboxes: true
            });
            var $validator = $("#add_form").validate({
                rules: {
                    document: {
                        required: true
                    }
                }
            });

            $("#btnSubmit").click(function () {
                var checkedIds = tree.getCheckedNodes();
                if (checkedIds == "")
                {
                    toastr.options.closeButton = true;
                    toastr.options.closeMethod = 'fadeOut';
                    toastr.options.timeOut = 2000; // How long the toast will display without user interaction
                    toastr.options.progressBar = true;
                    toastr.warning("Please choose Departments", "Warning!");
                    return;
                }
                $("#depart_ids").val(checkedIds);
                $('#add_form').submit();
            });

            $('#progressbarwizard').bootstrapWizard({
                'tabClass': 'nav nav-pills',
                'onNext': function(tab, navigation, index) {
                    var $valid = $("#add_form").valid();
                    if (!$valid) {
                        $validator.focusInvalid();
                        return false;
                    }
                },
                'onTabClick': function(activeTab, navigation, currentIndex, nextIndex) {
                    if (nextIndex <= currentIndex) {
                        return;
                    }
                    var $valid = $("#add_form").valid();
                    if (!$valid) {
                        $validator.focusInvalid();
                        return false;
                    }
                    if (nextIndex > currentIndex+1){
                        return false;
                    }
                },
                onTabShow:function(t,r,a){
                    var o=(a+1)/r.find("li").length*100;
                    $("#progressbarwizard").find(".bar").css({width:o+"%"})
                    tab_index = $(t).attr('tab-index');
                    if (tab_index == 2)
                    {
                        $("#btnSubmit").css("display", "block");
                        $("#btnNext").css("display", "none");
                    }else{
                        $("#btnSubmit").css("display", "none");
                        $("#btnNext").css("display", "block");
                    }
                }

            });
        });
    </script>
@endsection

