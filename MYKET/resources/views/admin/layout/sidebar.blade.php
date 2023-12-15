<?php

$leftMenu = [];
/*======= Dashboard ==========*/
$leftMenu['dashboard']['title'] = translate('Dashboards');
$leftMenu['dashboard']['url'] = route('admin.dashboard');
$leftMenu['dashboard']['icon'] = 'ti-home';

/*======= Products ==========*/
$leftMenu['account']['title'] = translate('Accounts');
$leftMenu['account']['url'] = 'javascript::void(0)';
$leftMenu['account']['icon'] = 'icon-user';

$leftSubMenu = [];
$leftSubSubMenu = [];
$leftSubMenu['partner']['title'] = translate('Suppliers');
$leftSubMenu['partner']['url'] = route('admin.partner_account');
$leftSubMenu['partner']['icon'] = '';

$leftSubMenu['users']['title'] = translate('Users');
$leftSubMenu['users']['url'] = route('admin.users_list');
$leftSubMenu['users']['icon'] = '';

$leftSubMenu['affiliates']['title'] = translate('Affiliates');
$leftSubMenu['affiliates']['url'] = 'javascript::void(0)';
$leftSubMenu['affiliates']['icon'] = '';

$leftSubSubMenu['affiliate']['title'] = translate('Affiliates');
$leftSubSubMenu['affiliate']['url'] = route('admin.affiliates');
$leftSubSubMenu['affiliate']['icon'] = '';

$leftSubSubMenu['affiliate_commission']['title'] = translate('Affiliate Commission');
$leftSubSubMenu['affiliate_commission']['url'] = route('admin.affiliate_commission');
$leftSubSubMenu['affiliate_commission']['icon'] = '';

$leftSubMenu['affiliates']['subsubmenu'] = $leftSubSubMenu;

/*======= Hotels ==========*/
$leftSubMenu['hotels']['title'] = translate('Hotels');
$leftSubMenu['hotels']['url'] = route('admin.hotels');
$leftSubMenu['hotels']['icon'] = 'ion-stats-bars';

$leftMenu['account']['submenu'] = $leftSubMenu;

/*======= Pages Building ==========*/
// $leftMenu['pages_building']['title'] = 'Pages Building';
// $leftMenu['pages_building']['url'] = 'javascript::void(0)';
// $leftMenu['pages_building']['icon'] = 'icon-layers';

/*======= Products ==========*/
$leftMenu['products']['title'] = translate('Products');
$leftMenu['products']['url'] = 'javascript::void(0)';
$leftMenu['products']['icon'] = 'ti-align-right';

$leftSubMenu = [];
$leftSubMenu['product']['title'] = translate('Products');
$leftSubMenu['product']['url'] = route('admin.get_products');
$leftSubMenu['product']['icon'] = '';

$leftSubMenu['product_type']['title'] = translate('Product Type');
$leftSubMenu['product_type']['url'] = route('admin.product_type');
$leftSubMenu['product_type']['icon'] = '';

// $leftSubMenu = [];
// $leftSubMenu['products']['title'] = 'Products';
// $leftSubMenu['products']['url'] = route('admin.add_product');
// $leftSubMenu['products']['icon'] = '';

/*======= Category ==========*/
$leftSubMenu['categories']['title'] = translate('Categories');
$leftSubMenu['categories']['url'] = route('admin.categories');
$leftSubMenu['categories']['icon'] = '';

/*======= Type of Meal ==========*/
$leftSubMenu['meal_type']['title'] = translate('Type of Meal');
$leftSubMenu['meal_type']['url'] = route('admin.productsfood.mealtype');
$leftSubMenu['meal_type']['icon'] = '';

/*======= Time of Day ==========*/
$leftSubMenu['time_of_day']['title'] = translate('Time of Day');
$leftSubMenu['time_of_day']['url'] = route('admin.productsfood.timeofday');
$leftSubMenu['time_of_day']['icon'] = '';

/*======= Tags ==========*/
$leftSubMenu['tags']['title'] = translate('Tags');
$leftSubMenu['tags']['url'] = route('admin.productsfood.tags');
$leftSubMenu['tags']['icon'] = '';

/*======= Gears ==========*/
$leftSubMenu['gear']['title'] = translate('Gears');
$leftSubMenu['gear']['url'] = route('admin.gears');
$leftSubMenu['gear']['icon'] = '';

/*======= Media ==========*/
$leftSubMenu['media']['title'] = translate('Media');
$leftSubMenu['media']['url'] = route('admin.media');
$leftSubMenu['media']['icon'] = '';

/*======= Transportation ==========*/
$leftSubMenu['transportation']['title'] = translate('Transportation');
$leftSubMenu['transportation']['url'] = route('admin.transportation');
$leftSubMenu['transportation']['icon'] = '';

/*======= Inclusion ==========*/
$leftSubMenu['inclusion']['title'] = translate('Inclusion');
$leftSubMenu['inclusion']['url'] = route('admin.inclusion');
$leftSubMenu['inclusion']['icon'] = '';

