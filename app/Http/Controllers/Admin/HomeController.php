<?php

namespace App\Http\Controllers\Admin;

use App\Models\SubscriptionType;
use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\User;

class HomeController
{
    public function index()
    {
        $user = User::where('id', auth()->user()->id)
            ->with([
                'subscription.subscription_type.plan',
                'subscription.subscriptionPayments.subscription.subscription_type.plan',
                'company.shop_company'
            ])->first();

        $plans = Plan::with([
            'subscriptionTypes.plan'
        ])
            ->get();

        return view('home')->with([
            'plans' => $plans,
            'user' => $user
        ]);
    }

    public function subscriptionType(Request $request)
    {
        return SubscriptionType::with('plan')->where('id', $request->subscription_type_id)->first();
    }

}