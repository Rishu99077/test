@include('front.layout.header')
@include('front.layout.sidebar')
<div class="main_right">

    <div class="top_announce d-flex align-items-center justify-content-between mb_20">
        <div class="top_ann_left">
         
          <a href="{{Route('job_add')}}" class="site_btn f16 f_bold blue__btn post_ad_disabled">{{__("customer.text_add_new_job")}}</a>
        </div>
    </div>

    <div class="presonal-wallines radioPanel wali_ka_form">
      <form method="post" action="{{ url('save_job') }}">
         @csrf 
         <input type="hidden" name="Job_id" value="{{$get_jobs['id']}}">
         <div class="row">
            <div class="col-lg-4 col-sm-6">
               <div class="form-group">
                  <label for="" class="full-name">{{__("customer.text_job_types")}}</label>
                  <!-- <input type="number" name="job_type_id" class="form-control full-name-control"> -->
                  <select class="form-control full-name-control" name="job_type_id">
                     <option value="">-- {{__("customer.text_select")}} {{__("customer.text_job_types")}} --</option>
                     <?php foreach ($get_job_type_desc as $type_key => $val_con) { ?>
                     <option value="<?php echo $val_con['job_type_id']; ?>" <?php if ($get_jobs['job_type_id'] == $val_con['job_type_id'] ) echo 'selected' ; ?>><?php echo $val_con['title']; ?></option>
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
                  <label for="" class="full-name">{{__("customer.text_job_title")}}</label>
                  <input type="text" id="comment" class="form-control full-name-control" name="title" value="{{old('title',$get_jobs['title'])}}" placeholder='{{__("customer.text_enter")}} {{__("customer.text_job_title")}}'>

                  <!-- <div id="the-count_comment" style="">
                    <span id="current_comment">0</span>
                    <span id="maximum_comment"> / 20</span>
                  </div> -->

                  <span class="text-danger"> 
                  <?php if ($errors->has('title')) { ?> {{
                  $errors->first('title') }}
                  <?php } ?>
                  </span>
               </div>
            </div>
            <div class="col-lg-4 col-sm-6">
               <div class="form-group">
                  <label for="" class="full-name">{{__("customer.text_hours_salary")}}</label>
                  <input type="text" class="form-control full-name-control" name="salary" value="{{old('salary',$get_jobs['salary'])}}" placeholder='{{__("customer.text_enter")}} {{__("customer.text_hours_salary")}}'>
                  <span class="text-danger"> 
                  <?php if ($errors->has('salary')) { ?> {{
                  $errors->first('salary') }}
                  <?php } ?>
                  </span>
               </div>
            </div>
         
            <div class="col-lg-4 col-sm-6">
               <div class="form-group">
                  <label for="" class="full-name">{{__("customer.text_profession_name")}}</label>
                  <input type="text" class="form-control full-name-control" name="profession_name" value="{{old('profession_name',$get_jobs['profession_name'])}}" placeholder='{{__("customer.text_enter")}} {{__("customer.text_profession_name")}}'>
                  <span class="text-danger"> 
                  <?php if ($errors->has('profession_name')) { ?> {{
                     $errors->first('profession_name') }}
                  <?php } ?>
                  </span>
               </div>
            </div>
            <div class="col-lg-4 col-sm-6">
               <div class="form-group">
                  <label for="" class="full-name">{{__("customer.text_experience")}}</label>
                  <input type="text" class="form-control full-name-control" name="experience" value="{{old('experience',$get_jobs['experience'])}}" placeholder='{{__("customer.text_enter")}} {{__("customer.text_experience")}}'>
                  <span class="text-danger"> 
                  <?php if ($errors->has('experience')) { ?> {{
                     $errors->first('experience') }}
                  <?php } ?>
                  </span>
               </div>
            </div>
            <div class="col-lg-4 col-sm-6">
               <div class="form-group">
                  <label for="" class="full-name">{{__("customer.text_working_hours")}}</label>
                  <input type="number" class="form-control full-name-control" name="working_hours" value="{{old('working_hours',$get_jobs['working_hours'])}}" placeholder='{{__("customer.text_enter")}} {{__("customer.text_working_hours")}}'>
                  <span class="text-danger"> 
                  <?php if ($errors->has('working_hours')) { ?> {{
                     $errors->first('working_hours') }}
                  <?php } ?>
                  </span>
               </div>
            </div>
         
            <div class="col-lg-4 col-sm-6">
               <div class="form-group">
                  <label for="" class="full-name">{{__("customer.text_work_location")}}</label>
                  <input type="text" class="form-control full-name-control" id="comment_location" name="work_location" value="{{old('work_location',$get_jobs['work_location'])}}" placeholder='{{__("customer.text_enter")}} {{__("customer.text_work_location")}}' maxlength="32">

                  <div id="the-count_comment" style="">
                    <span id="current_comment_loc">0</span>
                    <span id="maximum_comment_loc"> / 32</span>
                  </div>

                  <span class="text-danger"> 
                  <?php if ($errors->has('work_location')) { ?> {{
                     $errors->first('work_location') }}
                  <?php } ?>
                  </span>
               </div>
            </div>
            <div class="col-lg-4 col-md-6" style="display: none;">
                <div class="form-group">
                 <label for="" class="full-name">{{__("customer.text_status")}}</label>
                 <select  name="status" required class="form-control full-name-control">
                    <option value="Published" <?php if (@$get_jobs['status']=='Published') {echo 'selected=selected';} ?>>{{__("customer.text_published")}}</option>
                    <option value="Disabled" <?php if (@$get_jobs['status']=='Disabled') {echo 'selected=selected';} ?>>{{__("customer.text_disabled")}}</option>
                 </select>
                </div>
            </div>

            <div class="col-lg-4 col-sm-6">
                <label for="st_date" class="full-name">{{__("customer.text_start_date")}}</label>
                <div class="form-group">
                  <input type="date" class="form-control full-name-control" name="start_date" value="{{old('start_date',$get_jobs['start_date'])}}" min="<?php echo date('Y-m-d'); ?>" onkeydown="return false">
                  <span class="text-danger"> 
                  <?php if ($errors->has('start_date')) { ?> {{
                     $errors->first('start_date') }}
                  <?php } ?>
                  </span>
                </div>
                <!-- <div class="row sm_inp">
                    <div class="col">
                        <div class="form-group">
                            <input type="number" id="st_date" name="day" value="{{old('day',$get_jobs['day'])}}" class="form-control full-name-control" placeholder='{{__("customer.text_day")}}' min="1" max="30">
                            <span class="text-danger"> 
                            <?php if ($errors->has('day')) { ?> {{
                               $errors->first('day') }}
                            <?php } ?>
                            </span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <input type="number" class="form-control full-name-control" value="{{old('month',$get_jobs['month'])}}" name="month"  placeholder='{{__("customer.text_month")}}' min="1" max="12">
                            <span class="text-danger"> 
                            <?php if ($errors->has('month')) { ?> {{
                               $errors->first('month') }}
                            <?php } ?>
                            </span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <input type="number" class="form-control full-name-control" value="{{old('year',$get_jobs['year'])}}" name="year" min="<?php echo date('Y'); ?>"  placeholder='{{__("customer.text_years")}}'>
                            <span class="text-danger"> 
                            <?php if ($errors->has('year')) { ?> {{
                               $errors->first('year') }}
                            <?php } ?>
                            </span>
                        </div>
                    </div>
                </div> -->
            </div>

            <div class="col-lg-4 col-sm-6">
                <div class="form_row">
                    <label for="req" class="full-name">{{__("customer.text_requirements")}}</label>

                <?php if ($job_requirements!='') { ?>
                    <?php foreach ($job_requirements as $key => $value) { ?>
                      <div class="all_available_input">
                          <div class="single_input">
                              <input type="text" class="form-control full-name-control mb_12" name="requirements[]" id="req" value="{{$value['requirements']}}" >
                          </div>
                      </div>
                    <?php } ?>
                <?php } ?>
                    <div class="all_available_input">
                        <div class="single_input">
                            <input type="text" class="form-control full-name-control mb_12" name="requirements[]" id="req" placeholder='{{__("customer.text_enter")}} {{__("customer.text_requirements")}}' >
                        </div>
                    </div>
                    <div class="single_input for_clone_element mb_12">
                        <input type="text" name="requirements[]" id="req" placeholder='{{__("customer.text_enter")}} {{__("customer.text_requirements")}}' class="form-control full-name-control mb_12">
                        <div class="remove_btn text-end"><a href="javascript:void(0)" class="f12 f_bold remove_input">{{__("customer.text_remove")}}(-)</a></div>
                    </div>
                    <div class="add_more_btn text-end"><a href="javascript:void(0)" class="f12 f_bold add_more_input">{{__("customer.text_add_more")}}(+)</a></div>
                

                </div>
            </div>
              

            <div class="row">
              <div class="col-xl-8">
                  <div class="form-group">
                      <label for="" class="full-name">{{__("customer.text_offer_desc")}}</label>
                      <textarea name="description" cols="30" rows="10" placeholder='{{__("customer.text_enter")}} {{__("customer.text_offer_desc")}}'>{{old('description',$get_jobs['description'])}}</textarea>
                      <span class="text-danger"> 
                        <?php if ($errors->has('description')) { ?> {{
                          $errors->first('description') }}
                        <?php } ?>
                      </span>
                  </div>
              </div>
              <div class="col-xl-4 sp_frm_group">
                  <div class="row sm_inp jpost_dl">
                      <div class="col-xxl-6 col-xl-12 col-sm-6">
                          <label for="dlicense" class="full-name d-inline-block w-auto">{{__("customer.text_driving_license")}}</label>
                          <input type="hidden" name="driving_license" value="0">
                          <input type="checkbox" name="driving_license" value='1'
                          <?php if($get_jobs['driving_license']=='1'){echo 'checked';} ?>>
                      </div>
                      <div class="col-xxl-6 col-xl-12 col-sm-6">
                          <label for="own_car" class="full-name d-inline-block w-auto">{{__("customer.text_own_car")}}</label>
                          <input type="hidden" name="own_car" value="0">
                          <input type="checkbox" name="own_car" value='1' <?php if($get_jobs['own_car']=='1'){echo 'checked';} ?>>
                      </div>
                  </div>

                  <div class="d-flex flex-wrap justify-content-between post_job_btns">
                           
                      <div class="btn_half"><input type="reset" value='{{__("customer.text_back")}}' class="site_btn act_btn" onclick="goBack()"></div>
                      <div class="btn_half">
                        @if($get_jobs['id']=='')
                        <button type="submit" class="site_btn">{{__("customer.text_save")}}</button>
                        @else
                        <button type="submit" class="site_btn">{{__("customer.text_update")}}</button>
                        @endif
                      </div>
                  </div>

              </div>   
            </div>
         </div>
      </form>
   </div>
</div>
@include('front.layout.footer')
<script>
$('#comment').keyup(function () {
  var characterCount = $(this).val().length,
  current = $('#current_comment'),
  maximum = $('#maximum_comment'),
  theCount = $('#the-count_comment');
  var maxlength = $(this).attr('maxlength');
  var changeColor = 0.75 * maxlength;
  current.text(characterCount);

  if (characterCount > changeColor && characterCount < maxlength) {
    current.css('color', '#FF4500');
    current.css('fontWeight', 'bold');
  }
  else if (characterCount >= maxlength) {
    current.css('color', '#B22222');
    current.css('fontWeight', 'bold');
  }
  else {
    var col = maximum.css('color');
    var fontW = maximum.css('fontWeight');
    current.css('color', col);
    current.css('fontWeight', fontW);
  }
});


$('#comment_location').keyup(function () {
  var characterCount = $(this).val().length,
  current = $('#current_comment_loc'),
  maximum = $('#maximum_comment_loc'),
  theCount = $('#the-count_comment');
  var maxlength = $(this).attr('maxlength');
  var changeColor = 0.75 * maxlength;
  current.text(characterCount);

  if (characterCount > changeColor && characterCount < maxlength) {
    current.css('color', '#FF4500');
    current.css('fontWeight', 'bold');
  }
  else if (characterCount >= maxlength) {
    current.css('color', '#B22222');
    current.css('fontWeight', 'bold');
  }
  else {
    var col = maximum.css('color');
    var fontW = maximum.css('fontWeight');
    current.css('color', col);
    current.css('fontWeight', fontW);
  }
});
</script>