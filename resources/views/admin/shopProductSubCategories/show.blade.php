@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.shopProductSubCategory.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.shop-product-sub-categories.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.shopProductSubCategory.fields.id') }}
                        </th>
                        <td>
                            {{ $shopProductSubCategory->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopProductSubCategory.fields.shop_product_category') }}
                        </th>
                        <td>
                            {{ $shopProductSubCategory->shop_product_category->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shopProductSubCategory.fields.name') }}
                        </th>
                        <td>
                            {{ $shopProductSubCategory->name }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.shop-product-sub-categories.index') }}">
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
            <a class="nav-link" href="#shop_product_sub_categories_shop_products" role="tab" data-toggle="tab">
                {{ trans('cruds.shopProduct.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="shop_product_sub_categories_shop_products">
            @includeIf('admin.shopProductSubCategories.relationships.shopProductSubCategoriesShopProducts', ['shopProducts' => $shopProductSubCategory->shopProductSubCategoriesShopProducts])
        </div>
    </div>
</div>

@endsection