<?php

namespace App\Http\Requests;

use App\Models\ShopCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateShopCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('shop_category_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
        ];
    }
}
