<?php

namespace App\Http\Requests;

use App\Models\ShopCompany;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateShopCompanyRequest extends FormRequest
{
    public function authorize()
    {
        $allow = false;

        if (Gate::allows('shop_company_create') || Gate::allows('my_shop_access')) {
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
            'shop_location_id' => [
                'required',
                'integer',
            ],
            'shop_categories.*' => [
                'integer',
            ],
            'shop_categories' => [
                'array',
            ],
            'address' => [
                'string',
                'nullable',
            ],
            'youtube' => [
                'string',
                'nullable',
            ],
            'latitude' => [
                'string',
                'nullable',
            ],
            'longitude' => [
                'string',
                'nullable',
            ],
            'whatsapp' => [
                'string',
                'nullable',
            ],
            'photos' => [
                'array',
            ],
            'delivery_company' => [
                'string',
                'nullable',
            ],
        ];
    }
}