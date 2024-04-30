@extends('layouts.admin')
@section('content')
@can('service_employee_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.service-employees.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.serviceEmployee.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.serviceEmployee.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-ServiceEmployee">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.serviceEmployee.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.serviceEmployee.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.serviceEmployee.fields.shop_company') }}
                        </th>
                        <th>
                            {{ trans('cruds.serviceEmployee.fields.service') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($serviceEmployees as $key => $serviceEmployee)
                        <tr data-entry-id="{{ $serviceEmployee->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $serviceEmployee->id ?? '' }}
                            </td>
                            <td>
                                {{ $serviceEmployee->name ?? '' }}
                            </td>
                            <td>
                                {{ $serviceEmployee->shop_company->contacts ?? '' }}
                            </td>
                            <td>
                                @foreach($serviceEmployee->services as $key => $item)
                                    <span class="badge badge-info">{{ $item->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                @can('service_employee_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.service-employees.show', $serviceEmployee->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('service_employee_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.service-employees.edit', $serviceEmployee->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('service_employee_delete')
                                    <form action="{{ route('admin.service-employees.destroy', $serviceEmployee->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('service_employee_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.service-employees.massDestroy') }}",
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
  let table = $('.datatable-ServiceEmployee:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection