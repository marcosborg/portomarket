<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreShopScheduleRequest;
use App\Http\Requests\UpdateShopScheduleRequest;
use App\Http\Resources\Admin\ShopScheduleResource;
use App\Models\ShopSchedule;
use App\Models\User;
use App\Notifications\ClientScheduleNotification;
use App\Notifications\ScheduleCancelNotification;
use App\Notifications\ScheduleNotification;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Broadcasting\Channel;
use Illuminate\Support\Facades\Notification;

class ShopScheduleApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('shop_schedule_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ShopScheduleResource(ShopSchedule::with(['service_employee', 'service', 'client'])->get());
    }

    public function store(StoreShopScheduleRequest $request)
    {
        $shopSchedule = ShopSchedule::create($request->all());

        return (new ShopScheduleResource($shopSchedule))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ShopSchedule $shopSchedule)
    {
        //abort_if(Gate::denies('shop_schedule_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ShopScheduleResource($shopSchedule->load(['service_employee', 'service.shop_company.company', 'service.shop_company.shop_location', 'service.service_duration', 'client']));
    }

    public function update(UpdateShopScheduleRequest $request, ShopSchedule $shopSchedule)
    {
        $shopSchedule->update($request->all());

        return (new ShopScheduleResource($shopSchedule))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ShopSchedule $shopSchedule)
    {
        abort_if(Gate::denies('shop_schedule_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shopSchedule->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function saveSchedule(Request $request)
    {

        $client_id = Auth::guard('sanctum')->user()->id;
        $service_employee_id = $request->service_employee_id;
        $service_id = $request->service_id;
        $start_time = $request->start_time;
        $end_time = $request->end_time;

        $shop_schedule = new ShopSchedule;
        $shop_schedule->client_id = $client_id;
        $shop_schedule->service_employee_id = $service_employee_id;
        $shop_schedule->service_id = $service_id;
        $shop_schedule->start_time = $start_time;
        $shop_schedule->end_time = $end_time;
        $shop_schedule->save();

        $shop_schedule->load('service_employee.shop_company.company', 'client', 'service');
        $client_name = $shop_schedule->client->name;
        $client_email = $shop_schedule->client->email;
        $service_name = $shop_schedule->service->name;
        $service_employee_name = $shop_schedule->service_employee->name;
        $company_email = $shop_schedule->service_employee->shop_company->company->email;
        $company_name = $shop_schedule->service_employee->shop_company->company->name;
        $company_address = $shop_schedule->service_employee->shop_company->company->address;
        $company_contacts = $shop_schedule->service_employee->shop_company->contacts;

        $data = [
            'client_name' => $client_name,
            'client_email' => $client_email,
            'service_name' => $service_name,
            'service_employee_name' => $service_employee_name,
            'company_email' => $company_email,
            'company_name' => $company_name,
            'company_address' => $company_address,
            'company_contacts' => $company_contacts,
            'start_time' => $start_time,
            'end_time' => $end_time,
        ];

        //Enviar emails
        Notification::route('mail', [
            $company_email => $company_name,
        ])
            ->notify(new ScheduleNotification($data));

        Notification::route('mail', [
            $client_email => $client_name,
        ])
            ->notify(new ClientScheduleNotification($data));

    }

    public function deleteSchedule(Request $request)
    {
        $shop_schedule = ShopSchedule::find($request->id)->load('service_employee.shop_company.company', 'service', 'client');

        //SEND EMAIL

        Notification::route('mail', [
            $shop_schedule->service_employee->shop_company->company->email => $shop_schedule->service_employee->shop_company->company->name,
        ])->notify(new ScheduleCancelNotification($shop_schedule));

        //DELETE

        $shop_schedule->delete();
    }
}