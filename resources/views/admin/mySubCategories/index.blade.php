@extends('layouts.admin')
@section('content')

<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success"
            href="{{ route('admin.my-sub-categories.create') }}{{ $category_id ? '/' . $category_id : '' }}">
            {{ trans('global.add') }} {{ trans('cruds.mySubCategory.title_singular') }}
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('cruds.mySubCategory.title') }} {{ $shopProductSubCategories->count() > 0 ? ' de ' .
        $shopProductSubCategories[0]->shop_product_category->name : '' }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-ShopProductSubCategory">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.shopProductSubCategory.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopProductSubCategory.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.myCategory.title_singular') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($shopProductSubCategories as $key => $shopProductSubCategory)
                    <tr data-entry-id="{{ $shopProductSubCategory->id }}">
                        <td>

                        </td>
                        <td>
                            {{ $shopProductSubCategory->id ?? '' }}
                        </td>
                        <td>
                            {{ $shopProductSubCategory->name ?? '' }}
                        </td>
                        <td>
                            {{ $shopProductSubCategory->shop_product_category->name ?? '' }}
                        </td>
                        <td>
                            @if(Gate::allows('shop_product_sub_category_edit') || Gate::allows('my_sub_category_access'))
                            <a class="btn btn-xs btn-info"
                                href="{{ route('admin.my-sub-categories.edit', $shopProductSubCategory->id) }}">
                                {{ trans('global.edit') }}
                            </a>
                            @endcan
                            @if (Gate::allows('shop_product_sub_category_delete') || Gate::allows('my_sub_category_access'))
                            <form
                            action="{{ route('admin.my-sub-categories.destroy') }}"
                            method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                            style="display: inline-block;">
                            <input type="hidden" name="id" value="{{ $shopProductSubCategory->id }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                        </form>
                            @endif
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
@can('shop_product_sub_category_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.shop-product-sub-categories.massDestroy') }}",
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
  let table = $('.datatable-ShopProductSubCategory:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection