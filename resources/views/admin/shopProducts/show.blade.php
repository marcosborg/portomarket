@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.shopProduct.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.shop-products.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.shopProduct.fields.id') }}
                        </th>
                        <td>
                            {{ $shopProduct->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopProduct.fields.name') }}
                        </th>
                        <td>
                            {{ $shopProduct->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopProduct.fields.reference') }}
                        </th>
                        <td>
                            {{ $shopProduct->reference }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopProduct.fields.description') }}
                        </th>
                        <td>
                            {!! $shopProduct->description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopProduct.fields.photos') }}
                        </th>
                        <td>
                            @foreach($shopProduct->photos as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopProduct.fields.shop_product_categories') }}
                        </th>
                        <td>
                            @foreach($shopProduct->shop_product_categories as $key => $shop_product_categories)
                                <span class="label label-info">{{ $shop_product_categories->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopProduct.fields.shop_product_sub_categories') }}
                        </th>
                        <td>
                            @foreach($shopProduct->shop_product_sub_categories as $key => $shop_product_sub_categories)
                                <span class="label label-info">{{ $shop_product_sub_categories->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopProduct.fields.price') }}
                        </th>
                        <td>
                            {{ $shopProduct->price }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopProduct.fields.sales_price') }}
                        </th>
                        <td>
                            {{ $shopProduct->sales_price }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopProduct.fields.sales_label') }}
                        </th>
                        <td>
                            {{ $shopProduct->sales_label }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopProduct.fields.tax') }}
                        </th>
                        <td>
                            {{ $shopProduct->tax->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopProduct.fields.youtube') }}
                        </th>
                        <td>
                            {{ $shopProduct->youtube }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopProduct.fields.state') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $shopProduct->state ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopProduct.fields.attachment_name') }}
                        </th>
                        <td>
                            {{ $shopProduct->attachment_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopProduct.fields.attachment') }}
                        </th>
                        <td>
                            @if($shopProduct->attachment)
                                <a href="{{ $shopProduct->attachment->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopProduct.fields.position') }}
                        </th>
                        <td>
                            {{ $shopProduct->position }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopProduct.fields.stock') }}
                        </th>
                        <td>
                            {{ $shopProduct->stock }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopProduct.fields.shipping_cost') }}
                        </th>
                        <td>
                            {{ $shopProduct->shipping_cost }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopProduct.fields.weight') }}
                        </th>
                        <td>
                            {{ $shopProduct->weight }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.shop-products.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#shop_product_shop_product_variations" role="tab" data-toggle="tab">
                {{ trans('cruds.shopProductVariation.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="shop_product_shop_product_variations">
            @includeIf('admin.shopProducts.relationships.shopProductShopProductVariations', ['shopProductVariations' => $shopProduct->shopProductShopProductVariations])
        </div>
    </div>
</div>

@endsection