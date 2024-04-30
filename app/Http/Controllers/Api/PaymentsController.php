<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Subscription;
use App\Models\SubscriptionPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function mb(Request $request)
    {

        $subscriptionPayment = SubscriptionPayment::find($request->orderId);
        $subscriptionPayment->paid = true;
        $subscriptionPayment->save();

        $subscription = Subscription::where('id', $subscriptionPayment->subscription_id)
        ->with([
            'subscription_type',
            'user.roles'
        ])
        ->first();
        
        $start_date = $subscription->end_date;
        $months = $subscription->subscription_type->months;
        $subscription->end_date = Carbon::parse($start_date)->addMonths($months);
        $subscription->start_date = date('Y-m-d H:i:s');
        $subscription->save();

        $roles = [];
        if($subscription->user->roles()->where('title', 'Admin')->exists()){
            $roles[] = 1;
        }
        $roles[] = 2;
        $roles[] = Role::where('title', $subscription->subscription_type->plan->name)->first()->id;

        $subscription->user->roles()->sync($roles);

        return $roles;

    }

    public function mbway(Request $request)
    {

        $subscriptionPayment = SubscriptionPayment::find($request->referencia);
        $subscriptionPayment->paid = true;
        $subscriptionPayment->save();

        $subscription = Subscription::where('id', $subscriptionPayment->subscription_id)
        ->with([
            'subscription_type'
        ])
        ->first();

        $start_date = $subscription->end_date;
        $months = $subscription->subscription_type->months;
        $subscription->end_date = Carbon::parse($start_date)->addMonths($months);
        $subscription->start_date = date('Y-m-d H:i:s');
        $subscription->save();
        
        $roles = [];
        if($subscription->user->roles()->where('title', 'Admin')->exists()){
            $roles[] = 1;
        }
        $roles[] = 2;
        $roles[] = Role::where('title', $subscription->subscription_type->plan->name)->first()->id;

        $subscription->user->roles()->sync($roles);

        return $roles;

    }
}