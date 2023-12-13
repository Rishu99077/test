<?php
$leftMenu = [];
/*======= Dashboard ==========*/
$leftMenu['dashboard']['title'] = 'Dashboard';
$leftMenu['dashboard']['url'] = route('admin.dashboard');
$leftMenu['dashboard']['icon'] = 'fas fa-chart-pie';

/*======= Category ==========*/
$leftMenu['category']['title'] = 'Category';
$leftMenu['category']['url'] = route('admin.category');
$leftMenu['category']['icon'] = 'fas fa-list-alt';

/*======= Settings ==========*/
$leftMenu['setting']['title'] = 'Settings';
$leftMenu['setting']['url'] = route('admin.settings');
$leftMenu['setting']['icon'] = 'fas fa-wrench';

$leftSubMenu = [];

$leftSubMenu['language']['title'] = __('admin.text_languages');
$leftSubMenu['language']['url'] = route('admin.language');

$leftSubMenu['currency']['title'] = 'Currency';
$leftSubMenu['currency']['url'] = route('admin.currency');

// $leftSubMenu['time_slot']['title'] = 'Time Slot';
// $leftSubMenu['time_slot']['url'] = route('admin.time_slot');

$leftSubMenu['countries']['title'] = 'Countries';
$leftSubMenu['countries']['url'] = route('admin.countries');
$leftSubMenu['countries']['title'] = 'Settings';
$leftSubMenu['countries']['url'] = route('admin.settings');

$leftSubMenu['states']['title'] = 'States';
$leftSubMenu['states']['url'] = route('admin.states');

$leftSubMenu['cities']['title'] = 'Cities';
$leftSubMenu['cities']['url'] = route('admin.cities');

$leftSubMenu['override_banner']['title'] = 'Over Ride Banner';
$leftSubMenu['override_banner']['url'] = route('admin.override_banner.edit', encrypt(1));

$leftSubMenu['contact_setting']['title'] = 'Contact setting';
$leftSubMenu['contact_setting']['url'] = route('admin.contact_setting.edit', encrypt(1));

$leftSubMenu['social_media']['title'] = 'Social Media Links';
$leftSubMenu['social_media']['url'] = route('admin.social_media.edit', encrypt(1));

$leftSubMenu['advertisment_banner']['title'] = 'Advertisment Banner';
$leftSubMenu['advertisment_banner']['url'] = route('admin.advertisment_banner.edit', encrypt(1));

$leftSubMenu['send_notification']['title'] = 'Send Notification';
$leftSubMenu['send_notification']['url'] = route('admin.send_notification.send');

$leftSubMenu['home_popup']['title'] = 'Home Popup';
$leftSubMenu['home_popup']['url'] = route('admin.home_popup');

$leftMenu['setting']['submenu'] = $leftSubMenu;

/*======= Product ==========*/
$leftMenu['product']['title'] = 'Product';
$leftMenu['product']['url'] = 'javascript::void(0)';
$leftMenu['product']['icon'] = 'fab fa-product-hunt';

$leftSubMenu = [];
$leftSubSubMenu = [];
$leftSubMenu['excursion']['title'] = translate('Excursion');
$leftSubMenu['excursion']['url'] = 'javascript:void()';

$leftSubSubMenu['excursion']['title'] = 'Add Excursion';
$leftSubSubMenu['excursion']['url'] = route('admin.excursion');

$leftSubSubMenu['time_slot']['title'] = 'Time Slot';
$leftSubSubMenu['time_slot']['url'] = route('admin.time_slot');

$leftSubSubMenu['car_details']['title'] = 'Car details';
$leftSubSubMenu['car_details']['url'] = route('admin.car_details');

$leftSubMenu['excursion']['subsubmenu'] = $leftSubSubMenu;

$leftSubSubMenu = [];
$leftSubMenu['transfer']['title'] = translate('Airport Transfer');
$leftSubMenu['transfer']['url'] = 'javascript:void()';

