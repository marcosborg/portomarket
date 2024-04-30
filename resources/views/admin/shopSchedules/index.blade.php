@extends('layouts.admin')
@section('content')
@can('shop_schedule_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.shop-schedules.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.shopSchedule.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.shopSchedule.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-ShopSchedule">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.shopSchedule.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopSchedule.fields.service_employee') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopSchedule.fields.start_time') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopSchedule.fields.end_time') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopSchedule.fields.service') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopSchedule.fields.client') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopSchedule.fields.notes') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($shopSchedules as $key => $shopSchedule)
                        <tr data-entry-id="{{ $shopSchedule->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $shopSchedule->id ?? '' }}
                            </td>
                            <td>
                                {{ $shopSchedule->service_employee->name ?? '' }}
                            </td>
                            <td>
                                {{ $shopSchedule->start_time ?? '' }}
                            </td>
                            <td>
                                {{ $shopSchedule->end_time ?? '' }}
                            </td>
                            <td>
                                {{ $shopSchedule->service->name ?? '' }}
                            </td>
                            <td>
                                {{ $shopSchedule->client->name ?? '' }}
                            </td>
                            <td>
                                {{ $shopSchedule->notes ?? '' }}
                            </td>
                            <td>
                                @can('shop_schedule_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.shop-schedules.show', $shopSchedule->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('shop_schedule_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.shop-schedules.edit', $shopSchedule->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('shop_schedule_delete')
                                    <form action="{{ route('admin.shop-schedules.destroy', $shopSchedule->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
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
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('shop_schedule_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.shop-schedules.massDestroy') }}",
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
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-ShopSchedule:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection