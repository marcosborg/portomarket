<?php

namespace App\Http\Requests;

use App\Models\ShopProduct;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreShopProductRequest extends FormRequest
{
    public function authorize()
    {
        $allow = false;
        if (Gate::allows('shop_product_create') || Gate::allows('my_product_access')) {
            $allow = true;
        }
        return $allow;

    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'reference' => [
                'string',
                'nullable',
            ],
            'photos' => [
                'array',
            ],
            'shop_product_categories.*' => [
                'integer',
            ],
            'shop_product_categories' => [
                'array',
            ],
            'shop_product_sub_categories.*' => [
                'integer',
            ],
            'shop_product_sub_categories' => [
                'array',
            ],
            'tax_id' => [
                'required',
                'integer',
            ],
            'youtube' => [
                'string',
                'nullable',
            ],
            'attachment_name' => [
                'string',
                'nullable',
            ],
            'position' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'stock' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'weight' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}