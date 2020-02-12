@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        <p class="table-heading">
            {{ trans('cruds.role.title_singular') }} {{ trans('global.list') }}
            @can('role_create')
                <a class="btn btn-success table-heading add-button-align primary-button-class"  href="{{ route("admin.roles.create") }}">
                    <i class="fas fa-plus-circle"></i> <span >{{ trans('global.create') }} {{ trans('cruds.role.title_singular') }}</span>
                </a>
            @endcan
        </p>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Role">
                <thead>
                    <tr>
                        <th width="10">
                        </th>
                        <th>
                            {{ trans('cruds.role.fields.s_no') }}
                        </th>
                        <th>
                            {{ trans('cruds.role.fields.title') }}
                        </th>
                        <th>
                            {{ trans('cruds.role.fields.permissions') }}
                        </th>
                        <th class="action-column">
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $key => $role)
                        <tr data-entry-id="{{ $role->id }}">
                            <td>
                            </td>
                            <td>
                                {{ ++$key ?? '' }}
                            </td>
                            <td>
                                {{ $role->title ?? '' }}
                            </td>
                            <td>
                                @foreach($role->permissions as $key => $item)
                                    <span class="badge badge-info">{{ $item->title }}</span>
                                @endforeach
                            </td>
                            <td class="action-column">
                                @can('role_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.roles.show', $role->id) }}" title="{{ trans('cruds.role.tooltip.view') }}">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                @endcan

                                @can('role_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.roles.edit', $role->id) }}" title="{{ trans('cruds.role.tooltip.update') }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endcan

                                @can('role_delete')
                                    <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type=submit class="btn btn-xs btn-danger" title="{{ trans('cruds.role.tooltip.delete') }}"><i class="far fa-trash-alt"></i></button>
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
@can('role_delete')
  let deleteButtonTrans = '<i class="far fa-trash-alt"></i>'
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
  dtButtons.push(deleteButton)
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
})

</script>
@endsection