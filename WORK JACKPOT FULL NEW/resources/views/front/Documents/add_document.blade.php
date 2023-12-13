@include('front.layout.header')
@include('front.layout.sidebar')
<div class="main_right">

    <div class="top_announce d-flex align-items-center justify-content-between mb_20">
        <div class="top_ann_left">
            @if($user['role']=='seeker')
              <a href="{{Route('add_advertisment')}}" class="site_btn f16 f_bold blue__btn">{{__("customer.text_post_job_search")}}</a>
            @elseif($user['role']=='provider')
                <a href="{{Route('job_add')}}" class="site_btn f16 f_bold blue__btn">{{__("customer.text_add_new_job")}}</a>
            @endif
        </div>
        <div class="top_ann_right d-flex align-items-center ">
            <form action="" class="topan_search w-100 justify-content-xl-end">
                <input type="text" name="" id="" placeholder='{{__("customer.text_search_for_everything")}}'>
                <input type="submit" value="">
            </form>
        </div>
    </div>
    <div class="row top_bb mb_20 align-items-center justify-content-between">
        <h3 class="title col-xl-4 recom_title">{{__("customer.text_send_other_doc")}}</h3>
    </div>
    <div class="presonal-wallines radioPanel wali_ka_form">
      <form method="post" action="{{ Route('send_documents') }}" enctype="multipart/form-data">
         @csrf 
         <input type="hidden" name="Report_id" value="">
         <div class="row">
             <div class="col-lg-4 col-sm-6">
               <div class="form-group">
                  <label for="" class="full-name">{{__("customer.text_contracts")}}</label>
                  <select class="form-control full-name-control" name="contract">
                     <option value="">-- {{__("customer.text_select")}} --</option>
                     <?php foreach ($ContractsModel as $key => $value) { ?>
                     <option value="<?php echo $value['id']; ?>" {{old('contract') == $value['id'] ? "selected":""}} ><?php echo $value['title'];?></option>
                     <?php } ?>
                  </select>
                  <span class="text-danger"> 
                  <?php if ($errors->has('contract')) { ?> {{
                     $errors->first('contract') }}
                  <?php } ?>
                  </span>
               </div>
             </div>
            
            @if($user['role']=='seeker')
            <div class="col-lg-4 col-sm-6">
               <div class="form-group">
                  <label for="" class="full-name">{{__("customer.text_send_to")}}</label>  
                    <select class="form-control full-name-control" name="send_to">
                        <option value="1">{{__("customer.text_admin")}}</option>
                        <!-- <option value="2">{{__("customer.text_provider")}}</option> -->
                    </select>
                    <span class="text-danger"> 
                  <?php if ($errors->has('send_to')) { ?> {{
                     $errors->first('send_to') }}
                  <?php } ?>
                  </span>
               </div>
            </div>
            @elseif($user['role']=='provider')
            <div class="col-lg-4 col-sm-6">
               <div class="form-group">
                  <label for="" class="full-name">{{__("customer.text_send_to")}}</label>  
                    <select class="form-control full-name-control" name="send_to">
                        <option value="1">{{__("customer.text_admin")}}</option>
                    </select>
                    <span class="text-danger"> 
                  <?php if ($errors->has('send_to')) { ?> {{
                     $errors->first('send_to') }}
                  <?php } ?>
                  </span>
               </div>
            </div>
            @endif
            <div class="col-lg-4 col-sm-6">
               <div class="form-group">
                  <label for="" class="full-name">{{__("customer.text_title")}}</label>
                  <input type="text" class="form-control full-name-control" name="title" value="{{old('title')}}" placeholder='{{__("customer.text_enter")}} {{__("customer.text_title")}}'>
                  <span class="text-danger"> 
                  <?php if ($errors->has('title')) { ?> {{
                  $errors->first('title') }}
                  <?php } ?>
                  </span>
               </div>
            </div>
         
    
            <div class="col-lg-4 col-sm-6" style="display: none;">
               <div class="form-group">
                  <label for="" class="full-name">{{__("customer.text_date")}}</label>
                  <input type="date" class="form-control full-name-control" name="date" value="<?php echo date('Y-m-d'); ?>" placeholder='{{__("customer.text_enter")}}  {{__("customer.text_date")}}'>
                  <span class="text-danger"> 
                  <?php if ($errors->has('date')) { ?> {{
                     $errors->first('date') }}
                  <?php } ?>
                  </span>
               </div>
            </div>

            <div class="col-lg-4 col-sm-6">
               <div class="form-group">
                  <label for="file" class="full-name">{{__("customer.text_documents")}} </label>
                  <input type="file" name="document" class="form-control full-name-control">
                  <span class="text-danger"> 
                  <?php if ($errors->has('document')) { ?> {{
                     $errors->first('document') }}
                  <?php } ?>
                  </span>
               </div>
            </div>
           
            <div class="row">
              <div class="col-xl-8">
                  
              </div>
              <div class="col-xl-4 sp_frm_group">
                  <div class="row sm_inp jpost_dl">
                  </div>
                  <div class="d-flex flex-wrap justify-content-between post_job_btns">
                      <div class="btn_half"><input type="reset" value='{{__("customer.text_back")}}' class="site_btn act_btn" onclick="goBack()"></div>
                      <div class="btn_half">
                        <button type="submit" class="site_btn">{{__("customer.text_send")}}</button>
                      </div>
                  </div>
              </div>   
            </div>
         </div>
      </form>
   </div>
</div>
@include('front.layout.footer')