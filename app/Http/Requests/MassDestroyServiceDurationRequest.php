<?php

namespace App\Http\Requests;

use App\Models\ServiceDuration;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyServiceDurationRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('service_duration_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:service_durations,id',
        ];
    }
}
