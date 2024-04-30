<?php

namespace App\Http\Requests;

use App\Models\ShopType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyShopTypeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('shop_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:shop_types,id',
        ];
    }
}
