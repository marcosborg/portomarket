@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.purchase.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.purchases.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase.fields.id') }}
                        </th>
                        <td>
                            {{ $purchase->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase.fields.type') }}
                        </th>
                        <td>
                            {{ App\Models\Purchase::TYPE_RADIO[$purchase->type] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase.fields.relationship') }}
                        </th>
                        <td>
                            {{ $purchase->relationship }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase.fields.name') }}
                        </th>
                        <td>
                            {{ $purchase->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase.fields.price') }}
                        </th>
                        <td>
                            {{ $purchase->price }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase.fields.vat') }}
                        </th>
                        <td>
                            {{ $purchase->vat }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase.fields.status') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $purchase->status ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase.fields.user') }}
                        </th>
                        <td>
                            {{ $purchase->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase.fields.total') }}
                        </th>
                        <td>
                            {{ $purchase->total }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase.fields.qty') }}
                        </th>
                        <td>
                            {{ $purchase->qty }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase.fields.cart') }}
                        </th>
                        <td>
                            {{ $purchase->cart }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase.fields.address') }}
                        </th>
                        <td>
                            {{ $purchase->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase.fields.method') }}
                        </th>
                        <td>
                            {{ $purchase->method }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase.fields.payed') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $purchase->payed ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase.fields.internal') }}
                        </th>
                        <td>
                            {{ $purchase->internal }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase.fields.id_payment') }}
                        </th>
                        <td>
                            {{ $purchase->id_payment }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase.fields.delivery') }}
                        </th>
                        <td>
                            {{ $purchase->delivery }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase.fields.delivery_value') }}
                        </th>
                        <td>
                            {{ $purchase->delivery_value }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase.fields.created_at') }}
                        </th>
                        <td>
                            {{ $purchase->created_at }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.purchases.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection