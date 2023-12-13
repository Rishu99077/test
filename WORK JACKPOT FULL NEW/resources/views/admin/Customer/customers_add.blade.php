@include('admin.layout.header')
@include('admin.layout.sidebar')
<div class="main_right">

    <div class="top_announce d-flex align-items-center justify-content-between mb_20">
        <div class="top_ann_left">
          <a href="{{Route('customers_add')}}" class="site_btn f16 f_bold blue__btn post_ad_disabled">{{$common['heading_title']}}</a>
        </div>
    </div>

    <div class="presonal-wallines radioPanel wali_ka_form">
        <form method="post" action="{{url('admin/save_customer')}}">
         @csrf 
            <input type="hidden"  name="CustID" value="{{$customers['id']}}">
            <input type="hidden"  name="role" value="seeker">
            <div class="row">
                <div class="col-lg-4 col-sm-6">
                    <div class="form-group">
                        <label for="" class="full-name">{{__("admin.text_first_name")}}</label>
                        <input type="text" class="form-control full-name-control" name="firstname" value="{{old('firstname',$customers['firstname'])}}" placeholder='{{__("admin.text_first_name")}}'>
                        <span class="text-danger"> 
                         <?php if ($errors->has('firstname')) { ?> {{
                         $errors->first('firstname') }}
                         <?php } ?>
                        </span>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="form-group">
                      <label for="" class="full-name">{{__("admin.text_family_name")}}</label>
                      <input type="text" class="form-control full-name-control" name="surname" value="{{old('surname',$customers['surname'])}}" placeholder='{{__("admin.text_family_name")}}'>
                      <span class="text-danger"> 
                      <?php if ($errors->has('surname')) { ?> {{
                      $errors->first('surname') }}
                      <?php } ?>
                      </span>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="form-group">
                        <label for="" class="full-name">{{__("admin.text_nick_name")}}</label>
                        <input type="text" class="form-control full-name-control" name="nick_name" value="{{old('nick_name',$customers['nick_name'])}}">
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="form-group">
                        <label for="" class="full-name">{{__("admin.text_country")}}</label>
                         <select id="CountryID" class="form-control full-name-control" name="country">
                            <option value="">-- {{__("admin.text_select")}} {{__("admin.text_country")}} --</option>
                            <?php foreach ($get_countries as $type_key => $val_con) { ?>
                            <option value="<?php echo $val_con['id']; ?>" <?php echo $customers['country'] == $val_con['id'] ? "selected" : "" ;?>><?php echo $val_con['name']; ?></option>
                            <?php } ?>
                         </select>
                         <span class="text-danger"> 
                         <?php if ($errors->has('country')) { ?> {{
                         $errors->first('country') }}
                         <?php } ?>
                         </span>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="form-group">
                      <label for="" class="full-name">{{__("admin.text_state")}}</label>
                      <select id="StateID" class="form-control full-name-control" name="state">
                        <option value="">-- {{__("admin.text_select")}} {{__("admin.text_state")}} --</option>
                        @if($customers['country'] !="")
                        @foreach($StateModel as $key => $state)
                        <option value="{{$state['id']}}"<?php echo $customers['state'] == $state['id'] ? "selected" : "" ;?>><?php echo $state['name']; ?></option>
                        @endforeach
                        @endif
                      </select>
                      <span class="text-danger"> 
                      <?php if ($errors->has('state')) { ?> {{
                      $errors->first('state') }}
                      <?php } ?>
                      </span>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="form-group">
                      <label for="" class="full-name">{{__("admin.text_city")}}</label>
                      <select id="CityID" class="form-control full-name-control" name="city">
                      <option value="">-- {{__("admin.text_select")}} {{__("admin.text_city")}} --</option>
                      @if($customers['country'] !="")
                      @foreach($CityModel as $key => $city)
                      <option value="{{$city['id']}}"<?php echo $customers['city'] == $city['id'] ? "selected" : "" ;?>><?php echo $city['name']; ?></option>
                      @endforeach
                      @endif
                      </select>
                      <span class="text-danger"> 
                      <?php if ($errors->has('city')) { ?> {{
                      $errors->first('city') }}
                      <?php } ?>
                      </span>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                  <div class="form-group">  
                    <label for="" class="full-name">{{__("admin.text_zip_code")}}</label>
                    <input type="number"  class="form-control full-name-control" name="zip_code" value="{{old('zip_code',$customers['zip_code'])}}">
                    <span class="text-danger"> 
                    <?php if ($errors->has('zip_code')) { ?> {{
                    $errors->first('zip_code') }}
                    <?php } ?>
                    </span>
                  </div>
                </div>

                <div class="col-lg-4 col-sm-6">
                    <div class="form-group">
                      <label for="" class="full-name">{{__("admin.text_house_number")}}</label>
                      <input type="text"  class="form-control full-name-control" name="house_number" value="{{old('house_number',$customers['house_number'])}}">
                      <span class="text-danger"> 
                      <?php if ($errors->has('house_number')) { ?> {{
                      $errors->first('house_number') }}
                      <?php } ?>
                      </span>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="form-group">
                      <label for="" class="full-name">{{__("admin.text_phone_number")}}</label>
                      <input type="number" class="form-control full-name-control" name="phone_number"  value="{{old('phone_number',$customers['phone_number'])}}">
                      <span class="text-danger"> 
                      <?php if ($errors->has('phone_number')) { ?> {{
                        $errors->first('phone_number') }}
                      <?php } ?>
                      </span>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                  <div class="form-group">
                   <label for="" class="full-name">{{__("admin.text_email")}}</label>
                   <input type="email"  class="form-control full-name-control" name="email" value="{{old('email',$customers['email'])}}">
                   <span class="text-danger"> 
                   <?php if ($errors->has('email')) { ?> {{
                   $errors->first('email') }}
                   <?php } ?>
                   </span>
                 </div>
                </div>
                @if($customers['id'] == '')
                <div class="col-lg-4 col-md-6">
                  <div class="form-group">
                   <label for="" class="full-name">{{__("admin.text_password")}}</label>
                   <input type="password"  class="form-control full-name-control" name="password" value="{{old('password',$customers['password'])}}">
                   <span class="text-danger"> 
                   <?php if ($errors->has('password')) { ?> {{
                   $errors->first('password') }}
                   <?php } ?>
                   </span>
                 </div>
                </div>
                <div class="col-lg-4 col-md-6">
                  <div class="form-group">
                    <label for="" class="full-name">{{__("admin.text_confirm_password")}}</label>
                    <input type="password"  class="form-control full-name-control" name="confirm_password">
                    <span class="text-danger"> 
                    <?php if ($errors->has('confirm_password')) { ?> {{
                    $errors->first('confirm_password') }}
                    <?php } ?>
                    </span>
                  </div>
                </div>
                @endif
                <div class="row">
                  <div class="col-xl-8">
                      <div class="form-group">
                          <label for="" class="full-name">{{__("admin.text_address")}}</label>
                          <textarea cols="40" rows="10" name="address">{{old('address',$customers['address'])}}</textarea>
                          <span class="text-danger"> 
                            <?php if ($errors->has('address')) { ?> {{
                              $errors->first('address') }}
                            <?php } ?>
                          </span>
                      </div>
                  </div>
                  <div class="col-xl-4 sp_frm_group">
                      <div class="row sm_inp jpost_dl">
                          
                      </div>

                      <div class="d-flex flex-wrap justify-content-between post_job_btns">
                         
                          <div class="btn_half"><input type="reset" value="Back" class="site_btn act_btn" onclick="goBack()"></div>
                          <div class="btn_half">
                            @if($customers['id']=='')
                              <button type="submit" class="site_btn">{{__("admin.text_save")}}</button>
                            @else
                              <button type="submit" class="site_btn">{{__("admin.text_Update")}}</button>
                            @endif
                          </div>
                      </div>

                  </div>
                </div>
            </div>
        </form>
       
    </div>

</div>
@include('admin.layout.footer')
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
