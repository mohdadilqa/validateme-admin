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
                            {{ trans('cruds.role.fields.id') }}
                        </th>
                        <td>
                            {{ $role->id }}
                        </td>
                    </tr>
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
                </tbody>
            </table>
            <div class="float-right">
                <a class="btn btn-success secondary-button-class" href="{{ url()->previous() }}">
                        {{ trans('global.back') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection