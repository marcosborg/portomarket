@extends('layouts.admin')
@section('content')
@can('shop_product_feature_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.shop-product-features.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.shopProductFeature.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.shopProductFeature.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-ShopProductFeature">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.shopProductFeature.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopProductFeature.fields.shop_product') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopProduct.fields.reference') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopProduct.fields.price') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopProduct.fields.state') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopProductFeature.fields.name') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($shopProductFeatures as $key => $shopProductFeature)
                        <tr data-entry-id="{{ $shopProductFeature->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $shopProductFeature->id ?? '' }}
                            </td>
                            <td>
                                {{ $shopProductFeature->shop_product->name ?? '' }}
                            </td>
                            <td>
                                {{ $shopProductFeature->shop_product->reference ?? '' }}
                            </td>
                            <td>
                                {{ $shopProductFeature->shop_product->price ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $shopProductFeature->shop_product->state ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $shopProductFeature->shop_product->state ? 'checked' : '' }}>
                            </td>
                            <td>
                                {{ $shopProductFeature->name ?? '' }}
                            </td>
                            <td>
                                @can('shop_product_feature_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.shop-product-features.show', $shopProductFeature->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('shop_product_feature_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.shop-product-features.edit', $shopProductFeature->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('shop_product_feature_delete')
                                    <form action="{{ route('admin.shop-product-features.destroy', $shopProductFeature->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('shop_product_feature_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.shop-product-features.massDestroy') }}",
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
  let table = $('.datatable-ShopProductFeature:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection