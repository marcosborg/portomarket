<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyServiceDurationRequest;
use App\Http\Requests\StoreServiceDurationRequest;
use App\Http\Requests\UpdateServiceDurationRequest;
use App\Models\ServiceDuration;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ServiceDurationController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('service_duration_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $serviceDurations = ServiceDuration::all();

        return view('admin.serviceDurations.index', compact('serviceDurations'));
    }

    public function create()
    {
        abort_if(Gate::denies('service_duration_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.serviceDurations.create');
    }

    public function store(StoreServiceDurationRequest $request)
    {
        $serviceDuration = ServiceDuration::create($request->all());

        return redirect()->route('admin.service-durations.index');
    }

    public function edit(ServiceDuration $serviceDuration)
    {
        abort_if(Gate::denies('service_duration_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.serviceDurations.edit', compact('serviceDuration'));
    }

    public function update(UpdateServiceDurationRequest $request, ServiceDuration $serviceDuration)
    {
        $serviceDuration->update($request->all());

        return redirect()->route('admin.service-durations.index');
    }

    public function show(ServiceDuration $serviceDuration)
    {
        abort_if(Gate::denies('service_duration_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.serviceDurations.show', compact('serviceDuration'));
    }

    public function destroy(ServiceDuration $serviceDuration)
    {
        abort_if(Gate::denies('service_duration_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $serviceDuration->delete();

        return back();
    }

    public function massDestroy(MassDestroyServiceDurationRequest $request)
    {
        $serviceDurations = ServiceDuration::find(request('ids'));

        foreach ($serviceDurations as $serviceDuration) {
            $serviceDuration->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
