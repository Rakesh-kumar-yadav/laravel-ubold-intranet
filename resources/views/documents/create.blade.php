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
                        <li class="breadcrumb-item active">
                            <span> @lang('document.add new') </span>
                        </li>
                    </ol>
                </div>
                <h4 class="page-title">@lang('document.add new')</h4>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="pt-4 pl-4">
            <a href="{{ route('document.index') }}"><i class="mdi mdi-arrow-left-drop-circle"></i> @lang('document.back') </a>
        </div>
        <div class="card-body">
            <form action="{{ route('document.store') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-10">

                        <div class="form-group row mb-3">
                            <label class="col-md-3 col-form-label text-right" for="company">@lang('document.fields.company')</label>
                            <div class="col-md-9">
                                <select class="form-control" name="company" id="company" onchange="chengeCompany()">
                                    @foreach($companies as $one)
                                        <option value="{{ $one->id }}">{{ $one->company_name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('company'))
                                    <strong class="text-danger">{{ $errors->first('company') }}</strong>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label class="col-md-3 col-form-label text-right" for="department">@lang('document.fields.department')</label>
                            <div class="col-md-9">
                                <select class="form-control" name="department" id="department">
                                </select>
                                @if ($errors->has('department'))
                                    <strong class="text-danger">{{ $errors->first('department') }}</strong>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label class="col-md-3 col-form-label text-right" for="category">@lang('document.fields.category')</label>
                            <div class="col-md-9">
                                <select class="form-control" name="category" id="category">
                                    @foreach($categories as $one)
                                        <option value="{{ $one->id }}">{{ $one->category_name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('category'))
                                    <strong class="text-danger">{{ $errors->first('category') }}</strong>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label class="col-md-3 col-form-label text-right" for="docu_name">@lang('document.fields.doc name')</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="docu_name" id="docu_name" value="{{ old('docu_name') }}" maxlength="50">
                                @if ($errors->has('docu_name'))
                                    <strong class="text-danger">{{ $errors->first('docu_name') }}</strong>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label class="col-md-3 col-form-label text-right" for="docu_no">@lang('document.fields.doc no')</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="docu_no" id="docu_no" value="{{ old('docu_no') }}" maxlength="50">
                                @if ($errors->has('docu_no'))
                                    <strong class="text-danger">{{ $errors->first('docu_no') }}</strong>
                                @endif
                            </div>
                        </div>

                        <div class="form-group mb-0 justify-content-end row">
                            <div class="col-9">
                                <button type="submit" class="btn btn-block btn-primary waves-effect waves-light">@lang('document.save')</button>
                            </div>
                        </div>                        
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop


@section('javascript')
    <script>
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
        $(document).ready(function () {
           chengeCompany();
        });
    </script>
@endsection
