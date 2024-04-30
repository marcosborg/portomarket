<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubscriptionPaymentRequest;
use App\Http\Requests\UpdateSubscriptionPaymentRequest;
use App\Http\Resources\Admin\SubscriptionPaymentResource;
use App\Models\SubscriptionPayment;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionPaymentApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('subscription_payment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SubscriptionPaymentResource(SubscriptionPayment::with(['subscription'])->get());
    }

    public function store(StoreSubscriptionPaymentRequest $request)
    {
        $subscriptionPayment = SubscriptionPayment::create($request->all());

        return (new SubscriptionPaymentResource($subscriptionPayment))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(SubscriptionPayment $subscriptionPayment)
    {
        abort_if(Gate::denies('subscription_payment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SubscriptionPaymentResource($subscriptionPayment->load(['subscription']));
    }

    public function update(UpdateSubscriptionPaymentRequest $request, SubscriptionPayment $subscriptionPayment)
    {
        $subscriptionPayment->update($request->all());

        return (new SubscriptionPaymentResource($subscriptionPayment))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(SubscriptionPayment $subscriptionPayment)
    {
        abort_if(Gate::denies('subscription_payment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subscriptionPayment->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
