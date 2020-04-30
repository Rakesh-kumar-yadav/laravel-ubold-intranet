@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <i class="fe-bar-chart active"></i><span> @lang('global.organisation.title') </span>
                        </li>
                    </ol>
                </div>
                <h4 class="page-title">@lang('global.organisation.title')</h4>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="row">
            @can('documents_manage')
                <div class="col-md-4 pt-4 pl-4">
                    <a href="{{ route('organisations.create') }}" class="btn btn-primary"><i class="icon-plus"></i> @lang('global.organisation.add') </a>
                </div>
            @endcan
            
            <div class="col-md-8">
                <form action="{{ route('organisations.index') }}" method="get">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-4 pt-4 pl-4 pr-4">
                            <select id="company" name="company" class="form-control" onchange="chengeCompany()">
                                <option value="0">@lang('global.organisation.select_company')</option>
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 pt-4 pl-4 pr-4">
                            <select id="department" name="department" class="form-control">
                                <option value="0">@lang('global.organisation.select_department')</option>
                            </select>
                        </div>
                        <div class="col-md-4 pt-4 pl-4 pr-4 text-right">
                            <button class="btn btn-blue" type="submit">
                                <i class="fe-search"></i> @lang('document.search')
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="responsive-table-plugin">
                <div class="table-rep-plugin">
                    <div class="table-responsive">
                        <table id="dataTable" class="table dt-responsive table-striped nowrap dataTable no-footer">
                            <thead>
                                <tr>
                                    <th>@lang('dashboard.memo.field.no')</th>
                                    <th>@lang('global.organisation.field.company')</th>
                                    <th>@lang('global.organisation.field.department')</th>
                                    <th>Revision No</th>
                                    <th>@lang('dashboard.memo.field.action.title')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $index = 0 @endphp
                                @foreach ($ones as $one)
                                    @if ($one->companyname == null || $one->departmentname == null)
                                        @continue
                                    @endif
                                    @php $index ++ @endphp
                                    <tr data-entry-id="{{ $one->id }}">
                                        <td>{{ $index }}</td>
                                        <td>{{ $one->companyname }}</td>
                                        <td>{{ $one->departmentname }}</td>
                                        <td>{{ $one->title }}</td>
                                        @php $extension = explode('.', $one->organisation_chart) @endphp
                                        <td>
                                            <div class="btn-group mb-2">
                                                @if ($extension[1] == 'pdf')
                                                    <a href="#"  class="btn dropdown-toggle btn-sm" data-toggle="dropdown"
                                                       aria-haspopup="true" aria-expanded="false">
                                                        <img src="/assets/images/documents/pdf.png" height="30" />
                                                    </a>
                                                @else
                                                    <a href="#"  class="btn dropdown-toggle btn-sm" data-toggle="dropdown"
                                                       aria-haspopup="true" aria-expanded="false">
                                                        <img src="/assets/images/documents/jpeg.png" height="30" />
                                                    </a>
                                                @endif
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{ route('organisations.show', $one->id) }}"><i class="fe-eye mr-2"></i>@lang('dashboard.memo.field.action.view')</a>
                                                    @can('documents_manage')
                                                        <a class="dropdown-item" href="{{ route('organisations.edit', $one->id) }}"><i class="mdi mdi-square-edit-outline mr-2"></i>@lang('dashboard.memo.field.action.edit')</a>
                                                        <a class="dropdown-item" href="javascript:;" onclick="del({{ $one->id }});"><i class="mdi mdi-delete-outline mr-2"></i>@lang('dashboard.memo.field.action.delete')</a>
                                                    @endcan
                                                </div>
                                            </div>
                                        </td>
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
        $(document).ready(function(){
            $('#company').val({{ $company_id }});
            chengeCompany();
            $('#department').val({{ $department_id }});
        });
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
                        url: "{{ url('/organisations/destroy') }}" + "/" + id,
                        type: 'post',
                        dataType: 'text',
                        success: function(data) {
                            window.location="{{ route('organisations.index') }}";
                        }
                    });
                }
            });
        }
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
                        .attr("value", 0)
                        .text("@lang('global.organisation.select_department')")
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
                        $('#department').val("{{ $department_id }}");
                        firstFlag = false;
                    }
                }
            });
        }

    </script>
@endsection
