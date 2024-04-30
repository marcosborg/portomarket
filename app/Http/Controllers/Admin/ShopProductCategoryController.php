<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyShopProductCategoryRequest;
use App\Http\Requests\StoreShopProductCategoryRequest;
use App\Http\Requests\UpdateShopProductCategoryRequest;
use App\Models\Company;
use App\Models\ShopProductCategory;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class ShopProductCategoryController extends Controller
{

    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('shop_product_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shopProductCategories = ShopProductCategory::with(['company', 'media'])->get();

        return view('admin.shopProductCategories.index', compact('shopProductCategories'));
    }

    public function create()
    {
        abort_if(Gate::denies('shop_product_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $companies = Company::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.shopProductCategories.create', compact('companies'));
    }

    public function store(StoreShopProductCategoryRequest $request)
    {
        $shopProductCategory = ShopProductCategory::create($request->all());

        if ($request->input('image', false)) {
            $shopProductCategory->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $shopProductCategory->id]);
        }

        if ($request->shopProductCategory) {
            return redirect('/admin/my-categories')->with('message', 'Criado com sucesso.');
        } else {
            return redirect()->route('admin.shop-product-categories.index');
        }

    }

    public function edit(ShopProductCategory $shopProductCategory)
    {
        abort_if(Gate::denies('shop_product_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $companies = Company::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $shopProductCategory->load('company');

        return view('admin.shopProductCategories.edit', compact('companies', 'shopProductCategory'));
    }

    public function update(UpdateShopProductCategoryRequest $request, ShopProductCategory $shopProductCategory)
    {
        $shopProductCategory->update($request->all());

        if ($request->input('image', false)) {
            if (!$shopProductCategory->image || $request->input('image') !== $shopProductCategory->image->file_name) {
                if ($shopProductCategory->image) {
                    $shopProductCategory->image->delete();
                }
                $shopProductCategory->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($shopProductCategory->image) {
            $shopProductCategory->image->delete();
        }

        if ($request->shopProductCategory) {
            return redirect('/admin/my-categories/edit/' . $request->id)->with('message', 'Atualizado com sucesso.');
        } else {
            return redirect()->route('admin.shop-product-categories.index');
        }

    }

    public function show(ShopProductCategory $shopProductCategory)
    {
        abort_if(Gate::denies('shop_product_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shopProductCategory->load('company');

        return view('admin.shopProductCategories.show', compact('shopProductCategory'));
    }

    public function destroy(ShopProductCategory $shopProductCategory)
    {
        abort_if(Gate::denies('shop_product_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shopProductCategory->delete();

        return back();
    }

    public function massDestroy(MassDestroyShopProductCategoryRequest $request)
    {
        $shopProductCategories = ShopProductCategory::find(request('ids'));

        foreach ($shopProductCategories as $shopProductCategory) {
            $shopProductCategory->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('shop_product_category_create') && Gate::denies('shop_product_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model = new ShopProductCategory();
        $model->id = $request->input('crud_id', 0);
        $model->exists = true;
        $media = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}