$leftSubSubMenu['transfer']['title'] = translate('Add Airport Transfer');
$leftSubSubMenu['transfer']['url'] = route('admin.transfer');

$leftSubSubMenu['airport']['title'] = 'Airport';
$leftSubSubMenu['airport']['url'] = route('admin.airport');

$leftSubSubMenu['zones']['title'] = 'Zones';
$leftSubSubMenu['zones']['url'] = route('admin.zones');

$leftSubSubMenu['locations']['title'] = 'Locations';
$leftSubSubMenu['locations']['url'] = route('admin.locations');

$leftSubSubMenu['car_type']['title'] = 'Car type';
$leftSubSubMenu['car_type']['url'] = route('admin.car_type');

$leftSubSubMenu['bus_type']['title'] = translate('Bus type');
$leftSubSubMenu['bus_type']['url'] = route('admin.bus_type');

// $leftSubSubMenu['car_model']['title'] = 'Car Models';
// $leftSubSubMenu['car_model']['url'] = route('admin.car_model');

$leftSubMenu['transfer']['subsubmenu'] = $leftSubSubMenu;

$leftSubMenu['lodge']['title'] = translate('Lodge');
$leftSubMenu['lodge']['url'] = route('admin.lodge');

$leftSubMenu['yachtes']['title'] = translate('Yacht');
$leftSubMenu['yachtes']['url'] = 'javascript:void()';

$leftSubSubMenu = [];

$leftSubSubMenu['yachtes']['title'] = translate('Add Yacht');
$leftSubSubMenu['yachtes']['url'] = route('admin.yachtes');

$leftSubSubMenu['transportation_vehicle']['title'] = 'Transportation Vehicle';
$leftSubSubMenu['transportation_vehicle']['url'] = route('admin.transportation_vehicle');

$leftSubSubMenu['boat_locations']['title'] = 'Boat Locations';
$leftSubSubMenu['boat_locations']['url'] = route('admin.boat_locations');

$leftSubSubMenu['boat_types']['title'] = 'Boat Types';
$leftSubSubMenu['boat_types']['url'] = route('admin.boat_types');

$leftSubMenu['yachtes']['subsubmenu'] = $leftSubSubMenu;

/*======= User ==========*/
$leftMenu['hotel']['title'] = 'Hotel';
$leftMenu['hotel']['url'] = route('admin.hotel_page');
$leftMenu['hotel']['icon'] = 'fas fa-user-friends';

$leftSubSubMenu = [];
$leftSubMenu['limousine']['title'] = translate('Limousine');
$leftSubMenu['limousine']['url'] = 'javascript:void()';

$leftSubSubMenu['limousine']['title'] = translate('Add Limousine');
$leftSubSubMenu['limousine']['url'] = route('admin.limousine');

$leftSubSubMenu['limousine_types']['title'] = 'Limousine Types';
$leftSubSubMenu['limousine_types']['url'] = route('admin.limousine_types');

$leftSubSubMenu['limousine_locations']['title'] = 'Limousine Locations';
$leftSubSubMenu['limousine_locations']['url'] = route('admin.limousine_locations');

$leftSubMenu['limousine']['subsubmenu'] = $leftSubSubMenu;

$leftSubSubMenu = [];
$leftSubMenu['golf']['title'] = translate('Golf');
$leftSubMenu['golf']['url'] = 'javascript:void()';

$leftSubSubMenu['golf']['title'] = translate('Add Golf');
$leftSubSubMenu['golf']['url'] = route('admin.golf');

$leftSubSubMenu['golf_courses']['title'] = 'Golf Course';
$leftSubSubMenu['golf_courses']['url'] = route('admin.golf_courses');

$leftSubMenu['golf']['subsubmenu'] = $leftSubSubMenu;

$leftMenu['product']['submenu'] = $leftSubMenu;

// dd($leftMenu,$leftSubMenu);

