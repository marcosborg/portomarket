<?php

namespace App\Http\Requests;

use App\Models\ShopTax;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyShopTaxRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('shop_tax_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:shop_taxes,id',
        ];
    }
}
