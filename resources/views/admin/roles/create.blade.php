@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
    <p class="table-heading">{{ trans('global.create') }} {{ trans('cruds.role.title_singular') }}</p>
    </div>

    <div class="card-body">
        <form action="{{ route("admin.roles.store") }}" method="POST" enctype="multipart/form-data" class="row">
            @csrf
            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }} col-md-6">
                <label for="title">{{ trans('cruds.role.fields.title') }}*</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('title', isset($role) ? $role->title : '') }}" required>
                @if($errors->has('title'))
                    <em class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('permissions') ? 'has-error' : '' }} col-md-6">
                <label for="permissions">{{ trans('cruds.role.fields.permissions') }}*
                    <span class="btn btn-info btn-xs select-all">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all">{{ trans('global.deselect_all') }}</span></label>
                <select name="permissions[]" id="permissions" class="form-control select2 permission-dropdown" multiple="multiple" required>
                    @foreach($permissions as $id => $permissions)
                        <option value="{{ $id }}" {{ (in_array($id, old('permissions', [])) || isset($role) && $role->permissions->contains($id)) ? 'selected' : '' }}>{{ $permissions }}</option>
                    @endforeach
                </select>
                @if($errors->has('permissions'))
                    <em class="invalid-feedback">
                        {{ $errors->first('permissions') }}
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