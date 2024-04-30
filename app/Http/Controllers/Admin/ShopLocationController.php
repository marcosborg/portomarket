<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyShopLocationRequest;
use App\Http\Requests\StoreShopLocationRequest;
use App\Http\Requests\UpdateShopLocationRequest;
use App\Models\ShopLocation;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ShopLocationController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('shop_location_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shopLocations = ShopLocation::all();

        return view('admin.shopLocations.index', compact('shopLocations'));
    }

    public function create()
    {
        abort_if(Gate::denies('shop_location_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.shopLocations.create');
    }

    public function store(StoreShopLocationRequest $request)
    {
        $shopLocation = ShopLocation::create($request->all());

        return redirect()->route('admin.shop-locations.index');
    }

    public function edit(ShopLocation $shopLocation)
    {
        abort_if(Gate::denies('shop_location_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.shopLocations.edit', compact('shopLocation'));
    }

    public function update(UpdateShopLocationRequest $request, ShopLocation $shopLocation)
    {
        $shopLocation->update($request->all());

        return redirect()->route('admin.shop-locations.index');
    }

    public function show(ShopLocation $shopLocation)
    {
        abort_if(Gate::denies('shop_location_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.shopLocations.show', compact('shopLocation'));
    }

    public function destroy(ShopLocation $shopLocation)
    {
        abort_if(Gate::denies('shop_location_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shopLocation->delete();

        return back();
    }

    public function massDestroy(MassDestroyShopLocationRequest $request)
    {
        $shopLocations = ShopLocation::find(request('ids'));

        foreach ($shopLocations as $shopLocation) {
            $shopLocation->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
