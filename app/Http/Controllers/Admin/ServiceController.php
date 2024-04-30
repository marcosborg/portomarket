<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyServiceRequest;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use App\Models\ServiceDuration;
use App\Models\ShopCompany;
use App\Models\ShopProductCategory;
use App\Models\ShopProductSubCategory;
use App\Models\ShopTax;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class ServiceController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('service_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $services = Service::with(['shop_company', 'service_duration', 'shop_product_categories', 'shop_product_sub_categories', 'tax', 'media'])->get();

        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        abort_if(Gate::denies('service_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shop_companies = ShopCompany::pluck('contacts', 'id')->prepend(trans('global.pleaseSelect'), '');

        $service_durations = ServiceDuration::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $shop_product_categories = ShopProductCategory::pluck('name', 'id');

        $shop_product_sub_categories = ShopProductSubCategory::pluck('name', 'id');

        $taxes = ShopTax::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.services.create', compact('service_durations', 'shop_companies', 'shop_product_categories', 'shop_product_sub_categories', 'taxes'));
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

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $service->id]);
        }

        if (!$request->shop_company_id) {
            return redirect()->route('admin.services.index');
        } else {
            return redirect('admin/my-services');
        }

    }

    public function edit(Service $service)
    {
        abort_if(Gate::denies('service_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shop_companies = ShopCompany::pluck('contacts', 'id')->prepend(trans('global.pleaseSelect'), '');

        $service_durations = ServiceDuration::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $shop_product_categories = ShopProductCategory::pluck('name', 'id');

        $shop_product_sub_categories = ShopProductSubCategory::pluck('name', 'id');

        $taxes = ShopTax::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $service->load('shop_company', 'service_duration', 'shop_product_categories', 'shop_product_sub_categories', 'tax');

        return view('admin.services.edit', compact('service', 'service_durations', 'shop_companies', 'shop_product_categories', 'shop_product_sub_categories', 'taxes'));
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

        if (!$request->myService) {
            return redirect()->route('admin.services.index');
        } else {
            return redirect()->back()->with('message', 'Atualizado com secesso.');
        }

    }

    public function show(Service $service)
    {
        abort_if(Gate::denies('service_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $service->load('shop_company', 'service_duration', 'shop_product_categories', 'shop_product_sub_categories', 'tax');

        return view('admin.services.show', compact('service'));
    }

    public function destroy(Service $service)
    {

        $allow = false;

        if (Gate::allows('service_delete') || Gate::allows('my_service_access')) {
            $allow = true;
        }

        abort_if($allow == false, Response::HTTP_FORBIDDEN, '403 Forbidden');

        $service->delete();

        return back();
    }

    public function massDestroy(MassDestroyServiceRequest $request)
    {
        $services = Service::find(request('ids'));

        foreach ($services as $service) {
            $service->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('service_create') && Gate::denies('service_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model = new Service();
        $model->id = $request->input('crud_id', 0);
        $model->exists = true;
        $media = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}