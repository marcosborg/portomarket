<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Country;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('client_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shop_company = User::find(auth()->user()->id)->load('company.shop_company')->company[0]->shop_company;

        $clients = User::whereHas('shop_schedules', function ($shopSchedules) use ($shop_company) {
            $shopSchedules->whereHas('service_employee', function ($serviceEmployee) use ($shop_company) {
                $serviceEmployee->whereHas('shop_company', function ($shopCompany) use ($shop_company) {
                    $shopCompany->where('id', $shop_company->id);
                });
            });
        })
            ->get()->load([
                'address'
            ])
            ->unique('id');

        $countries = Country::all();

        return view('admin.clients.index', compact('clients', 'countries'));
    }

    public function newClient(Request $request)
    {
        $request->validate([
            'name' => [
                'string',
                'required',
            ],
            'email' => [
                'required',
                'unique:users',
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
                'required',
            ],
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make(Str::password());
        $user->save();

        $address = new Address;
        $address->user_id = $user->id;
        $address->address = $request->address;
        $address->city = $request->city;
        $address->zip = $request->zip;
        $address->country_id = $request->country_id;
        $address->phone = $request->phone;
        $address->save();

    }

    public function details(Request $request)
    {
        
        $client = User::find($request->client_id)->load('address.country');

        return $client;

    }

}