// /*======= Restriction ==========*/
$leftSubMenu['restriction']['title'] = translate('Restriction');
$leftSubMenu['restriction']['url'] = route('admin.restriction');
$leftSubMenu['restriction']['icon'] = '';

// /*======= Restriction ==========*/
$leftSubMenu['addOn']['title'] = translate('Add-On');
$leftSubMenu['addOn']['url'] = route('admin.add_on');
$leftSubMenu['addOn']['icon'] = '';

/*======= Reviews ==========*/
$leftSubMenu['reviews']['title'] = translate('Reviews');
$leftSubMenu['reviews']['url'] = route('admin.reviews');
$leftSubMenu['reviews']['icon'] = 'icon-layers';

$leftMenu['products']['submenu'] = $leftSubMenu;

/*======= Page Building ==========*/
$leftMenu['page_building']['title'] = translate('Page Building');
$leftMenu['page_building']['url'] = 'javascript::void(0)';
$leftMenu['page_building']['icon'] = 'ti-files';

$leftSubMenu = [];

$leftSubMenu['topDestination']['title'] = translate('Top Destination');
$leftSubMenu['topDestination']['url'] = route('admin.top_destination');
$leftSubMenu['topDestination']['icon'] = '';

$leftSubMenu['topAttraction']['title'] = translate('Top Attraction');
$leftSubMenu['topAttraction']['url'] = route('admin.top_attraction');
$leftSubMenu['topAttraction']['icon'] = '';

$leftSubMenu['interests']['title'] = translate('Interests');
$leftSubMenu['interests']['url'] = route('admin.interests');
$leftSubMenu['interests']['icon'] = 'ion-stats-bars';

$leftSubMenu['Pages']['title'] = translate('Pages');
$leftSubMenu['Pages']['url'] = route('admin.pages');
$leftSubMenu['Pages']['icon'] = 'icon-layers';

$leftSubMenu['testimonials']['title'] = translate('Testimonials');
$leftSubMenu['testimonials']['url'] = route('admin.testimonials');
$leftSubMenu['testimonials']['icon'] = 'icon-bubbles';

$leftSubMenu['faqs']['title'] = translate('FAQ');
$leftSubMenu['faqs']['url'] = route('admin.faqs');
$leftSubMenu['faqs']['icon'] = 'ion-chatbox-working';

$leftSubMenu['blogs']['title'] = translate('Blogs');
$leftSubMenu['blogs']['url'] = route('admin.blogs');
$leftSubMenu['blogs']['icon'] = 'icon-note';

$leftSubMenu['blog_category']['title'] = translate('Blog Category');
$leftSubMenu['blog_category']['url'] = route('admin.blogcategory');
$leftSubMenu['blog_category']['icon'] = 'icon-speech';

$leftSubMenu['guide']['title'] = translate('Guide');
$leftSubMenu['guide']['url'] = route('admin.guide');
$leftSubMenu['guide']['icon'] = 'ion-ios-flag';

$leftSubMenu['services']['title'] = translate('Services');
$leftSubMenu['services']['url'] = route('admin.services');
$leftSubMenu['services']['icon'] = 'icon-layers';

$leftSubMenu['partners']['title'] = translate('Our Partners');
$leftSubMenu['partners']['url'] = route('admin.partners');
$leftSubMenu['partners']['icon'] = 'icon-people';

$leftSubMenu['recommended_things']['title'] = translate('Recommended Things');
$leftSubMenu['recommended_things']['url'] = route('admin.recommended_things');
$leftSubMenu['recommended_things']['icon'] = 'icon-people';

$leftMenu['page_building']['submenu'] = $leftSubMenu;

/*======= Sales ==========*/
$leftMenu['sales']['title'] = translate('Sales');
$leftMenu['sales']['url'] = 'javascript::void(0)';
$leftMenu['sales']['icon'] = 'ti-bar-chart';

$leftSubMenu = [];

$leftSubMenu['orders']['title'] = translate('Orders');
$leftSubMenu['orders']['url'] = route('admin.orders');
$leftSubMenu['orders']['icon'] = 'ion-ios-flag';

$leftSubMenu['affilliate_history']['title'] = translate('Affiliates history');
$leftSubMenu['affilliate_history']['url'] = route('admin.affilliate_history');
$leftSubMenu['affilliate_history']['icon'] = 'ion-ios-flag';

$leftSubMenu['supplier_history']['title'] = translate('Suppliers history');
$leftSubMenu['supplier_history']['url'] = route('admin.supplier_history');
$leftSubMenu['supplier_history']['icon'] = 'ion-ios-flag';

$leftSubMenu['hotel_history']['title'] = translate('Hotel history');
$leftSubMenu['hotel_history']['url'] = route('admin.hotel_history');
$leftSubMenu['hotel_history']['icon'] = 'ion-ios-flag';

