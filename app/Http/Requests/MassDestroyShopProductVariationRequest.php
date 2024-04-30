<?php

namespace App\Http\Requests;

use App\Models\ShopProductVariation;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyShopProductVariationRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('shop_product_variation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:shop_product_variations,id',
        ];
    }
}
