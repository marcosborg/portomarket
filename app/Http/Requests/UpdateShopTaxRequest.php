<?php

namespace App\Http\Requests;

use App\Models\ShopTax;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateShopTaxRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('shop_tax_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'tax' => [
                'numeric',
                'required',
            ],
        ];
    }
}
