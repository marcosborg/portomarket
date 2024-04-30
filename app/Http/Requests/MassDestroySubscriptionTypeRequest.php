<?php

namespace App\Http\Requests;

use App\Models\SubscriptionType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroySubscriptionTypeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('subscription_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:subscription_types,id',
        ];
    }
}