<?php

namespace App\Http\Requests;

use App\Models\ShopProductSubCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyShopProductSubCategoryRequest extends FormRequest
{
    public function authorize()
    {

        $allow = false;

        if (Gate::allows('shop_product_sub_category_delete') || Gate::allows('my_sub_category_access')) {
            $allow = true;
        }
        return $allow;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:shop_product_sub_categories,id',
        ];
    }
}
