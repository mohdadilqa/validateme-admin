@extends('layouts.admin')
@section('content')
@include('modals.modal')
<div class="card">
    <div class="card-header">
        <span class="table-heading"> 
            {{ trans('cruds.refdatafield.title_singular') }} {{ trans('global.list') }}
        </span>
        <span class="table-heading add-button-align"> 
            @can('refdatafield_create')
                <a class="btn btn-success table-heading primary-button-class"  href="{{ route("admin.refdatafield.create") }}">
                    <i class="fas fa-plus-circle"></i> <span >{{ trans('global.create') }} {{ trans('cruds.refdatafield.title_singular') }}</span>
                </a>
            @endcan
            <button type="button" class="btn btn-success primary-button-class filedDataUpload"><i class="fa fa-upload" aria-hidden="true"></i> {{ trans('cruds.refdatafield.fields.upload') }}</button>
            <button type="button" class="btn btn-success primary-button-class"><i class="fas fa-download"></i> {{ trans('cruds.refdatafield.fields.download') }}</button>
        </span>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Role">
                <thead>
                    <tr>
                        <th width="10">
                        </th>
                        <th>
                            {{ trans('cruds.refdatafield.fields.code') }}
                        </th>
                        <th>
                            {{ trans('cruds.refdatafield.fields.title') }}
                        </th>
                        <th>
                            {{ trans('cruds.refdatafield.fields.RDT_key') }}
                        </th>
                        <th>
                            {{ trans('cruds.refdatafield.fields.UXType') }}
                        </th>
                        <th>
                            {{ trans('cruds.refdatafield.fields.created_date') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($datas as $key => $data)
                        <tr data-entry-id="{{ $data['_id'] }}">
                        <td>
                            </td>
                            <td>
                                {{ $data['code'] ?? '' }}
                            </td>
                            <td>
                                {{ $data['title'] }}
                            </td>
                            <td>
                                {{ $data['referenceDataTypeKey'] }}
                            </td>
                            <td>
                                {{ $data['type'] }}
                            </td>
                            <td>
                                {{ date("d-M-Y",strtotime($data['createdAt'])) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@push('modeljs')
<script src="{{ asset('js/modal_popup.js')}}"></script>
@endpush
@push('docTypeScript')
<script src="{{ asset('js/doctype.js')}}"></script>
@endpush
@section('scripts')
@parent
<script>
    $(function () {
  //let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
  let dtButtons=[];
@can('refdatafield_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.roles.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { 
                $('.container-fluid').html('<div class="row mb-2"><div class="col-lg-12"><div class="alert alert-success" role="alert">Role has been deleted successfully.</div></div></div>');  
                location.reload() 
            })
      }
    }
  }
  //dtButtons.push(deleteButton)
  
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 1, 'asc' ]],
    pageLength: 10,
  });
  $('.datatable-Role:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
    $('.select-checkbox').css('display','none');
})

</script>
@endsection