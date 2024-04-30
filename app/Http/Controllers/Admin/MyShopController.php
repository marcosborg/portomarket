<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreShopCompanyRequest;
use App\Http\Requests\UpdateShopCompanyRequest;
use App\Models\ShopCategory;
use App\Models\ShopCompany;
use App\Models\ShopCompanySchedule;
use App\Models\ShopLocation;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class MyShopController extends Controller
{

    use MediaUploadingTrait;

    public function index(ShopCompany $shopCompany)
    {
        abort_if(Gate::denies('my_shop_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shopCompany = User::where('id', auth()->user()->id)
            ->with('company.shop_company')->first()->company[0]->shop_company;

        $shopCompanySchedule = ShopCompanySchedule::where('shop_company_id', $shopCompany->id)->firstOrNew();
        $shopCompanySchedule->shop_company_id = $shopCompany->id;
        $shopCompanySchedule->save();

        $user = User::where('id', auth()->user()->id)
            ->with([
                'subscription.subscription_type.plan',
                'subscription.subscriptionPayments.subscription.subscription_type.plan',
                'company.shop_company',
                'company.shop_company.shop_company_schedules'
            ])->first();

        $shop_locations = ShopLocation::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $shop_categories = ShopCategory::pluck('name', 'id');

        return view('admin.myShops.index', compact('user', 'shopCompany', 'shop_categories', 'shop_locations'));
    }

    public function create()
    {
        abort_if(Gate::denies('my_shop_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $company = User::where('id', auth()->user()->id)->with('company')->first()->company[0];

        $shop_locations = ShopLocation::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $shop_categories = ShopCategory::pluck('name', 'id');

        return view('admin.myShops.create', compact('company', 'shop_categories', 'shop_locations'));

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

        $shopCompanySchedule = new ShopCompanySchedule;
        $shopCompanySchedule->shop_company_id = $shopCompany->id;
        $shopCompany->save();

        return redirect()->route('admin.my-shops.index');
    }

    public function update(UpdateShopCompanyRequest $request, ShopCompany $shopCompany)
    {

        $shopCompanyUpdate = ShopCompany::find($request->id);
        $shopCompanyUpdate->about = $request->about;
        $shopCompanyUpdate->contacts = $request->contacts;
        $shopCompanyUpdate->youtube = $request->youtube;
        $shopCompanyUpdate->address = $request->address;
        $shopCompanyUpdate->latitude = $request->latitude;
        $shopCompanyUpdate->longitude = $request->longitude;

        $shopCompanyUpdate->shop_categories()->sync($request->shop_categories);

        $shopCompanyUpdate->save();

        if (count($shopCompanyUpdate->photos) > 0) {
            foreach ($shopCompanyUpdate->photos as $media) {
                if (!in_array($media->file_name, $request->input('photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $shopCompanyUpdate->photos->pluck('file_name')->toArray();
        foreach ($request->input('photos', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $shopCompanyUpdate->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('photos');
            }
        }

        $shopCompanySchedule = ShopCompanySchedule::where('shop_company_id', $request->id)->firstOrNew();
        $shopCompanySchedule->shop_company_id = $request->id;
        $shopCompanySchedule->monday_morning_opening = $request->monday_morning_opening;
        $shopCompanySchedule->monday_morning_closing = $request->monday_morning_closing;
        $shopCompanySchedule->monday_afternoon_opening = $request->monday_afternoon_opening;
        $shopCompanySchedule->monday_afternoon_closing = $request->monday_afternoon_closing;
        $shopCompanySchedule->tuesday_morning_opening = $request->tuesday_morning_opening;
        $shopCompanySchedule->tuesday_morning_closing = $request->tuesday_morning_closing;
        $shopCompanySchedule->tuesday_afternoon_opening = $request->tuesday_afternoon_opening;
        $shopCompanySchedule->tuesday_afternoon_closing = $request->tuesday_afternoon_closing;
        $shopCompanySchedule->wednesday_morning_opening = $request->wednesday_morning_opening;
        $shopCompanySchedule->wednesday_morning_closing = $request->wednesday_morning_closing;
        $shopCompanySchedule->wednesday_afternoon_opening = $request->wednesday_afternoon_opening;
        $shopCompanySchedule->wednesday_afternoon_closing = $request->wednesday_afternoon_closing;
        $shopCompanySchedule->thursday_morning_opening = $request->thursday_morning_opening;
        $shopCompanySchedule->thursday_morning_closing = $request->thursday_morning_closing;
        $shopCompanySchedule->thursday_afternoon_opening = $request->thursday_afternoon_opening;
        $shopCompanySchedule->thursday_afternoon_closing = $request->thursday_afternoon_closing;
        $shopCompanySchedule->friday_morning_opening = $request->friday_morning_opening;
        $shopCompanySchedule->friday_morning_closing = $request->friday_morning_closing;
        $shopCompanySchedule->friday_afternoon_opening = $request->friday_afternoon_opening;
        $shopCompanySchedule->friday_afternoon_closing = $request->friday_afternoon_closing;
        $shopCompanySchedule->saturday_morning_opening = $request->saturday_morning_opening;
        $shopCompanySchedule->saturday_morning_closing = $request->saturday_morning_closing;
        $shopCompanySchedule->saturday_afternoon_opening = $request->saturday_afternoon_opening;
        $shopCompanySchedule->saturday_afternoon_closing = $request->saturday_afternoon_closing;
        $shopCompanySchedule->sunday_morning_opening = $request->sunday_morning_opening;
        $shopCompanySchedule->sunday_morning_closing = $request->sunday_morning_closing;
        $shopCompanySchedule->sunday_afternoon_opening = $request->sunday_afternoon_opening;
        $shopCompanySchedule->sunday_afternoon_closing = $request->sunday_afternoon_closing;
        $shopCompanySchedule->save();

        return redirect()->route('admin.my-shops.index')->with('message', 'Atualizado com sucesso.');
    }

}