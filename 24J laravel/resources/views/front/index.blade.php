<!DOCTYPE html>
<html lang="en">
<head>
  <title>QR-Code</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="{{asset('favicon.png')}}" type="image/x-icon">
  <link href="{{asset('front/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('front/css/custom.css')}}" rel="stylesheet">
  <script src="{{asset('front/js/bootstrap.bundle.min.js')}}"></script>
 
</head>
<body>

<div class="container ">
    <div class="row">
        <div class="col-sm-12">
            <div class="custom_card"  >

                <?php 
                    $profile_cls = 'without_profile_img';
                    if(isset($get_staff['avatar_file'])){
                        if( $get_staff['avatar_file'] != ''){
                            $profile_cls = 'staff_profile_img';
                        }
                    }
                ?>
                <div class="{{$profile_cls}}">
                    <?php 
                        if(isset($get_staff['avatar_file'])){
                            ?>
                            <img src="{{ $get_staff['avatar_file'] != '' ? asset('uploads/staff/' . $get_staff['avatar_file']) : asset('frontassets/image/default-avatar.svg') }}" />
                            <?php
                        }
                    ?>
                    <div class="share_vcf">
                      <ul>
                        <li>
                            <a href="{{ route('downoad_vcard', encrypt($get_staff['id'])) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">
                                  <g id="Group_484" data-name="Group 484" transform="translate(-2663 -149)">
                                    <g id="Rectangle_47" data-name="Rectangle 47" transform="translate(2663 149)" fill="none" stroke="#232a35" stroke-width="1">
                                      <rect width="32" height="32" stroke="none"/>
                                      <rect x="0.5" y="0.5" width="31" height="31" fill="none"/>
                                    </g>
                                    <g id="Group_457" data-name="Group 457" transform="translate(30 -575)">
                                      <path id="add-user" d="M10.929,4.5a4.5,4.5,0,0,0-2.511,8.237A6.443,6.443,0,0,0,4.5,18.643H5.786A5.133,5.133,0,0,1,10.929,13.5a5.061,5.061,0,0,1,2.43.623,5.214,5.214,0,1,0,.985-.926,6.528,6.528,0,0,0-.9-.462A4.5,4.5,0,0,0,10.929,4.5Zm0,1.286A3.214,3.214,0,1,1,7.714,9,3.2,3.2,0,0,1,10.929,5.786ZM17.357,13.5A3.857,3.857,0,1,1,13.5,17.357,3.847,3.847,0,0,1,17.357,13.5Zm-.643,1.286v1.929H14.786V18h1.929v1.929H18V18h1.929V16.714H18V14.786Z" transform="translate(2635.5 726.5)" fill="#232a35"/>
                                      <g id="Rectangle_96" data-name="Rectangle 96" transform="translate(2637 728)" fill="none" stroke="#232a35" stroke-width="1" opacity="0">
                                        <rect width="24" height="24" stroke="none"/>
                                        <rect x="0.5" y="0.5" width="23" height="23" fill="none"/>
                                      </g>
                                    </g>
                                  </g>
                                </svg>
                            </a>
                        </li>
                      </ul>
                    </div>
                </div>

                <div class="info_outer">
                    <div class="white_box">
                        <div class="staff_info">
                            <?php 
                                if( @$get_staff['company_logo_url'] != '' ){ 
                                    ?>

                                    <img class="company_logo" src="{{ $get_staff['company_logo_url'] != '' ? asset('uploads/staff/' . $get_staff['company_logo_url']) : asset('frontassets/image/company-logo.png') }}" />
                                    <?php
                                }else{
                                    if(isset($get_staff['company_logo'])){
                                        ?>
                                        <img class="company_logo" src="{{ $get_staff['company_logo'] != '' ? asset('uploads/staff/' . $get_staff['company_logo']) : asset('frontassets/image/company-logo.png') }}" />
                                        <?php
                                    }else{
                                    ?>
                                        <img class="company_logo" src="{{asset('frontassets/image/company-logo.png')}}">
                                    <?php
                                    }
                                }
                            ?>
                            
                            <?php if( $get_staff['first_name'] != '' || $get_staff['last_name'] != '' ){ ?>
                                <h2> 
                                    {{$get_staff['first_name']}} 
                                    {{$get_staff['last_name']}} 
                                </h2>
                            <?php } ?>

                            <ul>
                                <li class="staff_position">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                      <g id="Group_55" data-name="Group 55" transform="translate(-2648 -611)">
                                        <path id="user" d="M15,14.894a3.4,3.4,0,0,1-.733,2.192A2.195,2.195,0,0,1,12.5,18H2.5a2.194,2.194,0,0,1-1.763-.914A3.4,3.4,0,0,1,0,14.894a16.859,16.859,0,0,1,.1-1.881,10.1,10.1,0,0,1,.369-1.781A5.927,5.927,0,0,1,1.154,9.7a3.283,3.283,0,0,1,1.1-1.043,3.04,3.04,0,0,1,1.576-.4A5.065,5.065,0,0,0,7.5,9.75a5.065,5.065,0,0,0,3.668-1.5,3.042,3.042,0,0,1,1.576.4,3.283,3.283,0,0,1,1.1,1.043,5.927,5.927,0,0,1,.686,1.535,10.1,10.1,0,0,1,.369,1.781A16.859,16.859,0,0,1,15,14.9ZM12,4.5a4.334,4.334,0,0,1-1.319,3.181A4.338,4.338,0,0,1,7.5,9,4.333,4.333,0,0,1,4.319,7.681,4.337,4.337,0,0,1,3,4.5,4.337,4.337,0,0,1,4.319,1.319,4.333,4.333,0,0,1,7.5,0a4.338,4.338,0,0,1,3.181,1.319A4.334,4.334,0,0,1,12,4.5Z" transform="translate(2652.5 614)" fill="#baad85"/>
                                        <g id="Rectangle_94" data-name="Rectangle 94" transform="translate(2648 611)" fill="none" stroke="#707070" stroke-width="1" opacity="0">
                                          <rect width="24" height="24" stroke="none"/>
                                          <rect x="0.5" y="0.5" width="23" height="23" fill="none"/>
                                        </g>
                                      </g>
                                    </svg>
                                    <?php 
                                        $designation = 'Chief Operation Officer';
                                        if( $get_staff['designation'] != '' ){ 
                                            $designation = $get_staff['designation'];
                                        } 
                                    ?>
                                    <span>{{$designation}}</span>
                                </li>
                                
                            </ul>
                        </div>

                        <div class="white_box_inner">
                            <div class="main_title">
                                <?php 
                                    $company_name = 'DG Company Profile';
                                    if( $get_staff['company_name'] != '' ){ 
                                        $company_name = $get_staff['company_name'];
                                    } 
                                ?>
                                <h4>{{$company_name}}</h4>
                                
                            </div>

                            <div class="staff_address">
                                <svg id="_36_px_icon" data-name="36 px icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                  <g id="location" transform="translate(4.929 3)">
                                    <path id="Path_126" data-name="Path 126" d="M15.589,15.429A3.214,3.214,0,1,1,18.8,12.214,3.214,3.214,0,0,1,15.589,15.429Zm0-5.143a1.929,1.929,0,1,0,1.929,1.929A1.929,1.929,0,0,0,15.589,10.286Z" transform="translate(-8.518 -5.143)" fill="#959799"/>
                                    <path id="Path_127" data-name="Path 127" d="M12.7,20.25l-5.423-6.4q-.113-.144-.223-.29A7,7,0,0,1,5.625,9.321a7.071,7.071,0,1,1,14.143,0,7,7,0,0,1-1.424,4.241v0s-.193.253-.222.287ZM8.075,12.789s.15.2.185.241L12.7,18.263l4.442-5.239c.028-.035.179-.235.179-.235a5.722,5.722,0,0,0,1.164-3.466,5.786,5.786,0,1,0-11.571,0,5.725,5.725,0,0,0,1.166,3.468Z" transform="translate(-5.625 -2.25)" fill="#959799"/>
                                  </g>
                                  <g id="Rectangle_53" data-name="Rectangle 53" fill="none" stroke="#707070" stroke-width="1" opacity="0">
                                    <rect width="24" height="24" stroke="none"/>
                                    <rect x="0.5" y="0.5" width="23" height="23" fill="none"/>
                                  </g>
                                </svg>

                                <?php if( $get_staff['address'] != '' || $get_staff['town'] != '' || $get_staff['country'] != ''  ){ ?>
                                    
                                     {{$get_staff['address']}}, {{$get_staff['town']}} , {{$get_staff['country']}}

                                 <?php }else{
                                    echo 'I-Rise Tower, 16E1 Dubai United Arab Emirates';
                                 } ?>
                            </div>

                            <?php 
                                if( $get_staff['contact'] != '' ){  
                                    $contact_arr = explode(",",$get_staff['contact']);
                                    if(count($contact_arr) > 0){
                                        foreach ($contact_arr as $value) { 
                                            ?>
                                                <div class="info_box">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                      <g id="Group_475" data-name="Group 475" transform="translate(-2610 -771)">
                                                        <path id="phone" d="M17.751,14.968l-2.538,2.518A1.836,1.836,0,0,1,13.858,18a11.738,11.738,0,0,1-5.82-2.193A22.448,22.448,0,0,1,1.245,8.4,9.588,9.588,0,0,1,0,4.173,1.848,1.848,0,0,1,.52,2.8L3.058.264A.84.84,0,0,1,4.432.493L6.473,4.364a1.124,1.124,0,0,1-.229,1.278l-.935.935a.461.461,0,0,0-.1.267,7.971,7.971,0,0,0,2.4,3.548c.96.881,1.991,2.073,3.33,2.356a.527.527,0,0,0,.487-.048l1.088-1.106a1.242,1.242,0,0,1,1.317-.191h.019l3.683,2.174a.886.886,0,0,1,.21,1.392Z" transform="translate(2613 774)" fill="#847a5b"/>
                                                        <g id="Rectangle_115" data-name="Rectangle 115" transform="translate(2610 771)" fill="none" stroke="#707070" stroke-width="1" opacity="0">
                                                          <rect width="24" height="24" stroke="none"/>
                                                          <rect x="0.5" y="0.5" width="23" height="23" fill="none"/>
                                                        </g>
                                                      </g>
                                                    </svg>
                                                    <span>{{$value}}</span>
                                                    <img src="{{asset('frontassets/image/next-arrow.png')}}">
                                                </div>
                                            <?php                            
                                        }
                                    }
                                } 
                            ?>

                            <?php 
                                if( $get_staff['email'] != '' ){  
                                    $email_arr = explode(",",$get_staff['email']);
                                    if(count($email_arr) > 0){
                                        foreach ($email_arr as $value) { 
                                            ?>
                                            <div class="info_box">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                  <g id="Group_483" data-name="Group 483" transform="translate(-2495 -771)">
                                                    <path id="email" d="M16.188,1.75A1.8,1.8,0,0,1,18,3.562V14.354a1.8,1.8,0,0,1-1.812,1.813H1.812A1.75,1.75,0,0,1,.527,15.64,1.747,1.747,0,0,1,0,14.355V3.562A1.75,1.75,0,0,1,.527,2.277,1.747,1.747,0,0,1,1.812,1.75Zm0,3.625V3.562L8.979,8.073,1.812,3.562V5.375L8.979,9.843Z" transform="translate(2498 774.042)" fill="#847a5b"/>
                                                    <g id="Rectangle_112" data-name="Rectangle 112" transform="translate(2495 771)" fill="none" stroke="#707070" stroke-width="1" opacity="0">
                                                      <rect width="24" height="24" stroke="none"/>
                                                      <rect x="0.5" y="0.5" width="23" height="23" fill="none"/>
                                                    </g>
                                                  </g>
                                                </svg>
                                                <span>{{$value}}</span>
                                                <img src="{{asset('frontassets/image/next-arrow.png')}}">
                                            </div>
                                            <?php 
                                        }
                                    }
                                } 
                            ?>

                            <div class="social_links">
                                <ul>
                                    <?php if( $get_staff['facebook'] != '' ){ ?>
                                        <?php 
                                            $facebook_arr = parse_url($get_staff['facebook']);
                                            $fb_http = '';
                                            if($facebook_arr != ''){
                                                if (!array_key_exists("scheme",$facebook_arr)){
                                                    $fb_http = "http://";
                                                }
                                            }
                                        ?>
                                        <li>
                                            <a href="{{$fb_http}}{{$get_staff['facebook']}}" target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                  <g id="Group_464" data-name="Group 464" transform="translate(-3167 -912)">
                                                    <path id="facebook-rect" d="M3.756,0A3.748,3.748,0,0,0,0,3.756V16.815a3.748,3.748,0,0,0,3.756,3.756h7.078V12.529H8.707v-2.9h2.126V7.16c0-1.943,1.257-3.728,4.151-3.728a17.538,17.538,0,0,1,2.038.113l-.068,2.7s-.884-.009-1.848-.009c-1.044,0-1.211.481-1.211,1.279V9.634h3.142l-.137,2.9H13.9v8.042h2.919a3.748,3.748,0,0,0,3.756-3.756V3.756A3.748,3.748,0,0,0,16.815,0Z" transform="translate(3168.714 913.714)" fill="#BAAD85"/>
                                                    <g id="Rectangle_98" data-name="Rectangle 98" transform="translate(3167 912)" fill="none" stroke="#BAAD85" stroke-width="1" opacity="0">
                                                      <rect width="24" height="24" stroke="none"/>
                                                      <rect x="0.5" y="0.5" width="23" height="23" fill="none"/>
                                                    </g>
                                                  </g>
                                                </svg>
                                            </a>
                                        </li>
                                    <?php } ?>

                                    <?php if( $get_staff['instagram'] != '' ){ ?>
                                        <?php 
                                            $insta_http = '';
                                            $instagram_arr = parse_url($get_staff['instagram']);
                                            if($instagram_arr != ''){
                                                if (!array_key_exists("scheme",$instagram_arr)){
                                                    $insta_http = "http://";
                                                }
                                            }
                                        ?>
                                        <li>
                                            <a href="{{$insta_http}}{{$get_staff['instagram']}}" target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                  <g id="Group_467" data-name="Group 467" transform="translate(-3210 -1010)">
                                                    <g id="bxl-instagram-alt" transform="translate(3211.714 1011.697)">
                                                      <path id="Path_168" data-name="Path 168" d="M25,10.553a7.46,7.46,0,0,0-.478-2.532,5.266,5.266,0,0,0-3.008-3.008,7.547,7.547,0,0,0-2.5-.48c-1.1-.05-1.447-.063-4.238-.063s-3.148,0-4.238.063a7.547,7.547,0,0,0-2.5.48A5.263,5.263,0,0,0,5.037,8.021a7.487,7.487,0,0,0-.478,2.5c-.05,1.1-.064,1.449-.064,4.238s0,3.146.064,4.238a7.53,7.53,0,0,0,.478,2.5A5.266,5.266,0,0,0,8.046,24.5a7.521,7.521,0,0,0,2.5.514c1.1.05,1.449.064,4.238.064s3.148,0,4.238-.064a7.528,7.528,0,0,0,2.5-.478,5.273,5.273,0,0,0,3.008-3.008,7.5,7.5,0,0,0,.478-2.5c.05-1.1.064-1.447.064-4.238s0-3.144-.066-4.238ZM14.773,20.032a5.281,5.281,0,1,1,5.281-5.281,5.279,5.279,0,0,1-5.281,5.281ZM20.265,10.5A1.231,1.231,0,1,1,21.5,9.273,1.23,1.23,0,0,1,20.265,10.5Z" transform="translate(-4.495 -4.47)" fill="#BAAD85"/>
                                                      <path id="Path_169" data-name="Path 169" d="M20.347,16.894a3.431,3.431,0,1,1-3.431-3.431,3.431,3.431,0,0,1,3.431,3.431Z" transform="translate(-6.639 -6.614)" fill="#BAAD85"/>
                                                    </g>
                                                    <g id="Rectangle_103" data-name="Rectangle 103" transform="translate(3210 1010)" fill="none" stroke="#BAAD85" stroke-width="1" opacity="0">
                                                      <rect width="24" height="24" stroke="none"/>
                                                      <rect x="0.5" y="0.5" width="23" height="23" fill="none"/>
                                                    </g>
                                                  </g>
                                                </svg>
                                            </a>
                                        </li>
                                    <?php } ?>

                                    <?php if( $get_staff['twitter'] != '' ){ ?>
                                        <?php 
                                            $twitter_http = '';
                                            $twitter_arr = parse_url($get_staff['twitter']);
                                            if($twitter_arr != ''){
                                                if (!array_key_exists("scheme",$twitter_arr)){
                                                    $twitter_http = "http://";
                                                }
                                            }
                                        ?>
                                        <li>
                                            <a href="{{$twitter_http}}{{$get_staff['twitter']}}" target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                  <g id="Group_463" data-name="Group 463" transform="translate(-3210 -934)">
                                                    <path id="twitter-bird" d="M20.571,1.979a8.546,8.546,0,0,1-2.109,2.179q.013.242.013.546a12.123,12.123,0,0,1-2,6.636,12.822,12.822,0,0,1-2.416,2.748A10.77,10.77,0,0,1,10.688,16a12.31,12.31,0,0,1-4.219.712A11.747,11.747,0,0,1,0,14.814a9.125,9.125,0,0,0,1.007.058,8.275,8.275,0,0,0,5.242-1.808A4.1,4.1,0,0,1,3.8,12.223a4.148,4.148,0,0,1-1.49-2.089,4.219,4.219,0,0,0,1.906-.071A4.113,4.113,0,0,1,1.791,8.609,4.083,4.083,0,0,1,.829,5.927V5.875A4.165,4.165,0,0,0,2.741,6.4,4.192,4.192,0,0,1,1.37,4.9,4.118,4.118,0,0,1,.863,2.892,4.147,4.147,0,0,1,1.434.771,12.016,12.016,0,0,0,5.282,3.886a11.728,11.728,0,0,0,4.85,1.3,4.127,4.127,0,0,1-.111-.961,4.066,4.066,0,0,1,1.237-2.983,4.222,4.222,0,0,1,6.064.094A8.406,8.406,0,0,0,20,.307a4.08,4.08,0,0,1-1.854,2.335,8.434,8.434,0,0,0,2.425-.663Z" transform="translate(3211.714 937.645)" fill="#BAAD85"/>
                                                    <g id="Rectangle_100" data-name="Rectangle 100" transform="translate(3210 934)" fill="none" stroke="#BAAD85" stroke-width="1" opacity="0">
                                                      <rect width="24" height="24" stroke="none"/>
                                                      <rect x="0.5" y="0.5" width="23" height="23" fill="none"/>
                                                    </g>
                                                  </g>
                                                </svg>
                                            </a>
                                        </li>
                                    <?php } ?>

                                    <?php if( $get_staff['whatsapp_url'] != '' ){ ?>
                                        <?php 
                                            /*$whatsapp_http = '';
                                            $whatsapp_url_arr = parse_url($get_staff['whatsapp_url']);
                                            if($whatsapp_url_arr != ''){
                                                if (!array_key_exists("scheme",$whatsapp_url_arr)){
                                                    $whatsapp_http = "http://";
                                                }
                                            }*/
                                        ?>
                                        <li>

                                            <div class="hide_on_desktop">
                                                <a href="https://api.whatsapp.com/send?phone={{$get_staff['whatsapp_url']}}&text=hello" target="_blank">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                      <g id="Group_466" data-name="Group 466" transform="translate(-3210 -979)">
                                                        <path id="whatsapp" d="M10.928,19.285a9.558,9.558,0,0,1-4.68-1.205L0,20.571l2.491-6.248a9.558,9.558,0,0,1-1.205-4.68A9.4,9.4,0,0,1,2.049,5.9,9.541,9.541,0,0,1,7.182.763a9.576,9.576,0,0,1,7.494,0A9.543,9.543,0,0,1,19.808,5.9a9.576,9.576,0,0,1,0,7.494,9.543,9.543,0,0,1-5.133,5.133A9.385,9.385,0,0,1,10.928,19.285Zm3.214-7.714H12.857l-.723.643a5.623,5.623,0,0,1-2.22-1.557A5.617,5.617,0,0,1,8.357,8.437L9,7.714V6.428a1.177,1.177,0,0,0-.241-.683,1.527,1.527,0,0,0-.533-.492q-.291-.151-.411-.03l-.944.944A2.263,2.263,0,0,0,6.64,8.608a8.346,8.346,0,0,0,2.109,3.214,8.331,8.331,0,0,0,3.214,2.109A2.265,2.265,0,0,0,14.4,13.7l.944-.944q.121-.121-.03-.412a1.527,1.527,0,0,0-.492-.533A1.177,1.177,0,0,0,14.142,11.571Z" transform="translate(3211.714 980.714)" fill="#BAAD85"/>
                                                        <g id="Rectangle_101" data-name="Rectangle 101" transform="translate(3210 979)" fill="none" stroke="#BAAD85" stroke-width="1" opacity="0">
                                                          <rect width="24" height="24" stroke="none"/>
                                                          <rect x="0.5" y="0.5" width="23" height="23" fill="none"/>
                                                        </g>
                                                      </g>
                                                    </svg>
                                                </a>
                                            </div>

                                        </li>
                                    <?php } ?>

                                    <?php if( $get_staff['linkedin'] != '' ){ ?>
                                        <?php 
                                            $linkedin_http = '';
                                            $linkedin_arr = parse_url($get_staff['linkedin']);
                                            if($linkedin_arr != ''){
                                                if (!array_key_exists("scheme",$linkedin_arr)){
                                                    $linkedin_http = "http://";
                                                }
                                            }
                                        ?>
                                        <li>
                                            <a href="{{$linkedin_http}}{{$get_staff['linkedin']}}" target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                  <g id="Group_465" data-name="Group 465" transform="translate(-3167 -961)">
                                                    <path id="linkedin" d="M4.67,19.664V6.4H.26V19.664Zm-2.2-15.08A2.3,2.3,0,1,0,2.495,0a2.3,2.3,0,1,0-.058,4.584h.029ZM7.11,19.664h4.41V12.255a3.019,3.019,0,0,1,.145-1.076,2.414,2.414,0,0,1,2.263-1.613c1.6,0,2.234,1.216,2.234,3v7.1h4.41V12.057c0-4.075-2.176-5.971-5.077-5.971a4.392,4.392,0,0,0-4,2.235h.03V6.4H7.111c.058,1.245,0,13.267,0,13.267Z" transform="translate(3168.714 963.168)" fill="#BAAD85"/>
                                                    <g id="Rectangle_99" data-name="Rectangle 99" transform="translate(3167 961)" fill="none" stroke="#BAAD85" stroke-width="1" opacity="0">
                                                      <rect width="24" height="24" stroke="none"/>
                                                      <rect x="0.5" y="0.5" width="23" height="23" fill="none"/>
                                                    </g>
                                                  </g>
                                                </svg>
                                            </a>
                                        </li>
                                    <?php } ?>

                                    <?php if( $get_staff['google_plus_url'] != '' ){ ?>
                                        <?php 
                                            $google_plus_http = '';
                                            $google_plus_url_arr = parse_url($get_staff['google_plus_url']);
                                            if($google_plus_url_arr != ''){
                                                if (!array_key_exists("scheme",$google_plus_url_arr)){
                                                    $google_plus_http = "http://";
                                                }
                                            }
                                        ?>
                                        <li>
                                            <a href="{{$google_plus_http}}{{$get_staff['google_plus_url']}}" target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                  <g id="Group_518" data-name="Group 518" transform="translate(-4745 437)">
                                                    <path id="google-plus" d="M6.411,9.837h5.994a7.226,7.226,0,0,1-.14,3.371,5.757,5.757,0,0,1-1.639,2.669A5.863,5.863,0,0,1,8,17.236a6.835,6.835,0,0,1-3.278-.047,5.936,5.936,0,0,1-2.294-1.17A6.21,6.21,0,0,1,.7,13.912,6.023,6.023,0,0,1,.137,9.744,4.848,4.848,0,0,1,.7,8.152,5.974,5.974,0,0,1,4.3,4.968a6.2,6.2,0,0,1,4.308.047,6.449,6.449,0,0,1,2.061,1.264,2.077,2.077,0,0,1-.328.351,1.394,1.394,0,0,0-.281.3,6.522,6.522,0,0,0-.586.538,8.58,8.58,0,0,0-.587.632,3.266,3.266,0,0,0-1.4-.843,3.471,3.471,0,0,0-1.873-.047,3.736,3.736,0,0,0-1.92,1.03A4.567,4.567,0,0,0,2.758,9.79a3.759,3.759,0,0,0,0,2.482,3.9,3.9,0,0,0,1.5,1.967,3.512,3.512,0,0,0,1.4.609,4.276,4.276,0,0,0,1.545,0,3.5,3.5,0,0,0,1.4-.562,2.728,2.728,0,0,0,1.264-1.967H6.411V9.837Zm13.58.14V11.57h-2.2v2.154H16.2V11.57H14V9.978h2.2v-2.2H17.79v2.2Z" transform="translate(4747.009 -436.008)" fill="#BAAD85"/>
                                                    <g id="Rectangle_152" data-name="Rectangle 152" transform="translate(4745 -437)" fill="none" stroke="#BAAD85" stroke-width="1" opacity="0">
                                                      <rect width="24" height="24" stroke="none"/>
                                                      <rect x="0.5" y="0.5" width="23" height="23" fill="none"/>
                                                    </g>
                                                  </g>
                                                </svg>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>    
                        </div>

                    </div>
                </div>

                <?php if( @$get_staff['google_map'] != '' && $get_staff['address'] != '' ){ ?>
                    <div>
                        <div class="mapouter">
                            <div class="gmap_canvas">
                                <iframe width="100%" height="200" id="gmap_canvas" src="https://maps.google.com/maps?q={{$get_staff['address']}}&t=&z=10&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0">
                                </iframe>
                            </div>
                        </div>
                    </div>
                <?php } ?>

            </div>
        </div>
    </div>
</div>

</body>
</html>