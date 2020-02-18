@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <p class="table-heading">{{ trans('global.show') }} {{ trans('cruds.permission.title') }}</p>
    </div>

    <div class="card-body">
        <div class="mb-2">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.permission.fields.title') }}
                        </th>
                        <td>
                            {{ $permission->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.permission.fields.created_at') }}
                        </th>
                        <td>
                            {{ date("d-M-Y",strtotime($permission->created_at)) }}
                        </td>
                    </tr>
                    <!-- <tr>
                        <th>
                            {{ trans('cruds.permission.fields.updated_at') }}
                        </th>
                        <td>
                            {{ date("d-M-Y",strtotime($permission->updated_at)) }}
                        </td>
                    </tr> -->
                </tbody>
            </table>
            <div class="">
                <a class="btn btn-success secondary-button-class" onclick="goBack()">
                        {{ trans('global.back') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection