@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.planItem.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.plan-items.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.planItem.fields.id') }}
                        </th>
                        <td>
                            {{ $planItem->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.planItem.fields.text') }}
                        </th>
                        <td>
                            {{ $planItem->text }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.planItem.fields.plan') }}
                        </th>
                        <td>
                            {{ $planItem->plan->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.planItem.fields.type') }}
                        </th>
                        <td>
                            {{ App\Models\PlanItem::TYPE_RADIO[$planItem->type] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.plan-items.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection