<?php

namespace App\Http\Requests;

use App\Models\DeliveryRange;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreDeliveryRangeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('delivery_range_create');
    }

    public function rules()
    {
        return [
            'shop_company_id' => [
                'required',
                'integer',
            ],
            'from' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'to' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'value' => [
                'required',
            ],
        ];
    }
}
