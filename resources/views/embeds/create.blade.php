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
                            <a href="{{ route('embeds.index') }}"><i class="fe-book"></i><span> @lang('global.embed.title') </span></a>
                        </li>
                        <li class="breadcrumb-item active">
                            <span> @lang('global.embed.add') </span>
                        </li>
                    </ol>
                </div>
                <h4 class="page-title">@lang('global.embed.add')</h4>
            </div>
        </div>
    </div>
    <div class="card">
{{--        <div class="pt-4 pl-4">--}}
{{--            <a href="{{ route('document.index') }}"><i class="mdi mdi-arrow-left-drop-circle"></i> @lang('document.back') </a>--}}
{{--        </div>--}}
        <div class="card-body">
            <form id="add_form" action="{{ route('embeds.store') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div id="progressbarwizard">
                    <ul class="nav nav-pills bg-light nav-justified form-wizard-header mb-3">
                        <li class="nav-item" tab-index="1">
                            <a href="#document-tab" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                <i class="fe-box"></i>
                                <span class="d-none d-sm-inline">Settings (Form)</span>
                            </a>
                        </li>
                        <li class="nav-item" tab-index="3">
                            <a href="#finish-tab" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                <i class="mdi mdi-checkbox-marked-circle-outline mr-1"></i>
                                <span class="d-none d-sm-inline">Available to</span>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content b-0 mb-0">
                        <div id="bar" class="progress mb-3" style="height: 7px;">
                            <div class="bar progress-bar progress-bar-striped progress-bar-animated bg-success"></div>
                        </div>

                        <div class="tab-pane" id="document-tab">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group row mb-3">
                                        <label class="col-md-3 col-form-label text-right" for="form_name">@lang('global.embed.field.form_name')</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="form_name" required="" id="form_name" value="{{ old('form_name') }}" maxlength="190">
                                            @if ($errors->has('form_name'))
                                                <strong class="text-danger">{{ $errors->first('form_name') }}</strong>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label class="col-md-3 col-form-label text-right" for="due_date">@lang('global.embed.field.due_date')</label>
                                        <div class="col-md-9">
                                            <input type="text" id="due_date" name="due_date" class="form-control flatpickr-input-date active" value="{{ old('due_date') }}" readonly="readonly">
                                            @if ($errors->has('due_date'))
                                                <strong class="text-danger">{{ $errors->first('due_date') }}</strong>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label class="col-md-3 col-form-label text-right" for="embed_html">@lang('global.embed.field.embed_html')</label>
                                        <div class="col-md-9">
                                            <textarea class="form-control" id="embed_html" name="embed_html" rows="6" value="{{ old('embed_html') }}"></textarea>
                                            @if ($errors->has('embed_html'))
                                                <strong class="text-danger">{{ $errors->first('embed_html') }}</strong>
                                            @endif
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->
                        </div>
                        <div class="tab-pane" id="finish-tab">
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

                    </div> <!-- tab-content -->
                </div> <!-- end #progressbarwizard-->
            </form>

        </div> <!-- end card-body -->
    </div>
@stop


@section('javascript')
    <script src="{{ url('assets/erp/gijgo.min.js') }}" type="text/javascript"></script>

    <script>
        var tab_index = 1;
        function chengeCompany() {
            $.ajax({
                url: "{{ route('document.getdepartments') }}",
                data: {
                    'company_id': $('#company').val(),
                    '_token': "{{ csrf_token() }}"
                },
                type: 'get',
                success: function(data) {
                    let rows = JSON.parse(data);
                    $("#department option").remove();
                    for (let ind in rows)
                    {
                        $("#department").append($("<option></option>")
                            .attr("value", rows[ind].id)
                            .text(rows[ind].department_name)
                        );
                    }
                }
            });
        }
        var tree;
        $(document).ready(function () {
           chengeCompany();

           tree = $('#tree').tree({
               primaryKey: 'id',
               uiLibrary: 'bootstrap4',
               dataSource: '{{ url("getdeparttree") }}',
               checkboxes: true
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

           $(".custom-file-input").on("change", function() {
                console.log($(this).val());
                var file = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(file);
            });
            var $validator = $("#add_form").validate({
                rules: {
                    due_date: {
                        required: true
                    },
                    embed_html: {
                        required:true
                    }
                }
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
                    if (tab_index == 3)
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
