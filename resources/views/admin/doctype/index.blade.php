@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        <p class="table-heading"> 
            {{ trans('cruds.doctype.title_singular') }} {{ trans('global.list') }}
            @can('doctype_create')
                <a class="btn btn-success table-heading add-button-align primary-button-class"  href="{{ route("admin.doctype.create") }}">
                    <i class="fas fa-plus-circle"></i> <span >{{ trans('global.create') }} {{ trans('cruds.doctype.title_singular') }}</span>
                </a>
            @endcan
        </p>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable datatable-Role">
                <thead>
                    <tr>
                        <th width="10">
                        </th>
                        <th>
                            {{ trans('cruds.user.fields.s_no') }}
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
                        <th>
                        {{ trans('global.actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($datas as $key => $data)
                        <tr data-entry-id="{{ $data['_id'] }}">
                            <td>
                            </td>
                            <td>
                                {{ ++$key ?? '' }}
                            </td>
                            <td>
                                {{ isset($data['name'])?$data['name']:""}}
                            </td>
                            <td>
                                {{ Helper::object_to_string($data['fields'],'title') }}
                            </td>
                            <td>
                                {{ Helper::object_to_string($data['nameRule'],'title') }}
                            </td>
                            <td>
                               {{ isset($data['category']['name'])?$data['category']['name']:""}}
                            </td>
                            <td>
                                {{ isset($data['createdAt'])?date("d-M-Y",strtotime($data['createdAt'])):"" ??''}}
                            </td>
                            <td>
                                @can('refdata_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.doctype.show', $data['_id']) }}" data-toggle="tooltip" title="{{ trans('cruds.doctype.tooltip.view') }}">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                @endcan
                                @can('refdata_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.doctype.edit', $data['_id']) }}" data-toggle="tooltip" title="{{ trans('cruds.doctype.tooltip.update') }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endcan
                                @can('refdata_delete')
                                    <form action="{{ route('admin.doctype.destroy', $data['_id']) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type=submit class="btn btn-xs btn-danger" data-toggle="tooltip" title="{{ trans('cruds.doctype.tooltip.delete') }}"><i class="far fa-trash-alt"></i></button>
                                    </form>
                                @endcan
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
  let deleteButtonTrans = '<i class="far fa-trash-alt"></i>'
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