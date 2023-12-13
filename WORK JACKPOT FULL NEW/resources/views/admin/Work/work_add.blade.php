@include('admin.layout.header')
@include('admin.layout.sidebar')
<?php
   $Title = @$_GET['title'];
?>
<div class="main_right">

    <div class="top_announce d-flex align-items-center justify-content-between mb_20">
        <div class="top_ann_left">
          <a href="{{Route('work_seeker_add')}}" class="site_btn f16 f_bold blue__btn post_ad_disabled">{{$common['heading_title']}}</a>
        </div>
    </div>

    <div class="presonal-wallines radioPanel wali_ka_form">
      <form method="post"  action="{{url('admin/save_work_seeker')}}" enctype="multipart/form-data">
         @csrf 
         <input type="hidden" name="Work_id" value="{{$works['id']}}">
         <div class="row">
            <?php foreach ($get_languages as $key => $language) { 
               $language_id = $language['id']; ?>
            <div class="col-lg-4 col-md-6">
               <input type="hidden" name="language_id" value="{{$language['id']}}">
               <div class="form-group">
                  <label for="" class="full-name">Title <span>({{$language['name']}})</span></label>
                  <input type="text"  required name="title[{{ $language['id'] }}]" value="{{@$get_work_description[$language_id]['title']}}" class="form-control full-name-control">
               </div>
            </div>
            <?php } ?>
            <hr>
            <?php foreach ($get_languages as $key => $language) { 
               $language_id = $language['id']; ?>
            <div class="col-lg-4 col-md-6 mb-4">
               <label for="" class="full-name">Description <span>({{$language['name']}})</span></label>
               <textarea cols="40" rows="7"  id="editor_{{$key}}" required name="description[{{ $language['id'] }}]">{{ @$get_work_description[$language_id]['description'] }} </textarea>
            </div>
            <script>
               ClassicEditor
               .create( document.querySelector( '#editor_<?php echo $key; ?>') )
               .then( editor => {
                       console.log( editor );
               } )
               .catch( error => {
                       console.error( error );
               } );
            </script>
            <?php } ?>
         
            <hr>
            <div class="col-lg-4 col-md-6">
               <div class="form-group">
                  <label for="" class="full-name">Status</label>
                  <select  class="form-control full-name-control" name="status" required>
                     <option value="1" <?php if ($works['status']==1) {echo 'selected=selected';} ?>>Active</option>
                     <option value="0" <?php if ($works['status']==0) {echo 'selected=selected';} ?>>Inactive</option>
                  </select>
               </div>
            </div>
            <div class="col-lg-4 col-md-6">
               <div class="form-group">
                  <label for="" class="full-name">Image</label>
                  <input type="file" class="form-control full-name-control" name="image" >
               </div>
            </div>
            <div class="col-lg-4 col-md-6">
               <?php if ($works['image']!='') { 
                  $Image = $works['image']; ?>
               <img src="{{ url('/Images/Howitwork')}}/{{$Image}}" class="Uploaded_img">
               <?php } ?>
            </div>


            <div class="col-lg-4 col-md-6">
               <div class="form-group">
                  <label for="" class="full-name">Logo</label>
                  <input type="file" class="form-control full-name-control" name="logo" >
               </div>
            </div>
            <div class="col-lg-4 col-md-6">
               <?php if ($works['logo']!='') { 
                  $Logo = $works['logo']; ?>
               <img src="{{ url('/Images/Howitwork')}}/{{$Logo}}" class="Uploaded_img">
               <?php } ?>
            </div>


            <?php if ($Title=='provider') { ?>
            <input type="hidden" name="role" value="provider">
            <?php }else{ ?>
            <input type="hidden" name="role" value="seeker">
            <?php } ?>

            <div class="offset-md-8 col-xl-4 sp_frm_group">
                  <div class="row sm_inp jpost_dl">
                      
                  </div>

                  <div class="d-flex flex-wrap justify-content-between post_job_btns">
                      <div class="btn_half"><input type="reset" value="Back" onclick="goBack()" class="site_btn act_btn"></div>
                      <div class="btn_half">
                        <button type="submit" class="site_btn">UPDATE</button>
                      </div>
                  </div>

            </div> 
         </div>
      </form>
   </div>

</div>
@include('admin.layout.footer')