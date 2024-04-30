<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySubscriptionPaymentRequest;
use App\Http\Requests\StoreSubscriptionPaymentRequest;
use App\Http\Requests\UpdateSubscriptionPaymentRequest;
use App\Models\Subscription;
use App\Models\SubscriptionPayment;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionPaymentController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('subscription_payment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subscriptionPayments = SubscriptionPayment::with([
            'subscription.subscription_type.plan',
            'subscription.user',
            ])->get();

        return view('admin.subscriptionPayments.index', compact('subscriptionPayments'));
    }

    public function create()
    {
        abort_if(Gate::denies('subscription_payment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subscriptions = Subscription::pluck('start_date', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.subscriptionPayments.create', compact('subscriptions'));
    }

    public function store(StoreSubscriptionPaymentRequest $request)
    {
        $subscriptionPayment = SubscriptionPayment::create($request->all());

        return redirect()->route('admin.subscription-payments.index');
    }

    public function edit(SubscriptionPayment $subscriptionPayment)
    {
        abort_if(Gate::denies('subscription_payment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subscriptions = Subscription::pluck('start_date', 'id')->prepend(trans('global.pleaseSelect'), '');

        $subscriptionPayment->load('subscription');

        return view('admin.subscriptionPayments.edit', compact('subscriptionPayment', 'subscriptions'));
    }

    public function update(UpdateSubscriptionPaymentRequest $request, SubscriptionPayment $subscriptionPayment)
    {
        $subscriptionPayment->update($request->all());

        return redirect()->route('admin.subscription-payments.index');
    }

    public function show(SubscriptionPayment $subscriptionPayment)
    {
        abort_if(Gate::denies('subscription_payment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subscriptionPayment->load('subscription');

        return view('admin.subscriptionPayments.show', compact('subscriptionPayment'));
    }

    public function destroy(SubscriptionPayment $subscriptionPayment)
    {
        abort_if(Gate::denies('subscription_payment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subscriptionPayment->delete();

        return back();
    }

    public function massDestroy(MassDestroySubscriptionPaymentRequest $request)
    {
        $subscriptionPayments = SubscriptionPayment::find(request('ids'));

        foreach ($subscriptionPayments as $subscriptionPayment) {
            $subscriptionPayment->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
