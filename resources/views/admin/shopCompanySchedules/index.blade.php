@extends('layouts.admin')
@section('content')
@can('shop_company_schedule_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.shop-company-schedules.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.shopCompanySchedule.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.shopCompanySchedule.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-ShopCompanySchedule">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.shop_company') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.monday_morning_opening') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.monday_morning_closing') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.moday_afternoon_opening') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.monday_afternoon_closing') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.tuesday_morning_opening') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.tuesday_morning_closing') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.tuesday_afternoon_opening') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.tuesday_afternoon_closing') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.wednesday_morning_opening') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.wednesday_morning_closing') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.wednesday_afternoon_opening') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.wednesday_afternoon_closing') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.thursday_morning_opening') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.thursday_morning_closing') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.thursday_afternoon_opening') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.thursday_afternoon_closing') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.friday_morning_opening') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.friday_morning_closing') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.friday_afternoon_opening') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.friday_afternoon_closing') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.saturday_morning_opening') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.saturday_morning_closing') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.saturday_afternoon_opening') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.saturday_afternoon_closing') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.sunday_morning_opening') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.sunday_morning_closing') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.sunday_afternoon_opening') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.sunday_afternoon_closing') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($shopCompanySchedules as $key => $shopCompanySchedule)
                        <tr data-entry-id="{{ $shopCompanySchedule->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $shopCompanySchedule->id ?? '' }}
                            </td>
                            <td>
                                {{ $shopCompanySchedule->shop_company->contacts ?? '' }}
                            </td>
                            <td>
                                {{ $shopCompanySchedule->monday_morning_opening ?? '' }}
                            </td>
                            <td>
                                {{ $shopCompanySchedule->monday_morning_closing ?? '' }}
                            </td>
                            <td>
                                {{ $shopCompanySchedule->moday_afternoon_opening ?? '' }}
                            </td>
                            <td>
                                {{ $shopCompanySchedule->monday_afternoon_closing ?? '' }}
                            </td>
                            <td>
                                {{ $shopCompanySchedule->tuesday_morning_opening ?? '' }}
                            </td>
                            <td>
                                {{ $shopCompanySchedule->tuesday_morning_closing ?? '' }}
                            </td>
                            <td>
                                {{ $shopCompanySchedule->tuesday_afternoon_opening ?? '' }}
                            </td>
                            <td>
                                {{ $shopCompanySchedule->tuesday_afternoon_closing ?? '' }}
                            </td>
                            <td>
                                {{ $shopCompanySchedule->wednesday_morning_opening ?? '' }}
                            </td>
                            <td>
                                {{ $shopCompanySchedule->wednesday_morning_closing ?? '' }}
                            </td>
                            <td>
                                {{ $shopCompanySchedule->wednesday_afternoon_opening ?? '' }}
                            </td>
                            <td>
                                {{ $shopCompanySchedule->wednesday_afternoon_closing ?? '' }}
                            </td>
                            <td>
                                {{ $shopCompanySchedule->thursday_morning_opening ?? '' }}
                            </td>
                            <td>
                                {{ $shopCompanySchedule->thursday_morning_closing ?? '' }}
                            </td>
                            <td>
                                {{ $shopCompanySchedule->thursday_afternoon_opening ?? '' }}
                            </td>
                            <td>
                                {{ $shopCompanySchedule->thursday_afternoon_closing ?? '' }}
                            </td>
                            <td>
                                {{ $shopCompanySchedule->friday_morning_opening ?? '' }}
                            </td>
                            <td>
                                {{ $shopCompanySchedule->friday_morning_closing ?? '' }}
                            </td>
                            <td>
                                {{ $shopCompanySchedule->friday_afternoon_opening ?? '' }}
                            </td>
                            <td>
                                {{ $shopCompanySchedule->friday_afternoon_closing ?? '' }}
                            </td>
                            <td>
                                {{ $shopCompanySchedule->saturday_morning_opening ?? '' }}
                            </td>
                            <td>
                                {{ $shopCompanySchedule->saturday_morning_closing ?? '' }}
                            </td>
                            <td>
                                {{ $shopCompanySchedule->saturday_afternoon_opening ?? '' }}
                            </td>
                            <td>
                                {{ $shopCompanySchedule->saturday_afternoon_closing ?? '' }}
                            </td>
                            <td>
                                {{ $shopCompanySchedule->sunday_morning_opening ?? '' }}
                            </td>
                            <td>
                                {{ $shopCompanySchedule->sunday_morning_closing ?? '' }}
                            </td>
                            <td>
                                {{ $shopCompanySchedule->sunday_afternoon_opening ?? '' }}
                            </td>
                            <td>
                                {{ $shopCompanySchedule->sunday_afternoon_closing ?? '' }}
                            </td>
                            <td>
                                @can('shop_company_schedule_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.shop-company-schedules.show', $shopCompanySchedule->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('shop_company_schedule_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.shop-company-schedules.edit', $shopCompanySchedule->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('shop_company_schedule_delete')
                                    <form action="{{ route('admin.shop-company-schedules.destroy', $shopCompanySchedule->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('shop_company_schedule_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.shop-company-schedules.massDestroy') }}",
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
  let table = $('.datatable-ShopCompanySchedule:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection