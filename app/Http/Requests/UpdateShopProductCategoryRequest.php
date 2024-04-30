<?php

namespace App\Http\Requests;

use App\Models\ShopProductCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateShopProductCategoryRequest extends FormRequest
{
    public function authorize()
    {
        $allow = false;
        if (Gate::allows('shop_product_category_edit') || Gate::allows('my_category_access')) {
            $allow = true;
        }
        return $allow;
    }

    public function rules()
    {
        return [
            'company_id' => [
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