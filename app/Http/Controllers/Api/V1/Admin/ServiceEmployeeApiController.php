<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceEmployeeRequest;
use App\Http\Requests\UpdateServiceEmployeeRequest;
use App\Http\Resources\Admin\ServiceEmployeeResource;
use App\Models\ServiceEmployee;
use App\Models\ShopSchedule;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ServiceEmployeeApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('service_employee_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ServiceEmployeeResource(ServiceEmployee::with(['shop_company', 'services'])->get());
    }

    public function store(StoreServiceEmployeeRequest $request)
    {
        $serviceEmployee = ServiceEmployee::create($request->all());
        $serviceEmployee->services()->sync($request->input('services', []));

        return (new ServiceEmployeeResource($serviceEmployee))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ServiceEmployee $serviceEmployee)
    {
        //abort_if(Gate::denies('service_employee_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ServiceEmployeeResource($serviceEmployee->load(['shop_company', 'services']));
    }

    public function update(UpdateServiceEmployeeRequest $request, ServiceEmployee $serviceEmployee)
    {
        $serviceEmployee->update($request->all());
        $serviceEmployee->services()->sync($request->input('services', []));

        return (new ServiceEmployeeResource($serviceEmployee))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ServiceEmployee $serviceEmployee)
    {
        abort_if(Gate::denies('service_employee_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $serviceEmployee->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function serviceEmployeeSchedules(Request $request)
    {
        $shop_schedules = ShopSchedule::where([
            'service_employee_id' => $request->employee_id
        ])
        ->whereDate('start_time', $request->date)
        ->get();

        return $shop_schedules;
    }
}