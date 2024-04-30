<?php

namespace App\Http\Requests;

use App\Models\ShopCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyShopCategoryRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('shop_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:shop_categories,id',
        ];
    }
}
