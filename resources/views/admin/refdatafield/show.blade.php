@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        <p class="table-heading">{{ trans('global.show') }} {{ trans('cruds.refdata.title') }}</p>
    </div>
    <div class="card-body">
        <div class="mb-2">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.refdata.fields.title') }}
                        </th>
                        <td>
                            {{ isset($data['title'])?$data['title']:'' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.refdata.fields.code') }}
                        </th>
                        <td>
                            {{ isset($data['code'])?$data['code']:'' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                        {{ trans('cruds.refdata.fields.RDT_key') }}
                        </th>
                        <td>
                        {{ isset($data['referenceDataTypeKey'])?$data['referenceDataTypeKey']:'' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.refdata.fields.filed_type') }}
                        </th>
                        <td>
                            {{ isset($data['filed_type'])?$data['filed_type']:'' }}
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