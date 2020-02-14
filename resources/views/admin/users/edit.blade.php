@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
    <p class="table-heading"> {{ trans('global.edit') }} {{ trans('cruds.user.title_singular') }}</p>
    </div>
    <div class="card-body">
        <form action="{{ route("admin.users.update", [$user->id]) }}" method="POST" enctype="multipart/form-data" class="row">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('roles') ? 'has-error' : '' }}  col-md-6">
                <label for="roles">{{ trans('cruds.user.fields.roles') }}*</label>
                <select name="roles" id="roles" class="form-control select2" required>
                    @foreach($roles as $id => $roles)
                        <option value="{{ $id }}" {{ (in_array($id, old('roles', [])) || isset($user) && $user->roles->contains($id)) ? 'selected' : '' }}>{{ $roles }}</option>
                    @endforeach
                </select>
                @if($errors->has('roles'))
                    <em class="invalid-feedback">
                        {{ $errors->first('roles') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}  col-md-6">
                <label for="name">{{ trans('cruds.user.fields.name') }}*</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($user) ? $user->name : '') }}" required>
                @if($errors->has('name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}  col-md-6">
                <label for="email">{{ trans('cruds.user.fields.email') }}*</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email', isset($user) ? $user->email : '') }}" required>
                @if($errors->has('email'))
                    <em class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </em>
                @endif
            </div>
            
            <div class="password form-group {{ $errors->has('password') ? 'has-error' : '' }}  col-md-6">
                <label for="password">{{ trans('cruds.user.fields.password') }}</label>
                <input type="password" id="password" name="password" class="form-control">
                @if($errors->has('password'))
                    <em class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </em>
                @endif
            </div>
            
            <div class="float-right  col-md-12">
                <input class="btn btn-success primary-button-class" type="submit" value="{{ trans('global.save') }}">
                <a class="btn btn-success secondary-button-class" onclick="goBack()">
                    {{ trans('global.cancel') }}
                </a>
                
            </div>
        </form>
    </div>
</div>
@endsection
@push('manageuserjs')
<script src="{{ asset('js/manage_user.js')}}"></script>
@endpush