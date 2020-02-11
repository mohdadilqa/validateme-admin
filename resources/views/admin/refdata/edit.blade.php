@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
    <p class="table-heading"> {{ trans('global.edit') }} {{ trans('cruds.refdata.title_singular') }}</p>
    </div>
    <div class="card-body">
        <form action="{{ route("admin.refdata.update", [$data['_id']]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                <label for="title">{{ trans('cruds.refdata.fields.title') }}*</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('name', isset($data['title']) ? $data['title'] : '') }}" required>
                @if($errors->has('title'))
                    <em class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('code') ? 'has-error' : '' }}">
                <label for="code">{{ trans('cruds.refdata.fields.code') }}*</label>
                <input type="text" id="code" name="code" class="form-control" value="{{ old('email', isset($data['code']) ? $data['code'] : '') }}" required>
                @if($errors->has('code'))
                    <em class="invalid-feedback">
                        {{ $errors->first('code') }}
                    </em>
                @endif
            </div>
            <div class="form-group ui-widget">
                <label for="RDT_key">{{ trans('cruds.refdata.fields.RDT_key') }}*</label>
                <input name="RDT_key" id="RDT_key" class="form-control" value="{{ isset($data['referenceDataTypeKey']) ? $data['referenceDataTypeKey'] : '' }}" required>
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