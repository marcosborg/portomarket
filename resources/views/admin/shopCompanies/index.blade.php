@extends('layouts.admin')
@section('content')
@can('shop_company_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.shop-companies.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.shopCompany.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.shopCompany.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-ShopCompany">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.shopCompany.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopCompany.fields.company') }}
                        </th>
                        <th>
                            {{ trans('cruds.company.fields.vat') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopCompany.fields.shop_location') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopCompany.fields.shop_categories') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopCompany.fields.address') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopCompany.fields.latitude') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopCompany.fields.longitude') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopCompany.fields.whatsapp') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopCompany.fields.youtube') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopCompany.fields.photos') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopCompany.fields.delivery_company') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopCompany.fields.minimum_delivery_value') }}
                        </th>
                        <th>
                            {{ trans('cruds.shopCompany.fields.delivery_free_after') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($shopCompanies as $key => $shopCompany)
                        <tr data-entry-id="{{ $shopCompany->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $shopCompany->id ?? '' }}
                            </td>
                            <td>
                                {{ $shopCompany->company->name ?? '' }}
                            </td>
                            <td>
                                {{ $shopCompany->company->vat ?? '' }}
                            </td>
                            <td>
                                {{ $shopCompany->shop_location->name ?? '' }}
                            </td>
                            <td>
                                @foreach($shopCompany->shop_categories as $key => $item)
                                    <span class="badge badge-info">{{ $item->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                {{ $shopCompany->address ?? '' }}
                            </td>
                            <td>
                                {{ $shopCompany->latitude ?? '' }}
                            </td>
                            <td>
                                {{ $shopCompany->longitude ?? '' }}
                            </td>
                            <td>
                                {{ $shopCompany->whatsapp ?? '' }}
                            </td>
                            <td>
                                {{ $shopCompany->youtube ?? '' }}
                            </td>
                            <td>
                                @foreach($shopCompany->photos as $key => $media)
                                    <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $media->getUrl('thumb') }}">
                                    </a>
                                @endforeach
                            </td>
                            <td>
                                {{ $shopCompany->delivery_company ?? '' }}
                            </td>
                            <td>
                                {{ $shopCompany->minimum_delivery_value ?? '' }}
                            </td>
                            <td>
                                {{ $shopCompany->delivery_free_after ?? '' }}
                            </td>
                            <td>
                                @can('shop_company_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.shop-companies.show', $shopCompany->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('shop_company_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.shop-companies.edit', $shopCompany->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('shop_company_delete')
                                    <form action="{{ route('admin.shop-companies.destroy', $shopCompany->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('shop_company_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.shop-companies.massDestroy') }}",
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
  let table = $('.datatable-ShopCompany:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection