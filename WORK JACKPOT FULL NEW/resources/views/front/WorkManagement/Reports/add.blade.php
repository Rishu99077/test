@include('front.layout.header')
@include('front.layout.sidebar')
<style type="text/css">
.upload_file_ui{background: #EBF5FC 0% 0% no-repeat padding-box;border: 2px dashed #228EE3;border-radius: 12px;height: 250px;}
.upload_file_ui .report_img{margin-top: 50px;padding: 0px;}
.report_img p{color: #19286B;font-weight: bolder;}
</style>
<div class="main_right">

    <div class="top_announce d-flex align-items-center justify-content-between mb_20">
        <div class="top_ann_left">
            <a href="{{Route('add_advertisment')}}" class="site_btn f16 f_bold blue__btn">{{__("customer.text_post_job_search")}}</a>
        </div>
        <div class="top_ann_right d-flex align-items-center ">
            <form action="" class="topan_search w-100 justify-content-xl-end">
                <input type="text" name="" id="" placeholder='{{__("customer.text_search_for_everything")}}'>
                <input type="submit" value="">
            </form>
        </div>
    </div>
    <div class="row top_bb mb_20 align-items-center justify-content-between">
        <h3 class="title col-xl-4 recom_title">{{__("customer.text_add_report")}}</h3>
    </div>
    <div class="presonal-wallines radioPanel wali_ka_form">
      <form method="post" action="{{ Route('report_save') }}" enctype="multipart/form-data">
         @csrf 
         <input type="hidden" name="Report_id" value="{{$get_works['id']}}">
         <div class="row">
            <div class="col-lg-4 col-sm-6">
               <div class="form-group">
                  <label for="" class="full-name">{{__("customer.text_contracts")}}</label>
                  <select class="form-control full-name-control" name="contract">
                     <option value="">--  {{__("customer.text_select")}}  {{__("customer.text_job")}} --</option>
                     <?php foreach ($get_jobs as $key => $value) { ?>
                     <option value="<?php echo $value['id']; ?>" <?php if ($get_works['contract'] == $value['id'] ) echo 'selected' ; ?>><?php echo $value['contract_title']; ?></option>
                     <?php } ?>
                  </select>
                  <span class="text-danger"> 
                  <?php if ($errors->has('contract')) { ?> {{
                     $errors->first('contract') }}
                  <?php } ?>
                  </span>
               </div>
            </div>
            <div class="col-lg-4 col-sm-6">
               <div class="form-group">
                  <label for="" class="full-name">{{__("customer.text_working_hours")}}</label>
                  <input type="number" class="form-control full-name-control" name="working_hours" value="{{old('working_hours',$get_works['working_hours'])}}" placeholder='{{__("customer.text_enter")}} {{__("customer.text_working_hours")}}'>
                  <span class="text-danger"> 
                  <?php if ($errors->has('working_hours')) { ?> {{
                  $errors->first('working_hours') }}
                  <?php } ?>
                  </span>
               </div>
            </div>
            <div class="col-lg-4 col-sm-6">
               <div class="form-group">
                  <label for="" class="full-name">{{__("customer.text_working_amount")}}</label>
                  <input type="number" class="form-control full-name-control" name="working_amount" value="{{old('working_amount',$get_works['working_amount'])}}" placeholder='{{__("customer.text_enter")}} {{__("customer.text_working_amount")}}'>
                  <span class="text-danger"> 
                  <?php if ($errors->has('working_amount')) { ?> {{
                  $errors->first('working_amount') }}
                  <?php } ?>
                  </span>
               </div>
            </div>
    
            <div class="col-lg-4 col-sm-6">
               <div class="form-group">
                  <label for="" class="full-name">{{__("customer.text_start_date")}}</label>
                  <input type="date" class="form-control full-name-control" name="start_date" value="{{old('start_date',$get_works['start_date'])}}" placeholder='{{__("customer.text_enter")}} {{__("customer.text_start_date")}}'>
                  <span class="text-danger"> 
                  <?php if ($errors->has('start_date')) { ?> {{
                     $errors->first('start_date') }}
                  <?php } ?>
                  </span>
               </div>
            </div>
            <div class="col-lg-4 col-sm-6">
               <div class="form-group">
                  <label for="" class="full-name">{{__("customer.text_end_date")}}</label>
                  <input type="date" class="form-control full-name-control" name="end_date" value="{{old('end_date',$get_works['end_date'])}}" placeholder='{{__("customer.text_enter")}} {{__("customer.text_end_date")}}'>
                  <span class="text-danger"> 
                  <?php if ($errors->has('end_date')) { ?> {{
                     $errors->first('end_date') }}
                  <?php } ?>
                  </span>
               </div>
            </div>
            <div class="row">
              <div class="col-xl-8 upload_file_ui">
                  <div class="text-center report_img">
                    <input type="file" id="document" name="document" style="display: none;">
                    <label for="document">
                      <img src="{{ asset('assets/images/upload_report_2.png') }}">
                    </label>
                    <p>{{__("customer.text_upload_report")}}</p>
                    <p class="text-secondary">{{__("customer.text_file_format")}}</p>
                  </div>
                  <span class="text-danger"> 
                  <?php if ($errors->has('document')) { ?> {{
                     $errors->first('document') }}
                  <?php } ?>
                  </span>
              </div>


              <div class="col-xl-4 sp_frm_group">
                  <div class="row sm_inp jpost_dl">
                      
                  </div>

                  <div class="d-flex flex-wrap justify-content-between post_job_btns">
                           
                      <div class="btn_half"><input type="reset" value='{{__("customer.text_back")}}' class="site_btn act_btn" onclick="goBack()"></div>
                      <div class="btn_half">
                        @if($get_works['id']=='')
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