// /*======= Yachtes ==========*/
// $leftMenu['yachtes']['title'] = 'Yacht';
// $leftMenu['yachtes']['url'] = route('admin.yachtes');
// $leftMenu['yachtes']['icon'] = 'fas fa-bookmark';

/*======= Customer Group ==========*/
$leftMenu['customer_group']['title'] = translate('Customer Group');
$leftMenu['customer_group']['url'] = route('admin.customerGroup');
$leftMenu['customer_group']['icon'] = 'fas fa-user-tag';

/*======= Affiliate  ==========*/
$leftMenu['affiliate']['title'] = translate('Affiliate');
$leftMenu['affiliate']['url'] = 'javascript::void(0)';
$leftMenu['affiliate']['icon'] = 'fas fa-bookmark';
$leftSubMenu = [];

$leftSubMenu['add_affiliate']['title'] = translate('Add Affiliate');
$leftSubMenu['add_affiliate']['url'] = route('admin.affiliate');
$leftSubMenu['add_affiliate']['icon'] = 'fas fa-user-tag';

$leftSubMenu['commission']['title'] = translate('Commission');
$leftSubMenu['commission']['url'] = route('admin.commission');
$leftSubMenu['commission']['icon'] = 'fas fa-cogs';

$leftMenu['affiliate']['submenu'] = $leftSubMenu;

/*======= Orders ==========*/
$leftMenu['orders']['title'] = translate('Orders');
$leftMenu['orders']['url'] = route('admin.orders');
$leftMenu['orders']['icon'] = 'fas fa-user-tag';

$leftMenu['reports']['title'] = translate('Reports');
$leftMenu['reports']['url'] = 'javascript::void(0)';
$leftMenu['reports']['icon'] = 'fas fa-file';

$leftSubMenu = [];
$leftSubMenu['reports']['title'] = translate('Sales Report');
$leftSubMenu['reports']['url'] = route('admin.reports');
$leftSubMenu['reports']['icon'] = 'fas fa-bookmark';

$leftSubMenu['best_seller_report']['title'] = translate('Best Sellers Report');
$leftSubMenu['best_seller_report']['url'] = route('admin.best_seller_report');
$leftSubMenu['best_seller_report']['icon'] = 'fas fa-bookmark';

$leftSubMenu['upcoming_booking_report']['title'] = translate('Upcoming Booking Report');
$leftSubMenu['upcoming_booking_report']['url'] = route('admin.upcoming_booking_report');
$leftSubMenu['upcoming_booking_report']['icon'] = 'fas fa-bookmark';

$leftMenu['reports']['submenu'] = $leftSubMenu;

/*======= Request Form ==========*/

$leftMenu['request']['title'] = 'Request';
$leftMenu['request']['url'] = 'javascript::void(0)';
$leftMenu['request']['icon'] = 'fas fa-bookmark';
$leftSubMenu = [];

$leftSubMenu['limousine']['title'] = 'Limousine Request';
$leftSubMenu['limousine']['url'] = route('admin.product_request', 'type=Limousine');
$leftSubMenu['limousine']['icon'] = 'fas fa-bookmark';

$leftSubMenu['yacht']['title'] = 'Yacht Request';
$leftSubMenu['yacht']['url'] = route('admin.product_request', 'type=Yatch');
$leftSubMenu['yacht']['icon'] = 'fas fa-bookmark';

$leftSubMenu['lodge_request']['title'] = 'Lodge Request';
$leftSubMenu['lodge_request']['url'] = route('admin.product_request', 'type=lodge');
$leftSubMenu['lodge_request']['icon'] = 'fas fa-bookmark';

$leftSubMenu['excursion_request']['title'] = 'Excursion Request';
$leftSubMenu['excursion_request']['url'] = route('admin.product_request', 'type=excursion');
$leftSubMenu['excursion_request']['icon'] = 'fas fa-bookmark';

$leftMenu['request']['submenu'] = $leftSubMenu;

