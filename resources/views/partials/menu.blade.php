<aside class="main-sidebar sidebar-dark-primary elevation-4" style="min-height: 917px;">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">{{ trans('panel.site_title') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs("admin.home") ? "active" : "" }}" href="{{ route("admin.home") }}">
                        <i class="fas fa-fw fa-tachometer-alt nav-icon">
                        </i>
                        <p>
                            {{ trans('global.dashboard') }}
                        </p>
                    </a>
                </li>
                @can('user_management_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/permissions*") ? "menu-open" : "" }} {{ request()->is("admin/roles*") ? "menu-open" : "" }} {{ request()->is("admin/users*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/permissions*") ? "active" : "" }} {{ request()->is("admin/roles*") ? "active" : "" }} {{ request()->is("admin/users*") ? "active" : "" }}" href="#">
                            <i class="fa-fw nav-icon fas fa-users">

                            </i>
                            <p>
                                {{ trans('cruds.userManagement.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('permission_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-unlock-alt">

                                        </i>
                                        <p>
                                            {{ trans('cruds.permission.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('role_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-briefcase">

                                        </i>
                                        <p>
                                            {{ trans('cruds.role.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('user_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-user">

                                        </i>
                                        <p>
                                            {{ trans('cruds.user.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('register_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.registers.index") }}" class="nav-link {{ request()->is("admin/registers") || request()->is("admin/registers/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-keyboard">

                            </i>
                            <p>
                                {{ trans('cruds.register.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('address_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.addresses.index") }}" class="nav-link {{ request()->is("admin/addresses") || request()->is("admin/addresses/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-address-book">

                            </i>
                            <p>
                                {{ trans('cruds.address.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('country_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.countries.index") }}" class="nav-link {{ request()->is("admin/countries") || request()->is("admin/countries/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-flag">

                            </i>
                            <p>
                                {{ trans('cruds.country.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('newsletter_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.newsletters.index") }}" class="nav-link {{ request()->is("admin/newsletters") || request()->is("admin/newsletters/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon far fa-newspaper">

                            </i>
                            <p>
                                {{ trans('cruds.newsletter.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('page_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.pages.index") }}" class="nav-link {{ request()->is("admin/pages") || request()->is("admin/pages/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-sitemap">

                            </i>
                            <p>
                                {{ trans('cruds.page.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('plan_menu_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/plans*") ? "menu-open" : "" }} {{ request()->is("admin/plan-items*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/plans*") ? "active" : "" }} {{ request()->is("admin/plan-items*") ? "active" : "" }}" href="#">
                            <i class="fa-fw nav-icon fas fa-check-double">

                            </i>
                            <p>
                                {{ trans('cruds.planMenu.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('plan_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.plans.index") }}" class="nav-link {{ request()->is("admin/plans") || request()->is("admin/plans/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-check-double">

                                        </i>
                                        <p>
                                            {{ trans('cruds.plan.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('plan_item_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.plan-items.index") }}" class="nav-link {{ request()->is("admin/plan-items") || request()->is("admin/plan-items/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-check">

                                        </i>
                                        <p>
                                            {{ trans('cruds.planItem.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('subscription_type_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.subscription-types.index") }}" class="nav-link {{ request()->is("admin/subscription-types") || request()->is("admin/subscription-types/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-file-contract">

                                        </i>
                                        <p>
                                            {{ trans('cruds.subscriptionType.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('company_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.companies.index") }}" class="nav-link {{ request()->is("admin/companies") || request()->is("admin/companies/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-building">

                            </i>
                            <p>
                                {{ trans('cruds.company.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('subscription_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.subscriptions.index") }}" class="nav-link {{ request()->is("admin/subscriptions") || request()->is("admin/subscriptions/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-file-signature">

                            </i>
                            <p>
                                {{ trans('cruds.subscription.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('subscription_payment_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.subscription-payments.index") }}" class="nav-link {{ request()->is("admin/subscription-payments") || request()->is("admin/subscription-payments/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-euro-sign">

                            </i>
                            <p>
                                {{ trans('cruds.subscriptionPayment.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('shop_setting_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/shop-categories*") ? "menu-open" : "" }} {{ request()->is("admin/shop-locations*") ? "menu-open" : "" }} {{ request()->is("admin/shop-types*") ? "menu-open" : "" }} {{ request()->is("admin/shop-taxes*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/shop-categories*") ? "active" : "" }} {{ request()->is("admin/shop-locations*") ? "active" : "" }} {{ request()->is("admin/shop-types*") ? "active" : "" }} {{ request()->is("admin/shop-taxes*") ? "active" : "" }}" href="#">
                            <i class="fa-fw nav-icon fas fa-cogs">

                            </i>
                            <p>
                                {{ trans('cruds.shopSetting.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('shop_category_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.shop-categories.index") }}" class="nav-link {{ request()->is("admin/shop-categories") || request()->is("admin/shop-categories/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-boxes">

                                        </i>
                                        <p>
                                            {{ trans('cruds.shopCategory.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('shop_location_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.shop-locations.index") }}" class="nav-link {{ request()->is("admin/shop-locations") || request()->is("admin/shop-locations/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-map-marker">

                                        </i>
                                        <p>
                                            {{ trans('cruds.shopLocation.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('shop_type_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.shop-types.index") }}" class="nav-link {{ request()->is("admin/shop-types") || request()->is("admin/shop-types/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-list">

                                        </i>
                                        <p>
                                            {{ trans('cruds.shopType.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('shop_tax_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.shop-taxes.index") }}" class="nav-link {{ request()->is("admin/shop-taxes") || request()->is("admin/shop-taxes/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-percentage">

                                        </i>
                                        <p>
                                            {{ trans('cruds.shopTax.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('shop_company_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.shop-companies.index") }}" class="nav-link {{ request()->is("admin/shop-companies") || request()->is("admin/shop-companies/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-store-alt">

                            </i>
                            <p>
                                {{ trans('cruds.shopCompany.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('shop_product_category_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.shop-product-categories.index") }}" class="nav-link {{ request()->is("admin/shop-product-categories") || request()->is("admin/shop-product-categories/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-boxes">

                            </i>
                            <p>
                                {{ trans('cruds.shopProductCategory.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('shop_product_sub_category_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.shop-product-sub-categories.index") }}" class="nav-link {{ request()->is("admin/shop-product-sub-categories") || request()->is("admin/shop-product-sub-categories/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-boxes">

                            </i>
                            <p>
                                {{ trans('cruds.shopProductSubCategory.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('shop_product_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.shop-products.index") }}" class="nav-link {{ request()->is("admin/shop-products") || request()->is("admin/shop-products/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-box-open">

                            </i>
                            <p>
                                {{ trans('cruds.shopProduct.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('shop_product_variation_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.shop-product-variations.index") }}" class="nav-link {{ request()->is("admin/shop-product-variations") || request()->is("admin/shop-product-variations/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-th">

                            </i>
                            <p>
                                {{ trans('cruds.shopProductVariation.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('shop_product_feature_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.shop-product-features.index") }}" class="nav-link {{ request()->is("admin/shop-product-features") || request()->is("admin/shop-product-features/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-tasks">

                            </i>
                            <p>
                                {{ trans('cruds.shopProductFeature.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('shop_company_schedule_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.shop-company-schedules.index") }}" class="nav-link {{ request()->is("admin/shop-company-schedules") || request()->is("admin/shop-company-schedules/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-calendar-alt">

                            </i>
                            <p>
                                {{ trans('cruds.shopCompanySchedule.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('service_duration_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.service-durations.index") }}" class="nav-link {{ request()->is("admin/service-durations") || request()->is("admin/service-durations/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-stopwatch">

                            </i>
                            <p>
                                {{ trans('cruds.serviceDuration.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('service_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.services.index") }}" class="nav-link {{ request()->is("admin/services") || request()->is("admin/services/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-star">

                            </i>
                            <p>
                                {{ trans('cruds.service.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('service_employee_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.service-employees.index") }}" class="nav-link {{ request()->is("admin/service-employees") || request()->is("admin/service-employees/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-user-tie">

                            </i>
                            <p>
                                {{ trans('cruds.serviceEmployee.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('shop_schedule_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.shop-schedules.index") }}" class="nav-link {{ request()->is("admin/shop-schedules") || request()->is("admin/shop-schedules/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-calendar-check">

                            </i>
                            <p>
                                {{ trans('cruds.shopSchedule.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('my_shop_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.my-shops.index") }}" class="nav-link {{ request()->is("admin/my-shops") || request()->is("admin/my-shops/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-store-alt">

                            </i>
                            <p>
                                {{ trans('cruds.myShop.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('manage_category_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/my-categories*") ? "menu-open" : "" }} {{ request()->is("admin/my-sub-categories*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/my-categories*") ? "active" : "" }} {{ request()->is("admin/my-sub-categories*") ? "active" : "" }}" href="#">
                            <i class="fa-fw nav-icon fas fa-boxes">

                            </i>
                            <p>
                                {{ trans('cruds.manageCategory.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('my_category_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.my-categories.index") }}" class="nav-link {{ request()->is("admin/my-categories") || request()->is("admin/my-categories/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-box-open">

                                        </i>
                                        <p>
                                            {{ trans('cruds.myCategory.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('my_sub_category_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.my-sub-categories.index") }}" class="nav-link {{ request()->is("admin/my-sub-categories") || request()->is("admin/my-sub-categories/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-boxes">

                                        </i>
                                        <p>
                                            {{ trans('cruds.mySubCategory.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('my_product_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.my-products.index") }}" class="nav-link {{ request()->is("admin/my-products") || request()->is("admin/my-products/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-box-open">

                            </i>
                            <p>
                                {{ trans('cruds.myProduct.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('my_service_access')
                    <li class="nav-item">
                        <a href="/admin/my-services" class="nav-link {{ request()->is("admin/my-services") || request()->is("admin/my-services/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-star">

                            </i>
                            <p>
                                {{ trans('cruds.myService.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('my_employee_access')
                    <li class="nav-item">
                        <a href="/admin/my-employees" class="nav-link {{ request()->is("admin/my-employees") || request()->is("admin/my-employees/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-user-tie">

                            </i>
                            <p>
                                {{ trans('cruds.myEmployee.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('my_order_access')
                    <li class="nav-item">
                        <a href="/admin/my-orders" class="nav-link {{ request()->is("admin/my-orders") || request()->is("admin/my-orders/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-shopping-cart">

                            </i>
                            <p>
                                {{ trans('cruds.myOrder.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('client_access')
                    <li class="nav-item">
                        <a href="/admin/clients" class="nav-link {{ request()->is("admin/clients") || request()->is("admin/clients/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-user-circle">

                            </i>
                            <p>
                                {{ trans('cruds.client.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('purchase_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.purchases.index") }}" class="nav-link {{ request()->is("admin/purchases") || request()->is("admin/purchases/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-shopping-cart">

                            </i>
                            <p>
                                {{ trans('cruds.purchase.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('ifthen_pay_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.ifthen-pays.index") }}" class="nav-link {{ request()->is("admin/ifthen-pays") || request()->is("admin/ifthen-pays/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-university">

                            </i>
                            <p>
                                {{ trans('cruds.ifthenPay.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('payment_method_access')
                    <li class="nav-item">
                        <a href="/admin/payment-methods" class="nav-link {{ request()->is("admin/payment-methods") || request()->is("admin/payment-methods/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-address-card">

                            </i>
                            <p>
                                {{ trans('cruds.paymentMethod.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('delivery_range_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.delivery-ranges.index") }}" class="nav-link {{ request()->is("admin/delivery-ranges") || request()->is("admin/delivery-ranges/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-truck">

                            </i>
                            <p>
                                {{ trans('cruds.deliveryRange.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('delivery_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.deliveries.index") }}" class="nav-link {{ request()->is("admin/deliveries") || request()->is("admin/deliveries/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-truck">

                            </i>
                            <p>
                                {{ trans('cruds.delivery.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                <li class="nav-item">
                    <a href="{{ route("admin.systemCalendar") }}" class="nav-link {{ request()->is("admin/system-calendar") || request()->is("admin/system-calendar/*") ? "active" : "" }}">
                        <i class="fas fa-fw fa-calendar nav-icon">

                        </i>
                        <p>
                            {{ trans('global.systemCalendar') }}
                        </p>
                    </a>
                </li>
                @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
                    @can('profile_password_edit')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'active' : '' }}" href="{{ route('profile.password.edit') }}">
                                <i class="fa-fw fas fa-key nav-icon">
                                </i>
                                <p>
                                    {{ trans('global.change_password') }}
                                </p>
                            </a>
                        </li>
                    @endcan
                @endif
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                        <p>
                            <i class="fas fa-fw fa-sign-out-alt nav-icon">

                            </i>
                            <p>{{ trans('global.logout') }}</p>
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>