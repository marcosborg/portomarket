<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MyOrderController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('my_order_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $company_id = User::where('id', auth()->user()->id)->with('company')->first()->company[0]->id;

        $purchases = Purchase::with(['user', 'product.shop_product_categories'])
            ->whereHas('product.shop_product_categories', function ($query) use ($company_id) {
                $query->where('company_id', $company_id);
            })
            ->get();

        return view('admin.myOrders.index', compact('purchases'));
    }

    public function edit(Request $request)
    {

        $allow = false;

        $company_id = User::where('id', auth()->user()->id)->with('company')->first()->company[0]->id;

        $purchase = Purchase::where('id', $request->id)
            ->whereHas('product.shop_product_categories', function ($query) use ($company_id) {
                $query->where('company_id', $company_id);
            })
            ->first()->load('user.address.country');

        if ($purchase && Gate::allows('my_order_access')) {
            $allow = true;
        }

        abort_if($allow == false, Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.myOrders.edit', compact('purchase'));
    }

    public function update(Request $request)
    {
        $purchase = Purchase::find($request->purchase_id);

        $purchase->payed = $request->payed;
        $purchase->status = $request->status;
        $purchase->save();

        return redirect()->back()->with('message', 'Atualizado com sucesso.');
    }

}