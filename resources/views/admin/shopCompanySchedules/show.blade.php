@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.shopCompanySchedule.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.shop-company-schedules.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.id') }}
                        </th>
                        <td>
                            {{ $shopCompanySchedule->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.shop_company') }}
                        </th>
                        <td>
                            {{ $shopCompanySchedule->shop_company->contacts ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.monday_morning_opening') }}
                        </th>
                        <td>
                            {{ $shopCompanySchedule->monday_morning_opening }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.monday_morning_closing') }}
                        </th>
                        <td>
                            {{ $shopCompanySchedule->monday_morning_closing }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.moday_afternoon_opening') }}
                        </th>
                        <td>
                            {{ $shopCompanySchedule->moday_afternoon_opening }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.monday_afternoon_closing') }}
                        </th>
                        <td>
                            {{ $shopCompanySchedule->monday_afternoon_closing }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.tuesday_morning_opening') }}
                        </th>
                        <td>
                            {{ $shopCompanySchedule->tuesday_morning_opening }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.tuesday_morning_closing') }}
                        </th>
                        <td>
                            {{ $shopCompanySchedule->tuesday_morning_closing }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.tuesday_afternoon_opening') }}
                        </th>
                        <td>
                            {{ $shopCompanySchedule->tuesday_afternoon_opening }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.tuesday_afternoon_closing') }}
                        </th>
                        <td>
                            {{ $shopCompanySchedule->tuesday_afternoon_closing }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.wednesday_morning_opening') }}
                        </th>
                        <td>
                            {{ $shopCompanySchedule->wednesday_morning_opening }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.wednesday_morning_closing') }}
                        </th>
                        <td>
                            {{ $shopCompanySchedule->wednesday_morning_closing }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.wednesday_afternoon_opening') }}
                        </th>
                        <td>
                            {{ $shopCompanySchedule->wednesday_afternoon_opening }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.wednesday_afternoon_closing') }}
                        </th>
                        <td>
                            {{ $shopCompanySchedule->wednesday_afternoon_closing }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.thursday_morning_opening') }}
                        </th>
                        <td>
                            {{ $shopCompanySchedule->thursday_morning_opening }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.thursday_morning_closing') }}
                        </th>
                        <td>
                            {{ $shopCompanySchedule->thursday_morning_closing }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.thursday_afternoon_opening') }}
                        </th>
                        <td>
                            {{ $shopCompanySchedule->thursday_afternoon_opening }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.thursday_afternoon_closing') }}
                        </th>
                        <td>
                            {{ $shopCompanySchedule->thursday_afternoon_closing }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.friday_morning_opening') }}
                        </th>
                        <td>
                            {{ $shopCompanySchedule->friday_morning_opening }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.friday_morning_closing') }}
                        </th>
                        <td>
                            {{ $shopCompanySchedule->friday_morning_closing }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.friday_afternoon_opening') }}
                        </th>
                        <td>
                            {{ $shopCompanySchedule->friday_afternoon_opening }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.friday_afternoon_closing') }}
                        </th>
                        <td>
                            {{ $shopCompanySchedule->friday_afternoon_closing }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.saturday_morning_opening') }}
                        </th>
                        <td>
                            {{ $shopCompanySchedule->saturday_morning_opening }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.saturday_morning_closing') }}
                        </th>
                        <td>
                            {{ $shopCompanySchedule->saturday_morning_closing }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.saturday_afternoon_opening') }}
                        </th>
                        <td>
                            {{ $shopCompanySchedule->saturday_afternoon_opening }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.saturday_afternoon_closing') }}
                        </th>
                        <td>
                            {{ $shopCompanySchedule->saturday_afternoon_closing }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.sunday_morning_opening') }}
                        </th>
                        <td>
                            {{ $shopCompanySchedule->sunday_morning_opening }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.sunday_morning_closing') }}
                        </th>
                        <td>
                            {{ $shopCompanySchedule->sunday_morning_closing }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.sunday_afternoon_opening') }}
                        </th>
                        <td>
                            {{ $shopCompanySchedule->sunday_afternoon_opening }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopCompanySchedule.fields.sunday_afternoon_closing') }}
                        </th>
                        <td>
                            {{ $shopCompanySchedule->sunday_afternoon_closing }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.shop-company-schedules.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection