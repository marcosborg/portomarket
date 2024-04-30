<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDeliveryRangeRequest;
use App\Http\Requests\StoreDeliveryRangeRequest;
use App\Http\Requests\UpdateDeliveryRangeRequest;
use App\Models\DeliveryRange;
use App\Models\ShopCompany;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DeliveryRangesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('delivery_range_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $deliveryRanges = DeliveryRange::with(['shop_company'])->get();

        return view('admin.deliveryRanges.index', compact('deliveryRanges'));
    }

    public function create()
    {
        abort_if(Gate::denies('delivery_range_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shop_companies = ShopCompany::pluck('address', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.deliveryRanges.create', compact('shop_companies'));
    }

    public function store(StoreDeliveryRangeRequest $request)
    {
        $deliveryRange = DeliveryRange::create($request->all());

        return redirect()->route('admin.delivery-ranges.index');
    }

    public function edit(DeliveryRange $deliveryRange)
    {
        abort_if(Gate::denies('delivery_range_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shop_companies = ShopCompany::pluck('address', 'id')->prepend(trans('global.pleaseSelect'), '');

        $deliveryRange->load('shop_company');

        return view('admin.deliveryRanges.edit', compact('deliveryRange', 'shop_companies'));
    }

    public function update(UpdateDeliveryRangeRequest $request, DeliveryRange $deliveryRange)
    {
        $deliveryRange->update($request->all());

        return redirect()->route('admin.delivery-ranges.index');
    }

    public function show(DeliveryRange $deliveryRange)
    {
        abort_if(Gate::denies('delivery_range_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $deliveryRange->load('shop_company');

        return view('admin.deliveryRanges.show', compact('deliveryRange'));
    }

    public function destroy(DeliveryRange $deliveryRange)
    {
        abort_if(Gate::denies('delivery_range_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $deliveryRange->delete();

        return back();
    }

    public function massDestroy(MassDestroyDeliveryRangeRequest $request)
    {
        $deliveryRanges = DeliveryRange::find(request('ids'));

        foreach ($deliveryRanges as $deliveryRange) {
            $deliveryRange->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
