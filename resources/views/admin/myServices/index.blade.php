@extends('layouts.admin')
@section('content')

<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success" href="/admin/my-services/create">
            {{ trans('global.add') }} {{ trans('cruds.myService.title_singular') }}
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('cruds.myService.title') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Service">
                <thead>
                    <tr>
                        <th class="hide">

                        </th>
                        <th>
                            
                        </th>
                        <th>
                            {{ trans('cruds.service.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.service.fields.reference') }}
                        </th>
                        <th>
                            {{ trans('cruds.service.fields.photos') }}
                        </th>
                        <th>
                            {{ trans('cruds.service.fields.service_duration') }}
                        </th>
                        <th>
                            {{ trans('cruds.service.fields.shop_product_categories') }}
                        </th>
                        <th>
                            {{ trans('cruds.service.fields.shop_product_sub_categories') }}
                        </th>
                        <th>
                            {{ trans('cruds.service.fields.price') }}
                        </th>
                        <th>
                            {{ trans('cruds.service.fields.tax') }}
                        </th>
                        <th>
                            {{ trans('cruds.service.fields.state') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody id="sortable" style="cursor: move;"></tbody>
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
@can('service_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.services.massDestroy') }}",
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
    orderCellsTop: true,
    order: [[ 5, 'desc' ]],
    pageLength: 100,
    ordering: false,
  });
  let table = $('.datatable-Service:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js">
</script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
    $(() => {
        serviceList();
        $('#sortable').sortable({
            stop: () => {
                let services = $('tbody > tr');
                let firstPosition = $(services[0]).data('position');
                let lastPosition = services.length;
                let data = [];
                $.each(services, function(index, value){
                    let service_id = $(value).data('service_id');
                    data.push({
                        service_id: service_id,
                    });
                });
                $.ajax({
                    url: '/admin/my-services/position',
                    type: 'POST',
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        data: JSON.stringify(data),
                        firstPosition: firstPosition,
                        lastPosition: lastPosition,
                    },
                });
            }
        });
    });
    serviceList = () => {
        $.LoadingOverlay('show');
        $.get('/admin/my-services/service-list').then((resp) => {
            $.LoadingOverlay('hide');
            $('#sortable').html(resp);
            loadDatatable();
        });
    }
</script>
@endsection