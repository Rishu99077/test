
<div class="left_menu">
    <div class="ver_scroll">

        <div class="top_sec">
            <div class="toggle d-inline-block">
                <span class="toggle_nav">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15">
                        <path id="Icon_ionic-ios-arrow-dropright-circle"
                            data-name="Icon ionic-ios-arrow-dropright-circle"
                            d="M3.375,10.875a7.5,7.5,0,1,0,7.5-7.5A7.5,7.5,0,0,0,3.375,10.875Zm8.816,0L9.238,7.951a.7.7,0,1,1,.984-.984l3.44,3.451a.7.7,0,0,1,.022.959l-3.389,3.4A.695.695,0,1,1,9.31,13.8Z"
                            transform="translate(18.375 18.375) rotate(180)" fill="#fff" />
                    </svg>

                </span>
            </div>
            <div class="logo">
                <a href="#"><img class="" src="{{ asset('admin/assets/images/logo.png') }}" alt="" srcset=""></a>
            </div>

            <div class="das_admin d-flex align-items-center justify-content-between">
                <div class="das_img"><img src="{{ url('profile',$user['profile_image']) }}" alt=""></div>
                <div class="das_name">
                    <h3 class="f14 mb0">{{$user['first_name']}} {{$user['last_name']}}</h3>
                    <p class="f12">{{$user['email']}}</p>
                </div>
            </div>

        </div>

        <nav class="sidebar py-2 mb-4">
            <ul class="nav flex-column side_menu" id="nav_accordion">


               <!--  <li class="nav-item">
                    <a href="javascript:void(0)" class="menu_items lang">
                        <span class="menu_icons">
                            <img src="{{ asset('admin/assets/images/flg.png') }}" alt="">
                        </span>
                        <select name="language_converter" id="" class="language_converter text_menu">
                          <?php 
                                 $languages = App\Models\LanguagesModel::get();

                                 foreach($languages as $key => $value){
                                ?>

                                <option value="{{$value['id']}}"<?php echo session()->get('language_id') == $value['id'] ? "selected" : ""; ?>>{{$value['name']}}</option>
                                <?php 
                                 }
                                ?>
                        </select>
                    </a>
                </li> -->

                <li class="nav-item">
                    <a href="{{Route('admin_dashboard')}}" class="menu_items <?php if($common['main_menu']=='Dashboard'){echo "active"; } ?>">
                        <span class="menu_icons">

                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <g id="Group_3483" data-name="Group 3483" transform="translate(-3027 -150)">
                                    <g id="Rectangle_1624" data-name="Rectangle 1624"
                                        transform="translate(3027 150)" fill="none" stroke="#707070"
                                        stroke-width="1" opacity="0">
                                        <rect width="24" height="24" stroke="none" />
                                        <rect x="0.5" y="0.5" width="23" height="23" fill="none" />
                                    </g>
                                    <g id="fi-sr-home" transform="translate(3030 152.985)">
                                        <path id="Path_52279" data-name="Path 52279"
                                            d="M17.578,7.874,11.2.979A3,3,0,0,0,6.8.979L.436,7.872A1.5,1.5,0,0,0,0,8.93v6.834a2.251,2.251,0,0,0,2.25,2.251h3v-4.5A3.741,3.741,0,0,1,7.221,10.23c.037-.021.075-.042.114-.062a3.726,3.726,0,0,1,.432-.182c.1-.037.2-.068.31-.1s.233-.053.353-.075c.066-.011.128-.033.2-.04.116-.011.225-.014.341-.014.012,0,.023,0,.034,0h.013a3.748,3.748,0,0,1,.691.07c.026.005.051.008.075.013a3.759,3.759,0,0,1,.626.2c.028.011.057.022.085.035a3.722,3.722,0,0,1,.556.3l.083.056a3.779,3.779,0,0,1,.482.4c.024.023.047.047.07.071a3.872,3.872,0,0,1,.4.485l.051.075a3.8,3.8,0,0,1,.307.565c.01.024.018.048.028.075a3.725,3.725,0,0,1,.2.642.293.293,0,0,0,.008.05,3.735,3.735,0,0,1,.073.727v4.5h3A2.251,2.251,0,0,0,18,15.764V8.919A1.5,1.5,0,0,0,17.578,7.874Z"
                                            transform="translate(0)" fill="#fff" />
                                        <path id="Path_52280" data-name="Path 52280"
                                            d="M11.25,15A2.251,2.251,0,0,0,9,17.251v4.5h4.5v-4.5A2.251,2.251,0,0,0,11.25,15Z"
                                            transform="translate(-2.25 -3.739)" fill="#fff" />
                                    </g>
                                </g>
                            </svg>
                        </span>
                        <span class="text_menu">{{__("admin.text_dashboard")}}</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{Route('admin_assistant')}}" class="menu_items <?php if($common['main_menu']=='Assistant'){echo "active"; } ?>">
                        <span class="menu_icons"><i class="fa fa-users"></i></span>
                        <span class="text_menu">{{__("admin.text_assistant")}}</span>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="{{Route('admin_my_profile')}}" class="menu_items <?php if($common['main_menu']=='My-profile'){echo "active"; } ?> ">
                        <span class="menu_icons">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <g id="Group_3558" data-name="Group 3558" transform="translate(-3024 -150)">
                                    <path id="user"
                                        d="M15,14.894a3.4,3.4,0,0,1-.732,2.192A2.195,2.195,0,0,1,12.5,18H2.5a2.194,2.194,0,0,1-1.763-.914A3.4,3.4,0,0,1,0,14.894a16.859,16.859,0,0,1,.1-1.881,10.1,10.1,0,0,1,.369-1.781A5.927,5.927,0,0,1,1.154,9.7a3.283,3.283,0,0,1,1.1-1.043,3.04,3.04,0,0,1,1.577-.4A5.065,5.065,0,0,0,7.5,9.75a5.065,5.065,0,0,0,3.668-1.5,3.042,3.042,0,0,1,1.576.4,3.283,3.283,0,0,1,1.1,1.043,5.927,5.927,0,0,1,.686,1.535,10.1,10.1,0,0,1,.369,1.782A16.859,16.859,0,0,1,15,14.9ZM12,4.5a4.334,4.334,0,0,1-1.319,3.182A4.338,4.338,0,0,1,7.5,9,4.333,4.333,0,0,1,4.319,7.682,4.337,4.337,0,0,1,3,4.5,4.337,4.337,0,0,1,4.319,1.319,4.333,4.333,0,0,1,7.5,0a4.338,4.338,0,0,1,3.181,1.319A4.334,4.334,0,0,1,12,4.5Z"
                                        transform="translate(3029 153)" fill="#19286b" />
                                    <g id="Rectangle_1720" data-name="Rectangle 1720"
                                        transform="translate(3024 150)" fill="none" stroke="#707070"
                                        stroke-width="1" opacity="0">
                                        <rect width="24" height="24" stroke="none" />
                                        <rect x="0.5" y="0.5" width="23" height="23" fill="none" />
                                    </g>
                                </g>
                            </svg>
                        </span>
                        <span class="text_menu">{{__("admin.text_my_profile")}}</span>
                    </a>

                </li>

                <li class="nav-item has-submenu">
                    <a class="nav-link" href="#">
                        <span class="menu_icons">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g transform="translate(-2112 270)"><g transform="translate(20)"><circle cx="2.25" cy="2.25" r="2.25" transform="translate(2095 -267)" fill="#19286b"/><circle cx="2.25" cy="2.25" r="2.25" transform="translate(2101.75 -267)" fill="#19286b"/><circle cx="2.25" cy="2.25" r="2.25" transform="translate(2108.5 -267)" fill="#19286b"/><circle cx="2.25" cy="2.25" r="2.25" transform="translate(2095 -260.25)" fill="#19286b"/><circle cx="2.25" cy="2.25" r="2.25" transform="translate(2101.75 -260.25)" fill="#19286b"/><circle cx="2.25" cy="2.25" r="2.25" transform="translate(2108.5 -260.25)" fill="#19286b"/><circle cx="2.25" cy="2.25" r="2.25" transform="translate(2095 -253.5)" fill="#19286b"/><circle cx="2.25" cy="2.25" r="2.25" transform="translate(2101.75 -253.5)" fill="#19286b"/><circle cx="2.25" cy="2.25" r="2.25" transform="translate(2108.5 -253.5)" fill="#19286b"/></g><path id="user" d="M1,1V23H23V1H1M0,0H24V24H0Z" transform="translate(2112 -270)" fill="#707070" opacity="0" fill="#19286b"/></g></svg>
                        </span>
                        <span class="text_menu">{{__("admin.text_menu")}}</span>
                    </a>
                    <ul class="submenu collapse <?php if($common['main_menu']=='Menu'){echo "show"; } ?>">
                        <li>
                            <a href="{{Route('faqs')}}" class="nav-link <?php if($common['sub_menu']=='Faqs'){echo "active"; } ?>">
                               Faqs
                            </a>
                        </li>

                        <li>
                            <a href="{{Route('notifications')}}" class="nav-link <?php if($common['sub_menu']=='Notification'){echo "active"; } ?>">{{__("admin.text_send_notification")}}</a>
                        </li>

                        <li>
                            <a href="{{Route('testimonials')}}" class="nav-link <?php if($common['sub_menu']=='Testimonials'){echo "active"; } ?>">{{__("admin.text_testimonials")}}</a>
                        </li>       

                        <li>
                            <a href="{{Route('contacts')}}" class="menu_items <?php if($common['sub_menu']=='Contacts'){echo "active"; } ?>">{{__("admin.text_contacts")}}</a>
                        </li>

                        <li>
                            <a href="{{Route('admin_chat')}}" class="nav-link <?php if($common['sub_menu']=='chat'){echo "active"; } ?>">{{__("admin.text_chat")}}</a>
                        </li>

                        <li>
                            <a href="{{ Route('work_seeker', array('title' => 'seeker')) }}" class="nav-link <?php if($common['sub_menu']=='Work_seeker'){echo "active"; } ?>">{{__("admin.text_seeker_how")}}</a>
                        </li>

                        <li>
                            <a href="{{ Route('work_seeker', array('title' => 'provider')) }}" class="nav-link <?php if($common['sub_menu']=='Work_seeker'){echo "active"; } ?>">{{__("admin.text_provider_how")}}</a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{Route('all_customers')}}" class="menu_items <?php if($common['main_menu']=='customers'){echo "active"; } ?>">
                        <span class="menu_icons">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <g id="Group_3558" data-name="Group 3558" transform="translate(-3024 -150)">
                                    <path id="user"
                                        d="M15,14.894a3.4,3.4,0,0,1-.732,2.192A2.195,2.195,0,0,1,12.5,18H2.5a2.194,2.194,0,0,1-1.763-.914A3.4,3.4,0,0,1,0,14.894a16.859,16.859,0,0,1,.1-1.881,10.1,10.1,0,0,1,.369-1.781A5.927,5.927,0,0,1,1.154,9.7a3.283,3.283,0,0,1,1.1-1.043,3.04,3.04,0,0,1,1.577-.4A5.065,5.065,0,0,0,7.5,9.75a5.065,5.065,0,0,0,3.668-1.5,3.042,3.042,0,0,1,1.576.4,3.283,3.283,0,0,1,1.1,1.043,5.927,5.927,0,0,1,.686,1.535,10.1,10.1,0,0,1,.369,1.782A16.859,16.859,0,0,1,15,14.9ZM12,4.5a4.334,4.334,0,0,1-1.319,3.182A4.338,4.338,0,0,1,7.5,9,4.333,4.333,0,0,1,4.319,7.682,4.337,4.337,0,0,1,3,4.5,4.337,4.337,0,0,1,4.319,1.319,4.333,4.333,0,0,1,7.5,0a4.338,4.338,0,0,1,3.181,1.319A4.334,4.334,0,0,1,12,4.5Z"
                                        transform="translate(3029 153)" fill="#19286b" />
                                    <g id="Rectangle_1720" data-name="Rectangle 1720"
                                        transform="translate(3024 150)" fill="none" stroke="#707070"
                                        stroke-width="1" opacity="0">
                                        <rect width="24" height="24" stroke="none" />
                                        <rect x="0.5" y="0.5" width="23" height="23" fill="none" />
                                    </g>
                                </g>
                            </svg>
                        </span>
                        <span class="text_menu">{{__("admin.text_seekers")}}</span>
                    </a>

                </li>

                <li class="nav-item ">
                    <a href="{{Route('all_providers')}}" class="menu_items <?php if($common['main_menu']=='providers'){echo "active"; } ?>">
                        <span class="menu_icons">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <g id="Group_3558" data-name="Group 3558" transform="translate(-3024 -150)">
                                    <path id="user"
                                        d="M15,14.894a3.4,3.4,0,0,1-.732,2.192A2.195,2.195,0,0,1,12.5,18H2.5a2.194,2.194,0,0,1-1.763-.914A3.4,3.4,0,0,1,0,14.894a16.859,16.859,0,0,1,.1-1.881,10.1,10.1,0,0,1,.369-1.781A5.927,5.927,0,0,1,1.154,9.7a3.283,3.283,0,0,1,1.1-1.043,3.04,3.04,0,0,1,1.577-.4A5.065,5.065,0,0,0,7.5,9.75a5.065,5.065,0,0,0,3.668-1.5,3.042,3.042,0,0,1,1.576.4,3.283,3.283,0,0,1,1.1,1.043,5.927,5.927,0,0,1,.686,1.535,10.1,10.1,0,0,1,.369,1.782A16.859,16.859,0,0,1,15,14.9ZM12,4.5a4.334,4.334,0,0,1-1.319,3.182A4.338,4.338,0,0,1,7.5,9,4.333,4.333,0,0,1,4.319,7.682,4.337,4.337,0,0,1,3,4.5,4.337,4.337,0,0,1,4.319,1.319,4.333,4.333,0,0,1,7.5,0a4.338,4.338,0,0,1,3.181,1.319A4.334,4.334,0,0,1,12,4.5Z"
                                        transform="translate(3029 153)" fill="#19286b" />
                                    <g id="Rectangle_1720" data-name="Rectangle 1720"
                                        transform="translate(3024 150)" fill="none" stroke="#707070"
                                        stroke-width="1" opacity="0">
                                        <rect width="24" height="24" stroke="none" />
                                        <rect x="0.5" y="0.5" width="23" height="23" fill="none" />
                                    </g>
                                </g>
                            </svg>
                        </span>
                        <span class="text_menu">{{__("admin.text_providers")}}</span>
                    </a>

                </li>

                <li class="nav-item">
                    <a href="{{Route('all_jobs')}}" class="menu_items <?php if($common['main_menu']=='Posted jobs'){echo "active"; } ?>">
                        <span class="menu_icons">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <g id="Group_3558" data-name="Group 3558" transform="translate(-3024 -150)">
                                    <path id="user"
                                        d="M15,14.894a3.4,3.4,0,0,1-.732,2.192A2.195,2.195,0,0,1,12.5,18H2.5a2.194,2.194,0,0,1-1.763-.914A3.4,3.4,0,0,1,0,14.894a16.859,16.859,0,0,1,.1-1.881,10.1,10.1,0,0,1,.369-1.781A5.927,5.927,0,0,1,1.154,9.7a3.283,3.283,0,0,1,1.1-1.043,3.04,3.04,0,0,1,1.577-.4A5.065,5.065,0,0,0,7.5,9.75a5.065,5.065,0,0,0,3.668-1.5,3.042,3.042,0,0,1,1.576.4,3.283,3.283,0,0,1,1.1,1.043,5.927,5.927,0,0,1,.686,1.535,10.1,10.1,0,0,1,.369,1.782A16.859,16.859,0,0,1,15,14.9ZM12,4.5a4.334,4.334,0,0,1-1.319,3.182A4.338,4.338,0,0,1,7.5,9,4.333,4.333,0,0,1,4.319,7.682,4.337,4.337,0,0,1,3,4.5,4.337,4.337,0,0,1,4.319,1.319,4.333,4.333,0,0,1,7.5,0a4.338,4.338,0,0,1,3.181,1.319A4.334,4.334,0,0,1,12,4.5Z"
                                        transform="translate(3029 153)" fill="#19286b" />
                                    <g id="Rectangle_1720" data-name="Rectangle 1720"
                                        transform="translate(3024 150)" fill="none" stroke="#707070"
                                        stroke-width="1" opacity="0">
                                        <rect width="24" height="24" stroke="none" />
                                        <rect x="0.5" y="0.5" width="23" height="23" fill="none" />
                                    </g>
                                </g>
                            </svg>
                        </span>
                        <span class="text_menu">{{__("admin.text_posted_job")}}</span>
                    </a>
                </li>


                <li class="nav-item ">
                    <a href="{{Route('contracts')}}" class="menu_items <?php if($common['main_menu']=='Contracts'){echo "active"; } ?>">
                        <span class="menu_icons">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <g id="Group_3558" data-name="Group 3558" transform="translate(-3024 -150)">
                                    <path id="user"
                                        d="M15,14.894a3.4,3.4,0,0,1-.732,2.192A2.195,2.195,0,0,1,12.5,18H2.5a2.194,2.194,0,0,1-1.763-.914A3.4,3.4,0,0,1,0,14.894a16.859,16.859,0,0,1,.1-1.881,10.1,10.1,0,0,1,.369-1.781A5.927,5.927,0,0,1,1.154,9.7a3.283,3.283,0,0,1,1.1-1.043,3.04,3.04,0,0,1,1.577-.4A5.065,5.065,0,0,0,7.5,9.75a5.065,5.065,0,0,0,3.668-1.5,3.042,3.042,0,0,1,1.576.4,3.283,3.283,0,0,1,1.1,1.043,5.927,5.927,0,0,1,.686,1.535,10.1,10.1,0,0,1,.369,1.782A16.859,16.859,0,0,1,15,14.9ZM12,4.5a4.334,4.334,0,0,1-1.319,3.182A4.338,4.338,0,0,1,7.5,9,4.333,4.333,0,0,1,4.319,7.682,4.337,4.337,0,0,1,3,4.5,4.337,4.337,0,0,1,4.319,1.319,4.333,4.333,0,0,1,7.5,0a4.338,4.338,0,0,1,3.181,1.319A4.334,4.334,0,0,1,12,4.5Z"
                                        transform="translate(3029 153)" fill="#19286b" />
                                    <g id="Rectangle_1720" data-name="Rectangle 1720"
                                        transform="translate(3024 150)" fill="none" stroke="#707070"
                                        stroke-width="1" opacity="0">
                                        <rect width="24" height="24" stroke="none" />
                                        <rect x="0.5" y="0.5" width="23" height="23" fill="none" />
                                    </g>
                                </g>
                            </svg>
                        </span>
                        <span class="text_menu">{{__("admin.text_contracts")}}</span>
                    </a>

                </li>

                <li class="nav-item">
                    <a href="{{Route('jobs_vacancies')}}" class="menu_items <?php if($common['main_menu']=='Job vacancies'){echo "active"; } ?>">
                        <span class="menu_icons">
                            <img src="{{ asset('admin/assets/images/cont.png') }}" alt="">
                        </span>
                        <!-- <span class="text_menu">Job Vacancies</span> -->
                        <span class="text_menu">{{__("admin.text_reports")}}</span>
                    </a>

                </li>

                <li class="nav-item">
                    <a href="{{Route('admin_other_documents')}}" class="menu_items <?php if($common['main_menu']=='other_documents'){echo "active"; } ?>">
                        <span class="menu_icons">
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <g id="Group_3505" data-name="Group 3505" transform="translate(-3034 -248)">
                                    <g id="fi-sr-folder" transform="translate(3037 250.75)">
                                        <path id="Path_52286" data-name="Path 52286"
                                            d="M0,8.963V15.72a3.755,3.755,0,0,0,3.75,3.75h10.5A3.754,3.754,0,0,0,18,15.72V8.88Z"
                                            transform="translate(0 -1.97)" fill="#19286b" />
                
                                        <path id="Path_52287" data-name="Path 52287"
                                            d="M14.25,2.5h-4.9a.764.764,0,0,1-.335-.075L6.652,1.237A2.261,2.261,0,0,0,5.646,1H3.75A3.755,3.755,0,0,0,0,4.75v.743L17.9,5.41A3.75,3.75,0,0,0,14.25,2.5Z"
                                            fill="#19286b" />
                                    </g>
                                    <g id="Rectangle_1647" data-name="Rectangle 1647"
                                        transform="translate(3034 248)" fill="none" stroke="#707070"
                                        stroke-width="1" opacity="0">
                                        <rect width="24" height="24" stroke="none" />
                                        <rect x="0.5" y="0.5" width="23" height="23" fill="none" />
                                    </g>
                                </g>
                            </svg>
                        </span>
                        <span class="text_menu">{{__("admin.text_other_docs")}}</span>
                    </a>

                </li>  

                <li class="nav-item">
                    <a href="{{Route('providers_list')}}" class="menu_items <?php if($common['main_menu']=='Applicants'){echo "active"; } ?>">
                        <span class="menu_icons">
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <g id="Group_3505" data-name="Group 3505" transform="translate(-3034 -248)">
                                    <g id="fi-sr-folder" transform="translate(3037 250.75)">
                                        <path id="Path_52286" data-name="Path 52286"
                                            d="M0,8.963V15.72a3.755,3.755,0,0,0,3.75,3.75h10.5A3.754,3.754,0,0,0,18,15.72V8.88Z"
                                            transform="translate(0 -1.97)" fill="#19286b" />
                
                                        <path id="Path_52287" data-name="Path 52287"
                                            d="M14.25,2.5h-4.9a.764.764,0,0,1-.335-.075L6.652,1.237A2.261,2.261,0,0,0,5.646,1H3.75A3.755,3.755,0,0,0,0,4.75v.743L17.9,5.41A3.75,3.75,0,0,0,14.25,2.5Z"
                                            fill="#19286b" />
                                    </g>
                                    <g id="Rectangle_1647" data-name="Rectangle 1647"
                                        transform="translate(3034 248)" fill="none" stroke="#707070"
                                        stroke-width="1" opacity="0">
                                        <rect width="24" height="24" stroke="none" />
                                        <rect x="0.5" y="0.5" width="23" height="23" fill="none" />
                                    </g>
                                </g>
                            </svg>
                        </span>
                        <span class="text_menu">{{__("admin.text_applicants")}}</span>
                    </a>

                </li>  

                <li class="nav-item">
                    <a href="{{Route('employes_list')}}" class="menu_items <?php if($common['main_menu']=='Employees'){echo "active"; } ?>">
                        <span class="menu_icons">
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <g id="Group_3505" data-name="Group 3505" transform="translate(-3034 -248)">
                                    <g id="fi-sr-folder" transform="translate(3037 250.75)">
                                        <path id="Path_52286" data-name="Path 52286"
                                            d="M0,8.963V15.72a3.755,3.755,0,0,0,3.75,3.75h10.5A3.754,3.754,0,0,0,18,15.72V8.88Z"
                                            transform="translate(0 -1.97)" fill="#19286b" />
                
                                        <path id="Path_52287" data-name="Path 52287"
                                            d="M14.25,2.5h-4.9a.764.764,0,0,1-.335-.075L6.652,1.237A2.261,2.261,0,0,0,5.646,1H3.75A3.755,3.755,0,0,0,0,4.75v.743L17.9,5.41A3.75,3.75,0,0,0,14.25,2.5Z"
                                            fill="#19286b" />
                                    </g>
                                    <g id="Rectangle_1647" data-name="Rectangle 1647"
                                        transform="translate(3034 248)" fill="none" stroke="#707070"
                                        stroke-width="1" opacity="0">
                                        <rect width="24" height="24" stroke="none" />
                                        <rect x="0.5" y="0.5" width="23" height="23" fill="none" />
                                    </g>
                                </g>
                            </svg>
                        </span>
                        <span class="text_menu">{{__("admin.text_employees")}}</span>
                    </a>

                </li> 

                <li class="nav-item">
                    <a href="{{Route('seeker_advertisment')}}" class="menu_items <?php if($common['main_menu']=='advertisment'){echo "active"; } ?>">
                        <span class="menu_icons">
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <g id="Group_3505" data-name="Group 3505" transform="translate(-3034 -248)">
                                    <g id="fi-sr-folder" transform="translate(3037 250.75)">
                                        <path id="Path_52286" data-name="Path 52286"
                                            d="M0,8.963V15.72a3.755,3.755,0,0,0,3.75,3.75h10.5A3.754,3.754,0,0,0,18,15.72V8.88Z"
                                            transform="translate(0 -1.97)" fill="#19286b" />
                
                                        <path id="Path_52287" data-name="Path 52287"
                                            d="M14.25,2.5h-4.9a.764.764,0,0,1-.335-.075L6.652,1.237A2.261,2.261,0,0,0,5.646,1H3.75A3.755,3.755,0,0,0,0,4.75v.743L17.9,5.41A3.75,3.75,0,0,0,14.25,2.5Z"
                                            fill="#19286b" />
                                    </g>
                                    <g id="Rectangle_1647" data-name="Rectangle 1647"
                                        transform="translate(3034 248)" fill="none" stroke="#707070"
                                        stroke-width="1" opacity="0">
                                        <rect width="24" height="24" stroke="none" />
                                        <rect x="0.5" y="0.5" width="23" height="23" fill="none" />
                                    </g>
                                </g>
                            </svg>
                        </span>
                        <span class="text_menu">{{__("admin.text_seekers_adv")}}</span>
                    </a>

                </li> 


                <li class="nav-item">
                    <a href="{{Route('actual_contracts')}}" class="menu_items <?php if($common['main_menu']=='actual_contracts'){echo "active"; } ?>">
                        <span class="menu_icons">
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <g id="Group_3505" data-name="Group 3505" transform="translate(-3034 -248)">
                                    <g id="fi-sr-folder" transform="translate(3037 250.75)">
                                        <path id="Path_52286" data-name="Path 52286"
                                            d="M0,8.963V15.72a3.755,3.755,0,0,0,3.75,3.75h10.5A3.754,3.754,0,0,0,18,15.72V8.88Z"
                                            transform="translate(0 -1.97)" fill="#19286b" />
                
                                        <path id="Path_52287" data-name="Path 52287"
                                            d="M14.25,2.5h-4.9a.764.764,0,0,1-.335-.075L6.652,1.237A2.261,2.261,0,0,0,5.646,1H3.75A3.755,3.755,0,0,0,0,4.75v.743L17.9,5.41A3.75,3.75,0,0,0,14.25,2.5Z"
                                            fill="#19286b" />
                                    </g>
                                    <g id="Rectangle_1647" data-name="Rectangle 1647"
                                        transform="translate(3034 248)" fill="none" stroke="#707070"
                                        stroke-width="1" opacity="0">
                                        <rect width="24" height="24" stroke="none" />
                                        <rect x="0.5" y="0.5" width="23" height="23" fill="none" />
                                    </g>
                                </g>
                            </svg>
                        </span>
                        <span class="text_menu">{{__("admin.text_actual_contract")}}</span>
                    </a>

                </li> 

                <!-- Documents -->
                <li class="nav-item">
                    <a href="{{Route('documents_from_seeker')}}" class="menu_items <?php if($common['main_menu']=='documents_from_seeker'){echo "active"; } ?>">
                        <span class="menu_icons">
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <g id="Group_3505" data-name="Group 3505" transform="translate(-3034 -248)">
                                    <g id="fi-sr-folder" transform="translate(3037 250.75)">
                                        <path id="Path_52286" data-name="Path 52286"
                                            d="M0,8.963V15.72a3.755,3.755,0,0,0,3.75,3.75h10.5A3.754,3.754,0,0,0,18,15.72V8.88Z"
                                            transform="translate(0 -1.97)" fill="#19286b" />
                
                                        <path id="Path_52287" data-name="Path 52287"
                                            d="M14.25,2.5h-4.9a.764.764,0,0,1-.335-.075L6.652,1.237A2.261,2.261,0,0,0,5.646,1H3.75A3.755,3.755,0,0,0,0,4.75v.743L17.9,5.41A3.75,3.75,0,0,0,14.25,2.5Z"
                                            fill="#19286b" />
                                    </g>
                                    <g id="Rectangle_1647" data-name="Rectangle 1647"
                                        transform="translate(3034 248)" fill="none" stroke="#707070"
                                        stroke-width="1" opacity="0">
                                        <rect width="24" height="24" stroke="none" />
                                        <rect x="0.5" y="0.5" width="23" height="23" fill="none" />
                                    </g>
                                </g>
                            </svg>
                        </span>
                        <span class="text_menu">{{__("admin.text_doc_seeker")}}</span>
                    </a>
                </li> 

                <li class="nav-item">
                    <a href="{{Route('documents_from_provider')}}" class="menu_items <?php if($common['main_menu']=='documents_from_provider'){echo "active"; } ?>">
                        <span class="menu_icons">
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <g id="Group_3505" data-name="Group 3505" transform="translate(-3034 -248)">
                                    <g id="fi-sr-folder" transform="translate(3037 250.75)">
                                        <path id="Path_52286" data-name="Path 52286"
                                            d="M0,8.963V15.72a3.755,3.755,0,0,0,3.75,3.75h10.5A3.754,3.754,0,0,0,18,15.72V8.88Z"
                                            transform="translate(0 -1.97)" fill="#19286b" />
                
                                        <path id="Path_52287" data-name="Path 52287"
                                            d="M14.25,2.5h-4.9a.764.764,0,0,1-.335-.075L6.652,1.237A2.261,2.261,0,0,0,5.646,1H3.75A3.755,3.755,0,0,0,0,4.75v.743L17.9,5.41A3.75,3.75,0,0,0,14.25,2.5Z"
                                            fill="#19286b" />
                                    </g>
                                    <g id="Rectangle_1647" data-name="Rectangle 1647"
                                        transform="translate(3034 248)" fill="none" stroke="#707070"
                                        stroke-width="1" opacity="0">
                                        <rect width="24" height="24" stroke="none" />
                                        <rect x="0.5" y="0.5" width="23" height="23" fill="none" />
                                    </g>
                                </g>
                            </svg>
                        </span>
                        <span class="text_menu">{{__("admin.text_doc_provider")}}</span>
                    </a>
                </li> 


                <li class="nav-item">
                    <a href="{{Route('other_documents_from_seeker')}}" class="menu_items <?php if($common['main_menu']=='other_documents_from_seeker'){echo "active"; } ?>">
                        <span class="menu_icons">
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <g id="Group_3505" data-name="Group 3505" transform="translate(-3034 -248)">
                                    <g id="fi-sr-folder" transform="translate(3037 250.75)">
                                        <path id="Path_52286" data-name="Path 52286"
                                            d="M0,8.963V15.72a3.755,3.755,0,0,0,3.75,3.75h10.5A3.754,3.754,0,0,0,18,15.72V8.88Z"
                                            transform="translate(0 -1.97)" fill="#19286b" />
                
                                        <path id="Path_52287" data-name="Path 52287"
                                            d="M14.25,2.5h-4.9a.764.764,0,0,1-.335-.075L6.652,1.237A2.261,2.261,0,0,0,5.646,1H3.75A3.755,3.755,0,0,0,0,4.75v.743L17.9,5.41A3.75,3.75,0,0,0,14.25,2.5Z"
                                            fill="#19286b" />
                                    </g>
                                    <g id="Rectangle_1647" data-name="Rectangle 1647"
                                        transform="translate(3034 248)" fill="none" stroke="#707070"
                                        stroke-width="1" opacity="0">
                                        <rect width="24" height="24" stroke="none" />
                                        <rect x="0.5" y="0.5" width="23" height="23" fill="none" />
                                    </g>
                                </g>
                            </svg>
                        </span>
                        <span class="text_menu">{{__("admin.text_other_docs_seeker")}}</span>
                    </a>

                </li> 

                <li class="nav-item">
                    <a href="{{Route('other_documents_from_provider')}}" class="menu_items <?php if($common['main_menu']=='other_documents_from_provider'){echo "active"; } ?>">
                        <span class="menu_icons">
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <g id="Group_3505" data-name="Group 3505" transform="translate(-3034 -248)">
                                    <g id="fi-sr-folder" transform="translate(3037 250.75)">
                                        <path id="Path_52286" data-name="Path 52286"
                                            d="M0,8.963V15.72a3.755,3.755,0,0,0,3.75,3.75h10.5A3.754,3.754,0,0,0,18,15.72V8.88Z"
                                            transform="translate(0 -1.97)" fill="#19286b" />
                
                                        <path id="Path_52287" data-name="Path 52287"
                                            d="M14.25,2.5h-4.9a.764.764,0,0,1-.335-.075L6.652,1.237A2.261,2.261,0,0,0,5.646,1H3.75A3.755,3.755,0,0,0,0,4.75v.743L17.9,5.41A3.75,3.75,0,0,0,14.25,2.5Z"
                                            fill="#19286b" />
                                    </g>
                                    <g id="Rectangle_1647" data-name="Rectangle 1647"
                                        transform="translate(3034 248)" fill="none" stroke="#707070"
                                        stroke-width="1" opacity="0">
                                        <rect width="24" height="24" stroke="none" />
                                        <rect x="0.5" y="0.5" width="23" height="23" fill="none" />
                                    </g>
                                </g>
                            </svg>
                        </span>
                        <span class="text_menu">{{__("admin.text_other_docs_provider")}}</span>
                    </a>

                </li> 


            </ul>

        <div class="text-center mb_60">
            <a href="{{url('admin/logout')}}" class="logout_btn">{{__("admin.text_logout")}}
                <span class="ms-1">
                    <img src="{{ asset('admin/assets/images/bot_ar.png') }}" alt="">
                </span>
            </a>
        </div>

    </div>
</div>
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function(){
      document.querySelectorAll('.sidebar .nav-link').forEach(function(element){
        
        element.addEventListener('click', function (e) {

          let nextEl = element.nextElementSibling;
          let parentEl  = element.parentElement;    

            if(nextEl) {
                e.preventDefault(); 
                let mycollapse = new bootstrap.Collapse(nextEl);
                
                if(nextEl.classList.contains('show')){
                  mycollapse.hide();
                } else {
                    mycollapse.show();
                    // find other submenus with class=show
                    var opened_submenu = parentEl.parentElement.querySelector('.submenu.show');
                    // if it exists, then close all of them
                    if(opened_submenu){
                      new bootstrap.Collapse(opened_submenu);
                    }
                }
            }
        }); // addEventListener
      }) // forEach
    }); 
// DOMContentLoaded  end
</script>