/*======= Rewards ==========*/
$leftMenu['rewardshare']['title'] = 'Rewards Share';
$leftMenu['rewardshare']['url'] = route('admin.rewardshare');
$leftMenu['rewardshare']['icon'] = 'fas fa-wrench';

/*======= User ==========*/
$leftMenu['supplier']['title'] = 'Supplier';
$leftMenu['supplier']['url'] = route('admin.supplier');
$leftMenu['supplier']['icon'] = 'fas fa-user-friends';

/*======= Staff ==========*/
$leftMenu['staff']['title'] = 'Staff';
$leftMenu['staff']['url'] = route('admin.staff');
$leftMenu['staff']['icon'] = 'fas fa-user-cog';

/*======= Media blog ==========*/
/*$leftMenu['media_blogs']['title'] = 'Media blog';
$leftMenu['media_blogs']['url'] = route('admin.media_blogs');
$leftMenu['media_blogs']['icon'] = 'fas fa-wrench';*/

/*======= CITY GUIDE blog ==========*/
$leftMenu['city_guide']['title'] = 'City Guide List';
$leftMenu['city_guide']['url'] = route('admin.city_guide');
$leftMenu['city_guide']['icon'] = 'fas fa-bookmark';

/*======= Partners ==========*/
$leftMenu['user']['title'] = 'Users';
$leftMenu['user']['url'] = route('admin.user');
$leftMenu['user']['icon'] = 'fas fa-user-cog';

/*======= Coupon Code ==========*/
$leftMenu['coupon_code']['title'] = 'Coupon Code';
$leftMenu['coupon_code']['url'] = route('admin.coupon_code');
$leftMenu['coupon_code']['icon'] = 'fas fa-user-friends';

/*======= Blogd Category ==========*/

$leftMenu['blog']['title'] = 'Blog';
$leftMenu['blog']['url'] = 'javascript::void(0)';
$leftMenu['blog']['icon'] = 'fas fa-bookmark';
$leftSubMenu = [];

$leftSubMenu['blog_category']['title'] = 'Blog Category';
$leftSubMenu['blog_category']['url'] = route('admin.blogsCategory');
$leftSubMenu['blog_category']['icon'] = 'fas fa-bookmark';

$leftSubMenu['blogs']['title'] = 'Blogs';
$leftSubMenu['blogs']['url'] = route('admin.blogs');
$leftSubMenu['blogs']['icon'] = 'fas fa-bookmark';

$leftMenu['blog']['submenu'] = $leftSubMenu;

/*======= Posts ==========*/
$leftMenu['posts']['title'] = 'Posts';
$leftMenu['posts']['url'] = route('admin.posts');
$leftMenu['posts']['icon'] = 'fas fa-wrench';

/*======= Partners ==========*/
$leftMenu['partner_list']['title'] = 'Partner';
$leftMenu['partner_list']['url'] = route('admin.partners_list');
$leftMenu['partner_list']['icon'] = 'fas fa-user-cog';

/*======= Reviews ==========*/
$leftMenu['user_reviews']['title'] = 'Reviews';
$leftMenu['user_reviews']['url'] = route('admin.user_reviews');
$leftMenu['user_reviews']['icon'] = 'fas fa-list-alt';

/*======= Posts ==========*/
$leftMenu['subscribers']['title'] = 'Subscribers list';
$leftMenu['subscribers']['url'] = route('admin.subscribers');
$leftMenu['subscribers']['icon'] = 'fas fa-wrench';

//*======= Pages ==========*/
$leftMenu['pages']['title'] = 'Pages';
$leftMenu['pages']['url'] = 'javascript::void(0)';
$leftMenu['pages']['icon'] = 'fas fa-bookmark';

$leftSubMenu = [];

$leftSubMenu['home_page']['title'] = 'Home Page';
$leftSubMenu['home_page']['url'] = route('admin.home_page.edit', encrypt(1));
$leftSubMenu['home_page']['icon'] = 'fas fa-bookmark';

