<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreShopProductVariationRequest;
use App\Http\Requests\UpdateShopProductVariationRequest;
use App\Http\Resources\Admin\ShopProductVariationResource;
use App\Models\ShopProductVariation;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ShopProductVariationsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('shop_product_variation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ShopProductVariationResource(ShopProductVariation::with(['shop_product'])->get());
    }

    public function store(StoreShopProductVariationRequest $request)
    {
        $shopProductVariation = ShopProductVariation::create($request->all());

        return (new ShopProductVariationResource($shopProductVariation))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ShopProductVariation $shopProductVariation)
    {
        //abort_if(Gate::denies('shop_product_variation_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ShopProductVariationResource($shopProductVariation->load(['shop_product']));
    }

    public function update(UpdateShopProductVariationRequest $request, ShopProductVariation $shopProductVariation)
    {
        $shopProductVariation->update($request->all());

        return (new ShopProductVariationResource($shopProductVariation))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ShopProductVariation $shopProductVariation)
    {
        abort_if(Gate::denies('shop_product_variation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shopProductVariation->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
