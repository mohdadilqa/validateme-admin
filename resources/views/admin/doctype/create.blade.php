@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        <p class="table-heading">{{ trans('global.create') }} {{ trans('cruds.doctype.title_singular') }}</p>
    </div>

    <div class="card-body">
        <form action="{{ route("admin.doctype.store") }}" id="doctypeAdd" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name">{{ trans('cruds.doctype.fields.name') }}*
                </label>
                <input type="text" id="name" name="name" class="form-control" required>
                @if($errors->has('name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.doctype.fields.name_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('ref_data_field') ? 'has-error' : '' }}">
                <label for="ref_data_field">{{ trans('cruds.doctype.fields.ref_data_field') }}*
                </label>
                <select name="ref_data_field[]" id="ref_data_field" class="form-control select2" required>
                </select>
                @if($errors->has('ref_data_field'))
                    <em class="invalid-feedback">
                        {{ $errors->first('ref_data_field') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.doctype.fields.ref_data_field_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('name_rule') ? 'has-error' : '' }}">
                <label for="name_rule">{{ trans('cruds.doctype.fields.name_rule') }}*</label>
                <label id="name_rule_text" class="name_rule_text"></label>
                <div>
                    <ul id="sortable1" name="sortable1" class="connectedSortable">
                    </ul>
                    <ul id="sortable2" class="connectedSortable" required>
                    </ul>
                    <label id="name_rule_error" class="name_rule_text"></label>
                </div>
            </div>
            <div class="form-group category {{ $errors->has('category') ? 'has-error' : '' }}">
                <label for="category">{{ trans('cruds.doctype.fields.category') }}*</label>
                <select name="category" id="category" class="form-control select2" multiple="multiple" required>
                    @foreach($categories as $id => $category)
                        <option value="{{ $id }}" >{{ $category }}</option>
                    @endforeach
                </select>
                @if($errors->has('category'))
                    <em class="invalid-feedback">
                        {{ $errors->first('category') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.doctype.fields.category_helper') }}
                </p>
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>
@endsection
@push('docTypeScript')
<script src="{{ asset('js/doctype.js')}}"></script>
@endpush
@section('scripts')
@endsection
