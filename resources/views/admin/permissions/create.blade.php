@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
    <p class="table-heading">{{ trans('global.create') }} {{ trans('cruds.permission.title_singular') }}</p>
    </div>
    <div class="card-body">
        <form action="{{ route("admin.permissions.store") }}" method="POST" enctype="multipart/form-data" class="row">
            @csrf
            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }} col-md-6">
                <label for="title">{{ trans('cruds.permission.fields.title') }}*</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('title', isset($permission) ? $permission->title : '') }}" required>
                @if($errors->has('title'))
                    <em class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </em>
                @endif
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