<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyShopProductVariationRequest;
use App\Http\Requests\StoreShopProductVariationRequest;
use App\Http\Requests\UpdateShopProductVariationRequest;
use App\Models\ShopProduct;
use App\Models\ShopProductVariation;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ShopProductVariationsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('shop_product_variation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shopProductVariations = ShopProductVariation::with(['shop_product'])->get();

        return view('admin.shopProductVariations.index', compact('shopProductVariations'));
    }

    public function create()
    {
        abort_if(Gate::denies('shop_product_variation_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shop_products = ShopProduct::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.shopProductVariations.create', compact('shop_products'));
    }

    public function store(StoreShopProductVariationRequest $request)
    {
        $shopProductVariation = ShopProductVariation::create($request->all());

        return redirect()->route('admin.shop-product-variations.index');
    }

    public function edit(ShopProductVariation $shopProductVariation)
    {
        abort_if(Gate::denies('shop_product_variation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shop_products = ShopProduct::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $shopProductVariation->load('shop_product');

        return view('admin.shopProductVariations.edit', compact('shopProductVariation', 'shop_products'));
    }

    public function update(UpdateShopProductVariationRequest $request, ShopProductVariation $shopProductVariation)
    {
        $shopProductVariation->update($request->all());

        return redirect()->route('admin.shop-product-variations.index');
    }

    public function show(ShopProductVariation $shopProductVariation)
    {
        abort_if(Gate::denies('shop_product_variation_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shopProductVariation->load('shop_product');

        return view('admin.shopProductVariations.show', compact('shopProductVariation'));
    }

    public function destroy(ShopProductVariation $shopProductVariation)
    {
        abort_if(Gate::denies('shop_product_variation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shopProductVariation->delete();

        return back();
    }

    public function massDestroy(MassDestroyShopProductVariationRequest $request)
    {
        $shopProductVariations = ShopProductVariation::find(request('ids'));

        foreach ($shopProductVariations as $shopProductVariation) {
            $shopProductVariation->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
