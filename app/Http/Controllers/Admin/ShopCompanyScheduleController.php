<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyShopCompanyScheduleRequest;
use App\Http\Requests\StoreShopCompanyScheduleRequest;
use App\Http\Requests\UpdateShopCompanyScheduleRequest;
use App\Models\ShopCompany;
use App\Models\ShopCompanySchedule;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ShopCompanyScheduleController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('shop_company_schedule_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shopCompanySchedules = ShopCompanySchedule::with(['shop_company'])->get();

        return view('admin.shopCompanySchedules.index', compact('shopCompanySchedules'));
    }

    public function create()
    {
        abort_if(Gate::denies('shop_company_schedule_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shop_companies = ShopCompany::pluck('contacts', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.shopCompanySchedules.create', compact('shop_companies'));
    }

    public function store(StoreShopCompanyScheduleRequest $request)
    {
        $shopCompanySchedule = ShopCompanySchedule::create($request->all());

        return redirect()->route('admin.shop-company-schedules.index');
    }

    public function edit(ShopCompanySchedule $shopCompanySchedule)
    {
        abort_if(Gate::denies('shop_company_schedule_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shop_companies = ShopCompany::pluck('contacts', 'id')->prepend(trans('global.pleaseSelect'), '');

        $shopCompanySchedule->load('shop_company');

        return view('admin.shopCompanySchedules.edit', compact('shopCompanySchedule', 'shop_companies'));
    }

    public function update(UpdateShopCompanyScheduleRequest $request, ShopCompanySchedule $shopCompanySchedule)
    {
        $shopCompanySchedule->update($request->all());

        return redirect()->route('admin.shop-company-schedules.index');
    }

    public function show(ShopCompanySchedule $shopCompanySchedule)
    {
        abort_if(Gate::denies('shop_company_schedule_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shopCompanySchedule->load('shop_company');

        return view('admin.shopCompanySchedules.show', compact('shopCompanySchedule'));
    }

    public function destroy(ShopCompanySchedule $shopCompanySchedule)
    {
        abort_if(Gate::denies('shop_company_schedule_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shopCompanySchedule->delete();

        return back();
    }

    public function massDestroy(MassDestroyShopCompanyScheduleRequest $request)
    {
        $shopCompanySchedules = ShopCompanySchedule::find(request('ids'));

        foreach ($shopCompanySchedules as $shopCompanySchedule) {
            $shopCompanySchedule->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
