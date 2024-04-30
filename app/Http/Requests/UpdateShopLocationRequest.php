<?php

namespace App\Http\Requests;

use App\Models\ShopLocation;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateShopLocationRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('shop_location_edit');
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
