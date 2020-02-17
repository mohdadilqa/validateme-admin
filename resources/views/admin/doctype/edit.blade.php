@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
    <p class="table-heading"> {{ trans('global.edit') }} {{ trans('cruds.doctype.title_singular') }}</p>
    </div>
    <div class="card-body">
        <form action="{{ route("admin.doctype.update", [$data['_id']]) }}" id="doctypeAdd" method="POST" enctype="multipart/form-data" class="row">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }} col-md-6">
                <label for="name">{{ trans('cruds.doctype.fields.name') }}*</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($data['name']) ? $data['name'] : '') }}" required>
                @if($errors->has('name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('ref_data_field') ? 'has-error' : '' }} col-md-6">
                <label for="ref_data_field">{{ trans('cruds.doctype.fields.ref_data_field') }}*
                </label>
                <select name="ref_data_field[]" id="ref_data_field" class="form-control select2" multiple required>
                    @foreach($data['fields'] as $id => $fields)
                        <option value="{{ $fields['_id'] }}" selected >{{ $fields['title'] }}</option>
                    @endforeach
                </select>
                @if($errors->has('ref_data_field'))
                    <em class="invalid-feedback">
                        {{ $errors->first('ref_data_field') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('name_rule') ? 'has-error' : '' }} col-md-6">
                <label for="name_rule">{{ trans('cruds.doctype.fields.name_rule') }}*</label>
                <label id="name_rule_text" class="name_rule_text">{{ Helper::nameRuleFunction($data['nameRule']) }}</label>
                <div>
                    <ul id="sortable1" name="sortable1" class="connectedSortable" required>
                        @foreach($data['nameRule'] as $id => $nameRule)
                            <li id="{{ $nameRule['_id'] }}" value="{{ $nameRule['_id'] }}" class="ui-state-default">
                            {{ $nameRule['title'] }}<input type="hidden" class="{{ $nameRule['_id'] }}" name="name_rule[]" value="{{ $nameRule['_id'] }}">
                            </li>
                        @endforeach
                    </ul>
                    <ul id="sortable2" class="connectedSortable">
                        @foreach($data['fields'] as $id => $fields)
                            @if(!in_array($fields['_id'], array_column($data['nameRule'], '_id')))
                                <li id="{{ $fields['_id'] }}" value="{{ $fields['_id'] }}" class="ui-state-default">
                                    {{ $fields['title'] }}<input type="hidden" class="{{ $fields['_id'] }}" name="name_rule[]" value="{{ $fields['_id'] }}" disabled>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                    <label id="name_rule_error" class="name_rule_text"></label>
                </div>
            </div>
            <div class="form-group category {{ $errors->has('category') ? 'has-error' : '' }} col-md-6">
                <label for="category">{{ trans('cruds.doctype.fields.category') }}*</label>
                <select name="category" id="category" class="form-control select2" required>
                    @foreach($categories as $id => $category)
                        <option value="{{ $category['_id'] }}" {{ (isset($data['category']['_id']) && $category['_id']==$data['category']['_id']) ? 'selected' : '' }}>{{ $category['label'] }}</option>
                    @endforeach
                </select>
                @if($errors->has('category'))
                    <em class="invalid-feedback">
                        {{ $errors->first('category') }}
                    </em>
                @endif
            </div>
            <div class="float-right col-md-12">
            <input class="btn btn-success primary-button-class" type="submit" value="{{ trans('global.save') }}">
                <a class="btn btn-success secondary-button-class" onclick="goBack()">
                    {{ trans('global.cancel') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
@push('docTypeScript')
<script src="{{ asset('js/doctype.js')}}"></script>
@endpush