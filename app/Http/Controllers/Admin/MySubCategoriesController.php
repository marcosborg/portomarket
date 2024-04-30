<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreShopProductSubCategoryRequest;
use App\Models\ShopProductCategory;
use App\Models\ShopProductSubCategory;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MySubCategoriesController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('my_sub_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $company_id = User::where('id', auth()->user()->id)->with('company')->first()->company[0]->id;

        if ($request->category_id) {
            $category_id = $request->category_id;
        } else {
            $category_id = NULL;
        }

        if ($request->category_id) {
            $category = ShopProductCategory::find($request->category_id);
            abort_if($category->company_id != $company_id, Response::HTTP_FORBIDDEN, '403 Forbidden');
            $shopProductSubCategories = ShopProductSubCategory::where([
                'shop_product_category_id' => $request->category_id,
            ])->with(['shop_product_category'])->get();
        } else {
            $shopProductSubCategories = ShopProductSubCategory::whereHas('shop_product_category', function ($query) use ($company_id) {
                $query->where('company_id', $company_id);
            })->with(['shop_product_category'])->get();
        }

        return view('admin.mySubCategories.index', compact('shopProductSubCategories', 'category_id'));
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('my_sub_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->category_id) {
            $category_id = $request->category_id;
        } else {
            $category_id = NULL;
        }

        $company_id = User::where('id', auth()->user()->id)->with('company')->first()->company[0]->id;

        $shop_product_categories = ShopProductCategory::where('company_id', $company_id)->get();

        return view('admin.mySubCategories.create', compact('shop_product_categories', 'category_id'));
    }

    public function store(StoreShopProductSubCategoryRequest $request)
    {

        $shopProductSubCategory = ShopProductSubCategory::create($request->all());

        return redirect()->route('admin.my-sub-categories.index', [$request->shop_product_category_id]);
    }

    public function edit(Request $request)
    {
        abort_if(Gate::denies('my_sub_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shop_product_categories = ShopProductCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $shopProductSubCategory = ShopProductSubCategory::find($request->id);
        
        $shopProductSubCategory->load('shop_product_category');

        return view('admin.mySubCategories.edit', compact('shopProductSubCategory', 'shop_product_categories'));
    }

    public function update(Request $request)
    {
        abort_if(Gate::denies('my_sub_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shopProductSubCategory = ShopProductSubCategory::find($request->id);
        $shopProductSubCategory->name = $request->name;
        $shopProductSubCategory->shop_product_category_id = $request->shop_product_category_id;
        $shopProductSubCategory->save();

        return redirect()->route('admin.my-sub-categories.index', [$request->shop_product_category_id]);
    }

    public function destroy(Request $request)
    {
        abort_if(Gate::denies('my_sub_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shopProductSubCategory = ShopProductSubCategory::find($request->id);
        $shopProductSubCategory->delete();

        return back();
    }

}