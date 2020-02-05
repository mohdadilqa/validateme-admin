@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        <p class="table-heading"> {{ trans('cruds.company_user.title_singular') }} {{ trans('global.list') }}
            @can('company_user_create')
                <!-- <a class="btn btn-success table-heading add-button-align primary-button-class"  href="{{ route("admin.company-user.create") }}">
                    <i class="fas fa-plus-circle"></i> <span >{{ trans('global.create') }} {{ trans('cruds.company_user.title_singular') }}</span>
                </a> -->
            @endcan
        </p>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                <thead>
                    <tr>
                        <th width="10">
                        </th>
                        <th>
                            {{ trans('cruds.company_user.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.company_user.fields.email') }}
                        </th>
                        <th>
                            {{ trans('cruds.company_user.fields.joining_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.company_user.fields.status') }}
                        </th>
                        <th width="197px">
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($datas as $key => $val)
                        <?php 
                            if($val['role']==="NONVERIFIED_ORG"){
                                $status="Non Verified";
                                $verifiedAction="Verfiy";
                                $disableAction="";
                                $viewActivityAction="";
                            }else{
                                $status="Verified";
                                $verifiedAction="";
                                $disableAction="Disable";
                                $viewActivityAction="View Actvity";
                            }
                        ?>
                        <tr data-entry-id="{{ $val['uid'] }}">
                            <td>
                            </td>
                            <td>
                                {{ $val['name'] ?? '' }}
                                <input type="hidden" id="<?php echo $val['uid'] ?>_name" name="name" value="<?php echo $val['name'];?>">
                                <input type="hidden" id="<?php echo $val['uid'] ?>_organization_name" name="organization_name" value="<?php echo $val['organization_name'];?>">
                            </td>
                            <td>
                                {{ $val['email'] ?? '' }}
                            </td>
                            <td>
                                {{ date('d-M-Y',strtotime($val['createdAt'])) ?? '' }}
                            </td>
                            <td id="<?php echo $val['uid'] ?>_status">
                                {{  $status ?? '' }}
                            </td>
                            <td>
                                @can('company_user_verify')
                                    
                                    <a class="btn btn-xs btn-primary " <?php if(empty($verifiedAction)) echo "style='display:none;'" ?> id="<?php echo $val['uid'] ?>_verifyAction"  onclick="verifyUser('<?php echo $val['uid']?>')" uid="{{ $val['uid'] }}" href="javascript:void(0)">
                                        Verify
                                    </a>
                                    
                                @endcan

                                @can('company_user_disable')
                                    
                                    <a class="btn btn-xs btn-info disable-button" <?php if(empty($disableAction)) echo "style='display:none;'" ?> id="<?php echo $val['uid'] ?>_disableAction" href="javascript:void(0)" disabled>
                                        Disable
                                    </a>
                                    
                                @endcan

                                @can('company_user_view_activity')
                                    
                                    <a class="btn btn-xs btn-info disable-button" <?php if(empty($viewActivityAction)) echo "style='display:none;'" ?> id="<?php echo $val['uid'] ?>_viewActvityAction" href="javascript:void(0)" disabled>
                                        View Activity
                                    </a>
                                    
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
  //let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
  let dtButtons=[];
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
    $('.select-checkbox').css('display','none');
});

//Ajax call to verify user and show disable && viewActivity Action
function verifyUser(uid){
    var x = confirm("Are you sure you want to verify user?");
    if(x){
        let name=$("#"+uid+"_name").val();
        let orgName=$("#"+uid+"_organization_name").val();
        $.ajax({
            headers: {'x-csrf-token': _token},
            url:"<?php echo env('APP_URL') ?>"+"/admin/company-user/verifyUser",
            type:'POST',
            data:{'uid':uid,'name':name,'organization_name':orgName},
            success:function(response){
                let result=($.parseJSON(response));
                console.log(result)
                let status=result.status;
                if(status===1){
                    $("#"+uid+"_status").text("Verfied");
                    $("#"+uid+"_verifyAction").css("display", "none");
                    $("#"+uid+"_disableAction").css("display", "");
                    $("#"+uid+"_viewActvityAction").css("display", "");
                    $(".main .container-fluid").prepend('<div class="row mb-2"><div class="col-lg-12"><div class="alert alert-success" role="alert">'+result.msg+'</div></div></div>');
                }else{
                    $(".main .container-fluid").prepend('<div class="row mb-2"><div class="col-lg-12"><div class="alert alert-danger" role="alert">'+result.msg+'</div></div></div>');
                }
            }
        })

    }else{
        return false;
    }
}
</script>
@endsection