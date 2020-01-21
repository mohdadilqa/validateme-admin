@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.doctype_field.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.doctype-field.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div id="dynamic_div">
                <div class="form-group">
                    <label for="field_name">{{ trans('cruds.doctype_field.fields.field_name') }}*</label>
                    <input type="text" id="field_name" name="field_name" placeholder="Enter field name" class="custom-form-control" style="margin-left: 21px;" required>
                </div>
                <div class="form-group">
                    <label for="field_type">{{ trans('cruds.doctype_field.fields.field_type') }}*</label>
                    <select name="field_type" id="field_type" class="custom-form-control" style="margin-left: 28px;" required>
                        <option value="">Please select </option>
                        @foreach($field_types as $key => $field)
                            <option value="{{ $key }}">{{ $field }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group" id="div1" div_data='1'>
                    <label for="field_option">{{ trans('cruds.doctype_field.fields.field_option') }}*</label>
                    <input type="text" id="input1" name="field_option[]" placeholder="Enter field option" class="custom-form-control" style="margin-left: 18px;" required>
                    <button type="button" name="add" id="add" class="btn btn-success" style="float: right;margin-right: 60px;">+</button>
                </div>
            </div>
            <div style="text-align: center;">
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>
@endsection
@push('script')
<script type="text/javascript" src="{{ URL::asset('js/doctype.js') }}"></script>
@endpush