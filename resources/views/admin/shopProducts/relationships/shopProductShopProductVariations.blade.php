<div class="m-3">
    @can('shop_product_variation_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.shop-product-variations.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.shopProductVariation.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.shopProductVariation.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-shopProductShopProductVariations">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.shopProductVariation.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.shopProductVariation.fields.shop_product') }}
                            </th>
                            <th>
                                {{ trans('cruds.shopProduct.fields.reference') }}
                            </th>
                            <th>
                                {{ trans('cruds.shopProductVariation.fields.name') }}
                            </th>
                            <th>
                                {{ trans('cruds.shopProductVariation.fields.price') }}
                            </th>
                            <th>
                                {{ trans('cruds.shopProductVariation.fields.stock') }}
                            </th>
                            <th>
                                {{ trans('cruds.shopProductVariation.fields.weight') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($shopProductVariations as $key => $shopProductVariation)
                            <tr data-entry-id="{{ $shopProductVariation->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $shopProductVariation->id ?? '' }}
                                </td>
                                <td>
                                    {{ $shopProductVariation->shop_product->name ?? '' }}
                                </td>
                                <td>
                                    {{ $shopProductVariation->shop_product->reference ?? '' }}
                                </td>
                                <td>
                                    {{ $shopProductVariation->name ?? '' }}
                                </td>
                                <td>
                                    {{ $shopProductVariation->price ?? '' }}
                                </td>
                                <td>
                                    {{ $shopProductVariation->stock ?? '' }}
                                </td>
                                <td>
                                    {{ $shopProductVariation->weight ?? '' }}
                                </td>
                                <td>
                                    @can('shop_product_variation_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.shop-product-variations.show', $shopProductVariation->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('shop_product_variation_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.shop-product-variations.edit', $shopProductVariation->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('shop_product_variation_delete')
                                        <form action="{{ route('admin.shop-product-variations.destroy', $shopProductVariation->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
</div>
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('shop_product_variation_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.shop-product-variations.massDestroy') }}",
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
  let table = $('.datatable-shopProductShopProductVariations:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection