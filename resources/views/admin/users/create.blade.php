@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.user.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.users.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if ((Auth::user()->roles->first()->toArray()['title'] ==='support staff'))
                <div class="form-group {{ $errors->has('organization') ? 'has-error' : '' }}">
                    <label for="organization">{{ trans('cruds.user.fields.organization') }}*
                    </label>
                    <select name="organization" id="organization" class="form-control select2" required>
                    </select>
                    <input type="hidden" id="organization_name" name="organization_name" class="form-control" val="">
                    @if($errors->has('organization'))
                        <em class="invalid-feedback">
                            {{ $errors->first('organization') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.user.fields.organization_helper') }}
                    </p>
                </div>

                <div class="form-group {{ $errors->has('organization_domain') ? 'has-error' : '' }}">
                    <label for="organization_domain">{{ trans('cruds.user.fields.organization_domain') }}*</label>
                    <input type="text" id="organization_domain" name="organization_domain" class="form-control" required readonly>
                    <input type="hidden" id="organization_email" name="organization_email" class="form-control" val="">
                    @if($errors->has('organization_domain'))
                        <em class="invalid-feedback">
                            {{ $errors->first('organization_domain') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.user.fields.organization_domain_helper') }}
                    </p>
                </div>
            @endif

            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name">{{ trans('cruds.user.fields.name') }}*</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($user) ? $user->name : '') }}" required>
                @if($errors->has('name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.name_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                <label for="email">{{ trans('cruds.user.fields.email') }}*</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email', isset($user) ? $user->email : '') }}" required>
                @if($errors->has('email'))
                    <em class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.email_helper') }}
                </p>
            </div>
            @if ((Auth::user()->roles->first()->toArray()['title'] !=='support staff'))
                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    <label for="password">{{ trans('cruds.user.fields.password') }}</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                    @if($errors->has('password'))
                        <em class="invalid-feedback">
                            {{ $errors->first('password') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.user.fields.password_helper') }}
                    </p>
                </div>
            @endif
            @if ((Auth::user()->roles->first()->toArray()['title'] ==='support staff'))
                <input type="password" style="display:none;" id="password" name="password" class="form-control" value="12345678" required>
            @endif
            <div class="form-group {{ $errors->has('roles') ? 'has-error' : '' }}">
                <label for="roles">{{ trans('cruds.user.fields.roles') }}*
                    <span class="btn btn-info btn-xs select-all">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all">{{ trans('global.deselect_all') }}</span>
                </label>
                <select name="roles[]" id="roles" class="form-control select2" multiple="multiple" required>
                    @foreach($roles as $id => $roles)
                        <option value="{{ $id }}" {{ (in_array($id, old('roles', [])) || isset($user) && $user->roles->contains($id)) ? 'selected' : '' }}>{{ $roles }}</option>
                    @endforeach
                </select>
                @if($errors->has('roles'))
                    <em class="invalid-feedback">
                        {{ $errors->first('roles') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.roles_helper') }}
                </p>
            </div>
            
            
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script>

$(document).ready(function(){
    //Ajax Code for autofill companies
    $("#organization").select2({
        ajax: { 
            headers: {'x-csrf-token': _token},
            url: "<?php echo url('/') ?>"+"/admin/users/allOrganization",
            type: "POST",
            dataType: 'json',
            data: function (params) {
                return {
                    q: params.term, // search term
                };
            },
            processResults: function (response) {
                return {
                    results: $.map(response, function (obj) {
                        return {
                            id: obj.domain,
                            text: obj.name,
                        };
                    })
                };
            },
            placeholder: "Please Select"  
        }
    });

    $("#organization").on("select2:select", function (e) { 
        var data = $('#organization').select2('data');
        let organization_name=data[0].text;
        let organization_domain= $('#organization :selected').val();
        let organization_email=organization_domain + '@validateme.online';
        $('#organization_name').val(organization_name);
        $('#organization_domain').val(organization_domain);
        $('#organization_email').val(organization_email);
    });
});
</script>
@endsection