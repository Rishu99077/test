@include('front.layout.header')
@include('front.layout.sidebar')
<?php 
   $tab         ="";
   $chat_tab    = "";
   $contact_tab = "";
   if(@$_GET['tab']){
     $tab    = $_GET['tab'];
     if($tab == 'chat_tab');{
       $chat_tab = "show active";
     }
   }else{
       $contact_tab = "show active";
   }
   
   ?>
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
      <h3 class="title col-md-6 mb-md-0 mb_20">{{$common['heading_title']}}</h3>
   </div>
   <div class="contact_tabs">
      <ul class="nav nav-tabs" id="myTab" role="tablist">
         <li class="nav-item " role="presentation">
            <a class="nav-link {{$contact_tab}}" id="contact-form-tab" data-bs-toggle="tab" href="#contact-form" role="tab" aria-controls="contact-form" aria-selected="true">
            <span class="tab_icon_a"><img src="{{ asset('assets/images/contact-form.png') }}" alt="" srcset=""></span>
            <span class="tab_title_txt">{{__("customer.text_contact_form")}}</span>
            </a>
         </li>
         <li class="nav-item" role="presentation">
            <a class="nav-link {{$chat_tab}}" id="chat-tab" data-bs-toggle="tab" href="#chat" role="tab" aria-controls="chat" aria-selected="false">
            <span class="tab_icon_a"><img src="{{ asset('assets/images/chat-icon.png') }}" alt="" srcset=""></span>
            <span class="tab_title_txt">{{__("customer.text_chat")}}</span>
            </a>
         </li>
         <li class="nav-item" role="presentation">
            <a class="nav-link" id="send-email-tab" data-bs-toggle="tab" href="#send-email" role="tab" aria-controls="send-email" aria-selected="false">
            <span class="tab_icon_a"><img src="{{ asset('assets/images/send-email.png') }}" alt="" srcset=""></span>
            <span class="tab_title_txt">{{__("customer.text_send_email")}}</span>
            </a>
         </li>
      </ul>
      <div class="tab-content" id="myTabContent">
         <div class="tab-pane fade {{$contact_tab }} " id="contact-form" role="tabpanel" aria-labelledby="contact-form-tab">
            <form action="{{ url('save_contact_us') }}" method="post" enctype="multipart/form-data">
               @csrf
               <div class="row align-items-end contactpage_row">
                  <div class="form_row col-lg-4 col-md-6">
                     <label for="topic">{{__("customer.text_topic")}}</label>
                     <input type="text" name="topic" id="topic" placeholder='{{__("customer.text_enter")}} {{__("customer.text_topic")}}' />
                     <span class="text-danger"> 
                     <?php if ($errors->has('topic')) { ?> {{
                     $errors->first('topic') }}
                     <?php } ?>
                     </span>
                  </div>
                  <div class="form_row col-lg-4 col-md-6">
                     <label for="email">{{__("customer.text_recipient")}}</label>
                     <input type="email" name="email"  id="email" placeholder='{{__("customer.text_enter")}} {{__("customer.text_recipient")}}' />
                     <span class="text-danger"> 
                     <?php if ($errors->has('email')) { ?> {{
                     $errors->first('email') }}
                     <?php } ?>
                     </span>
                  </div>
                  <div class="form_row col-lg-4 col-md-6">
                     <input type="file" name="files" id="files" class="border-0 visually-hidden">
                     <label for="files"><img src="{{ asset('assets/images/file_up_icon.svg') }}" alt="file icon" class="me-2"> <span class="file_name clr_purpule">{{__("customer.text_add_attachment")}}</span></label>
                  </div>
                  <div class="form_row col-lg-8 col-md-6">
                     <label for="message">{{__("customer.text_message")}}</label>
                     <textarea name="message" id="message" cols="30" rows="10" placeholder='{{__("customer.text_enter")}} {{__("customer.text_message")}}'></textarea>
                  </div>
                  <div class="form_row col-lg-4 col-md-6 con_submit_btn">
                     <input type="submit" value="Send" class="site_btn mb-4">
                     <div class="checkbox pt-2 d-flex align-items-center">
                        <input type="checkbox" name="rules" id="rules">
                        <label for="rules">{{__("customer.text_send_copy_mail")}}</label>
                     </div>
                  </div>
               </div>
            </form>
         </div>
         <div class="tab-pane fade {{$chat_tab}}" id="chat" role="tabpanel" aria-labelledby="chat-tab">
            <div class="chatting_screen">
               <div class="chat_list">
                  <div class="chat_search mb_30">
                  </div>
                  <div class="chat_members">
                     @if(count($Get_Customer)>0)
                     <?php 
                        if($Get_Customer['profile_image'] !=""){
                            $profile = url('profile',$Get_Customer['profile_image']);
                        }else{
                            $profile = url('assets/images/cli.png');
                        }
                        $fullname = $Get_Customer['fullname'];
                        
                        ?>
                     <div class="member_block position-relative chat_users" data-id="Admin">
                        <div class="member_img position-relative">
                           <!-- <span class="active_status"></span> -->
                           <img src="{{$profile}}" alt="" srcset="">
                        </div>
                        <div class="memeber_detail min_lenght_text" data-maxlength="60">
                           <h3 class=""><?php echo (strlen($fullname) > 30) ? substr($fullname, 0, 30) . '...' : $fullname; ?></h3>
                        </div>
                        <!-- <span class="active_time">2d ago</span> -->
                     </div>
                     @else
                     <div class="container-fluid bg-white text-center no_record">
                        <img src="{{asset('assets/images/no_record_face.png')}}">
                        <p>{{__("customer.text_sorry")}} , {{__("customer.text_no_record")}}</p>
                    </div>
                     @endif
                  </div>
               </div>
               <div class="single" id="my_chat">
                  <div class="single_chat ">
                     <h3 class="member_name">{{$to_user['fullname']}}</h3>
                     <div class="member_chat chat_msg">
                        @foreach($chats as $key =>$value)
                        <div class=" {{ $value['position'] =="left" ? "msg_recevie":"msg_send"}}">
                        <div class="msg_img">
                           @if($value['customer_image'] !="")
                           <img src="{{ url('profile',$value['customer_image']) }}" alt="" srcset="">
                           @else 
                           <img src="{{ url('assets/images/bo.png')}}" alt="" srcset="">
                           @endif
                        </div>
                        <div class="msg_details">
                           <div class="msg_date_time">
                              <span class="msgdate">{{$value['date']}}</span>
                              <span class="msgtime">{{$value['time']}}</span>
                           </div>
                           <div class="msg_text">
                              <p>{{$value['message']}}</p>
                           </div>
                        </div>
                     </div>
                     @endforeach
                  </div>
               </div>
               <div class="chat_search mb_30">
                  <form action="javascript:void(0)" class="topan_search w-100 justify-content-between">
                     <input type="text" style="width: 100%;" name="message" id="txt-message"  placeholder='{{__("customer.text_write_message")}}'>
                     <button class="send_btn mb-3" id="send-btn" data-id="{{$to_user['id']}}"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                  </form>
               </div>
            </div>
         </div>
      </div>
      <div class="tab-pane fade" id="send-email" role="tabpanel" aria-labelledby="send-email-tab">
         <form action="" method="post" enctype="multipart/form-data">
            <div class="row align-items-end contactpage_row">
               <div class="form_row col-lg-4 col-md-6">
                  <label for="mail">{{__("customer.text_admin_mail")}}</label>
                  <?php 
                     $user    = App\Models\UserModel::where(['id' => 1])->first();
                     ?>
                  <a href="mailto:{{$user['email']}}">{{$user['email']}}</a>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>
