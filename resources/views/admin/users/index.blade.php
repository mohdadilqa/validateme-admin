@extends('layouts.admin')
@section('content')
@can('user_create')
@endcan
<div class="card">
    <div class="card-header">
    <p class="table-heading"> 
        {{trans('cruds.user.title_singular') }} {{ trans('global.list') }}

        <a class="btn btn-success table-heading add-button-align primary-button-class"  href="{{ route("admin.users.create") }}">
            <i class="fas fa-plus-circle"></i> <span >{{ trans('global.create') }} {{ trans('cruds.user.title_singular') }}</span>
        </a>
    </p>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable datatable-User">
                <thead>
                    <tr>
                        <th width="10">
                        </th>
                        <th>
                            {{ trans('cruds.user.fields.s_no') }}
                        </th>
                        <th>
                            {{ trans('cruds.user.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.user.fields.email') }}
                        </th>
                        <th>
                            {{ trans('cruds.user.fields.roles') }}
                        </th>
                        @if ((Auth::user()->roles->first()->toArray()['title'] ==='support staff'))
                        <th>
                            {{ trans('cruds.user.fields.organization') }}
                        </th>
                        @endif
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $key => $user)
                        <tr data-entry-id="{{ $user->id }}">
                            <td>
                            </td>
                            <td>
                                {{ ++$key ?? '' }}
                            </td>
                            <td>
                                {{ $user->name ?? '' }}
                            </td>
                            <td>
                                {{ $user->email ?? '' }}
                            </td>
                            <td>
                                @foreach($user->roles as $key => $item)
                                    <span class="badge badge-info">{{ $item->title }}</span>
                                @endforeach
                            </td>
                            @if ((Auth::user()->roles->first()->toArray()['title'] ==='support staff'))
                            <td>
                                <span class="badge badge-info">{{ $user->organization['organization_name'] }}</span>
                            </td>
                            @endif
                            <td>
                                @can('user_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.users.show', $user->id) }}">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                @endcan

                                @can('user_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.users.edit', $user->id) }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endcan

                                @can('user_delete')
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type=submit class="btn btn-xs btn-danger"><i class="far fa-trash-alt"></i></button>
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
@can('user_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.users.massDestroy') }}",
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
            $('.container-fluid').html('<div class="row mb-2"><div class="col-lg-12"><div class="alert alert-success" role="alert">User has been deleted successfully.</div></div></div>');
              
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
  $('.datatable-User:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
    
})



</script>
@endsection