$leftSubMenu['lodge_page']['title'] = 'Lodge Page';
$leftSubMenu['lodge_page']['url'] = route('admin.lodge_page.edit', encrypt(1));
$leftSubMenu['lodge_page']['icon'] = 'fas fa-bookmark';

$leftSubMenu['tour_page']['title'] = 'Tour Page';
$leftSubMenu['tour_page']['url'] = route('admin.tour_page.edit', encrypt(1));
$leftSubMenu['tour_page']['icon'] = 'fas fa-bookmark';

$leftSubMenu['affiliate_page']['title'] = 'Affiliate Page';
$leftSubMenu['affiliate_page']['url'] = route('admin.affiliate_page.edit', encrypt(1));
$leftSubMenu['affiliate_page']['icon'] = 'fas fa-bookmark';

$leftSubMenu['giftcard_page']['title'] = 'Gift Card';
$leftSubMenu['giftcard_page']['url'] = route('admin.giftcard_page.edit', encrypt(1));
$leftSubMenu['giftcard_page']['icon'] = 'fas fa-bookmark';

$leftSubMenu['transfer_page']['title'] = 'Transfer Page';
$leftSubMenu['transfer_page']['url'] = route('admin.transfer_page.edit', encrypt(1));
$leftSubMenu['transfer_page']['icon'] = 'fas fa-bookmark';

$leftSubMenu['limousine_page']['title'] = 'Limousine Page';
$leftSubMenu['limousine_page']['url'] = route('admin.limousine_page.edit', encrypt(1));
$leftSubMenu['limousine_page']['icon'] = 'fas fa-bookmark';

$leftSubMenu['yacht_page']['title'] = 'Yacht Page';
$leftSubMenu['yacht_page']['url'] = route('admin.yacht_page.edit', encrypt(1));
$leftSubMenu['yacht_page']['icon'] = 'fas fa-bookmark';

$leftSubMenu['media_mension_page']['title'] = 'Media Mensions Page';
$leftSubMenu['media_mension_page']['url'] = route('admin.media_mension_page.edit', encrypt(1));
$leftSubMenu['media_mension_page']['icon'] = 'fas fa-bookmark';

$leftSubMenu['partner_page']['title'] = 'Partners Login Page';
$leftSubMenu['partner_page']['url'] = route('admin.partner_page.edit', encrypt(1));
$leftSubMenu['partner_page']['icon'] = 'fas fa-bookmark';

$leftSubMenu['about_us_page']['title'] = 'About Us Page';
$leftSubMenu['about_us_page']['url'] = route('admin.about_us_page.edit', encrypt(1));
$leftSubMenu['about_us_page']['icon'] = 'fas fa-bookmark';

$leftSubMenu['adv_us_page']['title'] = 'Advertise Us Page';
$leftSubMenu['adv_us_page']['url'] = route('admin.advertise_us_page.edit', encrypt(1));
$leftSubMenu['adv_us_page']['icon'] = 'fas fa-bookmark';

$leftSubMenu['join_us_page']['title'] = 'Join Us Page';
$leftSubMenu['join_us_page']['url'] = route('admin.join_us_page.edit', encrypt(1));
$leftSubMenu['join_us_page']['icon'] = 'fas fa-bookmark';

$leftSubMenu['golf_page']['title'] = 'Golf Page';
$leftSubMenu['golf_page']['url'] = route('admin.golf_page.edit', encrypt(1));
$leftSubMenu['golf_page']['icon'] = 'fas fa-bookmark';

$leftSubMenu['city_guide_page']['title'] = 'City Guide Page';
$leftSubMenu['city_guide_page']['url'] = route('admin.city_guide_page.edit', encrypt(1));
$leftSubMenu['city_guide_page']['icon'] = 'fas fa-bookmark';

