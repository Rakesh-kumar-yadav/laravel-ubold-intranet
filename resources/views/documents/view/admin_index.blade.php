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
                        <li class="breadcrumb-item active">Acknowledgement View</li>
                    </ol>
                </div>
                <h4 class="page-title">Acknowledgement View</h4>
            </div>
        </div>
    </div>
    <div class="row col-md-12 mb-2">
{{--        <input type="text" id="range-datepicker" class="form-control text-center" value="{{ date('Y-m-01')." to ". date('Y-m-d') }}" style="width: 250px; font-size: 15px;" id="dtstart" name="dtstart" />--}}
    </div>
    <div class="card">
        <div class="card-body">
            <form action="{{ url('/acknowledgment/adminview') }}" method="get">
            <div class="card-widgets">
                <a data-toggle="collapse" href="#cardCollpase1" class="btn btn-secondary btn-rounded" style="color:whitesmoke" role="button" aria-expanded="false" aria-controls="cardCollpase1">
                    <i class="mdi mdi-minus"></i>
                </a>
                <button class="btn btn-blue">
                    <i class="fe-search"></i> Search
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
                            <label class="col-md-3 col-form-label text-left" for="revision_no">Revision No</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="revision_no" id="revision_no" value="{{ isset($request->revision_no)?$request->revision_no:'' }}" maxlength="50">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 col-xs-12 mb-3">
                            <label class="col-md-3 col-form-label text-left" for="docu_name">Document Name</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="docu_name" id="docu_name" value="{{ isset($request->docu_name)?$request->docu_name:'' }}" maxlength="50">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div> <!-- end card-->
    <div class="card">
        <div class="card-body">
            <div class="responsive-table-plugin">
                <div class="table-rep-plugin">
                    <div class="table-responsive">
                        <table id="dataTable" class="table dt-responsive table-striped nowrap dataTable no-footer">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>User Name</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $index = 0 @endphp
                                @foreach ($notifications as $one)
                                    @if (\App\User::find($one->user_id)['name'] == null)
                                        @continue;
                                    @endif
                                    @php $index ++ @endphp
                                    <tr data-entry-id="{{ $one->id }}">
                                        <td>{{ $index }}</td>
                                        <td>{{ \App\User::find($one->user_id)['name'] }}</td>
                                        @if(intval($one->confirm) == 1)
                                        <td><span class="badge badge-success">read</span></td>
                                        @else
                                        <td><span class="badge badge-danger">unread</span></td>
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
<script src="{{ asset('assets/libs/datatables/dataTables.keyTable.min.js') }}"></script>
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
            $("#range-datepicker").flatpickr({mode:"range"});
            $('#company').val("{{ isset($request->company)?$request->company:'' }}");
            $('#category').val("{{ isset($request->category)?$request->category:'' }}");
            chengeCompany();
        })
    </script>
@endsection
