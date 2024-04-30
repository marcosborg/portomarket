<?php

namespace App\Http\Requests;

use App\Models\SubscriptionPayment;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreSubscriptionPaymentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('subscription_payment_create');
    }

    public function rules()
    {
        return [
            'subscription_id' => [
                'required',
                'integer',
            ],
            'value' => [
                'required',
            ],
            'method' => [
                'string',
                'required',
            ],
        ];
    }
}