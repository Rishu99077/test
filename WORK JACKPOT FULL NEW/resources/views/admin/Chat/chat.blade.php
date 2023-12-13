@include('admin.layout.header')
@include('admin.layout.sidebar')
<div class="main_right">
    <div class="top_announce d-flex align-items-center justify-content-between mb_20">
       <div class="top_ann_left">
            <a href="javascript:void(0);" class="site_btn f16 f_bold blue__btn post_ad_disabled">Dashboard</a>
        </div>
    </div>
    <div class="row top_bb mb_20 align-items-center justify-content-between">
        <h3 class="title col-md-6 mb-md-0 mb_20">{{$common['heading_title']}}</h3>
    </div>
    <div class="contact_tabs">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            
            
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="chat-tab" data-bs-toggle="tab" href="#chat" role="tab" aria-controls="chat" aria-selected="false">
                    <span class="tab_icon_a"><img src="{{ asset('assets/images/chat-icon.png') }}" alt="" srcset=""></span>
                    <span class="tab_title_txt">{{__("admin.text_chat")}}</span>
                </a>
            </li>
           
          
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="chat" role="tabpanel" aria-labelledby="chat-tab">
                <div class="chatting_screen">
                    <div class="chat_list">
                        <div class="chat_search mb_30">
                            <form action="" id="search_user" class="topan_search w-100 justify-content-between">
                                <input type="text" name="search_input" id="search_input" value="{{@$_GET['search_input'] ? $_GET['search_input']:''}}" placeholder='{{__("admin.text_search")}}'>
                                <input type="hidden" name="tab" value="chat_tab">
                                <input type="submit" id="search_btn" value="">
                            </form>
                        </div>
                        
                        <div class="chat_members">
                            
                           @if(count($Get_Customer)>0)
                                @foreach($Get_Customer as $key => $value)
                                    <?php 
                                        if($value['profile_image'] !=""){
                                            $profile = url('profile',$value['profile_image']);
                                        }else{
                                            $profile = url('assets/images/cli.png');
                                        }
                                        $fullname = $value['firstname']." ".$value['surname'];
                                    
                                    ?>
                                    <div class="member_block position-relative chat_users" data-id="{{$value['id']}}">
                                        <div class="member_img position-relative">
                                            <!-- <span class="active_status"></span> -->
                                            <img src="{{$profile}}" alt="" srcset="">
                                        </div>
                                        <div class="memeber_detail min_lenght_text" data-maxlength="60">
                                            <h3 class=""><?php echo (strlen($fullname) > 30) ? substr($fullname, 0, 30) . '...' : $fullname; ?></h3>
                                        </div>
                                        <!-- <span class="active_time">2d ago</span> -->
                                    </div>
                                @endforeach
                            @else
                            <div class="container-fluid bg-white text-center no_record">
                              <img src="{{asset('assets/images/no_record_face.png')}}">
                              <p>{{__("admin.text_sorry")}} , {{__("admin.text_no_record")}}</p>
                            </div>
                            @endif
                            
                        </div>
                    </div>
                    <div class="single" id="my_chat">
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).on('click','.chat_users',function(){
      var id = $(this).data('id');
      
        $.ajax({
             url: "{{Route('admin_get_chat')}}",
             method: 'POST',
             dataType:'json',
             data: {"user":id,"_token": "{{ csrf_token() }}",},
             success:function(resp){
             $('#my_chat').html(resp.html);
             $('.chat_msg').animate({
                  scrollTop: $('.chat_msg')[0].scrollHeight
                }, 1);
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
             url: "{{Route('admin_send_chat')}}",
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
@include('front.layout.footer')