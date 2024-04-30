@extends('layouts.admin')
@section('content')

<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success" href="{{ route('admin.my-products.create') }}">
            {{ trans('global.add') }} {{ trans('cruds.myProduct.title_singular') }}
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('cruds.myProduct.title') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable datatable-ShopProduct">
                <thead>
                    <tr>
                        <th class="hide">

                        </th>
                        <th>
                            &nbsp;
                        </th>
                        <th>
                            {{ trans('cruds.shopProduct.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopProduct.fields.reference') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopProduct.fields.photos') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopProduct.fields.shop_product_categories') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopProduct.fields.price') }}
                        </th>
                        <th>
                            Transporte
                        </th>
                        <th>
                            {{ trans('cruds.shopTax.fields.tax') }}
                        </th>
                        <th>
                            Stock
                        </th>
                        <th>
                            Peso
                        </th>
                        <th>
                            {{ trans('cruds.shopProduct.fields.state') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody id="sortable" style="cursor: move;">

                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
@section('scripts')
@parent
<script>
    loadDatatable = () => {
    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('shop_product_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.shop-products.massDestroy') }}",
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
    order: [[ 10, 'desc' ]],
    pageLength: 100,
    ordering: false,
  });
  let table = $('.datatable-ShopProduct:not(.ajaxTable)').DataTable({ 
    buttons: dtButtons,
 })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
}
</script>
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js">
</script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
    $(() => {
        productList();
        $("#sortable").sortable({
            stop: () => {
                let products = $('tbody > tr');
                let firstPosition = $(products[0]).data('position');
                let lastPosition = products.length;
                let data = [];
                $.each(products, function(index, value){
                    let product_id = $(value).data('product_id');
                    data.push({
                        product_id: product_id,
                    });
                });
                $.ajax({
                    url: '/admin/my-products/position',
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
    productList = () => {
        $.LoadingOverlay('show');
        $.get('/admin/my-products/product-list').then((resp) => {
            $.LoadingOverlay('hide');
            $('.datatable-ShopProduct > tbody').html(resp);
            loadDatatable();
        });
    }
</script>
@endsection