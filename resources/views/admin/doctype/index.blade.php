@extends('layouts.admin')
@section('content')
@can('doctype_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.doctype.create') }}">
                <i class="fas fa-plus-circle"></i>
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.doctype.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Role">
                <thead>
                    <tr>
                        <th width="10">
                        </th>
                        <th>
                            {{ trans('cruds.doctype.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.doctype.fields.ref_data_field') }}
                        </th>
                        <th>
                            {{ trans('cruds.doctype.fields.name_rule') }}
                        </th>
                        <th>
                            {{ trans('cruds.doctype.fields.category') }}
                        </th>
                        <th>
                            {{ trans('cruds.doctype.fields.created_date') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($datas as $key => $data)
                        <tr data-entry-id="{{ $data['_id'] }}">
                            <td>
                            </td>
                            <td>
                                {{ $data['name'] ?? ''}}
                            </td>
                            <td>
                                {{ implode(",",$data['fields']) ?? ''}}
                            </td>
                            <td>
                               {{ implode(",",$data['nameRule']) ?? '' }}
                            </td>
                            <td>
                               {{ $data['category'] ??'' }}
                            </td>
                            <td>
                                {{ date("d-M-Y",strtotime($data['createdAt'])) ??''}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
    let dtButtons=[];
  //let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('refdata_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "",
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
  $('.select-checkbox').css('display','none');
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