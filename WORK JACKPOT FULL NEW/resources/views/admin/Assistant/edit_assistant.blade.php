@include('admin.layout.header')
@include('admin.layout.sidebar')

<div class="main_right">
    <div class="top_announce d-flex align-items-center justify-content-between mb_20">
        <div class="top_ann_left">
            <a href="#" class="site_btn f16 f_bold blue__btn">{{$common['heading_title']}}</a>
        </div>
        <div class="top_ann_right d-flex align-items-center ">
            <form action="" class="topan_search w-100 justify-content-xl-end">
                <input type="text" name="" id="" placeholder='{{__("admin.text_search_for_everything")}}'>
                <input type="submit" value="">
            </form>
        </div>

    </div>
    <div class="d-flex top_bb mb_20 align-items-center justify-content-between">
        <h3 class="title w-100">{{$common['heading_title']}}</h3>
    </div>
    
    <form method="post" action="{{ url('admin/save_assistant') }}" autocomplete="off" enctype="multipart/form-data">
      @csrf 
      <input type="hidden" name="Assi_ID" value="{{$assistant['id']}}">
      <div class="edit_profile_row">
          <div class="edit_profile_all w-100">
              <div class="profile_nameimg">
                  <div class="profile_img">
                      <div class="upload_cv_sec">
                          <div class="form_row m-0 img_preview_main position-relative">
                              <input type="file" name="prof_img" id="prof_img" class="border-0 visually-hidden image_upload" accept="image/x-png,image/gif,image/jpeg">
                              <span class="upload_icon m-0 p-0">
                                  <img src="{{ url('profile',$assistant['profile_image']) }}" alt="" class="img_preview" id="img_preview">
                              </span>
                              <label for="prof_img" class="upload_lbl clicktoupload m-0">
                                  <img src="{{ asset('assets/images/camera.png') }}" alt="" srcset="">
                              </label>
                          </div>
                      </div>
                  </div>
                  <div class="profile_name">
                      <h3>{{$assistant['first_name']}} {{$assistant['last_name']}}</h3>
                      <p>{{$assistant['email']}}</p>
                  </div>
              </div>
              
          </div>
          <p class="f18 clr_purpule f_black">{{__("admin.text_personal_details")}}</p>
          <div class="row edit_form">
              <div class="col-lg-4 col-md-6">
                  <label for="name">{{__("admin.text_first_name")}}</label>
                  <input type="text" name="first_name" value="{{old('first_name',$assistant['first_name'])}}" placeholder='{{__("admin.text_enter")}} {{__("admin.text_first_name")}}' />
                  <span class="text-danger"> 
                  <?php if ($errors->has('first_name')) { ?> {{
                    $errors->first('first_name') }}
                  <?php } ?>
                  </span>
              </div>
              <div class="col-lg-4 col-md-6">
                  <label for="name">{{__("admin.text_last_name")}}</label>
                  <input type="text" name="last_name" value="{{old('last_name',$assistant['last_name'])}}" id="" placeholder='{{__("admin.text_enter")}} {{__("admin.text_last_name")}}' />
                  <span class="text-danger"> 
                  <?php if ($errors->has('last_name')) { ?> {{
                    $errors->first('last_name') }}
                  <?php } ?>
                  </span>
              </div>
              <div class="col-lg-4 col-md-6">
                  <label for="name">{{__("admin.text_email")}}</label>
                  <input type="email" name="email"  value="{{old('email',$assistant['email'])}}" id="" placeholder='{{__("admin.text_enter")}} {{__("admin.text_email")}}' />
                  <span class="text-danger"> 
                  <?php if ($errors->has('email')) { ?> {{
                    $errors->first('email') }}
                  <?php } ?>
                  </span>
              </div>

              <div class="col-lg-4 col-md-6">
                  <label for="name">{{__("admin.text_password")}}</label>
                  <input type="password" name="password"  id="" placeholder='{{__("admin.text_enter")}} {{__("admin.text_password")}}' />
                  <span class="text-danger"> 
                  <?php if ($errors->has('password')) { ?> {{
                    $errors->first('password') }}
                  <?php } ?>
                  </span>
              </div>

              <div class="col-lg-4 col-md-6">
                  <label for="name">{{__("admin.text_phone_number")}}</label>
                  <input type="text" name="phone_no"  value="{{old('phone_no',$assistant['phone_no'])}}" id="" placeholder='{{__("admin.text_enter")}} {{__("admin.text_phone_number")}}' />
                  <span class="text-danger"> 
                  <?php if ($errors->has('phone_no')) { ?> {{
                    $errors->first('phone_no') }}
                  <?php } ?>
                  </span>
              </div>

              <div class="col-lg-4 col-md-6">
                 <label>{{__("admin.text_country")}}</label>
                 <select id="CountryID" name="country">
                    <option value="">-- {{__("admin.text_select")}} {{__("admin.text_country")}} --</option>
                    <?php foreach ($get_countries as $type_key => $val_con) { ?>
                    <option value="<?php echo $val_con['id']; ?>" <?php echo $assistant['country'] == $val_con['id'] ? "selected" : "" ;?>><?php echo $val_con['name']; ?></option>
                    <?php } ?>
                 </select>
                 <span class="text-danger"> 
                 <?php if ($errors->has('country')) { ?> {{
                 $errors->first('country') }}
                 <?php } ?>
                 </span>
              </div>

              <div class="col-lg-4 col-md-6">
                 <label>{{__("admin.text_province")}}</label>
                 <select  id="StateID" name="state">
                    <option value="">-- {{__("admin.text_select")}} {{__("admin.text_province")}} --</option>
                    @if($assistant['country'] !="")
                    @foreach($StateModel as $key => $state)
                    <option value="{{$state['id']}}"<?php echo $assistant['state'] == $state['id'] ? "selected" : "" ;?>><?php echo $state['name']; ?></option>
                    @endforeach
                    @endif
                 </select>
                 <span class="text-danger"> 
                 <?php if ($errors->has('state')) { ?> {{
                 $errors->first('state') }}
                 <?php } ?>
                 </span>
              </div>

              <div class="col-lg-4 col-md-6">
                 <label>{{__("admin.text_city")}}</label>
                 <select id="CityID" name="city">
                    <option value="">-- {{__("admin.text_select")}} {{__("admin.text_city")}} --</option>
                    @if($assistant['country'] !="")
                    @foreach($CityModel as $key => $city)
                    <option value="{{$city['id']}}"<?php echo $assistant['city'] == $city['id'] ? "selected" : "" ;?>><?php echo $city['name']; ?></option>
                    @endforeach
                    @endif
                 </select>
                 <span class="text-danger"> 
                 <?php if ($errors->has('city')) { ?> {{
                 $errors->first('city') }}
                 <?php } ?>
                 </span>
              </div>

              <div class="row edit_text">
                <div class="col-xl-12 justify-content-center text-center">
                    <input type="reset" value='{{__("admin.text_back")}}' class="site_btn act_btn" onclick="goBack()" style="width: 10%!important;">
                    <button type="submit" class="site_btn">{{__("admin.text_save")}}</button>
                </div>
              </div>

          </div>
      </div>
    </form>
</div>
<script type="text/javascript">
   $('#CountryID').on("change",function(){
       var CountryID = $(this).val();
       if(CountryID==''){
           CountryID = 0;
       }
       $.ajax({
           type:"get",
           url: "{{ url('admin/get_states_by_countryid') }}"+"/"+CountryID,
           success:function(resp){
               $('#StateID').html(resp.get_states);
           }
       })
   });
   
   
   $('#StateID').on("change",function(){
       var StateID = $(this).val();
       if(StateID==''){
           StateID = 0;
       }
       $.ajax({
           type:"get",
           url: "{{ url('admin/get_cities_by_stateid') }}"+"/"+StateID,
           success:function(resp){
               $('#CityID').html(resp.get_cities);
           }
       })
   });
</script>
@include('admin.layout.footer')