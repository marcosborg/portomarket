<?php

namespace App\Http\Requests;

use App\Models\ShopCompanySchedule;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateShopCompanyScheduleRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('shop_company_schedule_edit');
    }

    public function rules()
    {
        return [
            'shop_company_id' => [
                'required',
                'integer',
            ],
            'monday_morning_opening' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'monday_morning_closing' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'moday_afternoon_opening' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'monday_afternoon_closing' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'tuesday_morning_opening' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'tuesday_morning_closing' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'tuesday_afternoon_opening' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'tuesday_afternoon_closing' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'wednesday_morning_opening' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'wednesday_morning_closing' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'wednesday_afternoon_opening' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'wednesday_afternoon_closing' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'thursday_morning_opening' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'thursday_morning_closing' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'thursday_afternoon_opening' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'thursday_afternoon_closing' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'friday_morning_opening' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'friday_morning_closing' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'friday_afternoon_opening' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'friday_afternoon_closing' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'saturday_morning_opening' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'saturday_morning_closing' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'saturday_afternoon_opening' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'saturday_afternoon_closing' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'sunday_morning_opening' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'sunday_morning_closing' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'sunday_afternoon_opening' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'sunday_afternoon_closing' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
        ];
    }
}
