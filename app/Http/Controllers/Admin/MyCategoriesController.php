<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreShopCategoryRequest;
use App\Http\Requests\StoreShopProductCategoryRequest;
use App\Http\Requests\UpdateShopProductCategoryRequest;
use App\Models\ShopCategory;
use App\Models\ShopProductCategory;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MyCategoriesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('my_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $company_id = User::where('id', auth()->user()->id)->with('company')->first()->company[0]->id;

        $shopProductCategories = ShopProductCategory::where([
            'company_id' => $company_id
        ])->get();

        return view('admin.myCategories.index', compact('shopProductCategories'));
    }

    public function create()
    {
        abort_if(Gate::denies('my_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $company = User::where('id', auth()->user()->id)->with('company')->first()->company[0];

        return view('admin.myCategories.create', compact('company'));
    }

    public function edit(Request $request)
    {
        abort_if(Gate::denies('my_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $company = User::where('id', auth()->user()->id)->with('company')->first()->company[0];

        $shopProductCategory = ShopProductCategory::find($request->id);

        return view('admin.myCategories.edit', compact('company', 'shopProductCategory'));
    }

    public function destroy(Request $request)
    {

        abort_if(Gate::denies('my_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shopProductCategory = ShopProductCategory::find($request->id);
        $shopProductCategory->delete();

        return back();
    }

}