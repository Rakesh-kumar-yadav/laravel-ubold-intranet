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
                        <li class="breadcrumb-item active">@lang('dashboard.memo.title')</li>
                    </ol>
                </div>
                <h4 class="page-title">@lang('dashboard.memo.title')</h4>
            </div>
        </div>
    </div>
    <div class="card">
        @can('documents_manage')
            <div class="pt-4 pl-4">
                <a href="{{ route('memos.create') }}" class="btn btn-primary"><i class="icon-plus"></i> @lang('dashboard.memo.add') </a>
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
                                    <th>@lang('dashboard.memo.field.title')</th>
                                    <th>@lang('dashboard.memo.field.action.title')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $index = 0 @endphp
                                @foreach ($memos as $one)
                                    @php $index ++ @endphp
                                    <tr data-entry-id="{{ $one->id }}">
                                        <td>{{ $index }}</td>
                                        <td>{{ $one->title }}</td>
                                        @php $extension = explode('.', $one->file_path) @endphp
                                        <td>
                                            <div class="btn-group mb-2">
                                                @if (isset($extension))
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
                                                @endif
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{ route('memos.show', $one->id) }}"><i class="fe-eye mr-2"></i>@lang('dashboard.memo.field.action.view')</a>
                                                    @can('documents_manage')
                                                        <a class="dropdown-item" href="{{ route('memos.edit', $one->id) }}"><i class="mdi mdi-square-edit-outline mr-2"></i>@lang('dashboard.memo.field.action.edit')</a>
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
                        url: "{{ url('/memos/destroy') }}" + "/" + id,
                        type: 'post',
                        dataType: 'text',
                        success: function(data) {
                            window.location="{{ route('memos.index') }}";
                        }
                    });
                }
            });
        }
    </script>
@endsection
