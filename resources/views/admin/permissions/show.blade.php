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
                            {{ trans('cruds.permission.fields.id') }}
                        </th>
                        <td>
                            {{ $permission->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.permission.fields.title') }}
                        </th>
                        <td>
                            {{ $permission->title }}
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