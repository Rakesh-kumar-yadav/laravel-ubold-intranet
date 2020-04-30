@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <i class="fe-settings"></i><span> @lang('global.setting.title') </span>
                        </li>
                        <li class="breadcrumb-item active">@lang('dashboard.message.title')</li>
                    </ol>
                </div>
                <h4 class="page-title">@lang('dashboard.message.title')</h4>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="pt-4 pl-4">
            <a href="{{ route('admin.messages.create') }}" class="btn btn-success"><i class="icon-plus"></i> @lang('templates.add new') </a>
        </div>
        <div class="card-body">
            <div class="responsive-table-plugin">
                <div class="table-rep-plugin">
                    <div class="table-responsive">
                        <table id="dataTable" class="table dt-responsive table-striped nowrap dataTable no-footer">
                            <thead>
                                <tr>
                                    <th>@lang('dashboard.message.field.no')</th>
                                    <th>Title</th>
                                    <th>@lang('dashboard.message.field.admin_message')</th>
                                    <th>@lang('templates.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $index = 0 @endphp
                                @foreach ($ones as $one)
                                    @php $index ++ @endphp
                                    <tr data-entry-id="{{ $one->id }}">
                                        <td>{{ $index }}</td>
                                        <td>{{ $one->admin_title }}</td>
                                        <td>{{ $one->admin_message }}</td>
                                        <td>
                                            <a href="{{ route('admin.messages.edit', $one->id) }}" class="btn btn-warning btn-xs waves-effect waves-light"><i class="mdi mdi-square-edit-outline"></i> @lang('templates.edit') </a>
                                            <button type="button" class="btn btn-danger btn-xs waves-effect waves-light" onclick="del({{ $one->id }})"><i class="mdi mdi-delete"></i> @lang('templates.delete') </button>
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
                        url: "{{ url('/admin/messages/destroy') }}" + "/" + id,
                        type: 'post',
                        dataType: 'text',
                        success: function(data) {
                            window.location="{{ route('admin.messages.index') }}";
                        }
                    });
                }
            });
        }
    </script>
@endsection