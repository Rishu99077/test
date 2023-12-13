@include('admin.layout.sidebar')
@include('admin.layout.header')
<style type="text/css">
.the-count_comment{margin-top: -20px;}
</style>
<div class="main_right">

     <div class="top_announce d-flex align-items-center justify-content-between mb_20">
        <div class="top_ann_left">
        <a href="{{Route('testimonials')}}" class="site_btn f16 f_bold blue__btn post_ad_disabled">{{$common['heading_title']}}</a>
        </div>
    </div>

    <div class="presonal-wallines radioPanel wali_ka_form">
        <form method="post" action="{{url('admin/save_testimonials')}}" autocomplete="off" enctype="multipart/form-data">
         @csrf 
         <input type="hidden" name="Test_id" value="{{@$tests['id']}}">
         <div class="row">
               <?php foreach ($get_languages as $key => $language) { 
                  $language_id = $language['id']; ?>
               <div class="col-md-4">
                  <input type="hidden" name="language_id" value="{{$language['id']}}">
                  <label for="" class="full-name">{{__("admin.text_name")}} <span>({{$language['name']}})</span></label>
                  <input type="text"  required id="comment_<?php echo $key; ?>" class="form-control full-name-control" name="name[{{ $language['id'] }}]" value="{{@$get_test_description[$language_id]['name']}}" maxlength="20">

                  <div id="the-count_comment_<?php echo $key; ?>" class="the-count_comment" style="">
                    <span id="current_comment_<?php echo $key; ?>">0</span>
                    <span id="maximum_comment_<?php echo $key; ?>"> / 20</span>
                  </div>
               </div>
               <?php } ?>
               <hr>
               <?php foreach ($get_languages as $key => $language) { 
                  $language_id = $language['id']; ?>
               <div class="col-md-4">
                  <label for="" class="full-name">{{__("admin.text_designation")}} <span>({{$language['name']}})</span></label>
                  <input type="text"  required class="form-control full-name-control" name="designation[{{ $language['id'] }}]" value="{{@$get_test_description[$language_id]['designation']}}">
               </div>
               <?php } ?>
               <hr>
               <!-- Description -->
               <?php foreach ($get_languages as $key => $language) { 
                   $language_id = $language['id'];?>
               <div class="col-md-4 mb-4">
                     <label for="" class="full-name">{{__("admin.text_description")}} <span>({{$language['name']}})</span></label>
                     <textarea cols="40" rows="7" id="descri_<?php echo $key; ?>" placeholder="Enter your text" required min="1" max="50" name="description[{{ $language['id'] }}]" maxlength="50">{{ @$get_test_description[$language_id]['description'] }}</textarea>

                    <div id="the-count_descri_<?php echo $key; ?>" class="the-count_comment" style="">
                      <span id="current_descri_<?php echo $key; ?>">0</span>
                      <span id="maximum_descri_<?php echo $key; ?>"> / 50</span>
                    </div>
               </div>
               <?php } ?>
               
               <hr>
               <div class="col-md-4">
                  <div class="form-group">
                     <label for="" class="full-name">{{__("admin.text_user_image")}}</label>
                     <input type="file" class="form-control full-name-control" name="image" >
                     <span class="help-block"></span>
                  </div>
               </div>
               <?php if ($tests['image']!='') { 
               $Image = $tests['image']; ?>
               <div class="col-md-4">
                  <label for="" class="full-name">{{__("admin.text_upload_image")}}</label>
                     <img src="{{ url('/Images/Testimonials')}}/{{$Image}}" class="Uploaded_img">
               </div>
               <?php } ?>
               <div class="col-md-4">
                  <div class="form-group" id="Inputstatus">
                     <label for="" class="full-name">{{__("admin.text_status")}}</label>
                     <select class="form-control full-name-control" name="status" required>
                        <option value="1" <?php if (@$tests['status']==1) {echo 'selected=selected';} ?>>{{__("admin.text_active")}}</option>
                        <option value="0" <?php if (@$tests['status']==0) {echo 'selected=selected';} ?>>{{__("admin.text_inactive")}}</option>
                     </select>
                     <span class="help-block"></span>
                  </div>
               </div>
               <div class="offset-md-8 col-xl-4 sp_frm_group">
                  <div class="row sm_inp jpost_dl">
                      
                  </div>

                  <div class="d-flex flex-wrap justify-content-between post_job_btns">
                      <div class="btn_half"><input type="reset" value="Back" onclick="goBack()" class="site_btn act_btn"></div>
                      <div class="btn_half">
                        <button type="submit" class="site_btn">{{__("admin.text_save")}}</button>
                      </div>
                  </div>
               </div>    
         </div>
      </form>
   </div>
</div>
@include('admin.layout.footer')
<script type="text/javascript">
  <?php foreach ($get_languages as $key => $language) { ?>
  $('#comment_<?php echo $key; ?>').keyup(function () {
      var characterCount = $(this).val().length,
      current = $('#current_comment_<?php echo $key; ?>'),
      maximum = $('#maximum_comment_<?php echo $key; ?>'),
      theCount = $('#the-count_comment_<?php echo $key; ?>');
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


  $('#descri_<?php echo $key; ?>').keyup(function () {
      var characterCount = $(this).val().length,
      current = $('#current_descri_<?php echo $key; ?>'),
      maximum = $('#maximum_descri_<?php echo $key; ?>'),
      theCount = $('#the-count_descri_<?php echo $key; ?>');
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

 <?php } ?>
</script>