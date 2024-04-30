<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreShopCategoryRequest;
use App\Http\Requests\UpdateShopCategoryRequest;
use App\Http\Resources\Admin\ShopCategoryResource;
use App\Models\ShopCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ShopCategoryApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        //abort_if(Gate::denies('shop_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ShopCategoryResource(ShopCategory::inRandomOrder()->get());
    }

    public function store(StoreShopCategoryRequest $request)
    {
        $shopCategory = ShopCategory::create($request->all());

        if ($request->input('image', false)) {
            $shopCategory->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        return (new ShopCategoryResource($shopCategory))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ShopCategory $shopCategory)
    {
        abort_if(Gate::denies('shop_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ShopCategoryResource($shopCategory);
    }

    public function update(UpdateShopCategoryRequest $request, ShopCategory $shopCategory)
    {
        $shopCategory->update($request->all());

        if ($request->input('image', false)) {
            if (!$shopCategory->image || $request->input('image') !== $shopCategory->image->file_name) {
                if ($shopCategory->image) {
                    $shopCategory->image->delete();
                }
                $shopCategory->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($shopCategory->image) {
            $shopCategory->image->delete();
        }

        return (new ShopCategoryResource($shopCategory))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ShopCategory $shopCategory)
    {
        abort_if(Gate::denies('shop_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shopCategory->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}