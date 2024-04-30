<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySubscriptionTypeRequest;
use App\Http\Requests\StoreSubscriptionTypeRequest;
use App\Http\Requests\UpdateSubscriptionTypeRequest;
use App\Models\Plan;
use App\Models\SubscriptionType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionTypeController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('subscription_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subscriptionTypes = SubscriptionType::with(['plan'])->get();

        return view('admin.subscriptionTypes.index', compact('subscriptionTypes'));
    }

    public function create()
    {
        abort_if(Gate::denies('subscription_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plans = Plan::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.subscriptionTypes.create', compact('plans'));
    }

    public function store(StoreSubscriptionTypeRequest $request)
    {
        $subscriptionType = SubscriptionType::create($request->all());

        return redirect()->route('admin.subscription-types.index');
    }

    public function edit(SubscriptionType $subscriptionType)
    {
        abort_if(Gate::denies('subscription_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plans = Plan::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $subscriptionType->load('plan');

        return view('admin.subscriptionTypes.edit', compact('plans', 'subscriptionType'));
    }

    public function update(UpdateSubscriptionTypeRequest $request, SubscriptionType $subscriptionType)
    {
        $subscriptionType->update($request->all());

        return redirect()->route('admin.subscription-types.index');
    }

    public function show(SubscriptionType $subscriptionType)
    {
        abort_if(Gate::denies('subscription_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subscriptionType->load('plan');

        return view('admin.subscriptionTypes.show', compact('subscriptionType'));
    }

    public function destroy(SubscriptionType $subscriptionType)
    {
        abort_if(Gate::denies('subscription_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subscriptionType->delete();

        return back();
    }

    public function massDestroy(MassDestroySubscriptionTypeRequest $request)
    {
        $subscriptionTypes = SubscriptionType::find(request('ids'));

        foreach ($subscriptionTypes as $subscriptionType) {
            $subscriptionType->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}