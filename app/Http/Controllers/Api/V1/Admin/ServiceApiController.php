<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Http\Resources\Admin\ServiceResource;
use App\Models\Service;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ServiceApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        //abort_if(Gate::denies('service_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ServiceResource(Service::with(['shop_company.company', 'service_duration', 'shop_product_categories', 'shop_product_sub_categories', 'tax'])->get());
    }

    public function store(StoreServiceRequest $request)
    {
        $service = Service::create($request->all());
        $service->shop_product_categories()->sync($request->input('shop_product_categories', []));
        $service->shop_product_sub_categories()->sync($request->input('shop_product_sub_categories', []));
        foreach ($request->input('photos', []) as $file) {
            $service->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('photos');
        }

        if ($request->input('attachment', false)) {
            $service->addMedia(storage_path('tmp/uploads/' . basename($request->input('attachment'))))->toMediaCollection('attachment');
        }

        return (new ServiceResource($service))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Service $service)
    {
        //abort_if(Gate::denies('service_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ServiceResource($service->load(['shop_company.company', 'shop_company.shop_company_schedules', 'service_employees', 'shop_company.shop_location', 'service_duration', 'shop_product_categories', 'shop_product_sub_categories', 'tax']));
    }

    public function update(UpdateServiceRequest $request, Service $service)
    {
        $service->update($request->all());
        $service->shop_product_categories()->sync($request->input('shop_product_categories', []));
        $service->shop_product_sub_categories()->sync($request->input('shop_product_sub_categories', []));
        if (count($service->photos) > 0) {
            foreach ($service->photos as $media) {
                if (!in_array($media->file_name, $request->input('photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $service->photos->pluck('file_name')->toArray();
        foreach ($request->input('photos', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $service->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('photos');
            }
        }

        if ($request->input('attachment', false)) {
            if (!$service->attachment || $request->input('attachment') !== $service->attachment->file_name) {
                if ($service->attachment) {
                    $service->attachment->delete();
                }
                $service->addMedia(storage_path('tmp/uploads/' . basename($request->input('attachment'))))->toMediaCollection('attachment');
            }
        } elseif ($service->attachment) {
            $service->attachment->delete();
        }

        return (new ServiceResource($service))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Service $service)
    {
        abort_if(Gate::denies('service_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $service->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function shopServicesByCategoryProduct(Request $request)
    {
        $services = Service::whereHas('shop_product_categories', function ($service) use ($request) {
            $service->where('id', $request->id);
        })
            ->paginate(10);
        return $services;
    }

    public function shopServicesBySubcategoryProduct(Request $request)
    {
        $services = Service::with([
            'shop_product_categories'
        ])
            ->whereHas('shop_product_sub_categories', function ($query) use ($request) {
                $query->where('id', $request->id);
            })
            ->paginate(10);

        return $services;
    }

    public function randomServices()
    {
        $services = Service::inRandomOrder()->take(20)->get();
        return $services;
    }
}