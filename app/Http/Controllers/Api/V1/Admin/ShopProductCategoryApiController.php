<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreShopProductCategoryRequest;
use App\Http\Requests\UpdateShopProductCategoryRequest;
use App\Http\Resources\Admin\ShopProductCategoryResource;
use App\Models\ShopProductCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ShopProductCategoryApiController extends Controller
{
    public function index()
    {
        //abort_if(Gate::denies('shop_product_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ShopProductCategoryResource(ShopProductCategory::with(['company'])->get());
    }

    public function categoriesByCompany(Request $request)
    {
        $categories = ShopProductCategory::with([
            'company'
        ])
        ->whereHas('company', function($query) use ($request) {
            $query->where('id', $request->id);
        })
        ->get();

        return $categories;
    }

    public function store(StoreShopProductCategoryRequest $request)
    {
        $shopProductCategory = ShopProductCategory::create($request->all());

        return (new ShopProductCategoryResource($shopProductCategory))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ShopProductCategory $shopProductCategory)
    {
        //abort_if(Gate::denies('shop_product_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ShopProductCategoryResource($shopProductCategory->load(['company']));
    }

    public function update(UpdateShopProductCategoryRequest $request, ShopProductCategory $shopProductCategory)
    {
        $shopProductCategory->update($request->all());

        return (new ShopProductCategoryResource($shopProductCategory))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ShopProductCategory $shopProductCategory)
    {
        abort_if(Gate::denies('shop_product_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shopProductCategory->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}