<?php

Route::get('/', 'WebsiteController@index')->name('homepage');
Route::get('politica-de-privacidade', 'WebsiteController@politicaDePrivacidade');
Route::get('termos-e-condicoes', 'WebsiteController@termosECondicoes');
Route::get('eliminar-conta', 'WebsiteController@accountDelete');
Route::post('delete-account', 'WebsiteController@deleteAccount');

Route::get('mobile', 'WebsiteController@mobile');

Route::get('recuperar-password', function () {
    return view('auth.passwords.email');
});

Route::prefix('lojas')->group(function () {
    Route::get('/', 'ShopController@index');
    Route::get('produto/{id}/{slug}', 'ShopController@product');
    Route::get('servico/{id}/{slug}', 'ShopController@service');
    Route::get('checkout', 'ShopController@checkout');
    Route::get('inner-checkout', 'ShopController@innerCheckout');
    Route::get('categoria/{category_id}/{slug}', 'ShopController@category');
    Route::get('loja/{company_id}/{slug}', 'ShopController@company');
    Route::get('produtos/{company_id}/{shop_product_category_id}/{slug}', 'ShopController@products');
    Route::get('searchInShop/{search}', 'ShopController@searchInShop');
    Route::get('changeDelivery/{delivery}', 'ShopController@changeDelivery');
});

Route::prefix('cart')->group(function () {
    Route::post('add-to-cart', 'CartController@addToCart');
    Route::post('remove-from-cart', 'CartController@removeFromCart');
    Route::get('delete-cart', 'CartController@deleteCart');
    Route::get('show-cart', 'CartController@showCart');
    Route::get('change-qty/{product_id}/{qty}', 'CartController@changeQty');
    Route::get('delete-product/{product_id}', 'CartController@deleteProduct');
    Route::get('change-same/{address_id}', 'CartController@changeSame');
    Route::post('create-address', 'CartController@createAddress');
    Route::post('update-address', 'CartController@updateAddress');
    Route::post('update-billing-address', 'CartController@updateBillingAddress');
    Route::post('generate-payments', 'CartController@generatePayments');
    Route::get('check-mbway-payment/{id_payment}/{mbway_key}', 'CartController@checkMbwayPayment');
    Route::post('send-mb-payment', 'CartController@sendMbPayment');
    Route::get('shop_schedules/{day}/{time}/{employee_id}/{service_id}', 'CartController@shop_schedules');
});

Route::prefix('payments')->group(function () {
    Route::get('mb-callback', 'CartController@mbCallback');
    Route::get('mbway-callback', 'CartController@mbwayCallback');
});

Route::prefix('forms')->group(function () {
    Route::post('contact', 'WebsiteController@contact');
    Route::post('newsletter', 'WebsiteController@newsletter');
    Route::post('formRegister', 'WebsiteController@formRegister');
    Route::post('companies/media', 'WebsiteController@storeMedia')->name('forms.companies.storeMedia');
});

Route::prefix('registo')->group(function () {
    Route::get('/', 'WebsiteController@register');
    Route::get('/{plan_id}', 'WebsiteController@selectedRegister');
});

