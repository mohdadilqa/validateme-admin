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
                        <th class="table-th-width">
                        {{ trans('cruds.refdata.fields.RDT_key') }}
                        </th>
                        <td>
                        {{ isset($data['referenceDataTypeKey'])?$data['referenceDataTypeKey']:'' }}
                        </td>
                    </tr>
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