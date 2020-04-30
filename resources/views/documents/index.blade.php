@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')
{{--<style>--}}
{{--    @media (min-width: 800px) {--}}
{{--        .table td{--}}
{{--            font-size: 13px;--}}
{{--            padding-top: 4px !important;--}}
{{--            padding-bottom: 4px !important;--}}
{{--        }--}}
{{--        .table th{--}}
{{--            font-size: 13px;--}}
{{--        }--}}
{{--    }--}}
{{--</style>--}}
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <i class="fe-book"></i><span> @lang('document.title') </span>
                        </li>
                    </ol>
                </div>
                <h4 class="page-title">@lang('document.title')</h4>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('document.index') }}" method="get">
            <div class="card-widgets">
                <a data-toggle="collapse" href="#cardCollpase1" class="btn btn-secondary btn-rounded" style="color:whitesmoke" role="button" aria-expanded="false" aria-controls="cardCollpase1">
                    <i class="mdi mdi-minus"></i>
                </a>
                <button class="btn btn-blue">
                    <i class="fe-search"></i> @lang('document.search')
                </button>
            </div>
            <h5 class="card-title mb-0">Search</h5>
            <div id="cardCollpase1" class="collapse pt-3 show">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="form-group col-md-6 col-xs-12 mb-3">
                            <label class="col-md-3 col-form-label text-left" for="company">@lang('document.fields.company')</label>
                            <div class="col-md-9">
                                <select class="form-control" name="company" id="company" onchange="chengeCompany()">
                                    <option value="0"></option>
                                    @foreach($companies as $one)
                                        <option value="{{ $one->id }}">{{ $one->company_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group col-md-6 col-xs-12 mb-3">
                            <label class="col-md-3 col-form-label text-left" for="department">@lang('document.fields.department')</label>
                            <div class="col-md-9">
                                <select class="form-control" name="department" id="department">
                                    <option value="0"></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 col-xs-12 mb-3">
                            <label class="col-md-3 col-form-label text-left" for="category">@lang('document.fields.category')</label>
                            <div class="col-md-9">
                                <select class="form-control" name="category" id="category">
                                    <option value="0"></option>
                                    @foreach($categories as $one)
                                        <option value="{{ $one->id }}">{{ $one->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-6 col-xs-12 mb-3">
                            <label class="col-md-3 col-form-label text-left" for="keyword">@lang('document.fields.keyword')</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="keyword" id="keyword" value="{{ isset($request->keyword)?$request->keyword:'' }}" maxlength="50">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div> <!-- end card-->
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8 col-xs-12 mb-3">
                    <!-- <input type="text" id="range-datepicker" class="form-control text-center" value="{{ date('Y-m-01')." to ". date('Y-m-d') }}" style="width: 250px;" id="dtstart" name="dtstart" /> -->
                </div>
                <div class="col-md-4 col-xs-12 text-sm-center text-md-right mb-3">
                    @can('documents_manage')
                    <a href="{{ route('document.create') }}" class="btn btn-primary">
                        <i class="icon-plus"></i> @lang('document.add new')
                    </a>
                    @endcan
                </div>
            </div>
            <div class="responsive-table-plugin">
                <div class="table-rep-plugin">
                    <div class="table-responsive">
                        <table id="dataTable" class="table dt-responsive table-striped nowrap dataTable no-footer">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>@lang('document.fields.company_code')</th>
                                    <th>@lang('document.fields.department')</th>
                                    <th>@lang('document.category.name')</th>
                                    <th>@lang('document.fields.doc name')</th>
                                    <th>@lang('document.fields.doc no')</th>
                                    <th>@lang('document.fields.revision no')</th>
                                    <th>@lang('document.fields.action.title')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $index = 0 @endphp
                                @foreach ($documents as $one)
                                    @if ($one->company_code == null || $one->department_name == null || $one->category_name == null)
                                        @continue
                                    @endif
                                    @php $index ++ @endphp
                                    <tr data-entry-id="{{ $one->id }}">
                                        <td>{{ $index }}</td>
                                        <td>{{ $one->company_code }}</td>
                                        <td>{{ $one->department_name }}</td>
                                        <td>{{ $one->category_name }}</td>
                                        <td>{{ $one->docu_name }}</td>
                                        <td>{{ $one->docu_no }}</td>
                                        @php
                                            $order = App\Models\Revision::whereRaw('id = (select max(`id`) from documents_revision where docu_id='.$one->id.')')->get();
                                        @endphp
                                        @if(sizeof($order) > 0)
                                        <td>{{ $order[0]->revision_no }}</td>
                                        @php $extension = explode('.', $order[0]->file_name) @endphp
                                        <td>
                                            <div class="btn-group">
                                                @if ($extension[1] == 'pdf')
                                                    <a href="#"  class="btn dropdown-toggle btn-sm" data-toggle="dropdown"
                                                       aria-haspopup="true" aria-expanded="false">
                                                        <img src="/assets/images/documents/pdf.png" height="30" />
                                                    </a>
                                                @elseif ($extension[1] == 'doc' || $extension[1] == 'docx')
                                                    <a href="#"  class="btn dropdown-toggle btn-sm" data-toggle="dropdown"
                                                       aria-haspopup="true" aria-expanded="false">
                                                        <img src="/assets/images/documents/word.png" height="30" />
                                                    </a>
                                                @elseif ($extension[1] == 'jpeg')
                                                    <a href="#"  class="btn dropdown-toggle btn-sm" data-toggle="dropdown"
                                                       aria-haspopup="true" aria-expanded="false">
                                                        <img src="/assets/images/documents/jpeg.png" height="30" />
                                                    </a>
                                                @elseif ($extension[1] == 'ppt' || $extension[1] == 'pptx')
                                                    <a href="#"  class="btn dropdown-toggle btn-sm" data-toggle="dropdown"
                                                       aria-haspopup="true" aria-expanded="false">
                                                        <img src="/assets/images/documents/ppt.png" height="30" />
                                                    </a>
                                                @else
                                                    <a href="#"  class="btn dropdown-toggle btn-sm" data-toggle="dropdown"
                                                       aria-haspopup="true" aria-expanded="false">
                                                        <img src="/assets/images/documents/excel.png" height="30" />
                                                    </a>
                                                @endif
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{ route('document.downfile', $one->id) }}"><i class="fe-download mr-2"></i>Download</a>
                                                    <a class="dropdown-item" href="{{ route('revision.index', $one->id) }}"><i class="fe-printer mr-2"></i>Revisions</a>
                                                    @can('documents_manage')
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item" href="{{ url('/document/' . $one->id . '/edit') }}"><i class="mdi mdi-square-edit-outline mr-2"></i>@lang('document.fields.action.edit')</a>
                                                        <a class="dropdown-item" href="javascript:;" onclick="del({{ $one->id }});"><i class="mdi mdi-delete-outline mr-2"></i>@lang('document.fields.action.delete')</a>
                                                    @endcan
                                                </div>
                                            </div>
                                        </td>
                                        @else
                                        <td></td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="#"  class="btn dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <img src="/assets/images/documents/nodoc.png" height="30" />
                                                </a>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{ route('revision.index', $one->id) }}"><i class="fe-printer mr-2"></i>Revisions</a>
                                                    @can('documents_manage')
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item" href="{{ url('/document/' . $one->id . '/edit') }}"><i class="mdi mdi-square-edit-outline mr-2"></i>@lang('document.fields.action.edit')</a>
                                                        <a class="dropdown-item" href="javascript:;" onclick="del({{ $one->id }});"><i class="mdi mdi-delete-outline mr-2"></i>@lang('document.fields.action.delete')</a>
                                                    @endcan
                                                </div>
                                            </div>
                                        </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript') 
    <script>
        var firstFlag = true;
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
                    $("#department").append($("<option></option>")
                        .attr("value", "0")
                        .text("")
                    );
                    for (let ind in rows)
                    {
                        $("#department").append($("<option></option>")
                            .attr("value", rows[ind].id)
                            .text(rows[ind].department_name)
                        );
                    }
                    if (firstFlag == true)
                    {
                        $('#department').val("{{ isset($request->department)?$request->department:'' }}");
                        firstFlag = false;
                    }
                }
            });
        }
        $(document).ready(function () {
            $('#company').val("{{ isset($request->company)?$request->company:'' }}");
            $('#category').val("{{ isset($request->category)?$request->category:'' }}");
            chengeCompany();
            $("#range-datepicker").flatpickr({mode:"range"});
        })
        function del(id) {
            swal({
                title: "{{ trans('templates.are you sure?') }}",
                text: "{{ trans('templates.you would not be able to revert this!') }}",
                type: "warning",
                showCancelButton: !0,
                confirmButtonClass: "btn btn-confirm mt-2",
                cancelButtonClass: "btn btn-cancel ml-2 mt-2",
                confirmButtonText: "{{ trans('templates.yes, delete it!') }}",
                cancelButtonText: "{{ trans('templates.cancel') }}",
            }).then(function(e) {
                if (e.value) {
                    $.ajax({
                        url: "{{ url('/document/destroy') }}" + "/" + id,
                        type: 'post',
                        dataType: 'text',
                        success: function(data) {
                            window.location="{{ route('document.index') }}";
                        }
                    });
                }
            });
        }
    </script>
@endsection
