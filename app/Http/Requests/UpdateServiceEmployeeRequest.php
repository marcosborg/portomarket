<?php

namespace App\Http\Requests;

use App\Models\ServiceEmployee;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateServiceEmployeeRequest extends FormRequest
{
    public function authorize()
    {
        $allow = false;
        if (Gate::allows('service_employee_edit') || Gate::allows('my_employee_access')) {
            $allow = true;
        }
        return $allow;
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'shop_company_id' => [
                'required',
                'integer',
            ],
            'services.*' => [
                'integer',
            ],
            'services' => [
                'array',
            ],
        ];
    }
}