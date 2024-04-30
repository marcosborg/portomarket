<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyIfthenPayRequest;
use App\Http\Requests\StoreIfthenPayRequest;
use App\Http\Requests\UpdateIfthenPayRequest;
use App\Models\Company;
use App\Models\IfthenPay;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IfthenPayController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('ifthen_pay_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ifthenPays = IfthenPay::with(['company'])->get();

        return view('admin.ifthenPays.index', compact('ifthenPays'));
    }

    public function create()
    {
        abort_if(Gate::denies('ifthen_pay_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $companies = Company::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.ifthenPays.create', compact('companies'));
    }

    public function store(StoreIfthenPayRequest $request)
    {
        $ifthenPay = IfthenPay::create($request->all());

        return redirect()->route('admin.ifthen-pays.index');
    }

    public function edit(IfthenPay $ifthenPay)
    {
        abort_if(Gate::denies('ifthen_pay_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $companies = Company::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $ifthenPay->load('company');

        return view('admin.ifthenPays.edit', compact('companies', 'ifthenPay'));
    }

    public function update(UpdateIfthenPayRequest $request, IfthenPay $ifthenPay)
    {
        $ifthenPay->update($request->all());

        return redirect()->route('admin.ifthen-pays.index');
    }

    public function show(IfthenPay $ifthenPay)
    {
        abort_if(Gate::denies('ifthen_pay_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ifthenPay->load('company');

        return view('admin.ifthenPays.show', compact('ifthenPay'));
    }

    public function destroy(IfthenPay $ifthenPay)
    {
        abort_if(Gate::denies('ifthen_pay_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ifthenPay->delete();

        return back();
    }

    public function massDestroy(MassDestroyIfthenPayRequest $request)
    {
        $ifthenPays = IfthenPay::find(request('ids'));

        foreach ($ifthenPays as $ifthenPay) {
            $ifthenPay->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
