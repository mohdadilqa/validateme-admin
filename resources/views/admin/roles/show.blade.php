@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
    <p class="table-heading">{{ trans('global.show') }} {{ trans('cruds.role.title') }}</p>
    </div>

    <div class="card-body">
        <div class="mb-2">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.role.fields.title') }}
                        </th>
                        <td>
                            {{ $role->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Permissions
                        </th>
                        <td>
                            @foreach($role->permissions as $id => $permissions)
                                <span class="label label-info label-many">{{ $permissions->title }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th class="table-th-width">
                            {{ trans('cruds.role.fields.created_at') }}
                        </th>
                        <td>
                            {{ date("d-M-Y",strtotime($role->created_at)) }}
                        </td>
                    </tr>
                    <!-- <tr>
                        <th>
                            {{ trans('cruds.role.fields.updated_at') }}
                        </th>
                        <td>
                            {{ date("d-M-Y",strtotime($role->updated_at)) }}
                        </td>
                    </tr> -->
                </tbody>
            </table>
            <div class="float-right">
                <a class="btn btn-success secondary-button-class" onclick="goBack()">
                        {{ trans('global.back') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection