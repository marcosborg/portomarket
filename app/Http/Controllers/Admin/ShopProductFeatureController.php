<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyShopProductFeatureRequest;
use App\Http\Requests\StoreShopProductFeatureRequest;
use App\Http\Requests\UpdateShopProductFeatureRequest;
use App\Models\ShopProduct;
use App\Models\ShopProductFeature;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ShopProductFeatureController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('shop_product_feature_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shopProductFeatures = ShopProductFeature::with(['shop_product'])->get();

        return view('admin.shopProductFeatures.index', compact('shopProductFeatures'));
    }

    public function create()
    {
        abort_if(Gate::denies('shop_product_feature_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shop_products = ShopProduct::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.shopProductFeatures.create', compact('shop_products'));
    }

    public function store(StoreShopProductFeatureRequest $request)
    {
        $shopProductFeature = ShopProductFeature::create($request->all());

        return redirect()->route('admin.shop-product-features.index');
    }

    public function edit(ShopProductFeature $shopProductFeature)
    {
        abort_if(Gate::denies('shop_product_feature_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shop_products = ShopProduct::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $shopProductFeature->load('shop_product');

        return view('admin.shopProductFeatures.edit', compact('shopProductFeature', 'shop_products'));
    }

    public function update(UpdateShopProductFeatureRequest $request, ShopProductFeature $shopProductFeature)
    {
        $shopProductFeature->update($request->all());

        return redirect()->route('admin.shop-product-features.index');
    }

    public function show(ShopProductFeature $shopProductFeature)
    {
        abort_if(Gate::denies('shop_product_feature_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shopProductFeature->load('shop_product');

        return view('admin.shopProductFeatures.show', compact('shopProductFeature'));
    }

    public function destroy(ShopProductFeature $shopProductFeature)
    {
        abort_if(Gate::denies('shop_product_feature_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shopProductFeature->delete();

        return back();
    }

    public function massDestroy(MassDestroyShopProductFeatureRequest $request)
    {
        $shopProductFeatures = ShopProductFeature::find(request('ids'));

        foreach ($shopProductFeatures as $shopProductFeature) {
            $shopProductFeature->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
