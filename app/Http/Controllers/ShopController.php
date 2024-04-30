<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Country;
use App\Models\DeliveryRange;
use App\Models\Page;
use App\Models\Service;
use App\Models\ShopCategory;
use App\Models\ShopProduct;
use App\Models\ShopProductCategory;
use App\Models\ShopProductSubCategory;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ShopController extends Controller
{

    public function __construct()
    {
        view()->share('pages', Page::all());
        view()->share('shop_categories', ShopCategory::all());
    }

    public function index()
    {

        $shop_categories_slide = ShopCategory::inRandomOrder()->get()->chunk(4);
        $shop_products = ShopProduct::where('state', true)->inRandomOrder()->limit(21)->get()->chunk(3);
        $companies = Company::inRandomOrder()->limit(20)->get()->chunk(4);

        return view('website.shop.index', compact('shop_categories_slide', 'shop_products', 'companies'));
    }

    public function product(Request $request)
    {
        $product = ShopProduct::where('id', $request->id)
            ->with([
                'shop_product_features',
                'shop_product_variations',
                'shop_product_categories.company.shop_company'
            ])
            ->first();

        abort_if(!$product->state, Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('website.shop.product', compact('product'));
    }

    public function service(Request $request)
    {
        $service = Service::find($request->id)->load('shop_product_categories.company.shop_company.shop_company_schedules', 'service_duration', 'service_employees');

        return view('website.shop.service', compact('service'));
    }

    public function checkout()
    {
        $countries = Country::all();
        $user = auth()->user();
        $address = null;

        if ($user) {
            $address = $user->address;
        }

        return view('website.shop.checkout', compact('countries', 'user', 'address'));
    }

    public function innerCheckout()
    {

        $products = collect(session()->get('cart'));

        $user = auth()->user();

        $address = null;

        if ($user) {
            $address = $user->address;
        }

        $total_array = [];
        $weight_array = [];

        foreach ($products as $product) {
            $company_id = $product['company_id'];
            $price = !$product['product']['sales_price'] ? $product['price'] : $product['product']['sales_price'];
            $total_array[] = $product['quantity'] * $price;
            $weight_array[] = $product['weight'] * $product['quantity'];
        }

        //GET SHIPPING

        if (session()->has('delivery')) {
            $delivery = session()->get('delivery');
        } else {
            $delivery = 0;
            session()->put('delivery', $delivery);
        }

        $total_weight = array_sum($weight_array);

        $company = Company::find($company_id)->load('shop_company');

        $delivery_range = DeliveryRange::where('shop_company_id', $company->shop_company->id)
            ->where('from', '<=', $total_weight)
            ->where('to', '>=', $total_weight)
            ->first();

        if ($delivery_range) {
            $delivery_price = $delivery_range->value;
        } else {
            $delivery_price = $company->shop_company->minimum_delivery_value;
        }

        $total_no_delivery = number_format(array_sum($total_array), 2);

        if ($company->shop_company->delivery_free_after != null && $total_no_delivery >= floatval($company->shop_company->delivery_free_after)) {
            $delivery_price = 0;
        }

        if ($delivery == 0) {
            $total = number_format(array_sum($total_array), 2);
        } else {
            $total = number_format(array_sum($total_array) + $delivery_price, 2);
        }


        return view('website.components.inner_checkout', compact('products', 'total_no_delivery', 'total', 'user', 'address', 'company', 'delivery_price', 'delivery'));
    }

    public function category($category_id)
    {
        $category = ShopCategory::find($category_id);

        $companies = Company::whereHas('shop_company', function ($query) use ($category) {
            $query->whereHas('shop_categories', function ($q) use ($category) {
                $q->where('id', $category->id);
            });
        })->get();

        $products = ShopProduct::where('state', true)->whereHas('shop_product_categories', function ($query) use ($category) {
            $query->whereHas('company.shop_company', function ($q) use ($category) {
                $q->whereHas('shop_categories', function ($shopCategory) use ($category) {
                    $shopCategory->where('id', $category->id);
                });
            });
        })
            ->inRandomOrder()
            ->limit(20)->get();

        return view('website.shop.category', compact('category', 'companies', 'products'));
    }

    public function company($company_id)
    {
        $shop_categories = ShopCategory::orderBy('name')->get();
        $company = Company::find($company_id)->load('shop_company.shop_company_schedules');

        return view('website.shop.company', compact('shop_categories', 'company'));
    }

    public function products($company_id, $shop_product_category_id)
    {

        $company = Company::find($company_id)->load('shop_company.shop_company_schedules');

        $shop_product_categories = ShopProductCategory::where('company_id', $company->id)->get();

        $products = ShopProduct::where('state', true)->whereHas('shop_product_categories', function ($query) use ($company, $shop_product_category_id) {
            $query->where([
                'company_id' => $company->id,
                'state' => true
            ]);
            if ($shop_product_category_id != 'todos') {
                $query->where('id', $shop_product_category_id);
            }
        })->get()->load('shop_product_sub_categories');

        $shop_product_sub_categories = ShopProductSubCategory::whereHas('shop_product_category', function ($query) use ($company, $shop_product_category_id) {
            $query->where('company_id', $company->id);
            $query->where('id', $shop_product_category_id);
        })->get();

        $services = Service::where('shop_company_id', $company->shop_company->id)->get()->load('shop_product_sub_categories');

        return view('website.shop.products', compact('shop_product_categories', 'products', 'company', 'shop_product_sub_categories', 'shop_product_category_id', 'services'));
    }

    public function searchInShop(Request $request)
    {
        $companies = Company::where('name', 'LIKE', '%' . $request->search . '%')
            ->limit(10)
            ->inRandomOrder()
            ->get();

        $results = collect();

        foreach ($companies as $company) {
            $results->add([
                'type' => 'company',
                'id' => $company->id,
                'name' => $company->name,
                'more' => $company->location,
                'image' => $company->logo ? $company->logo->thumbnail : null,
            ]);
        }

        $products = ShopProduct::where('name', 'LIKE', '%' . $request->search . '%')
            ->where('state', true)
            ->limit(10)
            ->inRandomOrder()
            ->get();

        foreach ($products as $product) {
            $results->add([
                'type' => 'product',
                'id' => $product->id,
                'name' => $product->name,
                'more' => !$product->sales_price ? '€' . $product->price : '<small><s>' . $product->price . '</s></small> €' . $product->sales_price,
                'image' => count($product->photos) > 0 ? $product->photos[0]->thumbnail : null,
            ]);
        }

        $services = Service::where('name', 'LIKE', '%' . $request->search . '%')
            ->limit(10)
            ->inRandomOrder()
            ->get();

        foreach ($services as $service) {
            $results->add([
                'type' => 'service',
                'id' => $service->id,
                'name' => $service->name,
                'more' => '€' . $service->price,
                'image' => count($service->photos) > 0 ? $service->photos[0]->thumbnail : null,
            ]);
        }

        $categories = ShopCategory::where('name', 'LIKE', '%' . $request->search . '%')
            ->limit(10)
            ->inRandomOrder()
            ->get();

        foreach ($categories as $category) {
            $results->add([
                'type' => 'category',
                'id' => $category->id,
                'name' => $category->name,
                'more' => $category->description,
                'image' => $category->image ? $category->image->thumbnail : null,
            ]);
        }

        $results = $results->shuffle();

        return view('website.components.search_results', compact('results'));
    }

    public function changeDelivery($delivery)
    {
        session()->put('delivery', $delivery);
    }

}