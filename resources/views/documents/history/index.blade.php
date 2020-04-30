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
                        <li class="breadcrumb-item active">@lang('document.download.title')</li>
                    </ol>
                </div>
                <h4 class="page-title">@lang('document.download.title')</h4>
            </div>
        </div>
    </div>
        <form id="history" action="{{ route('download.index') }}" method="get">
            {{ csrf_field() }}
            <div class="row pb-3">
                <div class="col-md-3 col-xs-12">
                    @if(isset($request->daterange))
                        <input type="text" id="range-datepicker" class="form-control text-center"
                               value="{{ $request->daterange }}" style="width: 250px; font-size: 15px;" id="daterange" name="daterange" />
                    @else
                        <input type="text" id="range-datepicker" class="form-control text-center"
                               value="{{ date('Y-m-01')." to ". date('Y-m-d') }}" style="width: 250px; font-size: 15px;" id="daterange" name="daterange" />
                    @endif
                </div>
                <div class="col-md-9 col-xs-12 text-right">
                    <button type="submit" class="btn btn-blue">
                        <i class="fe-search"></i> @lang('document.search')
                    </button>
                </div>
            </div>
        </form>
    <div class="card">
        <div class="card-body">
            <div class="responsive-table-plugin">
                <div class="table-rep-plugin">
                    <div class="table-responsive">
                        <table id="dataTable" class="table dt-responsive table-striped nowrap dataTable no-footer">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>@lang('document.download.name')</th>
                                    <th>Company</th>
                                    <th>Department</th>
                                    <th>Category</th>
                                    <th>Document Name</th>
                                    <th>Revision No</th>
                                    <th>@lang('document.download.filename')</th>
                                    <th>@lang('document.download.down_time')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $index = 0 @endphp
                                @foreach ($datas as $one)
                                    @php $index ++ @endphp
                                    <tr data-entry-id="{{ $one->id }}">
                                        <td>{{ $index }}</td>
                                        <td>{{ $one->user_name }}</td>
                                        <td>{{ $one->company_name }}</td>
                                        <td>{{ $one->depart_name }}</td>
                                        <td>{{ $one->category_name }}</td>
                                        <td>{{ $one->docu_name }}</td>
                                        <td>{{ $one->revision_no }}</td>
                                        <td>{{ $one->file_name }}</td>
                                        <td>{{ $one->created_at }}</td>
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
        $(document).ready(function () {
            $("#range-datepicker").flatpickr({mode:"range"});
        })
    </script>
@endsection
