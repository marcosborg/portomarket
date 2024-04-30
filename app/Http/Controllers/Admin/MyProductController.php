<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShopProduct;
use App\Models\ShopProductCategory;
use App\Models\ShopProductFeature;
use App\Models\ShopProductSubCategory;
use App\Models\ShopProductVariation;
use App\Models\ShopTax;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MyProductController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('my_product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.myProducts.index');
    }

    public function create()
    {
        abort_if(Gate::denies('my_product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $company = User::where('id', auth()->user()->id)->with('company')->first()->company[0];

        $taxes = ShopTax::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $shop_product_categories = ShopProductCategory::whereHas('company', function ($query) use ($company) {
            $query->where('company_id', $company->id);
        })->get()->pluck('name', 'id');

        $shop_product_sub_categories = ShopProductSubCategory::with('shop_product_category.company')->whereHas('shop_product_category', function ($query) use ($company) {
            $query->whereHas('company', function ($q) use ($company) {
                $q->where('id', $company->id);
            });
        })->get()->pluck('name', 'id');

        return view('admin.myProducts.create', compact('shop_product_categories', 'shop_product_sub_categories', 'taxes'));
    }

    public function edit(Request $request)
    {
        abort_if(Gate::denies('my_product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $company = User::where('id', auth()->user()->id)->with('company')->first()->company[0];

        $shop_product_categories = ShopProductCategory::pluck('name', 'id');

        $shop_product_sub_categories = ShopProductSubCategory::pluck('name', 'id');

        $taxes = ShopTax::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $shopProductFeatures = ShopProductFeature::with('shop_product.shop_product_categories')
            ->whereHas('shop_product', function ($query) use ($company) {
                $query->whereHas('shop_product_categories', function ($q) use ($company) {
                    $q->where('company_id', $company->id);
                });
            })
            ->select('name')
            ->distinct('name')
            ->get();

        $shopProductVariations = ShopProductVariation::with('shop_product.shop_product_categories')
            ->whereHas('shop_product', function ($query) use ($company) {
                $query->whereHas('shop_product_categories', function ($q) use ($company) {
                    $q->where('company_id', $company->id);
                });
            })
            ->select('name')
            ->distinct('name')
            ->get();

        $shopProduct = ShopProduct::where('id', $request->id)
            ->first();

        return view('admin.myProducts.edit', compact('shopProduct', 'shop_product_categories', 'shop_product_sub_categories', 'taxes', 'shopProductFeatures', 'shopProductVariations'));
    }

    public function newShopProductFeature(Request $request)
    {
        $shopProductFeature = new ShopProductFeature;
        $shopProductFeature->shop_product_id = $request->shop_product_id;
        $shopProductFeature->name = $request->name;
        $shopProductFeature->save();
    }

    public function shopProductFeatureList(Request $request)
    {
        $shopProductFeatures = ShopProductFeature::where('shop_product_id', $request->shop_product_id)->orderBy('position')->get();

        return view('admin.myProducts.featureList', compact('shopProductFeatures'));
    }

    public function deleteShopProductFeature(Request $request)
    {
        ShopProductFeature::where('id', $request->shop_product_feature_id)->first()->delete();
    }

    public function newShopProductVariation(Request $request)
    {

        $shopProduct = ShopProduct::find($request->shop_product_id);

        $shopProductVariation = new ShopProductVariation;
        $shopProductVariation->shop_product_id = $request->shop_product_id;
        $shopProductVariation->name = $request->name;
        $shopProductVariation->price = $shopProduct->price;
        $shopProductVariation->save();
    }

    public function shopProductVariationList(Request $request)
    {
        $shopProductVariations = ShopProductVariation::where('shop_product_id', $request->shop_product_id)->orderBy('position')->get();

        return view('admin.myProducts.variationList', compact('shopProductVariations'));
    }

    public function deleteShopProductVariation(Request $request)
    {
        ShopProductVariation::where('id', $request->shop_product_variation_id)->first()->delete();
    }

    public function updateShopProductVariationPrices(Request $request)
    {
        $data = json_decode($request->data);

        foreach ($data as $variation) {
            $shopProductVariation = ShopProductVariation::find($variation->shop_product_variation_id);
            $shopProductVariation->price = $variation->price;
            $shopProductVariation->stock = $variation->stock;
            $shopProductVariation->weight = $variation->weight;
            $shopProductVariation->save();
        }
    }

    public function productList()
    {
        $company = User::where('id', auth()->user()->id)->with('company')->first()->company[0];

        $shopProducts = ShopProduct::whereHas('shop_product_categories', function ($query) use ($company) {
            $query->where('company_id', $company->id);
        })->with(['shop_product_categories', 'tax', 'media'])
            ->orderBy('position')
            ->get();

        return view('admin.myProducts.productList', compact('shopProducts'));
    }

    public function position(Request $request)
    {
        $data = json_decode($request->data);
        $index = 0;

        for ($i = $request->firstPosition; $i < $request->lastPosition; $i++) {
            $shopProduct = ShopProduct::find($data[$index]->product_id);
            $shopProduct->position = $i;
            $shopProduct->save();
            $index++;
        }

        return [];

    }

    public function shopProductFeatureAdd(Request $request)
    {
        $data = [];
        foreach ($request->shop_product_feature_id as $name) {
            $data[] = [
                'name' => $name,
                'shop_product_id' => $request->shop_product_id
            ];
            ShopProductFeature::firstOrCreate([
                'name' => $name,
                'shop_product_id' => $request->shop_product_id
            ]);
        }
        return $data;
    }

    public function shopProductFeaturePositionUpdate(Request $request)
    {
        $data = json_decode($request->data);
        foreach ($data as $key => $id) {
            $shopProductFeature = ShopProductFeature::find($id);
            $shopProductFeature->position = $key;
            $shopProductFeature->save();
        }
    }

    public function shopProductVariationAdd(Request $request)
    {
        $data = [];
        foreach ($request->shop_product_variation_id as $name) {
            $data[] = [
                'name' => $name,
                'shop_product_id' => $request->shop_product_id
            ];
            ShopProductVariation::firstOrCreate([
                'name' => $name,
                'shop_product_id' => $request->shop_product_id
            ]);
        }
        return $data;
    }

    public function shopProductVariationPositionUpdate(Request $request)
    {
        $data = json_decode($request->data);
        foreach ($data as $key => $id) {
            $shopProductVariation = ShopProductVariation::find($id);
            $shopProductVariation->position = $key;
            $shopProductVariation->save();
        }
    }

}