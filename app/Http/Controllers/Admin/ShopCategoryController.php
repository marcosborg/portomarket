<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyShopCategoryRequest;
use App\Http\Requests\StoreShopCategoryRequest;
use App\Http\Requests\UpdateShopCategoryRequest;
use App\Models\ShopCategory;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class ShopCategoryController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('shop_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shopCategories = ShopCategory::with(['media'])->get();

        return view('admin.shopCategories.index', compact('shopCategories'));
    }

    public function create()
    {
        abort_if(Gate::denies('shop_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.shopCategories.create');
    }

    public function store(StoreShopCategoryRequest $request)
    {
        $shopCategory = ShopCategory::create($request->all());

        if ($request->input('image', false)) {
            $shopCategory->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $shopCategory->id]);
        }

        return redirect()->route('admin.shop-categories.index');
    }

    public function edit(ShopCategory $shopCategory)
    {
        abort_if(Gate::denies('shop_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.shopCategories.edit', compact('shopCategory'));
    }

    public function update(UpdateShopCategoryRequest $request, ShopCategory $shopCategory)
    {
        $shopCategory->update($request->all());

        if ($request->input('image', false)) {
            if (! $shopCategory->image || $request->input('image') !== $shopCategory->image->file_name) {
                if ($shopCategory->image) {
                    $shopCategory->image->delete();
                }
                $shopCategory->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($shopCategory->image) {
            $shopCategory->image->delete();
        }

        return redirect()->route('admin.shop-categories.index');
    }

    public function show(ShopCategory $shopCategory)
    {
        abort_if(Gate::denies('shop_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.shopCategories.show', compact('shopCategory'));
    }

    public function destroy(ShopCategory $shopCategory)
    {
        abort_if(Gate::denies('shop_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shopCategory->delete();

        return back();
    }

    public function massDestroy(MassDestroyShopCategoryRequest $request)
    {
        $shopCategories = ShopCategory::find(request('ids'));

        foreach ($shopCategories as $shopCategory) {
            $shopCategory->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('shop_category_create') && Gate::denies('shop_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new ShopCategory();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}