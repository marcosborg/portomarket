<?php

namespace App\Http\Requests;

use App\Models\PlanItem;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyPlanItemRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('plan_item_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:plan_items,id',
        ];
    }
}