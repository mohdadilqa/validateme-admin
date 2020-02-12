@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
    <p class="table-heading"> {{ trans('global.edit') }} {{ trans('cruds.refdatafield.title_singular') }}</p>
    </div>
    <div class="card-body">
        <form action="{{ route("admin.refdatafield.update", [$data['_id']]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                <label for="title">{{ trans('cruds.refdatafield.fields.title') }}*</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('title', isset($data['title']) ? $data['title'] : '') }}" required>
                @if($errors->has('title'))
                    <em class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('code') ? 'has-error' : '' }}">
                <label for="code">{{ trans('cruds.refdatafield.fields.code') }}*</label>
                <input type="text" id="code" name="code" class="form-control" value="{{ old('code', isset($data['code']) ? $data['code'] : '') }}" required>
                @if($errors->has('code'))
                    <em class="invalid-feedback">
                        {{ $errors->first('code') }}
                    </em>
                @endif
            </div>
            <div class="form-group ui-widget">
                <label for="RDT_key">{{ trans('cruds.refdata.fields.RDT_key') }}*</label>
                <input name="RDT_key" id="select_RDT_key" class="form-control" value="{{ old('referenceDataTypeKey', isset($data['referenceDataTypeKey']) ? $data['referenceDataTypeKey'] : '') }}" required>
            </div>
            <div class="form-group {{ $errors->has('field_type') ? 'has-error' : '' }}">
                <label for="field_type">{{ trans('cruds.refdatafield.fields.field_type') }}*</label>
                <select name="field_type" id="field_type" class="select2" required>
                    @foreach($fieldTypes as $key => $fieldType)
                        <option value="{{ $key }}">{{ $fieldType }}</option>
                    @endforeach
                </select>
                @if($errors->has('field_type'))
                    <em class="invalid-feedback">
                        {{ $errors->first('field_type') }}
                    </em>
                @endif
            </div>
            <div class="float-right">
                <a class="btn btn-success secondary-button-class" href="{{ url()->previous() }}">
                    {{ trans('global.cancel') }}
                </a>
                <input class="btn btn-success primary-button-class" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>
@endsection
@push('docTypeScript')
<script src="{{ asset('js/doctype.js')}}"></script>
@endpush