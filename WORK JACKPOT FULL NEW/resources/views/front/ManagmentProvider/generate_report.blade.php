@include('front.layout.header')
@include('front.layout.sidebar')
<style type="text/css">
  .table-responsive tr th:last-child{text-align: end;}
  .table-responsive tbody tr td:last-child{text-align: end;}
</style>
<div class="main_right">
<div class="top_announce d-flex align-items-center justify-content-between mb_20">
   <div class="top_ann_left">
      <a href="{{Route('job_add')}}" class="site_btn f16 f_bold blue__btn">{{__("customer.text_add_new_job")}}</a>
   </div>
   <div class="top_ann_right d-flex align-items-center ">
      <form action="" class="topan_search w-100 justify-content-xl-end">
         <input type="text" name="" id="" placeholder='{{__("customer.text_search_for_everything")}}'>
         <input type="submit" value="">
      </form>
   </div>
</div>

<div class="row top_bb mb_20 align-items-center justify-content-between">
   <h3 class="title col-md-4 mb-md-0 mb_20">{{__("customer.text_salaries")}}</h3>
</div>

<div class="job_card_wrapper sjob_det mb_30">
   <div class="job_card job_details_sec mb_20">
      <div class="jcard_top px-0 d-flex align-items-center justify-content-between">
         <div class="jc_left d-flex align-items-center justify-content-between">
            <div class="jc_left_l">
               <span><img src="{{ asset('assets/images/bpro.png') }}" alt=""></span>
            </div>
            <div class="jc_left_r">
               <p class="mb0 f16 clr_prpl f_black">{{$reports['seeker_name']}}</p>
               <p class="clr_grey f12 mb0 f_bold">{{__("customer.text_contract_no")}} {{$reports['job_id']}} <!-- <span class="clr_ylw"> {{$reports['seeker_name']}}</span> --></p>
            </div>
         </div>
      </div>
      
      <div class="row">
         <div class="col-md-8">
            <table class="table table-responsive">
               <thead class="table-pay">
               <tr>
                  <th>{{__("customer.text_contracts")}}</th>
                  <th>{{__("customer.text_total_hours")}}</th>
               </tr>
              </thead>
              <tbody>
                 <tr>
                    <td>{{$reports['job_title']}}</td>
                    <td>{{$reports['working_hours']}} {{__("customer.text_hours")}}</td>
                 </tr>
              </tbody>
            </table>

            <table class="table table-responsive">
               <thead class="table-pay">
               <tr>
                  <th>{{__("customer.text_start_date")}}</th>
                  <th>{{__("customer.text_end_date")}}</th>
               </tr>
              </thead>
              <tbody>
                 <tr>
                    <td>{{$reports['start_date']}}</td>
                    <td>{{$reports['end_date']}}</td>
                 </tr>
              </tbody>
            </table>

            <table class="table table-responsive">
               <thead class="table-pay">
               <tr>
                  <th>{{__("customer.text_working_amount_bru")}} (Euro)</th>
                  <th>{{__("customer.text_max_install")}} </th>
               </tr>
              </thead>
              <tbody>
                 <tr>
                    <td>{{$reports['total_amount']}}</td>
                    <td>{{$reports['total_inst']}}</td>
                 </tr>
              </tbody>
            </table>
         </div>
         <div class="col-md-4">
            <div class="col-xl-8 upload_file_ui">
                  <div class="text-center report_img_2">
                    <a href="{{url('/Images/WorkDocuments',$reports['document'])}}"  download onClick="return confirm('{{__('customer.text_sure_to_download')}}');">
                      <label for="document">
                        <img src="{{url('/Images/WorkDocuments',$reports['document'])}}">
                      </label>
                    </a>
                  </div>
                  <span class="text-danger"> 
                  <?php if ($errors->has('document')) { ?> {{
                     $errors->first('document') }}
                  <?php } ?>
                  </span>
              </div>
         </div>
      </div>
      
      <div class="row mt-4">
         <div class="col-md-4 text-left">
           <div class="text-left"><a href="#" class="bk_btn" onclick="goBack()"><img src="{{ asset('assets/images/back.png') }}" alt="">{{__("customer.text_back")}}</a></div> 
           <!-- <button class="btn btn-back">Back</button>  -->
         </div>
         <div class="col-md-4 text-center">
           <button class="btn btn-reject" id="send_pending" data-id="{{$reports['report_id']}}" data-status="reject">{{__("customer.text_reject")}}</button> 
           <button class="btn btn-invoice" id="send_pending" data-id="{{$reports['report_id']}}" data-status="generate">{{__("customer.text_invoice_generate")}}</button> 
         </div>
         <div class="col-md-4 text-end">
           <a href="{{url('/Images/WorkDocuments',$reports['document'])}}"  download onClick="return confirm('{{__('customer.text_sure_to_download')}}');">
            <button class="btn btn-download">{{__("customer.text_download")}}</button> 
          </a>
         </div>
      </div>

   </div>
</div>


<script type="text/javascript">
    $('body').on("click",'#send_pending', function(){
     
        job=confirm('{{__("customer.text_sure")}}');
        if(job!=true){
          return false;
        }


        var Report_ID = $(this).attr('data-id');
        var Datastatus = $(this).attr('data-status');

        // alert('Report_ID'+Report_ID);
        // alert('Datastatus'+Datastatus);
        // return false;
        
        _token = $("input[name='_token']").val();

        $.ajax({
            url:"{{ url('change_report_status') }}",
            type: 'post',
            data: {'Report_ID': Report_ID,"_token": "{{ csrf_token() }}",'Datastatus':Datastatus},
            success: function(response) {  
             window.location.href = "{{Route('provider.salaries')}}";
            }
        });
  
    });
</script>
@include('front.layout.footer')