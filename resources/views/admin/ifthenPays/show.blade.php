@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.ifthenPay.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.ifthen-pays.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.ifthenPay.fields.id') }}
                        </th>
                        <td>
                            {{ $ifthenPay->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ifthenPay.fields.company') }}
                        </th>
                        <td>
                            {{ $ifthenPay->company->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ifthenPay.fields.mb_key') }}
                        </th>
                        <td>
                            {{ $ifthenPay->mb_key }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ifthenPay.fields.mbway_key') }}
                        </th>
                        <td>
                            {{ $ifthenPay->mbway_key }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ifthenPay.fields.mb_antiphishing') }}
                        </th>
                        <td>
                            {{ $ifthenPay->mb_antiphishing }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ifthenPay.fields.mbway_antiphishing') }}
                        </th>
                        <td>
                            {{ $ifthenPay->mbway_antiphishing }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ifthenPay.fields.simple_mbway_number') }}
                        </th>
                        <td>
                            {{ $ifthenPay->simple_mbway_number }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.ifthen-pays.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection