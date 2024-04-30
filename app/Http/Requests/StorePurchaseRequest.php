<?php

namespace App\Http\Requests;

use App\Models\Purchase;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePurchaseRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('purchase_create');
    }

    public function rules()
    {
        return [
            'type' => [
                'required',
            ],
            'relationship' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'name' => [
                'string',
                'nullable',
            ],
            'vat' => [
                'numeric',
            ],
            'user_id' => [
                'required',
                'integer',
            ],
            'qty' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'method' => [
                'string',
                'nullable',
            ],
            'internal' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'id_payment' => [
                'string',
                'nullable',
            ],
            'delivery' => [
                'string',
                'nullable',
            ],
        ];
    }
}
