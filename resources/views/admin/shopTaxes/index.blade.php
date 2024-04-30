@extends('layouts.admin')
@section('content')
@can('shop_tax_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.shop-taxes.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.shopTax.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.shopTax.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-ShopTax">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.shopTax.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopTax.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopTax.fields.tax') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($shopTaxes as $key => $shopTax)
                        <tr data-entry-id="{{ $shopTax->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $shopTax->id ?? '' }}
                            </td>
                            <td>
                                {{ $shopTax->name ?? '' }}
                            </td>
                            <td>
                                {{ $shopTax->tax ?? '' }}
                            </td>
                            <td>
                                @can('shop_tax_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.shop-taxes.show', $shopTax->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('shop_tax_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.shop-taxes.edit', $shopTax->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('shop_tax_delete')
                                    <form action="{{ route('admin.shop-taxes.destroy', $shopTax->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('shop_tax_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.shop-taxes.massDestroy') }}",
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
  let table = $('.datatable-ShopTax:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection