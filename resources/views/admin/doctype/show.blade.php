@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        <p class="table-heading">{{ trans('global.show') }} {{ trans('cruds.doctype.title') }}</p>
    </div>
    <div class="card-body">
        <div class="mb-2">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.doctype.fields.name') }}
                        </th>
                        <td>
                            {{ isset($data['name'])?$data['name']:'' }}
                        </td>
                    </tr>
                    <tr>
                        <th class="table-th-width">
                            {{ trans('cruds.doctype.fields.ref_data_field') }}
                        </th>
                        <td>
                            {{ isset($data['fields'])?Helper::object_to_string($data['fields'],'title'):'' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                        {{ trans('cruds.doctype.fields.name_rule') }}
                        </th>
                        <td>
                        {{ isset($data['nameRule'])? Helper::object_to_string($data['nameRule'],'title'):'' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                        {{ trans('cruds.doctype.fields.category') }}
                        </th>
                        <td>
                        {{ isset($data['category']['name'])?$data['category']['name']:'' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                        {{ trans('cruds.doctype.fields.created_date') }}
                        </th>
                        <td>
                        {{ isset($data['createdAt'])?date("d-M-Y",strtotime($data['createdAt'])):'' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                        {{ trans('cruds.doctype.fields.updated_date') }}
                        </th>
                        <td>
                        {{ isset($data['updatedAt'])?date("d-M-Y",strtotime($data['updatedAt'])):'' }}
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