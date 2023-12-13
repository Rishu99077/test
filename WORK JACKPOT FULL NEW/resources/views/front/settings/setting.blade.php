@include('front.layout.header')
@include('front.layout.sidebar')
<style type="text/css">
    input[type="checkbox"]:checked::before, input[type="checkbox"]:checked::after, input[type="checkbox"].dash_uncheck::after, input[type="checkbox"].dash_uncheck::before {
     opacity: 0; 
    transform: scale(1);
}
</style>
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
    <div class="d-flex top_bb mb_20 align-items-center justify-content-between">
        <h3 class="title w-100">{{$common['heading_title']}}</h3>
    </div>
    
    <form method="post" action="{{ url('update_settings') }}" autocomplete="off" enctype="multipart/form-data">

    <div class="edit_profile_row">
        
        
          <form class="other_profile_details w-100">
          @csrf 
            <div class="row edit_form">
                <div class="col-lg-3     col-md-6">
                    <label for="name">{{__("customer.text_notification")}} </label>
                    <div class="form-check form-switch">
                          <input class="form-check-input" type="checkbox" {{$user['notification_status'] =="On"?"checked":""}} role="switch" name="notification" value="On" id="notification">
                          <label class="form-check-label" for="notification">{{__("customer.text_on")}}/{{__("customer.text_off")}}</label>
                    </div>
                </div>


                <div class="col-lg-3 col-md-6">
                    <label for="name">{{__("customer.text_acc_privacy")}} </label>
                    <div class="form-check form-switch">
                          <input class="form-check-input" type="checkbox" name="account_privacy" {{$user['is_online'] =="online"?"checked":""}} role="switch" value="online" id="account_privacy">
                          <label class="form-check-label" for="account_privacy">{{__("customer.text_online_visible")}}</label>
                    </div>
                </div>


                <div class="col-lg-3 col-md-6">
                    <label for="name">{{__("customer.text_delete_acc")}}</label>
                    <div class="form-check form-switch form-check-inline">
                          <input class="form-check-input" type="checkbox" role="switch" {{$user['is_delete'] =="On"?"checked":""}} value="On" name="delete_account" id="delete_account">
                          <label class="form-check-label" for="delete_account">{{__("customer.text_delete")}}</label>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <label for="name">{{__("customer.text_account_pause")}} </label>
                    <div class="form-check form-switch">
                          <input class="form-check-input" type="checkbox" name="account_pause" {{$user['is_pause'] =="yes"?"checked":""}} role="switch" value="yes" id="account_pause">
                          <label class="form-check-label" for="account_pause">{{__("customer.text_on")}}/{{__("customer.text_off")}}</label>
                    </div>
                </div>
                


                
                <div class="row edit_text">
                  <div class="col-xl-8">
                     
                  </div>
                  <div class="col-xl-4 sp_frm_group">
                      <div class="row sm_inp jpost_dl">
                          
                      </div>

                      <div class="d-flex flex-wrap justify-content-between post_job_btns">
                          <div class="btn_half">
                            <button type="submit" class="site_btn">{{__("customer.text_update")}}</button>
                          </div>
                      </div>

                  </div>
                </div>

            </div>
            
        </form>
    </div>
</div>
@include('front.layout.footer')
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