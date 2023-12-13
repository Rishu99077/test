<div class="left_menu">
    <div class="ver_scroll">

        <div class="top_sec">
            <div class="logo">
                <a href="{{url('')}}"><img class="" src="{{ asset('assets/images/logo.png') }}" alt="" srcset=""></a>
            </div>
            <?php 
                $cust_id = Session::get('cust_id');
                $user = App\Models\CustomersModel::where(['id' => $cust_id])->first();
                $fullname = $user['firstname']." ".$user['surname'];
            ?>

            <div class="das_admin d-flex align-items-center justify-content-between">
                <div class="das_img"><img src="{{ url('profile',$user['profile_image']) }}" alt=""></div>
                <div class="das_name">
                    <h3 class="f14 mb0"><?php echo (strlen($fullname) > 25) ? substr($fullname, 0, 25) . '...' : $fullname; ?></h3>
                    <p class="f12">{{$user['email']}}</p>
                </div>
            </div>

        </div>

        <ul class="side_menu">


            <li class="">
                <a href="javascript:void(0)" class="menu_items lang">

                    <?php 
                        if (!empty(session('cust_id'))) {
                            $get_cust = App\Models\CustomersModel::where('id',$cust_id)->first();
                            
                            $Langu_id = $get_cust['language_id'];

                            // $Langu_id = session()->get('language_id'); 
                        }else{
                            $Langu_id = 1;
                        }
                            $lang_details = App\Models\LanguagesModel::where(['id' => $Langu_id])->first();
                            $Image = $lang_details['image'];
                    ?>
                    
                      
                    <span class="menu_icons">     
                        <img src="{{ asset('Images/Flags') }}/{{$Image}}" alt="" height="24px" width="24px">
                    </span>
      
                    <!-- <span><img src="{{ asset('assets/images/dwn.png') }}" alt=""></span> -->
                    <select name="language_converter" id="Change_language" class="language_converter text_menu">
                      <?php 
                             $languages = App\Models\LanguagesModel::get();

                            foreach($languages as $key => $value){
                            ?>

                            <option value="{{$value['id']}}"<?php echo $get_cust['language_id'] == $value['id'] ? "selected" : ""; ?>>{{$value['name']}}</option>
                            <?php 
                             }
                            ?>
                    </select>

                </a>
            </li>

            <li class="">
                <a href="{{Route('frontdashboard')}}" class="menu_items <?php if($common['main_menu']=='Dashboard'){echo "active"; } ?>">
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
                    <span class="text_menu">{{__("customer.text_dashboard")}}</span>


                </a>
            </li>

            <li class="menu_parent">
                <a href="{{Route('my_profile')}}" class="menu_items <?php if($common['main_menu']=='My Profile'){echo "active"; } ?>">
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
                    <span class="text_menu">{{__("customer.text_my_profile")}}</span>
                </a>

            </li>

            @if($user['role']=='seeker')
                <li class="menu_parent">
                    <a href="{{Route('search')}}" class="menu_items <?php if($common['main_menu']=='Search'){echo "active"; } ?>">
                        <span class="menu_icons">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <g id="Group_3669" data-name="Group 3669" transform="translate(-937 -1694)">
                                    <path id="search"
                                        d="M12.462,7.615a4.667,4.667,0,0,0-1.422-3.424A4.669,4.669,0,0,0,7.615,2.769,4.666,4.666,0,0,0,4.191,4.192,4.666,4.666,0,0,0,2.769,7.615a4.67,4.67,0,0,0,1.423,3.423,4.667,4.667,0,0,0,3.424,1.423,4.665,4.665,0,0,0,3.424-1.422A4.672,4.672,0,0,0,12.462,7.615Zm5.538,9A1.4,1.4,0,0,1,16.616,18a1.286,1.286,0,0,1-.974-.411l-3.71-3.7a7.407,7.407,0,0,1-4.316,1.342,7.481,7.481,0,0,1-2.958-.6A7.456,7.456,0,0,1,.6,10.574a7.588,7.588,0,0,1,0-5.917A7.456,7.456,0,0,1,4.657.6a7.588,7.588,0,0,1,5.917,0A7.456,7.456,0,0,1,14.63,4.657a7.471,7.471,0,0,1,.6,2.958,7.406,7.406,0,0,1-1.342,4.316l3.711,3.71A1.325,1.325,0,0,1,18,16.615Z"
                                        transform="translate(940 1697)" fill="#19286b" />
                                    <g id="Rectangle_280" data-name="Rectangle 280" transform="translate(937 1694)"
                                        fill="none" stroke="#707070" stroke-width="1" opacity="0">
                                        <rect width="24" height="24" stroke="none" />
                                        <rect x="0.5" y="0.5" width="23" height="23" fill="none" />
                                    </g>
                                </g>
                            </svg>
                        </span>
                        <span class="text_menu">{{__("customer.text_search_for_work")}}</span>
                    </a>
                </li>
            @elseif($user['role']=='provider')
                <li class="menu_parent">
                    <a href="{{Route('search')}}" class="menu_items <?php if($common['main_menu']=='Search'){echo "active"; } ?>">
                        <span class="menu_icons">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <g id="Group_3669" data-name="Group 3669" transform="translate(-937 -1694)">
                                    <path id="search"
                                        d="M12.462,7.615a4.667,4.667,0,0,0-1.422-3.424A4.669,4.669,0,0,0,7.615,2.769,4.666,4.666,0,0,0,4.191,4.192,4.666,4.666,0,0,0,2.769,7.615a4.67,4.67,0,0,0,1.423,3.423,4.667,4.667,0,0,0,3.424,1.423,4.665,4.665,0,0,0,3.424-1.422A4.672,4.672,0,0,0,12.462,7.615Zm5.538,9A1.4,1.4,0,0,1,16.616,18a1.286,1.286,0,0,1-.974-.411l-3.71-3.7a7.407,7.407,0,0,1-4.316,1.342,7.481,7.481,0,0,1-2.958-.6A7.456,7.456,0,0,1,.6,10.574a7.588,7.588,0,0,1,0-5.917A7.456,7.456,0,0,1,4.657.6a7.588,7.588,0,0,1,5.917,0A7.456,7.456,0,0,1,14.63,4.657a7.471,7.471,0,0,1,.6,2.958,7.406,7.406,0,0,1-1.342,4.316l3.711,3.71A1.325,1.325,0,0,1,18,16.615Z"
                                        transform="translate(940 1697)" fill="#19286b" />
                                    <g id="Rectangle_280" data-name="Rectangle 280" transform="translate(937 1694)"
                                        fill="none" stroke="#707070" stroke-width="1" opacity="0">
                                        <rect width="24" height="24" stroke="none" />
                                        <rect x="0.5" y="0.5" width="23" height="23" fill="none" />
                                    </g>
                                </g>
                            </svg>
                        </span>
                        <span class="text_menu">{{__("customer.text_search_for_worker")}}</span>
                    </a>
                </li>
            @endif


            @if($user['role']=='provider')   
                <li class="menu_parent">
                    <a href="{{Route('job')}}" class="menu_items <?php if($common['main_menu']=='Job'){echo "active"; } ?>">
                        <span class="menu_icons">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <g id="Group_3669" data-name="Group 3669" transform="translate(-937 -1694)">
                                    <path id="search"
                                        d="M12.462,7.615a4.667,4.667,0,0,0-1.422-3.424A4.669,4.669,0,0,0,7.615,2.769,4.666,4.666,0,0,0,4.191,4.192,4.666,4.666,0,0,0,2.769,7.615a4.67,4.67,0,0,0,1.423,3.423,4.667,4.667,0,0,0,3.424,1.423,4.665,4.665,0,0,0,3.424-1.422A4.672,4.672,0,0,0,12.462,7.615Zm5.538,9A1.4,1.4,0,0,1,16.616,18a1.286,1.286,0,0,1-.974-.411l-3.71-3.7a7.407,7.407,0,0,1-4.316,1.342,7.481,7.481,0,0,1-2.958-.6A7.456,7.456,0,0,1,.6,10.574a7.588,7.588,0,0,1,0-5.917A7.456,7.456,0,0,1,4.657.6a7.588,7.588,0,0,1,5.917,0A7.456,7.456,0,0,1,14.63,4.657a7.471,7.471,0,0,1,.6,2.958,7.406,7.406,0,0,1-1.342,4.316l3.711,3.71A1.325,1.325,0,0,1,18,16.615Z"
                                        transform="translate(940 1697)" fill="#19286b" />
                                    <g id="Rectangle_280" data-name="Rectangle 280" transform="translate(937 1694)"
                                        fill="none" stroke="#707070" stroke-width="1" opacity="0">
                                        <rect width="24" height="24" stroke="none" />
                                        <rect x="0.5" y="0.5" width="23" height="23" fill="none" />
                                    </g>
                                </g>
                            </svg>
                        </span>
                        <span class="text_menu">{{__("customer.text_publish_job")}}</span>
                    </a>
                </li>
            @endif
            

            @if($user['role']=='seeker')
                <li class="menu_parent">
                    <a href="{{Route('seeker.reports')}}" class="menu_items <?php if($common['main_menu']=='Work Management'){echo "active"; } ?>">
                        <span class="menu_icons">
                            <img src="{{ asset('assets/images/work.png') }}" alt="">
                        </span>
                        <span class="text_menu">{{__("customer.text_work_managment")}}</span>
                    </a>
                </li>
            @elseif($user['role']=='provider')
                <li class="menu_parent">
                    <a href="{{Route('provider.reports')}}" class="menu_items <?php if($common['main_menu']=='Work Management'){echo "active"; } ?>">
                        <span class="menu_icons">
                            <img src="{{ asset('assets/images/work.png') }}" alt="">
                        </span>
                        <span class="text_menu">{{__("customer.text_work_managment")}}</span>
                    </a>
                </li>
            @endif

            @if($user['role']=='seeker')
                <li class="menu_parent">
                    <a href="{{Route('seeker.documents_contracts')}}" class="menu_items  <?php if($common['main_menu']=='Documents'){echo "active"; } ?>">
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
                        <span class="text_menu">{{__("customer.text_documents")}}</span>
                    </a>
                </li>   
            @elseif($user['role']=='provider')
                <li class="menu_parent">
                    <a href="{{Route('provider.documents_contracts')}}" class="menu_items  <?php if($common['main_menu']=='Documents'){echo "active"; } ?>">
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
                        <span class="text_menu">{{__("customer.text_documents")}}</span>
                    </a>
                </li> 
            @endif

            @if($user['role']=='seeker')
                <li class="menu_parent">
                    <a href="{{Route('favorite_jobs')}}" class="menu_items <?php if($common['main_menu']=='Favorites Jobs'){echo "active"; } ?>">
                        <span class="menu_icons">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <g id="Group_7695" data-name="Group 7695" transform="translate(-9663 -2424)">
                                    <g id="Rectangle_4600" data-name="Rectangle 4600"
                                        transform="translate(9663 2424)" fill="none" stroke="#707070"
                                        stroke-width="1" opacity="0">
                                        <rect width="24" height="24" stroke="none" />
                                        <rect x="0.5" y="0.5" width="23" height="23" fill="none" />
                                    </g>
                                    <path id="fi-sr-heart"
                                        d="M13.118,1.917A4.79,4.79,0,0,0,9,4.42a4.79,4.79,0,0,0-4.123-2.5A5.134,5.134,0,0,0,0,7.264c0,3.449,3.588,7.215,6.6,9.769a3.7,3.7,0,0,0,4.8,0c3.009-2.554,6.6-6.32,6.6-9.769a5.134,5.134,0,0,0-4.873-5.347Z"
                                        transform="translate(9666.005 2426.083)" fill="#19286b" />
                                </g>
                            </svg>
                        </span>
                        <span class="text_menu">{{__("customer.text_fav_jobs")}}</span>
                    </a>
                </li>
            @elseif($user['role']=='provider')    
                <li class="menu_parent">
                    <a href="{{Route('favorite_candidates')}}" class="menu_items <?php if($common['main_menu']=='Favorites Candidates'){echo "active"; } ?>">
                        <span class="menu_icons">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <g id="Group_7695" data-name="Group 7695" transform="translate(-9663 -2424)">
                                    <g id="Rectangle_4600" data-name="Rectangle 4600"
                                        transform="translate(9663 2424)" fill="none" stroke="#707070"
                                        stroke-width="1" opacity="0">
                                        <rect width="24" height="24" stroke="none" />
                                        <rect x="0.5" y="0.5" width="23" height="23" fill="none" />
                                    </g>
                                    <path id="fi-sr-heart"
                                        d="M13.118,1.917A4.79,4.79,0,0,0,9,4.42a4.79,4.79,0,0,0-4.123-2.5A5.134,5.134,0,0,0,0,7.264c0,3.449,3.588,7.215,6.6,9.769a3.7,3.7,0,0,0,4.8,0c3.009-2.554,6.6-6.32,6.6-9.769a5.134,5.134,0,0,0-4.873-5.347Z"
                                        transform="translate(9666.005 2426.083)" fill="#19286b" />
                                </g>
                            </svg>
                        </span>
                        <span class="text_menu">{{__("customer.text_fav_candidates")}}</span>
                    </a>
                </li>
            @endif    

            <li class="menu_parent">
                <a href="{{Route('notification')}}" class="menu_items <?php if($common['main_menu']=='Notifications'){echo "active"; } ?>">
                    <span class="menu_icons">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <g id="Group_3478" data-name="Group 3478" transform="translate(-1321 -1787)">
                                <g id="notification-solid-badged" transform="translate(1320.95 1789)">
                                    <path id="Path_300" data-name="Path 300"
                                        d="M16.83,33.233A1.485,1.485,0,0,0,18.283,32H15.32a1.487,1.487,0,0,0,1.51,1.233Z"
                                        transform="translate(-5.357 -14.233)" fill="#19286b" />
                                    <path id="Path_301" data-name="Path 301"
                                        d="M19.839,16.029l-.192-.162a7.868,7.868,0,0,1-1.414-1.585,6.624,6.624,0,0,1-.761-2.6V9.009a5.677,5.677,0,0,0-.09-.968A4.1,4.1,0,0,1,14.008,4.06V3.719a6.14,6.14,0,0,0-1.87-.541V2.5a.753.753,0,0,0-1.5,0v.709a5.929,5.929,0,0,0-5.239,5.8v2.672a6.624,6.624,0,0,1-.761,2.6,7.877,7.877,0,0,1-1.392,1.585l-.192.162v1.525H19.839Z"
                                        transform="translate(0 -0.356)" fill="#19286b" />
                                    <path id="Path_302" data-name="Path 302"
                                        d="M30.634,3.7A2.819,2.819,0,0,1,25,3.7a2.819,2.819,0,0,1,5.634,0Z"
                                        transform="translate(-9.584)" fill="#5aa136" />
                                </g>
                                <g id="Rectangle_285" data-name="Rectangle 285" transform="translate(1321 1787)"
                                    fill="none" stroke="#707070" stroke-width="1" opacity="0">
                                    <rect width="24" height="24" stroke="none" />
                                    <rect x="0.5" y="0.5" width="23" height="23" fill="none" />
                                </g>
                            </g>
                        </svg>
                    </span>
                    <span class="text_menu">{{__("customer.text_notification")}} !</span>
                </a>

            </li>

            <li class="menu_parent">
                <a href="{{Route('contact_us')}}" class="menu_items <?php if($common['main_menu']=='Contact us'){echo "active"; } ?>">
                    <span class="menu_icons">
                        <img src="{{ asset('assets/images/cont.png') }}" alt="">
                    </span>
                    <span class="text_menu">{{__("customer.text_contact_us")}}</span>
                </a>
            </li>

            <li class="menu_parent">
                <a href="{{Route('settings')}}" class="menu_items <?php if($common['main_menu']=='settings'){echo "active"; } ?>">
                    <span class="menu_icons">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <g id="Group_3477" data-name="Group 3477" transform="translate(-1384 -1854)">
                                <path id="settings-solid"
                                    d="M20.747,10.632l-2.012-.6a6.986,6.986,0,0,0-.571-1.4l.985-1.842a.366.366,0,0,0-.066-.432L17.648,4.92a.367.367,0,0,0-.432-.066l-1.832.978a6.983,6.983,0,0,0-1.417-.6l-.6-1.986A.366.366,0,0,0,13.012,3h-2.03a.366.366,0,0,0-.348.258l-.6,1.98a6.988,6.988,0,0,0-1.429.6L6.8,4.866a.367.367,0,0,0-.432.066L4.91,6.354a.366.366,0,0,0-.066.432l.973,1.8a6.974,6.974,0,0,0-.6,1.422l-1.988.6a.366.366,0,0,0-.258.348v2.028a.366.366,0,0,0,.258.348l2,.6a6.968,6.968,0,0,0,.6,1.4l-.985,1.884a.366.366,0,0,0,.066.432L6.345,19.08a.367.367,0,0,0,.432.066l1.856-.99a7,7,0,0,0,1.381.564l.6,2.022a.366.366,0,0,0,.348.258h2.03a.366.366,0,0,0,.348-.258l.6-2.028a6.989,6.989,0,0,0,1.369-.564l1.868,1a.367.367,0,0,0,.432-.066l1.435-1.434a.366.366,0,0,0,.066-.432l-1-1.86a6.974,6.974,0,0,0,.571-1.374l2.024-.6a.366.366,0,0,0,.258-.348V10.986a.366.366,0,0,0-.222-.354ZM12,15.3A3.3,3.3,0,1,1,15.3,12,3.3,3.3,0,0,1,12,15.3Z"
                                    transform="translate(1384.03 1854)" fill="#19286b" />
                                <g id="Rectangle_286" data-name="Rectangle 286" transform="translate(1384 1854)"
                                    fill="none" stroke="#707070" stroke-width="1" opacity="0">
                                    <rect width="24" height="24" stroke="none" />
                                    <rect x="0.5" y="0.5" width="23" height="23" fill="none" />
                                </g>
                            </g>
                        </svg>
                    </span>
                    <span class="text_menu">{{__("customer.text_setting")}}</span>
                </a>

            </li>



        </ul>

        <div class="text-center mb_60">
            <a href="{{Route('user_logout')}}" class="logout_btn">{{__("customer.text_logout")}}
                <span class="ms-1">
                    <img src="{{ asset('assets/images/bot_ar.png') }}" alt="">
                </span>
            </a>
        </div>

    </div>
</div>

<script type="text/javascript">
    $('body').on("change",'#Change_language', function(){
      var Languge_id = $('#Change_language option:selected').val();

      $.ajax({
        url:"{{ url('changeDashLang') }}",
        type: 'post',
        data: {'Languge_id': Languge_id ,"_token": "{{ csrf_token() }}"},
         success: function(response) {  
            location.reload();  
             // $(".flag_response").html(response);
            // alert('quantity updated successfully');
         }
      });
    });
    
</script>        