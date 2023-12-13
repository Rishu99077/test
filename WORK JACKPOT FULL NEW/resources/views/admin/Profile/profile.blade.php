@include('admin.layout.header')
@include('admin.layout.sidebar')
<div class="main_right">

   <div class="top_announce d-flex align-items-center justify-content-between mb_20">
        <div class="top_ann_left">
            <a href="{{Route('admin_my_profile')}}" class="site_btn f16 f_bold blue__btn post_ad_disabled">{{$common['heading_title']}}</a>
        </div>
    </div>
     <form method="post" action="{{ url('admin/update_profile') }}" autocomplete="off" enctype="multipart/form-data" >
    <div class="edit_profile_row">
        <div class="edit_profile_all w-100">
            <div class="profile_nameimg">
                <div class="profile_img">
                    <div class="upload_cv_sec">
                        <div class="form_row m-0 img_preview_main position-relative">
                            <input type="file" name="prof_img" id="prof_img" class="border-0 visually-hidden image_upload" accept="image/x-png,image/gif,image/jpeg">
                            <span class="upload_icon m-0 p-0">
                                <img src="{{ url('profile',$user['profile_image']) }}" alt="" class="img_preview" id="img_preview">
                            </span>
                            <label for="prof_img" class="upload_lbl clicktoupload m-0">
                                <img src="{{ asset('admin/assets/images/camera.png') }}" alt="" srcset="">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="profile_name">
                    <h3>{{$user['first_name']}} {{$user['last_name']}}</h3>
                    <p>{{__("admin.text_superadmin")}}</p>
                </div>
            </div>
            <div class="profile_btns p-0">
                <a href="{{Route('admin_change_password')}}" class="change_pass"><img src="{{ asset('admin/assets/images/change-pass.png') }}" alt="" srcset="">{{__("admin.text_chn_password")}}</a>
            </div>
        </div>
        <form  autocomplete="off" class="other_profile_details w-100">
         @csrf 
            <div class="row edit_form">
                <div class="col-lg-4 col-md-6">
                    <label for="name">{{__("admin.text_first_name")}}</label>
                    <input type="text" name="first_name" value="{{old('first_name',$user['first_name'])}}" placeholder='{{__("admin.text_first_name")}}' />
                    <span class="text-danger"> 
                    <?php if ($errors->has('first_name')) { ?> {{
                      $errors->first('first_name') }}
                    <?php } ?>
                    </span>
                </div>
                <div class="col-lg-4 col-md-6">
                    <label for="name">{{__("admin.text_last_name")}}</label>
                    <input type="text" name="last_name" value="{{old('last_name',$user['last_name'])}}" id="" placeholder='{{__("admin.text_last_name")}}' />
                    <span class="text-danger"> 
                    <?php if ($errors->has('last_name')) { ?> {{
                      $errors->first('last_name') }}
                    <?php } ?>
                    </span>
                </div>
                <div class="col-lg-4 col-md-6">
                    <label for="name">{{__("admin.text_email")}}</label>
                    <input type="email" name="email" readonly value="{{old('email',$user['email'])}}" id="" placeholder='{{__("admin.text_email")}}' />
                    <span class="text-danger"> 
                    <?php if ($errors->has('email')) { ?> {{
                      $errors->first('email') }}
                    <?php } ?>
                    </span>
                </div>
            </div>
            <div class="text-end">
               <button type="submit" class="btn add_btn">{{__("admin.text_update")}}</button>
            </div>
        </form>
    </div>
   </form>
</div>
@include('admin.layout.footer')