<?php

namespace App\Http\Middleware;

use App\Models\Subscription;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        $subscription = Subscription::where('user_id', $user->id)->first();
        if($subscription && $subscription->end_date < date('Y-m-d H:i:s')){
            foreach ($user->roles as $role) {
                if($role->id > 2){
                    $roleToRemove = $role->id;
                }
            }
            if(isset($roleToRemove)){
                $user->roles()->detach($roleToRemove);
            }
        }
        
        return $next($request);
    }
}
