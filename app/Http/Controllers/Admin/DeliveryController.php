<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryRange;
use App\Models\ShopCompany;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class DeliveryController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('delivery_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = Auth::user()->load('company.shop_company.delivery_ranges');

        return view('admin.deliveries.index', compact('user'));
    }

    public function newDeliveryRange(Request $request)
    {

        $request->validate([
            'from' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'to' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'value' => [
                'required',
            ],
        ], [], [
            'from' => 'De (kg)',
            'to' => 'Até (kg)',
            'value' => 'Valor (€)',
        ]);

        $delivery_range = new DeliveryRange;
        $delivery_range->shop_company_id = $request->shop_company_id;
        $delivery_range->from = $request->from;
        $delivery_range->to = $request->to;
        $delivery_range->value = $request->value;
        $delivery_range->save();

        return redirect()->back();
    }

    public function updateDeliveryRange(Request $request)
    {
        $request->validate([
            'from' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'to' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'value' => [
                'required',
            ],
        ], [], [
            'from' => 'De (kg)',
            'to' => 'Até (kg)',
            'value' => 'Valor (€)',
        ]);

        $delivery_range = DeliveryRange::find($request->delivery_range_id);
        $delivery_range->from = $request->from;
        $delivery_range->to = $request->to;
        $delivery_range->value = $request->value;
        $delivery_range->save();

        return redirect()->back();
    }

    public function deleteDeliveryRange($delivery_range_id)
    {
        DeliveryRange::find($delivery_range_id)->delete();
        return redirect()->back();
    }

    public function updateShopProduct(Request $request)
    {

        $shop_company = ShopCompany::find($request->shop_company_id);
        $shop_company->delivery_company = $request->delivery_company;
        $shop_company->minimum_delivery_value = $request->minimum_delivery_value;
        $shop_company->delivery_free_after = $request->delivery_free_after;
        $shop_company->save();

        return redirect()->back();
    }

}