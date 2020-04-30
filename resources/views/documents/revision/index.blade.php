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
                        <li class="breadcrumb-item active">@lang('document.revision.title')</li>
                    </ol>
                </div>
                <h4 class="page-title">@lang('document.revision.title')</h4>
            </div>
        </div>
    </div>
    <div class="card">
        @can('documents_manage')
        <div class="pt-4 pl-4">
            <a href="{{ route('revision.create', $id) }}" class="btn btn-primary"><i class="icon-plus"></i> @lang('document.revision.add new') </a>
        </div>
        @endcan
        <div class="card-body">
            <div class="responsive-table-plugin">
                <div class="table-rep-plugin">
                    <div class="table-responsive">
                        <table id="dataTable" class="table dt-responsive table-striped nowrap dataTable no-footer">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>@lang('document.revision.revision no')</th>
                                    <th>@lang('document.fields.updated_at')</th>
                                    <th>@lang('document.revision.user_key')</th>
                                    <th>@lang('document.fields.action.title')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $index = 0 @endphp
                                @foreach ($revisions as $one)
                                    @php $index ++ @endphp
                                    <tr data-entry-id="{{ $one->id }}">
                                        <td>{{ $index }}</td>
                                        @php $extension = explode('.', $one->file_name) @endphp
                                        <td>{{ $one->revision_no }}</td>
                                        <td>{{ $one->updated_at }}</td>
                                        <td>{{ $one->user_key }}</td>
                                        @can('documents_manage')
                                        <td>
                                            <div class="btn-group mb-2">

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
                                                    <a class="dropdown-item" href="{{ url('/revision/downfile/'.$one->id) }}"><i class="fe-download mr-2"></i>Download</a>
                                                    <a class="dropdown-item" href="{{ route('revision.edit', $one->id) }}"><i class="mdi mdi-square-edit-outline mr-2"></i>@lang('document.fields.action.edit')</a>
                                                    <a class="dropdown-item" href="javascript:;" onclick="del({{ $one->id }});"><i class="mdi mdi-delete-outline mr-2"></i>@lang('document.fields.action.delete')</a>
                                                </div>
                                            </div>
                                        </td>
                                        @else
                                            @if(sizeof($revisions) == $index)
                                                <td>
                                                    <a class="btn btn-danger btn-sm" href="{{ url('/revision/downfile/'.$one->id) }}"><i class="fe-download mr-2"></i>Download</a>
                                                </td>
                                            @else
                                                <td></td>
                                            @endif
                                        @endcan
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
                        url: "{{ url('/revision/destroy') }}" + "/" + id,
                        type: 'post',
                        dataType: 'text',
                        success: function(data) {
                            window.location="{{ route('revision.index', $id) }}";
                        }
                    });
                }
            });
        }
    </script>
@endsection
