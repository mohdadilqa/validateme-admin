@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.refdatafield.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.refdatafield.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('code') ? 'has-error' : '' }}">
                <label for="code">{{ trans('cruds.refdatafield.fields.code') }}*
                </label>
                <input type="text" id="label_code" name="code" class="form-control" required>
                @if($errors->has('code'))
                    <em class="invalid-feedback">
                        {{ $errors->first('code') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.refdatafield.fields.code_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                <label for="title">{{ trans('cruds.refdatafield.fields.title') }}*
                </label>
                <input type="text" id="title" name="title" class="form-control" required>
                @if($errors->has('title'))
                    <em class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.refdatafield.fields.title_helper') }}
                </p>
            </div>

            <div class="form-group ui-widget">
                <label for="RDT_key">Reference Data Type key: </label>
                <input name="RDT_key" id="select_RDT_key" class="form-control" required>
            </div>


            <div class="form-group {{ $errors->has('UXType') ? 'has-error' : '' }}">
                <label for="UXType">{{ trans('cruds.refdatafield.fields.UXType') }}*</label>
                <select name="UXType" id="UXType" class="select2" required>
                    <option value="">Please Select</option>
                    @foreach($uxtypes as $id => $uxtype)
                        <option value="{{ $id }}">{{ $uxtype }}</option>
                    @endforeach
                </select>
                @if($errors->has('UXType'))
                    <em class="invalid-feedback">
                        {{ $errors->first('UXType') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.refdatafield.fields.UXType_helper') }}
                </p>
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>
@endsection
@push('docTypeScript')
<script src="{{ asset('js/doctype.js')}}"></script>
@endpush
@section('scripts')
@endsection
