@include('front.layout.header')
@include('front.layout.sidebar')
<div class="main_right">

             <div class="top_announce d-flex align-items-center justify-content-between mb_20">

                <div class="top_ann_left">
                    <a href="#" class="site_btn f16 f_bold blue__btn post_ad_disabled">{{__("customer.text_post_job_search")}}</a>
                </div>
                <div class="top_ann_right d-flex align-items-center ">
                    <form action="" class="topan_search w-100 justify-content-xl-end">
                        <input type="text" name="" id="" placeholder='{{__("customer.text_search_for_everything")}}'>
                        <input type="submit" value="">
                    </form>
                </div>

            </div>

            <div class="mb_20">
                <h3 class="title">{{__("customer.text_post_job_search")}}</h3>
            </div>

            <div class="presonal-wallines radioPanel wali_ka_form">
                <form action="{{Route('add_advertisment')}}" method="post" id="Advertisment_form">
                    @csrf
                    <input type="hidden" name="id" value="{{$get_advertisment['id']}}">
                    <div class="row">
                        
                        <div class="col-lg-4 col-sm-6">
                                <div class="form-group">
                                    <label for="" class="full-name">{{__("customer.text_first_name")}}</label>
                                    <input type="text" class="form-control full-name-control  {{ $errors->has('firstname') ? 'is-invalid' : ''}}" value="{{old('firstname',$get_advertisment['firstname'])}}" name="firstname" placeholder='{{__("customer.text_enter")}} {{__("customer.text_first_name")}}'>
                                    @error('firstname')
                                      <div class="invalid-feedback">
                                         {{ $message }}
                                      </div>
                                    @enderror
                                </div>
                        </div>
                        
                        <div class="col-lg-4 col-sm-6">
                            <div class="form-group">
                                <label for="" class="full-name">{{__("customer.text_family_name")}}</label>
                                <input type="tel" class="form-control full-name-control {{ $errors->has('familyname') ? 'is-invalid' : ''}}" value="{{old('familyname',$get_advertisment['familyname'])}}" name="familyname" placeholder='{{__("customer.text_enter")}} {{__("customer.text_family_name")}}'>
                                @error('familyname')
                                  <div class="invalid-feedback">
                                     {{ $message }}
                                  </div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-lg-4 col-sm-6">
                            <div class="form-group">
                                <label for="" class="full-name">{{__("customer.text_academic_level")}}</label>
                                <input type="text" class="form-control full-name-control {{ $errors->has('academic_level') ? 'is-invalid' : ''}}" value="{{old('academic_level',$get_advertisment['academic_level'])}}" name="academic_level" placeholder='{{__("customer.text_enter")}} {{__("customer.text_academic_level")}}'>
                                 @error('academic_level')
                                  <div class="invalid-feedback">
                                     {{ $message }}
                                  </div>
                                @enderror
                            </div>
                        </div>
                    
                        
                        <div class="col-lg-4 col-sm-6">
                            <div class="form-group">
                                <label for="" class="full-name">{{__("customer.text_nationality")}}</label>
                                <input type="text" class="form-control full-name-control {{ $errors->has('nationality') ? 'is-invalid' : ''}}" value="{{old('nationality',$get_advertisment['nationality'])}}" name="nationality" placeholder='{{__("customer.text_enter")}} {{__("customer.text_nationality")}}'>
                                 @error('nationality')
                                  <div class="invalid-feedback">
                                     {{ $message }}
                                  </div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-lg-4 col-sm-6">
                            <div class="form-group">
                                <label for="" class="full-name">{{__("customer.text_country")}}</label>
                                <select name="country" id="country" class="{{ $errors->has('country') ? 'is-invalid' : ''}}">
                                    <option value="">{{__("customer.text_select")}} {{__("customer.text_country")}}</option>
                                    @foreach($CountryModel as $key => $value)
                                    <option value="{{$value['id']}}"<?php echo $get_advertisment['country'] == $value['id'] ?"selected":"";?>>{{$value['name']}}</option>
                                    @endforeach
                                </select>
                                  @error('country')
                                  <div class="invalid-feedback">
                                     {{ $message }}
                                  </div>
                                  @enderror
                            </div>
                        </div>
                        
                        <div class="col-lg-4 col-sm-6">
                            <div class="form-group">
                                <label for="" class="full-name">{{__("customer.text_city_with_zip")}}</label>
                                <input type="text" class="form-control full-name-control {{ $errors->has('zipcode') ? 'is-invalid' : ''}}" name="zipcode" value="{{old('zipcode',$get_advertisment['zipcode'])}}" placeholder='{{__("customer.text_city_with_zip")}}'>
                                @error('zipcode')
                                  <div class="invalid-feedback">
                                     {{ $message }}
                                  </div>
                                  @enderror
                            </div>
                        </div>
                        
                        <div class="col-lg-4 col-sm-6">
                            <div class="form-group">
                                <label for="" class="full-name">{{__("customer.text_profession_name")}}</label>
                                <input type="text" class="form-control full-name-control {{ $errors->has('profession_name') ? 'is-invalid' : ''}}" value="{{old('profession_name',$get_advertisment['profession_name'])}}" name="profession_name" placeholder='{{__("customer.text_enter")}} {{__("customer.text_profession_name")}}'>
                                @error('profession_name')
                                  <div class="invalid-feedback">
                                     {{ $message }}
                                  </div>
                                  @enderror
                            </div>
                        </div>
                        
                        <div class="col-lg-4 col-sm-6">
                            <div class="form-group">
                                <label for="" class="full-name">{{__("customer.text_hours_salary")}}</label>
                                <input type="text" class="form-control full-name-control {{ $errors->has('profession_name') ? 'is-invalid' : ''}}" value="{{old('hours_salary',$get_advertisment['hours_salary'])}}" name="hours_salary" placeholder='{{__("customer.text_enter")}} {{__("customer.text_hours_salary")}}'>
                                @error('profession_name')
                                  <div class="invalid-feedback">
                                     {{ $message }}
                                  </div>
                                @enderror
                            </div>
                            </div>
                        
                        <div class="col-lg-4 col-sm-6">
                            <div class="form-group">
                                <label for="" class="full-name">{{__("customer.text_working_hours")}}</label>
                                <input type="text" class="form-control full-name-control {{ $errors->has('working_hour') ? 'is-invalid' : ''}}"  value="{{old('working_hour',$get_advertisment['working_hour'])}}" name="working_hour" placeholder='{{__("customer.text_enter")}} {{__("customer.text_working_hours")}}'>
                                @error('working_hour')
                                  <div class="invalid-feedback">
                                     {{ $message }}
                                  </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-sm-6">
                            <div class="form-group">
                                <label for="" class="full-name">{{__("customer.text_experience")}}</label>
                                <input type="text" class="form-control full-name-control {{ $errors->has('experience') ? 'is-invalid' : ''}}" value="{{old('experience',$get_advertisment['experience'])}}" name="experience" placeholder='{{__("customer.text_enter")}} {{__("customer.text_experience")}}'>
                                 @error('experience')
                                  <div class="invalid-feedback">
                                     {{ $message }}
                                  </div>
                                  @enderror
                            </div>
                        </div>
                       
                        <div class="col-lg-4 col-sm-6">
                            <div class="form-group">
                                <label for="" class="full-name">{{__("customer.text_work_location")}} </label>
                                <input type="text" class="form-control full-name-control {{ $errors->has('work_location') ? 'is-invalid' : ''}}" value="{{old('work_location',$get_advertisment['work_location'])}}" name="work_location" placeholder='{{__("customer.text_work_location")}}'>
                                @error('work_location')
                                  <div class="invalid-feedback">
                                     {{ $message }}
                                  </div>
                                  @enderror
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <label for="st_date" class="full-name">{{__("customer.text_start_date")}}</label>
                            <div class="row sm_inp">
                                <div class="col">
                                    <div class="form-group">
                                        <input type="date" id="st_date" name="date"  class="form-control full-name-control {{ $errors->has('date') ? 'is-invalid' : ''}}" placeholder='{{__("customer.text_day")}}' min="{{date('Y-m-d')}}"  value="{{ date('Y-m-d') }}">
                                        @error('date')
                                          <div class="invalid-feedback">
                                             {{ $message }}
                                          </div>
                                        @enderror
                                    </div>
                                </div>
                               <!--  <div class="col">
                                    <div class="form-group">
                                        <input type="text" class="form-control full-name-control {{ $errors->has('month') ? 'is-invalid' : ''}}" name="month"  placeholder='{{__("customer.text_month")}}' value="<?php echo date('m'); ?>" readonly>
                                        @error('month')
                                          <div class="invalid-feedback">
                                             {{ $message }}
                                          </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <input type="text" class="form-control full-name-control {{ $errors->has('year') ? 'is-invalid' : ''}}"  name="year" placeholder='{{__("customer.text_years")}}' value="<?php echo date('Y'); ?>" readonly>

                                        @error('year')
                                          <div class="invalid-feedback">
                                             {{ $message }}
                                          </div>
                                        @enderror
                                    </div>
                                </div> -->
                            </div>
                        </div>

                        
                        <div class="col-xl-8">
                            <div class="form-group">
                                <label for="" class="full-name">{{__("customer.text_offer_description")}}</label>
                                <textarea  id="" cols="30" rows="10" name="description" placeholder='{{__("customer.text_enter")}} {{__("customer.text_offer_description")}}'>{{old('description',$get_advertisment['description'])}}</textarea>
                            </div>
                        </div>

                        <div class="col-xl-4 sp_frm_group">
                            <div class="row sm_inp jpost_dl">
                                <div class="col-xxl-6 col-xl-12 col-sm-6">
                                    <input type="checkbox" class="" name="driving_license" value="1" <?php echo $get_advertisment['driving_license'] == 1 ?"checked":""; ?>id="dlicense">
                                    <label for="dlicense" class="full-name d-inline-block w-auto">{{__("customer.text_driving_license")}}</label>
                                </div>
                                <div class="col-xxl-6 col-xl-12 col-sm-6">
                                    <input type="checkbox" class="" name="own_car" value="1" <?php echo $get_advertisment['own_car'] == 1 ?"checked":""; ?> id="own_car">
                                    <label for="own_car" class="full-name d-inline-block w-auto">{{__("customer.text_own_car")}}</label>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap justify-content-between post_job_btns">
                                <div class="w-100">
                                    <a href="#" class="bk_btn" onclick="goBack()"><img src="images/back.png" alt="">{{__("customer.text_back")}}</a>
                                </div>
                                <div class="btn_half"><input type="reset" value='{{__("customer.text_clear")}}'  id="clear" class="site_btn act_btn"></div>
                                <div class="btn_half">
                                    <button type="submit" class="site_btn">{{__("customer.text_publish_offer")}}</button></div>
                            </div>

                        </div>
                  
                    </div>
                </form>
               
            </div>

        </div>
<script type="text/javascript">
    $('#clear').on('click',function(){
       $("#Advertisment_form")[0].reset();
    })
</script>
@include('front.layout.footer')