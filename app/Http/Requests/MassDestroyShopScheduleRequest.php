<?php

namespace App\Http\Requests;

use App\Models\ShopSchedule;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyShopScheduleRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('shop_schedule_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:shop_schedules,id',
        ];
    }
}
