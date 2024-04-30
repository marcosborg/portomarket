<?php

namespace App\Http\Requests;

use App\Models\ShopSchedule;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreShopScheduleRequest extends FormRequest
{
    public function authorize()
    {
        $allow = false;
        if (Gate::allows('my_employee_access') || Gate::allows('shop_schedule_create')) {
            $allow = true;
        }
        return $allow;
    }

    public function rules()
    {
        return [
            'service_employee_id' => [
                'required',
                'integer',
            ],
            'start_time' => [
                'required',
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
            ],
            'end_time' => [
                'required',
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
            ],
            'service_id' => [
                'required',
                'integer',
            ],
        ];
    }
}