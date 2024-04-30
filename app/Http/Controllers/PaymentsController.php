<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\SubscriptionPayment;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\SendMbByEmail;

class PaymentsController extends Controller
{
    public function mb(Request $request)
    {
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
                    "mbKey": "HEZ-354674",
                    "orderId": ' . $request->subscriptionPayment . ',
                    "amount": ' . $request->amount . '
                }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                ),
            )
        );

        $response = curl_exec($curl);

        curl_close($curl);

        $mb = json_decode($response, true);

        return view('partials.mb')->with([
            'amount' => $mb['Amount'],
            'entity' => $mb['Entity'],
            'reference' => $mb['Reference'],
        ]);

    }

    public function subscriptionPaymentGenerate(Request $request)
    {

        $subscription = Subscription::find($request->subscription_id);
        $subscription->subscription_type_id = $request->subscription_type_id;
        $subscription->save();

        $subscriptionPayment = new SubscriptionPayment;
        $subscriptionPayment->subscription_id = $request->subscription_id;
        $subscriptionPayment->value = $request->value;
        $subscriptionPayment->method = $request->method;
        $subscriptionPayment->paid = $request->paid;
        $subscriptionPayment->save();

        return $subscriptionPayment;
    }

    public function sendMbByEmail(Request $request)
    {
        User::find(auth()->user()->id)->notify(new SendMbByEmail($request->body));
        return [];
    }

    public function mbway(Request $request)
    {

        $subscription_payment_id = $request->subscriptionPayment;
        $amount = $request->amount;

        return view('partials.mbway')->with([
            'referencia' => $subscription_payment_id,
            'valor' => $amount
        ]);
    }

    public function submitMbway(Request $request)
    {

        $curl = curl_init();

        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'https://mbway.ifthenpay.com/ifthenpaymbw.asmx/SetPedidoJSON?MbWayKey=BGU-477297&canal=03&referencia=' . $request->referencia . '&valor=' . $request->valor . '&nrtlm=' . $request->nrtlm . '&email=&descricao=ComercioDaCidade',
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
        echo $response;


    }

    public function list()
    {

        $subscriptionPayments = SubscriptionPayment::with('subscription')->whereHas('subscription', function ($query) {
            $query->where('user_id', auth()->user()->id);
        })->get();
        
        return view('partials.payments')->with([
            'subscriptionPayments' => $subscriptionPayments
        ]);
    }

    public function selectSubscriptionType(Request $request)
    {
        return $request;
    }

}