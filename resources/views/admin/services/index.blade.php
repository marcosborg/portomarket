@extends('layouts.admin')
@section('content')
@can('service_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.services.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.service.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.service.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Service">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.service.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.service.fields.shop_company') }}
                        </th>
                        <th>
                            {{ trans('cruds.service.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.service.fields.reference') }}
                        </th>
                        <th>
                            {{ trans('cruds.service.fields.description') }}
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
                            {{ trans('cruds.service.fields.youtube') }}
                        </th>
                        <th>
                            {{ trans('cruds.service.fields.attachment_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.service.fields.attachment') }}
                        </th>
                        <th>
                            {{ trans('cruds.service.fields.state') }}
                        </th>
                        <th>
                            {{ trans('cruds.service.fields.position') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($services as $key => $service)
                        <tr data-entry-id="{{ $service->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $service->id ?? '' }}
                            </td>
                            <td>
                                {{ $service->shop_company->contacts ?? '' }}
                            </td>
                            <td>
                                {{ $service->name ?? '' }}
                            </td>
                            <td>
                                {{ $service->reference ?? '' }}
                            </td>
                            <td>
                                {{ $service->description ?? '' }}
                            </td>
                            <td>
                                @foreach($service->photos as $key => $media)
                                    <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $media->getUrl('thumb') }}">
                                    </a>
                                @endforeach
                            </td>
                            <td>
                                {{ $service->service_duration->name ?? '' }}
                            </td>
                            <td>
                                @foreach($service->shop_product_categories as $key => $item)
                                    <span class="badge badge-info">{{ $item->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                @foreach($service->shop_product_sub_categories as $key => $item)
                                    <span class="badge badge-info">{{ $item->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                {{ $service->price ?? '' }}
                            </td>
                            <td>
                                {{ $service->tax->name ?? '' }}
                            </td>
                            <td>
                                {{ $service->youtube ?? '' }}
                            </td>
                            <td>
                                {{ $service->attachment_name ?? '' }}
                            </td>
                            <td>
                                @if($service->attachment)
                                    <a href="{{ $service->attachment->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                @endif
                            </td>
                            <td>
                                <span style="display:none">{{ $service->state ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $service->state ? 'checked' : '' }}>
                            </td>
                            <td>
                                {{ $service->position ?? '' }}
                            </td>
                            <td>
                                @can('service_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.services.show', $service->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('service_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.services.edit', $service->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('service_delete')
                                    <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-Service:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection