<div class="main">
   <div class="main_right">
      <!-- TOPBAR -->
      <div class="top_announce d-flex align-items-center justify-content-between mb_20">
         <div class="top_ann_center"><img src="{{ asset('admin/images/Barcontroller_logo.png') }}" alt="" height="110px"></div>
         <div class="top_ann_right d-flex align-items-center justify-content-between">
            <div class="topan_left">
               <a href="{{url('update_userprofile')}}">
                  <div class="d-flex">
                     <div class="cli_img"><img src="{{ asset('admin/images/cli.png') }}" alt=""></div>
                     <div class="">
                        <p class="f14 mb-0 fw_400">{{$data['user_details']['restaurant_name']}}</p>
                     </div>
                  </div>
               </a>
            </div>
            <div class="topan_right">
               <div class="not_box"><a href="#!"><img src="{{ asset('admin/images/not.png') }}" alt=""></a></div>
            </div>
         </div>
      </div>