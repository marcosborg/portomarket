<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\ShopProduct;
use App\Notifications\SendMbPayment;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function order(Request $request)
    {
        $cart = json_decode($request->cart);
        foreach ($cart as $item) {
            $product = ShopProduct::find($item->product_id)->load('tax', 'shop_product_categories.company.ifthenPay');
            $item->product = $product;
        }

        $user = $request->user()->load('address');

        $company_id = $cart[0]->product->shop_product_categories[0]->company_id;

        $lastPurchase = Purchase::whereHas('product.shop_product_categories', function ($shop_product_categories) use ($company_id) {
            $shop_product_categories->where('company_id', $company_id);
        })->latest()->first();

        $internal = 1;

        if ($lastPurchase) {
            $internal = $lastPurchase->internal + 1;
        }

        $purchase = new Purchase;
        $purchase->type = 'product';
        $purchase->relationship = $request->product_id;
        $purchase->name = $cart[0]->product->name;
        $purchase->price = $request->price;
        $purchase->vat = $cart[0]->product->tax->tax;
        $purchase->status = 0;
        $purchase->user_id = $user->id;
        $purchase->total = $request->total;
        $purchase->qty = $request->qty;
        $purchase->cart = json_encode($cart);
        $purchase->address = json_encode($user->address);
        $purchase->method = $request->method;
        $purchase->payed = 0;
        $purchase->internal = $internal;
        $purchase->id_payment = '';
        $purchase->delivery = $request->delivery;
        $purchase->delivery_value = $request->delivery_value;
        $purchase->save();

        return $purchase;
    }

    public function ifthenPayments(Request $request)
    {

        $cart = json_decode($request->cart);
        foreach ($cart as $item) {
            $product = ShopProduct::find($item->product_id)->load('tax', 'shop_product_categories.company.ifthenPay');
            $item->product = $product;
        }

        $user = $request->user()->load('address');

        $company_id = $cart[0]->product->shop_product_categories[0]->company_id;

        $MbWayKey = $cart[0]->product->shop_product_categories[0]->company->ifthenPay->mbway_key;

        $MbKey = $cart[0]->product->shop_product_categories[0]->company->ifthenPay->mb_key;

        $lastPurchase = Purchase::whereHas('product.shop_product_categories', function ($shop_product_categories) use ($company_id) {
            $shop_product_categories->where('company_id', $company_id);
        })->latest()->first();

        $internal = 1;

        if ($lastPurchase) {
            $internal = $lastPurchase->internal + 1;
        }

        $purchase = new Purchase;
        $purchase->type = 'product';
        $purchase->relationship = $request->product_id;
        $purchase->name = $cart[0]->product->name;
        $purchase->price = $request->price;
        $purchase->vat = $cart[0]->product->tax->tax;
        $purchase->status = 0;
        $purchase->user_id = $user->id;
        $purchase->total = $request->total;
        $purchase->qty = $request->qty;
        $purchase->cart = json_encode($cart);
        $purchase->address = json_encode($user->address);
        $purchase->method = $request->method;
        $purchase->payed = 0;
        $purchase->internal = $internal;
        $purchase->id_payment = '';
        $purchase->delivery = $request->delivery;
        $purchase->delivery_value = $request->delivery_value;
        $purchase->save();

        if ($request->method == 'mbway') {
            $curl = curl_init();

            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => 'mbway.ifthenpay.com/ifthenpaymbw.asmx/SetPedidoJSON?MbWayKey=' . $MbWayKey . '&canal=03&referencia=' . $purchase->id . '&valor=' . $purchase->total . '&nrtlm=' . $request->celphone . '&email=&descricao=',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                )
            );

            $response = curl_exec($curl);

            curl_close($curl);

            $purchase->id_payment = json_decode($response, true)['IdPedido'];
            $purchase->save();

        } else {

            $curl = curl_init();

            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => 'https://ifthenpay.com/api/multibanco/reference/init',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => '{
                        "mbKey": "' . $MbKey . '",
                        "orderId": "' . $purchase->id . '",
                        "amount": "' . $purchase->total . '",
                    }',
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json',
                    ),
                )
            );

            $response = curl_exec($curl);

            curl_close($curl);

            $purchase->id_payment = json_decode($response, true)['RequestId'];
            $purchase->save();

            $json_response = json_decode($response);

            $reference = '<p>Entidade: ' . $json_response->Entity . '</p>';
            $reference .= '<p>Referência: ' . $json_response->Reference . '</p>';
            $reference .= '<p>Valor: ' . $json_response->Amount . '€</p>';

            $data = [
                'purchase' => $purchase,
                'user' => $purchase->user,
                'reference' => $reference
            ];
    
            $purchase->user->notify(new SendMbPayment($data));

        }

        return $response;
    }
}