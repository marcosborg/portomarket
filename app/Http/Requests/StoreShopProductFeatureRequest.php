<?php

namespace App\Http\Requests;

use App\Models\ShopProductFeature;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreShopProductFeatureRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('shop_product_feature_create');
    }

    public function rules()
    {
        return [
            'shop_product_id' => [
                'required',
                'integer',
            ],
            'name' => [
                'string',
                'required',
            ],
        ];
    }
}
