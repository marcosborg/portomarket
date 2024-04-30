<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyShopScheduleRequest;
use App\Http\Requests\StoreShopScheduleRequest;
use App\Http\Requests\UpdateShopScheduleRequest;
use App\Models\Service;
use App\Models\ServiceEmployee;
use App\Models\ShopSchedule;
use App\Models\User;
use Carbon\Carbon;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ShopScheduleController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('shop_schedule_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shopSchedules = ShopSchedule::with(['service_employee', 'service', 'client'])->get();

        return view('admin.shopSchedules.index', compact('shopSchedules'));
    }

    public function create()
    {
        abort_if(Gate::denies('shop_schedule_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $service_employees = ServiceEmployee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $services = Service::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $clients = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.shopSchedules.create', compact('clients', 'service_employees', 'services'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'service_employee_id' => [
                'required',
                'integer',
            ],
            'start_time' => [
                'required',
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
            ],
            'service_id' => [
                'required',
                'integer',
            ],
        ]);

        $service = Service::find($request->service_id)->load('service_duration');

        $start_time = Carbon::parse($request->start_time);
        $end_time = Carbon::parse($request->start_time)->addMinutes($service->service_duration->minutes);

        $exist = ShopSchedule::where('service_employee_id', $request->service_employee_id)
            ->where(function ($query) use ($start_time, $end_time) {
                $query->whereBetween('start_time', [$start_time, $end_time])
                    ->orWhereBetween('end_time', [$start_time, $end_time])
                    ->orWhere(function ($query) use ($start_time, $end_time) {
                        $query->where('start_time', '<=', $start_time)
                            ->where('end_time', '>=', $end_time);
                    });
            })->exists();

        if ($exist) {
            return redirect()->back()->with('error', 'Já existe marcação para essa hora. Verifique no calendário.');
        } else {
            $shopSchedule = new ShopSchedule;
            $shopSchedule->service_employee_id = $request->service_employee_id;
            $shopSchedule->client_id = $request->user_id;
            $shopSchedule->notes = $request->notes;
            $shopSchedule->start_time = $start_time->format('Y-m-d H:i:s');
            $shopSchedule->end_time = $end_time->format('Y-m-d H:i:s');
            $shopSchedule->service_id = $request->service_id;
            $shopSchedule->save();
        }

        if (!$request->mySchedules) {
            return redirect()->route('admin.shop-schedules.index');
        } else {
            return redirect()->back()->with('message', 'Criado com sucesso');
        }

    }

    public function edit(ShopSchedule $shopSchedule)
    {
        abort_if(Gate::denies('shop_schedule_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $service_employees = ServiceEmployee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $services = Service::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $clients = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $shopSchedule->load('service_employee', 'service');

        return view('admin.shopSchedules.edit', compact('clients', 'service_employees', 'services', 'shopSchedule'));
    }

    public function update(UpdateShopScheduleRequest $request, ShopSchedule $shopSchedule)
    {
        $shopSchedule->update($request->all());

        if (!$request->mySchedules) {
            return redirect()->route('admin.shop-schedules.index');
        } else {
            return $shopSchedule;
        }

    }

    public function show(ShopSchedule $shopSchedule)
    {
        abort_if(Gate::denies('shop_schedule_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shopSchedule->load('service_employee', 'service', 'client');

        return view('admin.shopSchedules.show', compact('shopSchedule'));
    }

    public function destroy(ShopSchedule $shopSchedule)
    {
        abort_if(Gate::denies('shop_schedule_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shopSchedule->delete();

        return back();
    }

    public function massDestroy(MassDestroyShopScheduleRequest $request)
    {
        $shopSchedules = ShopSchedule::find(request('ids'));

        foreach ($shopSchedules as $shopSchedule) {
            $shopSchedule->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}