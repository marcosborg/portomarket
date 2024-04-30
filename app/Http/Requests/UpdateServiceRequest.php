<?php

namespace App\Http\Requests;

use App\Models\Service;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateServiceRequest extends FormRequest
{
    public function authorize()
    {
        $allow = false;
        if (Gate::allows('service_edit') || Gate::allows('my_service_access')) {
            $allow = true;
        }
        return $allow;
    }

    public function rules()
    {
        return [
            'shop_company_id' => [
                'required',
                'integer',
            ],
            'name' => [
                'string',
                'required',
            ],
            'reference' => [
                'string',
                'nullable',
            ],
            'photos' => [
                'array',
            ],
            'service_duration_id' => [
                'required',
                'integer',
            ],
            'shop_product_categories.*' => [
                'integer',
            ],
            'shop_product_categories' => [
                'array',
            ],
            'shop_product_sub_categories.*' => [
                'integer',
            ],
            'shop_product_sub_categories' => [
                'array',
            ],
            'price' => [
                'required',
            ],
            'tax_id' => [
                'required',
                'integer',
            ],
            'youtube' => [
                'string',
                'nullable',
            ],
            'attachment_name' => [
                'string',
                'nullable',
            ],
            'position' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
