@extends('layouts.admin')
@section('content')
@can('user_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <!-- <a class="btn btn-success">
               {{ trans('cruds.log.title_singular') }}
            </a> -->
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.log.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.log.fields.date') }}
                        </th>
                        <th>
                            {{ trans('cruds.log.fields.user') }}
                        </th>
                        <th>
                            {{ trans('cruds.log.fields.company') }}
                        </th>
                        <th>
                            {{ trans('cruds.log.fields.action') }}
                        </th>
                        <th>
                            {{ trans('cruds.log.fields.effeted_user') }}
                        </th>
                        <th>
                            {{ trans('cruds.log.fields.effected_user_company') }}
                        </th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $key => $log)
                        <?php  
                        //echo "<pre/>";print_r($logs);
                        $arr = ['Logged In','Logged Out','Failed Login Attempt','Locked Out','Reset Password'];
                        if(!in_array($log->description, $arr))
                        {$activity_data=json_decode($log->description,true);
                        $action=$activity_data['action'];
                        $target_user=$activity_data['target_user'];
                        $target_company=$activity_data['target_company'];
                        
                        } else {
                            $action=$log->description;
                            $target_user="NA";
                            $target_company="NA";
                        } ?>
                        <tr data-entry-id="{{ ++$key }}">
                            <td>

                            </td>
                            <td>
                            {{ date('d-M-Y h:i:s A',strtotime($log->created_at)) ?? '' }}
                            </td>
                            <td>
                            {{ $log['user']->name ?? 'Guest' }}
                            </td>
                            <td>
                            {{ $log['user']['organization']->organization_name ?? 'Validate Me' }}
                            </td>
                            <td>
                            {{ $action ?? '' }}
                            </td>
                            <td>
                            {{ $target_user ?? '' }}
                            </td>
                            <td>
                            {{ $target_company ?? '' }}
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
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
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
          .done(function () { location.reload() })
      }
    }
  }
  //dtButtons.push(deleteButton)
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
    $('.select-checkbox').css('display','none');
})



</script>
@endsection