$leftSubMenu['term_condition_page']['title'] = 'Terms & Condition';
$leftSubMenu['term_condition_page']['url'] = route('admin.term_condition_page.edit', encrypt(1));
$leftSubMenu['term_condition_page']['icon'] = 'fas fa-bookmark';

$leftSubMenu['the_insider']['title'] = 'The Insider';
$leftSubMenu['the_insider']['url'] = route('admin.the_insider_page.edit', encrypt(1));
$leftSubMenu['the_insider']['icon'] = 'fas fa-bookmark';

$leftSubMenu['help_page']['title'] = 'Help';
$leftSubMenu['help_page']['url'] = route('admin.help_page.edit', encrypt(1));
$leftSubMenu['help_page']['icon'] = 'fas fa-bookmark';

$leftSubMenu['blog_page']['title'] = 'Blog page';
$leftSubMenu['blog_page']['url'] = route('admin.blog_page.edit', encrypt(1));
$leftSubMenu['blog_page']['icon'] = 'fas fa-bookmark';

$leftSubMenu['category_page']['title'] = 'Category page';
$leftSubMenu['category_page']['url'] = route('admin.category_page.edit', encrypt(1));
$leftSubMenu['category_page']['icon'] = 'fas fa-bookmark';

$leftMenu['pages']['submenu'] = $leftSubMenu;

/*======= Contents ==========*/
$leftMenu['contents']['title'] = 'Contents';
$leftMenu['contents']['url'] = 'javascript:void(0)';
$leftMenu['contents']['icon'] = 'fa-solid fa-handshake';
$leftSubMenu = [];
/*======= Partners ==========*/
$leftSubMenu['partners']['title'] = 'Partners';
$leftSubMenu['partners']['url'] = route('admin.partners.add');
$leftSubMenu['partners']['icon'] = 'fa-solid fa-handshake';

/*======= Testimonials ==========*/
$leftSubMenu['testimonials']['title'] = 'Testimonials';
$leftSubMenu['testimonials']['url'] = route('admin.testimonials.add');
$leftSubMenu['testimonials']['icon'] = 'fa-sharp fa-solid fa-comments';

/*======= Gift An Expireance ==========*/
$leftSubMenu['gift_card']['title'] = 'Gift an Experience';
$leftSubMenu['gift_card']['url'] = route('admin.gift_an_expirence.add');
$leftSubMenu['gift_card']['icon'] = 'fa-sharp fa-solid fa-comments';

/*======= Faqs ==========*/
$leftSubMenu['faqs']['title'] = 'Faqs';
$leftSubMenu['faqs']['url'] = route('admin.faqs');
$leftSubMenu['faqs']['icon'] = 'fas fa-bookmark';

/*======= Faqs ==========*/
$leftSubMenu['faq_category']['title'] = 'Faqs Category';
$leftSubMenu['faq_category']['url'] = route('admin.faq_category');
$leftSubMenu['faq_category']['icon'] = 'fas fa-bookmark';

/*======= Legal Stuff ==========*/
$leftSubMenu['legal_stuff']['title'] = 'Legal Stuff';
$leftSubMenu['legal_stuff']['url'] = route('admin.legal_stuff');
$leftSubMenu['legal_stuff']['icon'] = 'fas fa-info';

/*======= Partners ==========*/
$leftSubMenu['side_banner']['title'] = 'Side Banner';
$leftSubMenu['side_banner']['url'] = route('admin.side_banner.add');
$leftSubMenu['side_banner']['icon'] = 'fa-solid fa-handshake';

/*======= Profile Banner ==========*/
$leftSubMenu['profile_banner']['title'] = 'My Profile Banner';
$leftSubMenu['profile_banner']['url'] = route('admin.profile_banner.add');
$leftSubMenu['profile_banner']['icon'] = 'fa-solid fa-handshake';

$leftMenu['contents']['submenu'] = $leftSubMenu;

