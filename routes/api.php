<?php

Route::post('login', 'Api\\AuthController@login');
Route::post('register', 'Api\\AuthController@register');

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {

    // Page
    Route::post('pages/media', 'PageApiController@storeMedia')->name('pages.storeMedia');
    Route::apiResource('pages', 'PageApiController');

    // Company
    Route::post('companies/media', 'CompanyApiController@storeMedia')->name('companies.storeMedia');
    Route::apiResource('companies', 'CompanyApiController');

    // Subscription Payment
    Route::apiResource('subscription-payments', 'SubscriptionPaymentApiController');

    // Shop Category
    Route::post('shop-categories/media', 'ShopCategoryApiController@storeMedia')->name('shop-categories.storeMedia');
    Route::apiResource('shop-categories', 'ShopCategoryApiController');

    // Shop Company
    Route::post('shop-companies/media', 'ShopCompanyApiController@storeMedia')->name('shop-companies.storeMedia');
    Route::apiResource('shop-companies', 'ShopCompanyApiController');
    Route::get('companiesByCategory/{category_id}', 'ShopCompanyApiController@companiesByCategory');
    Route::get('companyByProductCategory/{id}', 'ShopCompanyApiController@companyByProductCategory');

    // Shop Product Category
    Route::apiResource('shop-product-categories', 'ShopProductCategoryApiController');
    Route::get('categoriesByCompany/{id}', 'ShopProductCategoryApiController@categoriesByCompany');

    // Shop Product Sub Category
    Route::apiResource('shop-product-sub-categories', 'ShopProductSubCategoryApiController');
    Route::get('shop-product-sub-category-by-category-id/{id}', 'ShopProductSubCategoryApiController@shopProductSubCategoryByCategoryId');

    // Shop Product
    Route::post('shop-products/media', 'ShopProductApiController@storeMedia')->name('shop-products.storeMedia');
    Route::apiResource('shop-products', 'ShopProductApiController');
    Route::get('shopProductsByCategoryProduct/{id}', 'ShopProductApiController@shopProductsByCategoryProduct');
    Route::get('shopProductsBySubcategoryProduct/{id}', 'ShopProductApiController@shopProductsBySubcategoryProduct');
    Route::get('randomShopProducts', 'ShopProductApiController@randomShopProducts');
    Route::post('order-product', 'ShopProductApiController@orderProduct');

    // Shop Product Variations
    Route::apiResource('shop-product-variations', 'ShopProductVariationsApiController');

    // Service
    Route::post('services/media', 'ServiceApiController@storeMedia')->name('services.storeMedia');
    Route::apiResource('services', 'ServiceApiController');
    Route::get('shopServicesByCategoryProduct/{id}', 'ServiceApiController@shopServicesByCategoryProduct');
    Route::get('shopServicesBySubcategoryProduct/{id}', 'ServiceApiController@shopServicesBySubcategoryProduct');
    Route::get('randomServices', 'ServiceApiController@randomServices');

    // Service Employee
    Route::apiResource('service-employees', 'ServiceEmployeeApiController');
    Route::post('serviceEmployeeSchedules', 'ServiceEmployeeApiController@serviceEmployeeSchedules');

    // Shop Schedule
    Route::apiResource('shop-schedules', 'ShopScheduleApiController');
    Route::post('saveSchedule', 'ShopScheduleApiController@saveSchedule');
    Route::get('delete-schedule/{id}', 'ShopScheduleApiController@deleteSchedule');

    // Users
    Route::prefix('users')->group(function () {
        Route::get('user', 'UserApiController@user');
        Route::post('update', 'UserApiController@update');
        Route::post('ask-for-delete', 'UserApiController@askForDelete');
    });

    // Countries
    Route::apiResource('countries', 'CountriesApiController');

    //Search
    Route::post('search', 'SearchApiController@search');

    // Purchase
    Route::apiResource('purchases', 'PurchaseApiController');
    Route::get('last-purchases', 'PurchaseApiController@lastPurchases');
    Route::get('delete-purchase/{id}', 'PurchaseApiController@deletePurchase');

    // Ifthen Pay
    Route::apiResource('ifthen-pays', 'IfthenPayApiController');

    // Delivery Ranges
    Route::apiResource('delivery-ranges', 'DeliveryRangesApiController');
});

Route::middleware('verifyAntiPhishingKey')->prefix('callback')->group(function () {
    Route::get('mb', 'Api\PaymentsController@mb');
    Route::get('mbway', 'Api\PaymentsController@mbway');
});

Route::middleware('auth:sanctum')->prefix('orders')->group(function () {
    Route::post('order', 'Api\OrdersController@order');
    Route::post('ifthen-payments', 'Api\OrdersController@ifthenPayments');
});

// New API
Route::post('shop-categories/media', 'Api\V1\Admin\ShopCategoryApiController@storeMedia')->name('shop-categories.storeMedia');
Route::apiResource('shop-categories', 'Api\V1\Admin\ShopCategoryApiController');
Route::get('randomShopProducts', 'Api\V1\Admin\ShopProductApiController@randomShopProducts');
Route::get('randomServices', 'Api\V1\Admin\ServiceApiController@randomServices');
Route::post('search', 'Api\V1\Admin\SearchApiController@search');
Route::apiResource('shop-products', 'Api\V1\Admin\ShopProductApiController');
Route::apiResource('shop-product-variations', 'Api\V1\Admin\ShopProductVariationsApiController');
Route::get('companiesByCategory/{category_id}', 'Api\V1\Admin\ShopCompanyApiController@companiesByCategory');
Route::apiResource('companies', 'Api\V1\Admin\CompanyApiController');
Route::get('categoriesByCompany/{id}', 'Api\V1\Admin\ShopProductCategoryApiController@categoriesByCompany');
Route::get('companyByProductCategory/{id}', 'Api\V1\Admin\ShopCompanyApiController@companyByProductCategory');
Route::get('shop-product-sub-category-by-category-id/{id}', 'Api\V1\Admin\ShopProductSubCategoryApiController@shopProductSubCategoryByCategoryId');
Route::get('shopProductsByCategoryProduct/{id}', 'Api\V1\Admin\ShopProductApiController@shopProductsByCategoryProduct');
Route::get('shopServicesByCategoryProduct/{id}', 'Api\V1\Admin\ServiceApiController@shopServicesByCategoryProduct');
Route::apiResource('services', 'Api\V1\Admin\ServiceApiController');
Route::get('shopProductsBySubcategoryProduct/{id}', 'Api\V1\Admin\ShopProductApiController@shopProductsBySubcategoryProduct');
Route::get('shopServicesBySubcategoryProduct/{id}', 'Api\V1\Admin\ServiceApiController@shopServicesBySubcategoryProduct');