<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\DeliveryRange;
use App\Models\Purchase;
use App\Models\Service;
use App\Models\ShopCompany;
use App\Models\ShopProduct;
use App\Models\ShopProductVariation;
use App\Models\ShopSchedule;
use App\Notifications\ClientScheduleNotification;
use App\Notifications\ScheduleNotification;
use App\Notifications\SendMbPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $product = ShopProduct::find($request->product_id)->load('shop_product_categories.company.ifthenPay', 'tax');

        if ($request->shop_product_variation_id) {
            $variation = ShopProductVariation::find($request->shop_product_variation_id);
            $variation_name = $variation->name;
            $price = $variation->price;
            $weight = $variation->weight;
        } else {
            $variation_name = '';
            $price = $product->price;
            $weight = $product->weight;
        }

        // Recupera o carrinho atual da sessão
        $cart = session()->get('cart', []);

        // Verifica se o produto já está no carrinho
        if (array_key_exists($product->id, $cart)) {
            // Atualiza a quantidade do produto no carrinho
            $cart[$product->id]['quantity'] += $request->qty;
        } else {
            // Verifica se o produto é de outra empresa
            if (count($cart) > 0) {
                foreach ($cart as $item) {
                    if ($product->shop_product_categories[0]->company_id != $item['company_id']) {
                        return false;
                    }
                }
            }
            // Adiciona um novo produto ao carrinho
            $cart[$product->id] = [
                'product' => $product,
                'quantity' => $request->qty,
                'company_id' => $product->shop_product_categories[0]->company_id,
                'variation' => $variation_name,
                'price' => $price,
                'weight' => $weight
            ];
        }

        // Atualiza o carrinho na sessão
        session()->put('cart', $cart);

        return true;
    }

    public function showCart()
    {
        return view('website.components.nav_cart');
    }

    public function deleteCart()
    {
        session()->forget('cart');
    }

    public function changeQty($product_id, $qty)
    {

        // Verifique se o item existe na sessão
        if (session()->has('cart') && isset(session('cart')[$product_id])) {
            // Acesse a quantidade atual do item
            $quantidadeAtual = session('cart')[$product_id]['quantity'];

            // Aumente a quantidade em 1
            $quantidadeNova = $qty;

            // Atualize a quantidade na sessão
            session(['cart.' . $product_id . '.quantity' => $quantidadeNova]);
        }

    }

    public function deleteProduct($product_id)
    {
        $cart = session()->get('cart');

        // Procurar o item com o ID correspondente e removê-lo
        foreach ($cart as $index => $item) {
            if ($index === intval($product_id)) {
                unset($cart[$index]);
                break;
            }
        }

        // Atualizar o carrinho na sessão
        session()->put('cart', $cart);
    }

    public function changeSame($address_id)
    {
        $address = Address::find($address_id);
        if ($address->billing_same == true) {
            $address->billing_same = false;
        } else {
            $address->billing_same = true;
        }
        $address->save();
    }

    public function createAddress(Request $request)
    {
        $request->validate([
            'user_id' => [
                'required',
                'integer',
            ],
            'address' => [
                'string',
                'required',
            ],
            'city' => [
                'string',
                'required',
            ],
            'zip' => [
                'string',
                'required',
            ],
            'country_id' => [
                'required',
                'integer',
            ],
            'phone' => [
                'string',
                'nullable',
            ],
            'vat' => [
                'string',
                'nullable',
            ],
        ]);

        $address = new Address;
        $address->user_id = $request->user_id;
        $address->address = $request->address;
        $address->zip = $request->zip;
        $address->city = $request->city;
        $address->country_id = $request->country_id;
        $address->phone = $request->phone;
        $address->vat = $request->vat;
        $address->save();
    }

    public function updateAddress(Request $request)
    {
        $request->validate([
            'address' => [
                'string',
                'required',
            ],
            'city' => [
                'string',
                'required',
            ],
            'zip' => [
                'string',
                'required',
            ],
            'country_id' => [
                'required',
                'integer',
            ],
            'phone' => [
                'string',
                'nullable',
            ],
            'vat' => [
                'string',
                'nullable',
            ],
        ]);

        $address = Address::find($request->address_id);
        $address->address = $request->address;
        $address->zip = $request->zip;
        $address->city = $request->city;
        $address->country_id = $request->country_id;
        $address->phone = $request->phone;
        $address->vat = $request->vat;
        $address->save();
    }

    public function updateBillingAddress(Request $request)
    {
        $request->validate([
            'billing_country_id' => [
                'required',
                'integer',
            ],
            'billing_address' => [
                'string',
                'nullable',
            ],
            'billing_city' => [
                'string',
                'nullable',
            ],
            'billing_zip' => [
                'string',
                'nullable',
            ],
        ]);

        $address = Address::find($request->address_id);
        $address->billing_address = $request->billing_address;
        $address->billing_zip = $request->billing_zip;
        $address->billing_city = $request->billing_city;
        $address->billing_country_id = $request->billing_country_id;
        $address->save();

    }

    public function generatePayments(Request $request)
    {

        $cart = collect();
        $total = 0;
        $weight_array = [];

        foreach ($request->cart as $item) {
            if ($item['weight']) {
                $weight = $item['weight'];
            } else {
                $weight = 0;
            }

            $cart->add($item);
            $total = $total + ($item['price'] * $item['quantity']);
            $weight_array[] = intval($weight) * $item['quantity'];
        }

        $company_id = $cart[0]['product']['shop_product_categories'][0]['company_id'];

        $total_weight = array_sum($weight_array);

        $shop_company = ShopCompany::where('company_id', $company_id)->first();

        $delivery_range = DeliveryRange::where('shop_company_id', $shop_company->id)
            ->where('from', '<=', $total_weight)
            ->where('to', '>=', $total_weight)
            ->first();

        if ($request->delivery == 0) {
            $delivery = 'Recolha na loja';
            $delivery_value = 0;
        } else {
            $delivery = $shop_company->delivery_company;
            if ($delivery_range) {
                $delivery_value = $delivery_range->value;
            } else {
                $delivery_value = $shop_company->minimum_delivery_value;
            }
        }

        $total = $total + $delivery_value;

        $MbWayKey = $cart[0]['product']['shop_product_categories'][0]['company']['ifthen_pay']['mbway_key'];
        $MbKey = $cart[0]['product']['shop_product_categories'][0]['company']['ifthen_pay']['mb_key'];

        $lastPurchase = Purchase::whereHas('product.shop_product_categories', function ($shop_product_categories) use ($company_id) {
            $shop_product_categories->where('company_id', $company_id);
        })->latest()->first();

        $internal = 1;

        if ($lastPurchase) {
            $internal = $lastPurchase->internal + 1;
        }

        $purchase = new Purchase;
        $purchase->type = 'product';
        $purchase->relationship = $cart[0]['product']['id'];
        $purchase->name = $cart[0]['product']['name'];
        $purchase->price = $cart[0]['product']['price'];
        $purchase->vat = $cart[0]['product']['tax']['tax'];
        $purchase->status = 0;
        $purchase->user_id = $request->user['id'];
        $purchase->total = $total;
        $purchase->qty = $cart[0]['quantity'];
        $purchase->cart = json_encode($cart);
        $purchase->address = json_encode($request->address);
        $purchase->method = $request->type;
        $purchase->payed = 0;
        $purchase->internal = $internal;
        $purchase->delivery = $delivery;
        $purchase->delivery_value = $delivery_value;
        $purchase->save();

        if ($request->type == 'mbway') {
            $curl = curl_init();

            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => 'mbway.ifthenpay.com/ifthenpaymbw.asmx/SetPedidoJSON?MbWayKey=' . $MbWayKey . '&canal=03&referencia=' . $purchase->id . '&valor=' . $total . '&nrtlm=' . $request->celphone . '&email=&descricao=',
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
                        "amount": "' . $total . '",
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

        }

        return $response;

    }

    public function checkMbwayPayment($id_payment, $mbway_key)
    {

        $curl = curl_init();

        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'mbway.ifthenpay.com/ifthenpaymbw.asmx/EstadoPedidosJSON?MbWayKey=' . $mbway_key . '&canal=3&idspagamento=' . $id_payment,
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

        // Converte a resposta JSON em uma array
        $data = json_decode($response, true);

        // Verifica se houve um erro ao decodificar o JSON
        if ($data === null) {
            // Retorna uma resposta de erro como JSON
            $error = array(
                'error' => 'Ocorreu um erro ao decodificar o JSON da resposta'
            );
            return json_encode($error);
        }

        return $data['EstadoPedidos'][0]['MsgDescricao'];

    }

    public function sendMbPayment(Request $request)
    {

        $purchase = Purchase::where('id_payment', $request->requestId)->first()->load('user');

        $data = [
            'purchase' => $purchase,
            'user' => $purchase->user,
            'reference' => $request->reference
        ];

        $purchase->user->notify(new SendMbPayment($data));

    }

    public function mbCallback(Request $request)
    {
        $purchase = Purchase::where('id_payment', $request->requestId)->first();
        $mb_antiphishing = json_decode($purchase->cart)[0]->product->shop_product_categories[0]->company->ifthen_pay->mb_antiphishing;

        abort_if($mb_antiphishing != $request->key, Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchase->payed = true;
        $purchase->save();
    }

    public function mbwayCallback(Request $request)
    {

        $purchase = Purchase::where('id_payment', $request->idpedido)->first();
        $mbway_antiphishing = json_decode($purchase->cart)[0]->product->shop_product_categories[0]->company->ifthen_pay->mbway_antiphishing;

        abort_if($mbway_antiphishing != $request->chave, Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchase->payed = true;
        $purchase->save();
    }

    public function shop_schedules(Request $request)
    {

        $service = Service::find($request->service_id)->load('service_duration');

        $start_time = $request->day . ' ' . $request->time . ':00';

        $end_time = Carbon::parse($start_time)->addMinutes($service->service_duration->minutes)->format('Y-m-d H:i:s');

        $client_id = auth()->user()->id;
        $service_employee_id = $request->employee_id;
        $service_id = $request->service_id;

        $shop_schedule = new ShopSchedule;
        $shop_schedule->client_id = $client_id;
        $shop_schedule->service_employee_id = $service_employee_id;
        $shop_schedule->service_id = $service_id;
        $shop_schedule->start_time = $start_time;
        $shop_schedule->end_time = $end_time;
        $shop_schedule->save();

        $shop_schedule->load('service_employee.shop_company.company', 'client', 'service');
        $client_name = $shop_schedule->client->name;
        $client_email = $shop_schedule->client->email;
        $service_name = $shop_schedule->service->name;
        $service_employee_name = $shop_schedule->service_employee->name;
        $company_email = $shop_schedule->service_employee->shop_company->company->email;
        $company_name = $shop_schedule->service_employee->shop_company->company->name;
        $company_address = $shop_schedule->service_employee->shop_company->company->address;
        $company_contacts = $shop_schedule->service_employee->shop_company->contacts;

        $data = [
            'client_name' => $client_name,
            'client_email' => $client_email,
            'service_name' => $service_name,
            'service_employee_name' => $service_employee_name,
            'company_email' => $company_email,
            'company_name' => $company_name,
            'company_address' => $company_address,
            'company_contacts' => $company_contacts,
            'start_time' => $start_time,
            'end_time' => $end_time,
        ];

        //Enviar emails
        Notification::route('mail', [
            $company_email => $company_name,
        ])
            ->notify(new ScheduleNotification($data));

        Notification::route('mail', [
            $client_email => $client_name,
        ])
            ->notify(new ClientScheduleNotification($data));
    }

}