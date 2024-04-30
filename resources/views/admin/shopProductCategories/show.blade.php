@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.shopProductCategory.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.shop-product-categories.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.shopProductCategory.fields.id') }}
                        </th>
                        <td>
                            {{ $shopProductCategory->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopProductCategory.fields.company') }}
                        </th>
                        <td>
                            {{ $shopProductCategory->company->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopProductCategory.fields.name') }}
                        </th>
                        <td>
                            {{ $shopProductCategory->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopProductCategory.fields.image') }}
                        </th>
                        <td>
                            @if($shopProductCategory->image)
                                <a href="{{ $shopProductCategory->image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $shopProductCategory->image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.shop-product-categories.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection