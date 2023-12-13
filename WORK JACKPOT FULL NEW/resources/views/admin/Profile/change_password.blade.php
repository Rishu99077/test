@include('admin.layout.header')
@include('admin.layout.sidebar')
<div class="main_right">

    <div class="top_announce d-flex align-items-center justify-content-between mb_20">
        <div class="top_ann_left">
            <a href="{{Route('admin_change_password')}}" class="site_btn f16 f_bold blue__btn post_ad_disabled">{{$common['heading_title']}}</a>
        </div>
    </div>

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
        </div>
        <form method="post" action="{{ Route('admin_change_password') }}" autocomplete="off" class="other_profile_details w-100">
         @csrf 
            <div class="row edit_form">
                <div class="col-lg-4 col-md-6">
                     <label for="name">{{__("admin.text_old_password")}}</label>
                     <input type="password" name="current_password" value="{{old('current_password')}}" placeholder='{{__("admin.text_old_password")}}' />
                     <span class="text-danger"> 
                     <?php if ($errors->has('current_password')) { ?> {{
                        $errors->first('current_password') }}
                     <?php } ?>
                     </span>
                </div>
                <div class="col-lg-4 col-md-6">
                    <label for="name">{{__("admin.text_new_password")}}</label>
                    <input type="password" name="new_password" value="{{old('new_password')}}"  placeholder='{{__("admin.text_old_password")}}' />
                    <span class="text-danger"> 
                    <?php if ($errors->has('new_password')) { ?> {{
                      $errors->first('new_password') }}
                    <?php } ?>
                    </span>
                </div>
                <div class="col-lg-4 col-md-6">
                    <label for="name">{{__("admin.text_confirm_password")}}</label>
                    <input type="password" name="confirm_password" value="{{old('confirm_password')}}" placeholder='{{__("admin.text_confirm_password")}}' />
                    <span class="text-danger"> 
                    <?php if ($errors->has('confirm_password')) { ?> {{
                      $errors->first('confirm_password') }}
                    <?php } ?>
                    </span>
                </div>
            </div>
            <div class="text-end">
               <button type="submit" class="btn add_btn">{{__("admin.text_update")}}</button>
            </div>
        </form>
    </div>
</div>
@include('admin.layout.footer')