</div>
<script type="text/javascript">
   $(document).on('click','.chat_users',function(){
     var id = $(this).data('id');
     
       $.ajax({
            url: "{{Route('get_chat')}}",
            method: 'POST',
            dataType:'json',
            data: {"user":id,"_token": "{{ csrf_token() }}",},
            success:function(resp){
            $('#my_chat').html(resp.html);
            $('.chat_msg').animate({
                 scrollTop: $('.chat_msg')[0].scrollHeight
               },1);
            }
       });
   });
</script>
<script type="text/javascript">
   $(document).on('click','#send-btn',function(){
     var id      = $(this).data('id');
     var msg     = $('#txt-message').val();
    
     if(msg !=""){ 
       $.ajax({
            url: "{{Route('send_chat')}}",
            method: 'POST',
            dataType:'json',
            data: {"user":id,"message":msg,"_token": "{{ csrf_token() }}",},
            success:function(resp){
             if(resp.status == true){
               $('.chat_msg').append(resp.html)
               $('#txt-message').val('')
               $('.chat_msg').animate({
                 scrollTop: $('.chat_msg')[0].scrollHeight
               }, 1000);
             }
            }
       });
     }
   });
</script>
<script type="text/javascript">
   $(document).ready(function(){
     $('.chat_msg').animate({
           scrollTop: $('.chat_msg')[0].scrollHeight
         }, 1);
     });
</script>
@include('front.layout.footer')