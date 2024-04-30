<?php

namespace App\Http\Requests;

use App\Models\ShopProductFeature;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyShopProductFeatureRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('shop_product_feature_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:shop_product_features,id',
        ];
    }
}
