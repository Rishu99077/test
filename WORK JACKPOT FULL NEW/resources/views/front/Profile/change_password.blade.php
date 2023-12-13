@include('front.layout.header')
@include('front.layout.sidebar')
<div class="main_right">

    <div class="top_announce d-flex align-items-center justify-content-between mb_20">

        <div class="top_ann_left">
            @if($user['role']=='seeker')
                <a href="{{Route('add_advertisment')}}" class="site_btn f16 f_bold blue__btn">{{__("customer.text_post_job_search")}}</a>
            @elseif($user['role']=='provider')
                <a href="{{Route('job_add')}}" class="site_btn f16 f_bold blue__btn">{{__("customer.text_add_new_job")}}</a>
            @endif  
        </div>
        <div class="top_ann_right d-flex align-items-center ">
            <form action="" class="topan_search w-100 justify-content-xl-end">
                <input type="text" name="" id="" placeholder='{{__("customer.text_search_for_everything")}}'>
                <input type="submit" value="">
            </form>
        </div>

    </div>

    <!-- <h1 class="post_title mb_30">Marketing Clients</h1> -->
    <div class="d-flex top_bb mb_20 align-items-center justify-content-between">
        <h3 class="title w-100">{{$common['heading_title']}}</h3>
    </div>

    <div class="edit_profile_row">
        <div class="edit_profile_all w-100">
            <div class="profile_nameimg">
                <div class="profile_img">
                    <div class="upload_cv_sec">
                        <div class="form_row m-0 img_preview_main position-relative">
                            <!-- <input type="file" name="prof_img" id="prof_img" class="border-0 visually-hidden image_upload" accept="image/x-png,image/gif,image/jpeg"> -->
                            <span class="upload_icon m-0 p-0">
                                <img src="{{ url('profile',$user['profile_image']) }}" alt="" class="img_preview" id="img_preview">
                            </span>
                           <!--  <label for="prof_img" class="upload_lbl clicktoupload m-0">
                                <img src="{{ asset('assets/images/camera.png') }}" alt="" srcset="">
                            </label> -->
                        </div>
                    </div>
                </div>
                <div class="profile_name">
                    <h3>{{$user['firstname']}} {{$user['surname']}}</h3>
                    <p>{{$user['email']}}</p>
                </div>
            </div>
        </div>
        <form method="post" action="{{ Route('change_password') }}" autocomplete="off" class="other_profile_details w-100">
         @csrf 
            <div class="row edit_form">
                <div class="col-lg-4 col-md-6">
                     <label for="name">{{__("customer.text_old_password")}}</label>
                     <input type="password" name="current_password" value="{{old('current_password')}}" placeholder='{{__("customer.text_enter")}} {{__("customer.text_old_password")}}' />
                     <span class="text-danger"> 
                     <?php if ($errors->has('current_password')) { ?> {{
                        $errors->first('current_password') }}
                     <?php } ?>
                     </span>
                </div>
                <div class="col-lg-4 col-md-6">
                    <label for="name">{{__("customer.text_new_password")}}</label>
                    <input type="password" name="new_password" value="{{old('new_password')}}"  placeholder='{{__("customer.text_enter")}} {{__("customer.text_new_password")}}' />
                    <span class="text-danger"> 
                    <?php if ($errors->has('new_password')) { ?> {{
                      $errors->first('new_password') }}
                    <?php } ?>
                    </span>
                </div>
                <div class="col-lg-4 col-md-6">
                    <label for="name">{{__("customer.text_con_password")}}</label>
                    <input type="password" name="confirm_password" value="{{old('confirm_password')}}" placeholder='{{__("customer.text_enter")}} {{__("customer.text_con_password")}}' />
                    <span class="text-danger"> 
                    <?php if ($errors->has('confirm_password')) { ?> {{
                      $errors->first('confirm_password') }}
                    <?php } ?>
                    </span>
                </div>
            </div>
            <div class="text-end">
               <button type="button" class="site_btn act_btn" onclick="goBack()">{{__("customer.text_back")}}</button>
               <button type="submit" class="site_btn">{{__("customer.text_update")}}</button>
            </div>
        </form>
    </div>
</div>
@include('front.layout.footer')