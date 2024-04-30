<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyShopTypeRequest;
use App\Http\Requests\StoreShopTypeRequest;
use App\Http\Requests\UpdateShopTypeRequest;
use App\Models\ShopType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ShopTypeController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('shop_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shopTypes = ShopType::all();

        return view('admin.shopTypes.index', compact('shopTypes'));
    }

    public function create()
    {
        abort_if(Gate::denies('shop_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.shopTypes.create');
    }

    public function store(StoreShopTypeRequest $request)
    {
        $shopType = ShopType::create($request->all());

        return redirect()->route('admin.shop-types.index');
    }

    public function edit(ShopType $shopType)
    {
        abort_if(Gate::denies('shop_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.shopTypes.edit', compact('shopType'));
    }

    public function update(UpdateShopTypeRequest $request, ShopType $shopType)
    {
        $shopType->update($request->all());

        return redirect()->route('admin.shop-types.index');
    }

    public function show(ShopType $shopType)
    {
        abort_if(Gate::denies('shop_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.shopTypes.show', compact('shopType'));
    }

    public function destroy(ShopType $shopType)
    {
        abort_if(Gate::denies('shop_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shopType->delete();

        return back();
    }

    public function massDestroy(MassDestroyShopTypeRequest $request)
    {
        $shopTypes = ShopType::find(request('ids'));

        foreach ($shopTypes as $shopType) {
            $shopType->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
