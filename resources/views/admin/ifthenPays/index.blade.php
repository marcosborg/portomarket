@extends('layouts.admin')
@section('content')
@can('ifthen_pay_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.ifthen-pays.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.ifthenPay.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.ifthenPay.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-IfthenPay">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.ifthenPay.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.ifthenPay.fields.company') }}
                        </th>
                        <th>
                            {{ trans('cruds.ifthenPay.fields.mb_key') }}
                        </th>
                        <th>
                            {{ trans('cruds.ifthenPay.fields.mbway_key') }}
                        </th>
                        <th>
                            {{ trans('cruds.ifthenPay.fields.mb_antiphishing') }}
                        </th>
                        <th>
                            {{ trans('cruds.ifthenPay.fields.mbway_antiphishing') }}
                        </th>
                        <th>
                            {{ trans('cruds.ifthenPay.fields.simple_mbway_number') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ifthenPays as $key => $ifthenPay)
                        <tr data-entry-id="{{ $ifthenPay->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $ifthenPay->id ?? '' }}
                            </td>
                            <td>
                                {{ $ifthenPay->company->name ?? '' }}
                            </td>
                            <td>
                                {{ $ifthenPay->mb_key ?? '' }}
                            </td>
                            <td>
                                {{ $ifthenPay->mbway_key ?? '' }}
                            </td>
                            <td>
                                {{ $ifthenPay->mb_antiphishing ?? '' }}
                            </td>
                            <td>
                                {{ $ifthenPay->mbway_antiphishing ?? '' }}
                            </td>
                            <td>
                                {{ $ifthenPay->simple_mbway_number ?? '' }}
                            </td>
                            <td>
                                @can('ifthen_pay_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.ifthen-pays.show', $ifthenPay->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('ifthen_pay_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.ifthen-pays.edit', $ifthenPay->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('ifthen_pay_delete')
                                    <form action="{{ route('admin.ifthen-pays.destroy', $ifthenPay->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('ifthen_pay_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.ifthen-pays.massDestroy') }}",
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
  let table = $('.datatable-IfthenPay:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection