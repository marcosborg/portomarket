<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreShopCompanyRequest;
use App\Http\Requests\UpdateShopCompanyRequest;
use App\Http\Resources\Admin\ShopCompanyResource;
use App\Models\ShopCompany;
use App\Models\ShopProductCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ShopCompanyApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        //abort_if(Gate::denies('shop_company_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ShopCompanyResource(ShopCompany::with(['company', 'shop_location'])->get());
    }

    public function companiesByCategory(Request $request)
    {
        $shopCompanies = ShopCompany::with([
            'shop_categories',
            'company'
        ])->whereHas('shop_categories', function ($query) use ($request) {
            $query->where('id', $request->category_id);
        })->get();
        return $shopCompanies;
    }

    public function companyByProductCategory(Request $request)
    {
        $shopProductCategory = ShopProductCategory::where([
            'id' => $request->id
        ])
            ->with([
                'company'
            ])
            ->first();
        return $shopProductCategory;
    }

    public function store(StoreShopCompanyRequest $request)
    {
        $shopCompany = ShopCompany::create($request->all());

        foreach ($request->input('photos', []) as $file) {
            $shopCompany->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('photos');
        }

        return (new ShopCompanyResource($shopCompany))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ShopCompany $shopCompany)
    {
        abort_if(Gate::denies('shop_company_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ShopCompanyResource($shopCompany->load(['company', 'shop_location']));
    }

    public function update(UpdateShopCompanyRequest $request, ShopCompany $shopCompany)
    {
        $shopCompany->update($request->all());

        if (count($shopCompany->photos) > 0) {
            foreach ($shopCompany->photos as $media) {
                if (!in_array($media->file_name, $request->input('photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $shopCompany->photos->pluck('file_name')->toArray();
        foreach ($request->input('photos', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $shopCompany->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('photos');
            }
        }

        return (new ShopCompanyResource($shopCompany))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ShopCompany $shopCompany)
    {
        abort_if(Gate::denies('shop_company_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shopCompany->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}