@extends('layouts.admin')
@section('content')
@can('subscription_payment_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.subscription-payments.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.subscriptionPayment.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.subscriptionPayment.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-SubscriptionPayment">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.subscriptionPayment.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.user.title_singular') }}
                        </th>
                        <th>
                            {{ trans('cruds.plan.title_singular') }}
                        </th>
                        <th>
                            {{ trans('cruds.subscriptionPayment.fields.value') }}
                        </th>
                        <th>
                            {{ trans('cruds.subscriptionPayment.fields.method') }}
                        </th>
                        <th>
                            {{ trans('cruds.subscriptionPayment.fields.created_at') }}
                        </th>
                        <th>
                            {{ trans('cruds.subscriptionPayment.fields.updated_at') }}
                        </th>
                        <th>
                            {{ trans('cruds.subscriptionPayment.fields.paid') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subscriptionPayments as $key => $subscriptionPayment)
                        <tr data-entry-id="{{ $subscriptionPayment->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $subscriptionPayment->id ?? '' }}
                            </td>
                            <td>
                                {{ $subscriptionPayment->subscription->user->email ?? '' }}
                            </td>
                            <td>
                                {{ $subscriptionPayment->subscription->subscription_type->plan->name ?? '' }} - {{ $subscriptionPayment->subscription->subscription_type->months ?? '' }} meses
                            </td>
                            <td>
                                {{ $subscriptionPayment->value ?? '' }}
                            </td>
                            <td>
                                {{ $subscriptionPayment->method ?? '' }}
                            </td>
                            <td>
                                {{ $subscriptionPayment->created_at ?? '' }}
                            </td>
                            <td>
                                {{ $subscriptionPayment->updated_at ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $subscriptionPayment->paid ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $subscriptionPayment->paid ? 'checked' : '' }}>
                            </td>
                            <td>
                                @can('subscription_payment_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.subscription-payments.show', $subscriptionPayment->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('subscription_payment_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.subscription-payments.edit', $subscriptionPayment->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('subscription_payment_delete')
                                    <form action="{{ route('admin.subscription-payments.destroy', $subscriptionPayment->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('subscription_payment_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.subscription-payments.massDestroy') }}",
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
  let table = $('.datatable-SubscriptionPayment:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection