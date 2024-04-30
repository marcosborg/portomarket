<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyShopCompanyRequest;
use App\Http\Requests\StoreShopCompanyRequest;
use App\Http\Requests\UpdateShopCompanyRequest;
use App\Models\Company;
use App\Models\ShopCategory;
use App\Models\ShopCompany;
use App\Models\ShopLocation;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class ShopCompanyController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('shop_company_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shopCompanies = ShopCompany::with(['company', 'shop_location', 'shop_categories', 'media'])->get();

        return view('admin.shopCompanies.index', compact('shopCompanies'));
    }

    public function create()
    {
        abort_if(Gate::denies('shop_company_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $companies = Company::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $shop_locations = ShopLocation::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $shop_categories = ShopCategory::pluck('name', 'id');

        return view('admin.shopCompanies.create', compact('companies', 'shop_categories', 'shop_locations'));
    }

    public function store(StoreShopCompanyRequest $request)
    {
        $shopCompany = ShopCompany::create($request->all());
        $shopCompany->shop_categories()->sync($request->input('shop_categories', []));
        foreach ($request->input('photos', []) as $file) {
            $shopCompany->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('photos');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $shopCompany->id]);
        }

        return redirect()->route('admin.shop-companies.index');
    }

    public function edit(ShopCompany $shopCompany)
    {
        abort_if(Gate::denies('shop_company_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $companies = Company::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $shop_locations = ShopLocation::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $shop_categories = ShopCategory::pluck('name', 'id');

        $shopCompany->load('company', 'shop_location', 'shop_categories');

        return view('admin.shopCompanies.edit', compact('companies', 'shopCompany', 'shop_categories', 'shop_locations'));
    }

    public function update(UpdateShopCompanyRequest $request, ShopCompany $shopCompany)
    {
        $shopCompany->update($request->all());
        $shopCompany->shop_categories()->sync($request->input('shop_categories', []));
        if (count($shopCompany->photos) > 0) {
            foreach ($shopCompany->photos as $media) {
                if (! in_array($media->file_name, $request->input('photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $shopCompany->photos->pluck('file_name')->toArray();
        foreach ($request->input('photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $shopCompany->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('photos');
            }
        }

        return redirect()->route('admin.shop-companies.index');
    }

    public function show(ShopCompany $shopCompany)
    {
        abort_if(Gate::denies('shop_company_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shopCompany->load('company', 'shop_location', 'shop_categories');

        return view('admin.shopCompanies.show', compact('shopCompany'));
    }

    public function destroy(ShopCompany $shopCompany)
    {
        abort_if(Gate::denies('shop_company_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shopCompany->delete();

        return back();
    }

    public function massDestroy(MassDestroyShopCompanyRequest $request)
    {
        $shopCompanies = ShopCompany::find(request('ids'));

        foreach ($shopCompanies as $shopCompany) {
            $shopCompany->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('shop_company_create') && Gate::denies('shop_company_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new ShopCompany();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}