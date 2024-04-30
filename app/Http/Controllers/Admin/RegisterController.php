<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyRegisterRequest;
use App\Http\Requests\StoreRegisterRequest;
use App\Http\Requests\UpdateRegisterRequest;
use App\Models\Register;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('register_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $registers = Register::all();

        return view('admin.registers.index', compact('registers'));
    }

    public function create()
    {
        abort_if(Gate::denies('register_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.registers.create');
    }

    public function store(StoreRegisterRequest $request)
    {
        $register = Register::create($request->all());

        return redirect()->route('admin.registers.index');
    }

    public function edit(Register $register)
    {
        abort_if(Gate::denies('register_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.registers.edit', compact('register'));
    }

    public function update(UpdateRegisterRequest $request, Register $register)
    {
        $register->update($request->all());

        return redirect()->route('admin.registers.index');
    }

    public function show(Register $register)
    {
        abort_if(Gate::denies('register_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.registers.show', compact('register'));
    }

    public function destroy(Register $register)
    {
        abort_if(Gate::denies('register_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $register->delete();

        return back();
    }

    public function massDestroy(MassDestroyRegisterRequest $request)
    {
        $registers = Register::find(request('ids'));

        foreach ($registers as $register) {
            $register->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
