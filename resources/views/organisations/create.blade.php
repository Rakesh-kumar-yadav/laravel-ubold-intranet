@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <i class="fe-bar-chart"></i><span> @lang('global.organisation.title') </span>
                        </li>
                        <li class="breadcrumb-item active">@lang('global.organisation.add')</li>
                    </ol>
                </div>
                <h4 class="page-title">@lang('global.organisation.add')</h4>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="pt-4 pl-4">
            <a href="{{ route('organisations.index') }}"><i class="mdi mdi-arrow-left-drop-circle"></i> @lang('global.organisation.back') </a>
        </div>
        <div class="card-body">
            <form action="{{ route('organisations.store') }}" method="post" enctype="multipart/form-data">
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
                            <label class="col-md-3 col-form-label text-right" for="department">@lang('global.organisation.field.department')</label>
                            <div class="col-md-9">
                                <select class="form-control" name="department" id="department">
                                </select>
                                @if ($errors->has('department'))
                                    <strong class="text-danger">{{ $errors->first('department') }}</strong>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label class="col-md-3 col-form-label text-right" for="title">Revision No</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="title" value="{{ old('title') }}" maxlength="50">
                                @if ($errors->has('title'))
                                    <strong class="text-danger">{{ $errors->first('title') }}</strong>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label class="col-md-3 col-form-label text-right" for="organisation_chart">@lang('global.organisation.field.organisation_chart')</label>
                            <div class="col-md-9">
                                <input type="file" class="custom-file-input" id="organisation_chart" name="organisation_chart" accept='.jpg, .pdf'>
                                <label class="custom-file-label" for="organisation_chart">@lang('dashboard.memo.choose_file')</label>
                                @if ($errors->has('organisation_chart'))
                                    <strong class="text-danger">{{ $errors->first('organisation_chart') }}</strong>
                                @endif
                            </div>
                        </div>
                        <div class="form-group mb-0 justify-content-end row">
                            <div class="col-9">
                                <button type="submit" class="btn btn-block btn-primary waves-effect waves-light">@lang('global.organisation.save')</button>
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
        $(document).ready(function(){
            chengeCompany();
            
            $("#organisation_chart").on("change", function() {
                var file = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(file);
            });
        });

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
    </script>
@endsection
