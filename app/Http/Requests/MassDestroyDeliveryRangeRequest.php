<?php

namespace App\Http\Requests;

use App\Models\DeliveryRange;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyDeliveryRangeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('delivery_range_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:delivery_ranges,id',
        ];
    }
}
