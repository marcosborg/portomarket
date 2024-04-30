<?php

namespace App\Http\Requests;

use App\Models\ServiceDuration;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreServiceDurationRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('service_duration_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'minutes' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