?>
<nav class="navbar navbar-light navbar-vertical navbar-expand-xl navbar-card">
    <div class="d-flex align-items-center">
        <div class="toggle-icon-wrapper">
            <button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle" data-bs-toggle="tooltip"
                data-bs-placement="left" title="Toggle Navigation"><span class="navbar-toggle-icon"><span
                        class="toggle-line"></span></span></button>
        </div><a class="navbar-brand" href="{{ route('admin.dashboard') }}">
            <div class="d-flex align-items-center py-3">
                <img class="me-2"
                    src="{{ get_setting_data('header_logo') != '' ? url('uploads/setting', get_setting_data('header_logo')) : asset('front_assets/images/logo.png') }}"
                    alt="" width="150" />
            </div>
        </a>
    </div>

    <div class="collapse navbar-collapse mt-3" id="navbarVerticalCollapse">
        <div class="navbar-vertical-content scrollbar">
            <ul class="navbar-nav nav_menu flex-column mt-3 mb-3" id="navbarVerticalNav">
                {{-- {{ dd($leftMenu) }} --}}

                @foreach ($leftMenu as $key => $value)
                    @php
                        $hasSubMenu = 0;
                    @endphp
                    @if (isset($value['submenu']))
                        @php
                            $hasSubMenu = 1;
                        @endphp
                    @endif
                    <li class="nav-item">
                        <a class="nav-link @if ($hasSubMenu) dropdown-indicator @endif {{ set_TopMenu($value['title']) }}"
                            href="{{ $hasSubMenu ? '#' . $value['title'] : $value['url'] }}" role="button"
                            @if ($hasSubMenu) data-bs-toggle="collapse" aria-expanded="false" aria-controls="{{ $value['title'] }}" @endif>

                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <span class="{{ $value['icon'] }}"></span>
                                </span>
                                <span class="nav-link-text ps-1">{{ $value['title'] }}</span>
                            </div>
                        </a>
                        @isset($value['submenu'])
                            <ul class="nav collapse false {{ set_Collapse($value['title']) }}" id="{{ $value['title'] }}">
                                @php
                                    $count = 1;
                                @endphp
                                @foreach ($value['submenu'] as $subKey => $subValue)
                                    <li class="nav-item">
                                        @php
                                            $getSubmuenu = set_SubMenu($subValue['title']);
                                        @endphp

                                        <a class="nav-link {{ $getSubmuenu == 'newactive' ? 'active' : '' }} @isset($subValue['subsubmenu']) dropdown-indicator @endisset submenu-nav-link mt-2"
                                            @isset($subValue['subsubmenu']) data-bs-toggle="collapse" role="button" @endisset
                                            href="{{ isset($subValue['subsubmenu']) ? '#' . $subKey : $subValue['url'] }}">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text ps-1">

                                                    @if ($getSubmuenu == 'newactive')
                                                        <i class="fas fa-minus"></i>
                                                    @endif
                                                    {{ $subValue['title'] }}
                                                </span>
                                            </div>
                                        </a><!-- more inner pages-->
                                        @isset($subValue['subsubmenu'])
                                            <ul class="nav collapse false {{ set_Collapse($subValue['title']) }}"
                                                id="{{ $subKey }}">
                                                @foreach ($subValue['subsubmenu'] as $subsubKey => $subsubValue)
                                                    @php
                                                        $getSubSubmuenu = set_SubSubMenu($subsubValue['title']);
                                                    @endphp
                                                    <li class="nav-item">
                                                        <a class="nav-link  submenu-nav-link mt-2"
                                                            href="{{ $subsubValue['url'] }}">
                                                            <div class="d-flex align-items-center">
                                                                <span class="nav-link-text ps-1">
                                                                    @if ($getSubSubmuenu == 'newactive')
                                                                        <i class="fas fa-minus"></i>
                                                                    @endif
                                                                    {{ $subsubValue['title'] }}
                                                                </span>
                                                            </div>
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
    </div>
</nav>
