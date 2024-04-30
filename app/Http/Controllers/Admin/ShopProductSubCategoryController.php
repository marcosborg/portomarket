<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyShopProductSubCategoryRequest;
use App\Http\Requests\StoreShopProductSubCategoryRequest;
use App\Http\Requests\UpdateShopProductSubCategoryRequest;
use App\Models\ShopProductCategory;
use App\Models\ShopProductSubCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ShopProductSubCategoryController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('shop_product_sub_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shopProductSubCategories = ShopProductSubCategory::with(['shop_product_category'])->get();

        return view('admin.shopProductSubCategories.index', compact('shopProductSubCategories'));
    }

    public function create()
    {
        abort_if(Gate::denies('shop_product_sub_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shop_product_categories = ShopProductCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.shopProductSubCategories.create', compact('shop_product_categories'));
    }

    public function store(StoreShopProductSubCategoryRequest $request)
    {
        $shopProductSubCategory = ShopProductSubCategory::create($request->all());

        return redirect()->route('admin.shop-product-sub-categories.index');
    }

    public function edit(ShopProductSubCategory $shopProductSubCategory)
    {
        abort_if(Gate::denies('shop_product_sub_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shop_product_categories = ShopProductCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $shopProductSubCategory->load('shop_product_category');

        return view('admin.shopProductSubCategories.edit', compact('shopProductSubCategory', 'shop_product_categories'));
    }

    public function update(UpdateShopProductSubCategoryRequest $request, ShopProductSubCategory $shopProductSubCategory)
    {
        $shopProductSubCategory->update($request->all());

        return redirect()->route('admin.shop-product-sub-categories.index');
    }

    public function show(ShopProductSubCategory $shopProductSubCategory)
    {
        abort_if(Gate::denies('shop_product_sub_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shopProductSubCategory->load('shop_product_category', 'shopProductSubCategoriesShopProducts');

        return view('admin.shopProductSubCategories.show', compact('shopProductSubCategory'));
    }

    public function destroy(ShopProductSubCategory $shopProductSubCategory)
    {
        abort_if(Gate::denies('shop_product_sub_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shopProductSubCategory->delete();

        return back();
    }

    public function massDestroy(MassDestroyShopProductSubCategoryRequest $request)
    {
        $shopProductSubCategories = ShopProductSubCategory::find(request('ids'));

        foreach ($shopProductSubCategories as $shopProductSubCategory) {
            $shopProductSubCategory->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
