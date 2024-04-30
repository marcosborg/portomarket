<?php

namespace App\Http\Requests;

use App\Models\PlanItem;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePlanItemRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('plan_item_edit');
    }

    public function rules()
    {
        return [
            'text' => [
                'string',
                'required',
            ],
            'plan_id' => [
                'required',
                'integer',
            ],
            'type' => [
                'required',
            ],
        ];
    }
}