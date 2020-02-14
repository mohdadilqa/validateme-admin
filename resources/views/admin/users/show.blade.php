@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.user.title') }}
    </div>
    <div class="card-body">
        <div class="mb-2 row">
            <ul class ="col-md-3 list-style-heading">
                <li> {{ trans('cruds.user.fields.name') }}</li>
                <li> {{ trans('cruds.user.fields.email') }}</li>
                <li> {{ trans('cruds.user.fields.roles') }}</li>
            </ul>
            <ul class="col-md-9 list-style">
                <li> {{ $user->name }}</li>
                <li> {{ $user->email }}</li>
                <li> {{ isset($user->roles[0]->title)?$user->roles[0]->title:"" }}</li>
            </ul>
            <div class="float-right col-md-12 mt-3">
                <a class="btn btn-success secondary-button-class" onclick="goBack()">
                        {{ trans('global.back') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection