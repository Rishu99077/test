@include('admin.layout.header')
@include('admin.layout.sidebar')
<div class="main_right">

    <div class="top_announce d-flex align-items-center justify-content-between mb_20">
        <div class="top_ann_left">
          <a href="{{Route('customers_add')}}" class="site_btn f16 f_bold blue__btn post_ad_disabled">{{$common['heading_title']}}</a>
        </div>
    </div>

    <div class="presonal-wallines radioPanel wali_ka_form">
        <form method="post" action="{{url('admin/save_faqs')}}">
         @csrf 
            <input type="hidden" name="Faq_id" value="{{@$faqs['id']}}">
            <div class="row">
                  <?php foreach ($get_languages as $key => $language) { 
                     $language_id = $language['id']; ?>
                    <div class="col-lg-4 col-md-6">
                      <div class="form-group">
                        <input type="hidden" name="language_id" value="{{$language['id']}}">
                        <label for="" class="full-name">{{__("admin.text_title")}} <span>({{$language['name']}})</span></label>
                        <input type="text" required class="form-control full-name-control" name="title[{{ $language['id'] }}]" value="{{@$get_faq_description[$language_id]['title']}}">
                      </div>  
                    </div>
                  <?php } ?>
                  <hr>
                  <?php foreach ($get_languages as $key => $language) { 
                     $language_id = $language['id'];?>
                    <div class="col-lg-4 col-md-6 mb-3">
                      <div class="form-group">
                        <label for="" class="full-name">{{__("admin.text_description")}} <span>({{$language['name']}})</span></label>
                        <textarea cols="40" rows="7" placeholder="Enter your text" required name="description[{{ $language['id'] }}]">{{ @$get_faq_description[$language_id]['description'] }}</textarea>
                      </div>  
                    </div>
                  <?php } ?>
                  <hr>
                  <div class="col-lg-4 col-md-6">
                      <div class="form-group">
                       <label for="" class="full-name">{{__("admin.text_status")}}</label>
                       <select  name="status" required class="form-control full-name-control">
                          <option value="1" <?php if (@$faqs['status']==1) {echo 'selected=selected';} ?>>{{__("admin.text_active")}}</option>
                          <option value="0" <?php if (@$faqs['status']==0) {echo 'selected=selected';} ?>>{{__("admin.text_inactive")}}</option>
                       </select>
                      </div>
                  </div>
                  
                  <div class="offset-md-8 col-xl-4 sp_frm_group">
                        <div class="row sm_inp jpost_dl">
                            
                        </div>

                        <div class="d-flex flex-wrap justify-content-between post_job_btns">
                            <div class="btn_half"><input type="reset" value="Back" class="site_btn act_btn" onclick="goBack()"></div>
                            <div class="btn_half">
                              @if(empty($faqs))
                              <button type="submit" class="site_btn">{{__("admin.text_save")}}</button>
                              @else
                              <button type="submit" class="site_btn">{{__("admin.text_update")}}</button>
                              @endif
                            </div>
                        </div>

                  </div>  
            </div>
        </form>
    </div>
</div>
@include('admin.layout.footer')