$leftMenu['sales']['submenu'] = $leftSubMenu;

/*======= Financial ==========*/
$leftMenu['financial']['title'] = translate('Financial');
$leftMenu['financial']['url'] = 'javascript::void(0)';
$leftMenu['financial']['icon'] = 'ti-stats-up';

$leftSubMenu = [];

$leftSubMenu['transaction_history']['title'] = translate('Transaction History');
$leftSubMenu['transaction_history']['url'] = route('admin.transaction_history');
$leftSubMenu['transaction_history']['icon'] = 'ion-stats-bars';

$leftSubMenu['tax']['title'] = translate('Tax');
$leftSubMenu['tax']['url'] = route('admin.tax.add');
$leftSubMenu['tax']['icon'] = 'ion-ios-flag';

$leftMenu['financial']['submenu'] = $leftSubMenu;

/*======= Marketing ==========*/
$leftMenu['marketing']['title'] = translate('Marketing');
$leftMenu['marketing']['url'] = 'javascript::void(0)';
$leftMenu['marketing']['icon'] = 'ti-rss';

$leftSubMenu = [];

$leftSubMenu['coupon']['title'] = translate('Coupon');
$leftSubMenu['coupon']['url'] = route('admin.coupon');
$leftSubMenu['coupon']['icon'] = 'ion-ios-flag';

$leftMenu['marketing']['submenu'] = $leftSubMenu;

/*======= Teams ==========*/
$leftMenu['teams']['title'] = translate('Teams');
$leftMenu['teams']['url'] = route('admin.teams');
$leftMenu['teams']['icon'] = 'ti-link';

/*======= Setings ==========*/
$leftMenu['setting']['title'] = translate('Setting');
$leftMenu['setting']['url'] = route('admin.settings');
$leftMenu['setting']['icon'] = 'ti-settings';

?>

<nav class="pcoded-navbar" pcoded-header-position="relative">
    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
    <div class="pcoded-inner-navbar main-menu">
        <!-- <div class="">
           <div class="main-menu-header">
            </div>
        </div> -->
        <ul class="pcoded-item pcoded-left-item">
            @foreach ($leftMenu as $key => $value)
                @php
                    $hasSubMenu = 0;
                @endphp
                @if (isset($value['submenu']))
                    @php
                        $hasSubMenu = 1;
                    @endphp
                @endif
                <li
                    class="{{ set_TopMenu($value['title']) == ' active' ? 'pcoded-trigger' : '' }} @if ($hasSubMenu) pcoded-hasmenu @endif  {{ set_TopMenu($value['title']) }} ">
                    <a href="{{ $hasSubMenu ? '#' . $value['title'] : $value['url'] }}">
                        <span class="pcoded-micon"><i class="{{ $value['icon'] }}"></i></span>
                        <span class="pcoded-mtext" data-i18n="nav.dash.main">{{ $value['title'] }}</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    @isset($value['submenu'])
                        <ul class="pcoded-submenu">
                            @php
                                $count = 1;
                            @endphp
                            @foreach ($value['submenu'] as $subKey => $subValue)
                                @php
                                    $getSubmuenu = set_SubMenu($subValue['title']);
                                @endphp

                                @php
                                    $hasSubSubMenu = 0;
                                @endphp
                                @if (isset($subValue['subsubmenu']))
                                    @php
                                        $hasSubSubMenu = 1;
                                    @endphp
                                @endif

                                <li
                                    class="{{ set_TopMenu($subValue['title']) == ' active' ? 'pcoded-trigger' : '' }} @if ($hasSubSubMenu) pcoded-hasmenu @endif  {{ set_TopMenu($subValue['title']) }} ">

                                    <a href="{{ isset($subValue['subsubmenu']) ? '#' . $subKey : $subValue['url'] }}"
                                        data-i18n="nav.page_layout.vertical.static-layout">
                                        <span class="pcoded-micon"><i class="icon-chart"></i></span>
                                        <span class="pcoded-mtext">{{ $subValue['title'] }}</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                    @isset($subValue['subsubmenu'])
                                        <ul class="pcoded-submenu">
                                            @foreach ($subValue['subsubmenu'] as $subsubKey => $subsubValue)
                                                @php
                                                    $getSubSubmuenu = set_SubSubMenu($subsubValue['title']);
                                                @endphp
                                                <li class="{{ $getSubSubmuenu == 'newactive' ? 'active' : '' }}">
                                                    <a href="{{ isset($subsubValue['subsubmenu']) ? '#' . $subsubKey : $subsubValue['url'] }}"
                                                        data-i18n="nav.page_layout.vertical.static-layout">
                                                        <span class="pcoded-micon"><i class="icon-chart"></i></span>
                                                        <span class="pcoded-mtext">{{ $subsubValue['title'] }}</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endisset
                                </li>
                                @php
                                    $count++;
                                @endphp
                            @endforeach
                        </ul>
                    @endisset

                </li>
            @endforeach
        </ul>

    </div>
</nav>
