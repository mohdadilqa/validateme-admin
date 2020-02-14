@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
    <p class="table-heading"> {{ trans('global.create') }} {{ trans('cruds.refdata.title_singular') }}</p>
    </div>

    <div class="card-body">
        <form action="{{ route("admin.refdata.store") }}" method="POST" enctype="multipart/form-data" class="row">
            @csrf
            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }} col-md-6">
                <label for="title">{{ trans('cruds.refdata.fields.title') }}*
                </label>
                <input type="text" id="title" name="title" class="form-control" required>
                @if($errors->has('title'))
                    <em class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </em>
                @endif
            </div>
            
            <div class="form-group {{ $errors->has('code') ? 'has-error' : '' }} col-md-6">
                <label for="code">{{ trans('cruds.refdata.fields.code') }}*</label>
                <input type="text" id="code" name="code" class="form-control" required>
                @if($errors->has('code'))
                    <em class="invalid-feedback">
                        {{ $errors->first('code') }}
                    </em>
                @endif
            </div>

            <div class="form-group ui-widget col-md-6">
                <label for="RDT_key">{{ trans('cruds.refdata.fields.RDT_key') }}*</label>
                <input name="RDT_key" id="RDT_key" class="form-control" required>
            </div>
            <div class="float-right col-md-12">
                <input class="btn btn-success primary-button-class" type="submit" value="{{ trans('global.save') }}">
                <a class="btn btn-success secondary-button-class" onclick="goBack()">
                    {{ trans('global.cancel') }}
                </a>
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
