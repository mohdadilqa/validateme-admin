@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.user.title') }}
    </div>

    <div class="card-body">
        <div class="mb-2">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.id') }}
                        </th>
                        <td>
                            {{ $user->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.name') }}
                        </th>
                        <td>
                            {{ $user->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.email') }}
                        </th>
                        <td>
                            {{ $user->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                        {{ trans('cruds.user.fields.roles') }}
                        </th>
                        <td>
                            @foreach($user->roles as $id => $roles)
                                <span class="label label-info label-many">{{ $roles->title }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <!--<tr>
                        <th>
                        {{ trans('cruds.user.fields.organization') }}
                        </th>
                        <td>
                           
                            <span class="label label-info label-many">{{ $user->title }}</span>
                           
                        </td>
                    </tr>-->
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