Route::post('client-login', 'AuthController@clientLogin');
Route::post('create-account', 'AuthController@createAccount');

Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home');
    }
    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth', 'checkSubscription']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('subscription-type/{subscription_type_id}', 'HomeController@subscriptionType');

    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Register
    Route::delete('registers/destroy', 'RegisterController@massDestroy')->name('registers.massDestroy');
    Route::resource('registers', 'RegisterController');

    // Newsletter
    Route::delete('newsletters/destroy', 'NewsletterController@massDestroy')->name('newsletters.massDestroy');
    Route::resource('newsletters', 'NewsletterController');

    // Page
    Route::delete('pages/destroy', 'PageController@massDestroy')->name('pages.massDestroy');
    Route::post('pages/media', 'PageController@storeMedia')->name('pages.storeMedia');
    Route::post('pages/ckmedia', 'PageController@storeCKEditorImages')->name('pages.storeCKEditorImages');
    Route::resource('pages', 'PageController');

    // Plan
    Route::delete('plans/destroy', 'PlanController@massDestroy')->name('plans.massDestroy');
    Route::resource('plans', 'PlanController');

    // Plan Item
    Route::delete('plan-items/destroy', 'PlanItemController@massDestroy')->name('plan-items.massDestroy');
    Route::resource('plan-items', 'PlanItemController');

    // Company
    Route::delete('companies/destroy', 'CompanyController@massDestroy')->name('companies.massDestroy');
    Route::post('companies/media', 'CompanyController@storeMedia')->name('companies.storeMedia');
    Route::post('companies/ckmedia', 'CompanyController@storeCKEditorImages')->name('companies.storeCKEditorImages');
    Route::resource('companies', 'CompanyController');

    // Subscription Type
    Route::delete('subscription-types/destroy', 'SubscriptionTypeController@massDestroy')->name('subscription-types.massDestroy');
    Route::resource('subscription-types', 'SubscriptionTypeController');

    // Subscription
    Route::delete('subscriptions/destroy', 'SubscriptionController@massDestroy')->name('subscriptions.massDestroy');
    Route::resource('subscriptions', 'SubscriptionController');

    // Subscription Payment
    Route::delete('subscription-payments/destroy', 'SubscriptionPaymentController@massDestroy')->name('subscription-payments.massDestroy');
    Route::resource('subscription-payments', 'SubscriptionPaymentController');

    // Shop Category
    Route::delete('shop-categories/destroy', 'ShopCategoryController@massDestroy')->name('shop-categories.massDestroy');
    Route::post('shop-categories/media', 'ShopCategoryController@storeMedia')->name('shop-categories.storeMedia');
    Route::post('shop-categories/ckmedia', 'ShopCategoryController@storeCKEditorImages')->name('shop-categories.storeCKEditorImages');
    Route::resource('shop-categories', 'ShopCategoryController');

    // Shop Location
    Route::delete('shop-locations/destroy', 'ShopLocationController@massDestroy')->name('shop-locations.massDestroy');
    Route::resource('shop-locations', 'ShopLocationController');

    // Shop Type
    Route::delete('shop-types/destroy', 'ShopTypeController@massDestroy')->name('shop-types.massDestroy');
    Route::resource('shop-types', 'ShopTypeController');

    // Shop Taxes
    Route::delete('shop-taxes/destroy', 'ShopTaxesController@massDestroy')->name('shop-taxes.massDestroy');
    Route::resource('shop-taxes', 'ShopTaxesController');

    // Shop Company
    Route::delete('shop-companies/destroy', 'ShopCompanyController@massDestroy')->name('shop-companies.massDestroy');
    Route::post('shop-companies/media', 'ShopCompanyController@storeMedia')->name('shop-companies.storeMedia');
    Route::post('shop-companies/ckmedia', 'ShopCompanyController@storeCKEditorImages')->name('shop-companies.storeCKEditorImages');
    Route::resource('shop-companies', 'ShopCompanyController');

    // Shop Product Category
    Route::delete('shop-product-categories/destroy', 'ShopProductCategoryController@massDestroy')->name('shop-product-categories.massDestroy');
    Route::post('shop-product-categories/media', 'ShopProductCategoryController@storeMedia')->name('shop-product-categories.storeMedia');
    Route::post('shop-product-categories/ckmedia', 'ShopProductCategoryController@storeCKEditorImages')->name('shop-product-categories.storeCKEditorImages');
    Route::resource('shop-product-categories', 'ShopProductCategoryController');

    // Shop Product
    Route::delete('shop-products/destroy', 'ShopProductController@massDestroy')->name('shop-products.massDestroy');
    Route::post('shop-products/media', 'ShopProductController@storeMedia')->name('shop-products.storeMedia');
    Route::post('shop-products/ckmedia', 'ShopProductController@storeCKEditorImages')->name('shop-products.storeCKEditorImages');
    Route::resource('shop-products', 'ShopProductController');

    // Shop Product Variations
    Route::delete('shop-product-variations/destroy', 'ShopProductVariationsController@massDestroy')->name('shop-product-variations.massDestroy');
    Route::resource('shop-product-variations', 'ShopProductVariationsController');

    // Shop Product Feature
    Route::delete('shop-product-features/destroy', 'ShopProductFeatureController@massDestroy')->name('shop-product-features.massDestroy');
    Route::resource('shop-product-features', 'ShopProductFeatureController');

    // Shop Product Sub Category
    Route::delete('shop-product-sub-categories/destroy', 'ShopProductSubCategoryController@massDestroy')->name('shop-product-sub-categories.massDestroy');
    Route::resource('shop-product-sub-categories', 'ShopProductSubCategoryController');

    // My Categories
    Route::prefix('my-categories')->group(function () {
        Route::get('/', 'MyCategoriesController@index')->name('my-categories.index');
        Route::get('create', 'MyCategoriesController@create')->name('my-categories.create');
        Route::get('edit/{id}', 'MyCategoriesController@edit')->name('my-categories.edit');
        Route::post('destroy', 'MyCategoriesController@destroy')->name('my-categories.destroy');
    });

    // My Sub Categories
    Route::prefix('my-sub-categories')->group(function () {
        Route::get('index/{category_id?}', 'MySubCategoriesController@index')->name('my-sub-categories.index');
        Route::get('create/{category_id?}', 'MySubCategoriesController@create')->name('my-sub-categories.create');
        Route::post('store', 'MySubCategoriesController@store')->name('my-sub-categories.store');
        Route::get('edit/{id}', 'MySubCategoriesController@edit')->name('my-sub-categories.edit');
        Route::post('update', 'MySubCategoriesController@update')->name('my-sub-categories.update');
        ROute::post('destroy', 'MySubCategoriesController@destroy')->name('my-sub-categories.destroy');
    });

    // My Shop
    Route::prefix('my-shops')->group(function () {
        Route::get('/', 'MyShopController@index')->name('my-shops.index');
        Route::get('create', 'MyShopController@create');
        Route::post('store', 'MyShopController@store')->name('my-shops.store');
        Route::put('update/{shop_company_id}', 'MyShopController@update')->name('my-shops.update');
    });

    // My Product
    Route::prefix('my-products')->group(function () {
        Route::get('/', 'MyProductController@index')->name('my-products.index');
        Route::get('create', 'MyProductController@create')->name('my-products.create');
        Route::get('edit/{id}', 'MyProductController@edit')->name('my-products.edit');
        Route::post('new-shop-product-feature', 'MyProductController@newShopProductFeature');
        Route::get('shop-product-feature-list/{shop_product_id}', 'MyProductController@shopProductFeatureList');
        Route::get('delete-shop-product-feature/{shop_product_feature_id}', 'MyProductController@deleteShopProductFeature');
        Route::post('new-shop-product-variation', 'MyProductController@newShopProductVariation');
        Route::get('shop-product-variation-list/{shop_product_id}', 'MyProductController@shopProductVariationList');
        Route::get('delete-shop-product-variation/{shop_product_variation_id}', 'MyProductController@deleteShopProductVariation');
        Route::post('update-shop-product-variation-prices', 'MyProductController@updateShopProductVariationPrices');
        Route::get('product-list', 'MyProductController@productList');
        Route::post('position', 'MyProductController@position');
        Route::post('shop-product-feature-add', 'MyProductController@shopProductFeatureAdd');
        Route::post('shop-product-feature-position-update', 'MyProductController@shopProductFeaturePositionUpdate');
        Route::post('shop-product-variation-add', 'MyProductController@shopProductVariationAdd');
        Route::post('shop-product-variation-position-update', 'MyProductController@shopProductVariationPositionUpdate');
    });

    // Shop Company Schedule
    Route::delete('shop-company-schedules/destroy', 'ShopCompanyScheduleController@massDestroy')->name('shop-company-schedules.massDestroy');
    Route::resource('shop-company-schedules', 'ShopCompanyScheduleController');

    // Service Duration
    Route::delete('service-durations/destroy', 'ServiceDurationController@massDestroy')->name('service-durations.massDestroy');
    Route::resource('service-durations', 'ServiceDurationController');

    // Service
    Route::delete('services/destroy', 'ServiceController@massDestroy')->name('services.massDestroy');
    Route::post('services/media', 'ServiceController@storeMedia')->name('services.storeMedia');
    Route::post('services/ckmedia', 'ServiceController@storeCKEditorImages')->name('services.storeCKEditorImages');
    Route::resource('services', 'ServiceController');

    // Service Employee
    Route::delete('service-employees/destroy', 'ServiceEmployeeController@massDestroy')->name('service-employees.massDestroy');
    Route::resource('service-employees', 'ServiceEmployeeController');

    // Shop Schedule
    Route::delete('shop-schedules/destroy', 'ShopScheduleController@massDestroy')->name('shop-schedules.massDestroy');
    Route::resource('shop-schedules', 'ShopScheduleController');

    // My Service
    Route::prefix('my-services')->group(function () {
        Route::get('/', 'MyServiceController@index');
        Route::get('create', 'MyServiceController@create');
        Route::get('edit/{id}', 'MyServiceController@edit');
        Route::get('service-list', 'MyServiceController@serviceList');
        ROute::post('position', 'MyServiceController@position');
    });


    // My Employees
    Route::prefix('my-employees')->group(function () {
        Route::get('/', 'MyEmployeesController@index');
        Route::get('create', 'MyEmployeesController@create');
        Route::get('edit/{id}', 'MyEmployeesController@edit');
        Route::get('schedules/{id}', 'MyEmployeesController@schedules');
        Route::get('get-schedule/{id}', 'MyEmployeesController@getSchedule');
        Route::get('delete-schedule/{id}', 'MyEmployeesController@deleteSchedule');
        Route::post('search-users', 'MyEmployeesController@searchUsers');
        Route::get('get-client/{id}', 'MyEmployeesController@getClient');
        Route::post('update-schedule', 'MyEmployeesController@updateSchedule');
    });

    // Address
    Route::delete('addresses/destroy', 'AddressController@massDestroy')->name('addresses.massDestroy');
    Route::resource('addresses', 'AddressController');

    // Countries
    Route::delete('countries/destroy', 'CountriesController@massDestroy')->name('countries.massDestroy');
    Route::resource('countries', 'CountriesController');

    // Client
    Route::prefix('clients')->group(function () {
        Route::get('/', 'ClientController@index');
        Route::post('new-client', 'ClientController@newClient');
        Route::get('details/{client_id}', 'ClientController@details');
    });

    // Purchase
    Route::delete('purchases/destroy', 'PurchaseController@massDestroy')->name('purchases.massDestroy');
    Route::resource('purchases', 'PurchaseController');

    // My Order
    Route::prefix('my-orders')->group(function () {
        Route::get('/', 'MyOrderController@index');
        Route::get('edit/{id}', 'MyOrderController@edit');
        Route::post('update', 'MyOrderController@update');
    });

    // Ifthen Pay
    Route::delete('ifthen-pays/destroy', 'IfthenPayController@massDestroy')->name('ifthen-pays.massDestroy');
    Route::resource('ifthen-pays', 'IfthenPayController');

    // Payment Method
    Route::prefix('payment-methods')->group(function () {
        Route::get('/', 'PaymentMethodController@index');
        Route::post('update', 'PaymentMethodController@update');
    });

    // Delivery Ranges
    Route::delete('delivery-ranges/destroy', 'DeliveryRangesController@massDestroy')->name('delivery-ranges.massDestroy');
    Route::resource('delivery-ranges', 'DeliveryRangesController');

    // Delivery
    Route::prefix('deliveries')->group(function () {
        Route::get('/', 'DeliveryController@index')->name('deliveries.index');
        Route::post('new_delivery_range', 'DeliveryController@newDeliveryRange');
        Route::post('update_delivery_range', 'DeliveryController@updateDeliveryRange');
        Route::get('delete_delivery_range/{delivery_range_id}', 'DeliveryController@deleteDeliveryRange');
        Route::post('updateShopProduct', 'DeliveryController@updateShopProduct');
    });

    // System Calendar
    Route::get('system-calendar', 'SystemCalendarController@index')->name('systemCalendar');

});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});

Route::middleware(['auth'])->prefix('payments')->group(function () {
    Route::post('subscriptionPaymentGenerate', 'PaymentsController@subscriptionPaymentGenerate');
    Route::get('mb/{subscriptionPayment}/{amount}', 'PaymentsController@mb');
    Route::post('sendMbByEmail', 'PaymentsController@sendMbByEmail');
    Route::get('mbway/{subscriptionPayment}/{amount}', 'PaymentsController@mbway');
    Route::post('submitMbway', 'PaymentsController@submitMbway');
    Route::get('list', 'PaymentsController@list');
    Route::post('selectSubscriptionType', 'PaymentsController@selectSubscriptionType');
});

