<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDeliveryRangeRequest;
use App\Http\Requests\UpdateDeliveryRangeRequest;
use App\Http\Resources\Admin\DeliveryRangeResource;
use App\Models\DeliveryRange;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DeliveryRangesApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('delivery_range_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DeliveryRangeResource(DeliveryRange::with(['shop_company'])->get());
    }

    public function store(StoreDeliveryRangeRequest $request)
    {
        $deliveryRange = DeliveryRange::create($request->all());

        return (new DeliveryRangeResource($deliveryRange))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(DeliveryRange $deliveryRange)
    {
        abort_if(Gate::denies('delivery_range_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DeliveryRangeResource($deliveryRange->load(['shop_company']));
    }

    public function update(UpdateDeliveryRangeRequest $request, DeliveryRange $deliveryRange)
    {
        $deliveryRange->update($request->all());

        return (new DeliveryRangeResource($deliveryRange))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(DeliveryRange $deliveryRange)
    {
        abort_if(Gate::denies('delivery_range_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $deliveryRange->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
