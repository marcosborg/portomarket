<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Newsletter;
use App\Models\Page;
use App\Models\Register;
use App\Models\Plan;
use App\Models\User;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class WebsiteController extends Controller
{

    use MediaUploadingTrait;

    public function __construct()
    {
        view()->share('pages', Page::all());

    }
    public function index()
    {
        return view('website.pages.home');
    }

    public function contact(Request $request)
    {

        $request->validate([
            'company_name' => 'required',
            'email' => 'email:rfc,dns|required',
            'name' => 'required',
        ], [], [
            'company_name' => 'Nome da empresa',
            'email' => 'Email',
            'name' => 'Nome de contacto',
        ]);

        $register = new Register;
        $register->company_name = $request->company_name;
        $register->email = $request->email;
        $register->message = $request->message;
        $register->name = $request->name;
        $register->phone = $request->phone;
        $register->save();

        return [];
    }

    public function newsletter(Request $request)
    {

        $request->validate([
            'email' => 'email:rfc,dns|required'
        ], [
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'O email tem que ser válido.'
        ]);

        $newsletter = new Newsletter;
        $newsletter->email = $request->email;
        $newsletter->save();

        return [];
    }

    public function register()
    {

        $plans = Plan::with([
            'items'
        ])->get();

        return view('website.pages.register')->with([
            'plans' => $plans
        ]);
    }

    public function selectedRegister(Request $request)
    {
        $plan = Plan::where('id', $request->plan_id)
            ->with([
                'items',
                'subscriptionTypes'
            ])
            ->first();
        return view('website.pages.selected-register')->with('plan', $plan);
    }

    public function formRegister(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email:rfc,dns|unique:App\Models\User,email',
            'password' => [
                'required',
                'min:8',
                'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[\W_]).{8,}$/',
                'confirmed',
            ],
            'company' => 'required',
            'vat' => 'required',
            'address' => 'required',
            'zip' => 'required',
            'location' => 'required',
        ], [
            'name.required' => 'O nome é obrigatório.',
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'O email tem de ser válido.',
            'password.min' => 'A password deve ter no mínimo 8 caracteres.',
            'password.regex' => 'A password deve ter um comprimento mínimo de 8 caracteres, deve conter pelo menos uma letra minúscula, uma letra maiúscula, um número e um caractere especial.',
            'password.confirmed' => 'A confirmação de password deve corresponder ao campo password.',
            'company.required' => 'O nome da empresa é obrigatório.',
            'vat.required' => 'O contribuinte é obrigatório.',
            'address.required' => 'O endereço é obrigatório.',
            'zip.required' => 'O código postal é obrigatório.',
            'location.required' => 'A localidade é obrigatória.',
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        $users = [
            $user->id
        ];
        $company = new Company;
        $company->name = $request->company;
        $company->vat = $request->vat;
        $company->address = $request->address;
        $company->zip = $request->zip;
        $company->location = $request->location;
        $company->email = $request->email;
        $company->save();
        $company->users()->sync($users);

        if ($request->input('logo', false)) {
            $company->addMedia(storage_path('tmp/uploads/' . basename($request->input('logo'))))->toMediaCollection('logo');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $company->id]);
        }

        $user->roles()->sync([2]);

        $subscription = new Subscription;
        $subscription->start_date = date('Y-m-d H:i:s');
        $subscription->end_date = date('Y-m-d H:i:s');
        $subscription->user_id = $user->id;
        $subscription->subscription_type_id = $request->subscription_type_id;
        $subscription->save();

        Auth::attempt(['email' => $request->email, 'password' => $request->password]);

        return [];
    }

    public function politicaDePrivacidade()
    {

        $page = Page::find(2);

        return view('website.pages.politica_de_privacidade', compact('page'));
    }

    public function termosECondicoes()
    {

        $page = Page::find(1);

        return view('website.pages.politica_de_privacidade', compact('page'));
    }

    public function accountDelete()
    {
        return view('website.pages.account_delete');
    }

    public function deleteAccount(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        return redirect()->back()->with('message', 'Eliminado com sucesso.');

    }

    public function mobile(Request $request)
    {
        $userAgent = $request->header('User-Agent');
        // Detectar dispositivos iOS
        if (stripos($userAgent, 'iPhone') !== false || stripos($userAgent, 'iPad') !== false) {
            return redirect()->away('https://apps.apple.com/pt/app/id6470311626');
        }
        // Detectar dispositivos Android
        elseif (stripos($userAgent, 'Android') !== false) {
            return redirect()->away('https://play.google.com/store/apps/details?id=pt.comerciodacidade.app');
        }
        // Caso não seja nem iOS nem Android, redirecionar para um local padrão (opcional)
        else {
            return redirect()->to('https://comerciodacidade.pt/lojas');
        }
    }
}