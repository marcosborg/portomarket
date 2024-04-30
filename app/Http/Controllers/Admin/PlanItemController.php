<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPlanItemRequest;
use App\Http\Requests\StorePlanItemRequest;
use App\Http\Requests\UpdatePlanItemRequest;
use App\Models\Plan;
use App\Models\PlanItem;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PlanItemController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('plan_item_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $planItems = PlanItem::with(['plan'])->get();

        return view('admin.planItems.index', compact('planItems'));
    }

    public function create()
    {
        abort_if(Gate::denies('plan_item_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plans = Plan::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.planItems.create', compact('plans'));
    }

    public function store(StorePlanItemRequest $request)
    {
        $planItem = PlanItem::create($request->all());

        return redirect()->route('admin.plan-items.index');
    }

    public function edit(PlanItem $planItem)
    {
        abort_if(Gate::denies('plan_item_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plans = Plan::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $planItem->load('plan');

        return view('admin.planItems.edit', compact('planItem', 'plans'));
    }

    public function update(UpdatePlanItemRequest $request, PlanItem $planItem)
    {
        $planItem->update($request->all());

        return redirect()->route('admin.plan-items.index');
    }

    public function show(PlanItem $planItem)
    {
        abort_if(Gate::denies('plan_item_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $planItem->load('plan');

        return view('admin.planItems.show', compact('planItem'));
    }

    public function destroy(PlanItem $planItem)
    {
        abort_if(Gate::denies('plan_item_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $planItem->delete();

        return back();
    }

    public function massDestroy(MassDestroyPlanItemRequest $request)
    {
        $planItems = PlanItem::find(request('ids'));

        foreach ($planItems as $planItem) {
            $planItem->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}