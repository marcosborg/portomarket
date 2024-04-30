<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreShopProductSubCategoryRequest;
use App\Http\Requests\UpdateShopProductSubCategoryRequest;
use App\Http\Resources\Admin\ShopProductSubCategoryResource;
use App\Models\ShopProductSubCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ShopProductSubCategoryApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('shop_product_sub_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ShopProductSubCategoryResource(ShopProductSubCategory::with(['shop_product_category'])->get());
    }

    public function store(StoreShopProductSubCategoryRequest $request)
    {
        $shopProductSubCategory = ShopProductSubCategory::create($request->all());

        return (new ShopProductSubCategoryResource($shopProductSubCategory))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ShopProductSubCategory $shopProductSubCategory)
    {
        abort_if(Gate::denies('shop_product_sub_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ShopProductSubCategoryResource($shopProductSubCategory->load(['shop_product_category']));
    }

    public function update(UpdateShopProductSubCategoryRequest $request, ShopProductSubCategory $shopProductSubCategory)
    {
        $shopProductSubCategory->update($request->all());

        return (new ShopProductSubCategoryResource($shopProductSubCategory))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ShopProductSubCategory $shopProductSubCategory)
    {
        abort_if(Gate::denies('shop_product_sub_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shopProductSubCategory->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function shopProductSubCategoryByCategoryId(Request $request)
    {
        $shopProductSubCategory = ShopProductSubCategory::where('shop_product_category_id', $request->id)->get();
        return $shopProductSubCategory;
    }
}
