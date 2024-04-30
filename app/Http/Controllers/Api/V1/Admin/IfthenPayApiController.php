<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIfthenPayRequest;
use App\Http\Requests\UpdateIfthenPayRequest;
use App\Http\Resources\Admin\IfthenPayResource;
use App\Models\IfthenPay;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IfthenPayApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('ifthen_pay_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new IfthenPayResource(IfthenPay::with(['company'])->get());
    }

    public function store(StoreIfthenPayRequest $request)
    {
        $ifthenPay = IfthenPay::create($request->all());

        return (new IfthenPayResource($ifthenPay))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(IfthenPay $ifthenPay)
    {
        abort_if(Gate::denies('ifthen_pay_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new IfthenPayResource($ifthenPay->load(['company']));
    }

    public function update(UpdateIfthenPayRequest $request, IfthenPay $ifthenPay)
    {
        $ifthenPay->update($request->all());

        return (new IfthenPayResource($ifthenPay))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(IfthenPay $ifthenPay)
    {
        abort_if(Gate::denies('ifthen_pay_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ifthenPay->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
