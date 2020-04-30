@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">
                            <i class="fe-box"></i><span> @lang('global.embed.title') </span>
                        </li>
                    </ol>
                </div>
                <h4 class="page-title">@lang('global.embed.title')</h4>
            </div>
        </div>
    </div>
    <div class="card">
        @can('documents_manage')
            <div class="pt-4 pl-4">
                <a href="{{ route('embeds.create') }}" class="btn btn-primary"><i class="icon-plus"></i> @lang('global.embed.add') </a>
            </div>
        @endcan
        <div class="card-body">
            <div class="responsive-table-plugin">
                <div class="table-rep-plugin">
                    <div class="table-responsive">
                        <table id="dataTable" class="table dt-responsive table-striped nowrap dataTable no-footer">
                            <thead>
                                <tr>
                                    <th>@lang('dashboard.memo.field.no')</th>
                                    <th>@lang('global.embed.field.form_name')</th>
                                    <th>@lang('global.embed.field.due_date')</th>
                                    <th>@lang('dashboard.memo.field.action.title')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $index = 0 @endphp
                                @foreach ($ones as $one)
                                    @php $index ++ @endphp
                                    <tr data-entry-id="{{ $one->id }}">
                                        <td>{{ $index }}</td>
                                        <td>{{ $one->form_name }}</td>
                                        @php $date = strtotime($one->due_date); @endphp
                                        @php $newformat = date('d F Y', $date); @endphp
                                        <td><span class="badge badge-danger font-14">{{ $newformat }}</span></td>
                                        <td>
                                            <div class="btn-group mb-2">
                                                <button type="button" class="btn btn-primary btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <i class="mdi mdi-chevron-down"></i></button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{ route('embeds.show', $one->id) }}"><i class="fe-eye mr-2"></i>@lang('dashboard.memo.field.action.view')</a>
                                                    @can('documents_manage')
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
                        url: "{{ url('/embeds/destroy') }}" + "/" + id,
                        type: 'post',
                        dataType: 'text',
                        success: function(data) {
                            window.location="{{ route('embeds.index') }}";
                        }
                    });
                }
            });
        }
    </script>
@endsection
