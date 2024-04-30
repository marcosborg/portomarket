<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Service;
use App\Models\ShopCategory;
use App\Models\ShopProduct;
use Illuminate\Http\Request;

class SearchApiController extends Controller
{
    public function search(Request $request)
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
            ->limit(10)
            ->inRandomOrder()
            ->where('state', true)
            ->get();

        foreach ($products as $product) {
            $results->add([
                'type' => 'product',
                'id' => $product->id,
                'name' => $product->name,
                'more' => '€' . $product->price,
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

        return $results->shuffle();
    }
}