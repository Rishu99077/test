<nav class="navbar header-navbar pcoded-header" header-theme="theme4" pcoded-header-position="fixed">
    <div class="navbar-wrapper">
        <div class="navbar-logo">
            <a class="mobile-menu" id="mobile-collapse" href="#!">
                <i class="ti-menu"></i>
            </a>
            <a class="mobile-search morphsearch-search" href="#">
                <i class="ti-search"></i>
            </a>
            <a href="{{ route('admin.dashboard') }}">
                <img class="img-fluid my-logo mt-3"
                    src="{{ get_setting_data('header_logo') != '' ? url('uploads/setting', get_setting_data('header_logo')) : asset('assets/images/logo.png') }}"
                    alt="Theme-Logo" />
            </a>
            <a class="mobile-options">
                <i class="ti-more"></i>
            </a>
        </div>
        <div class="navbar-container container-fluid">
            <div>
                @php
                    $get_languages = App\Models\Languages::where('status', 'Active')->get();
                    $Session_lang_id = Session::get('Lang');
                    $getLang = getLang();
                @endphp

                <ul class="nav-left">
                </ul>
                <ul class="nav-right">
                    <ul class="nav-right">
                        <li class="header-notification lng-dropdown">
                            <a href="#" id="dropdown-active-item">
                                <img src="{{ asset('uploads/language_flag/' . $getLang->flag) }}" alt="">
                                <?php echo $getLang->title; ?>
                            </a>
                            <ul class="show-notification">
                                @foreach ($get_languages as $Lang)
                                    <li class="lang_chng cursor-pointer" data-id={{ $Lang['id'] }}>
                                        <img src="{{ asset('uploads/language_flag/' . $Lang['flag']) }}" class="w-10"
                                            alt="">
                                        {{ $Lang['title'] }}

                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="user-profile header-notification">
                            <a href="#!">

                                <img src="{{ get_admin_data('', 'image') != '' ? url('uploads/admin_image', get_admin_data('', 'image')) : asset('assets/images/user.png') }}"
                                    alt="User-Profile-Image">
                                <span>{{ get_admin_data('', 'first_name') }}
                                    {{ get_admin_data('', 'last_name') }}</span>
                                <i class="ti-angle-down"></i>
                            </a>
                            <ul class="show-notification profile-notification">
                                <li>
                                    <a href="{{ route('admin.profile') }}">
                                        <i class="ti-user"></i> {{ translate('View Profile') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.settings') }}">
                                        <i class="ti-settings"></i> {{ translate('Settings') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.changepassword') }}">
                                        <i class="ti-settings"></i> {{ translate('Change Password') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.logout') }}">
                                        <i class="ti-layout-sidebar-left"></i> {{ translate('Logout') }}
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
            </div>
        </div>
    </div>
</nav>
