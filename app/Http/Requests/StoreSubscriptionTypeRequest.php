<?php

namespace App\Http\Requests;

use App\Models\SubscriptionType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreSubscriptionTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('subscription_type_create');
    }

    public function rules()
    {
        return [
            'months' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'discount' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'plan_id' => [
                'required',
                'integer',
            ],
        ];
    }
}