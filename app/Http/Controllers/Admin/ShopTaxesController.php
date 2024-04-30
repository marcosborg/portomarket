<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyShopTaxRequest;
use App\Http\Requests\StoreShopTaxRequest;
use App\Http\Requests\UpdateShopTaxRequest;
use App\Models\ShopTax;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ShopTaxesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('shop_tax_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shopTaxes = ShopTax::all();

        return view('admin.shopTaxes.index', compact('shopTaxes'));
    }

    public function create()
    {
        abort_if(Gate::denies('shop_tax_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.shopTaxes.create');
    }

    public function store(StoreShopTaxRequest $request)
    {
        $shopTax = ShopTax::create($request->all());

        return redirect()->route('admin.shop-taxes.index');
    }

    public function edit(ShopTax $shopTax)
    {
        abort_if(Gate::denies('shop_tax_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.shopTaxes.edit', compact('shopTax'));
    }

    public function update(UpdateShopTaxRequest $request, ShopTax $shopTax)
    {
        $shopTax->update($request->all());

        return redirect()->route('admin.shop-taxes.index');
    }

    public function show(ShopTax $shopTax)
    {
        abort_if(Gate::denies('shop_tax_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.shopTaxes.show', compact('shopTax'));
    }

    public function destroy(ShopTax $shopTax)
    {
        abort_if(Gate::denies('shop_tax_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shopTax->delete();

        return back();
    }

    public function massDestroy(MassDestroyShopTaxRequest $request)
    {
        $shopTaxes = ShopTax::find(request('ids'));

        foreach ($shopTaxes as $shopTax) {
            $shopTax->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
