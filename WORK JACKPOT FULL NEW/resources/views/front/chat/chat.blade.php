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
        <input type="text" style="width: 100%;" name="message" id="txt-message"  placeholder='{{__("customer.text_write_your_message")}}'>
        <button class="send_btn mb-3" id="send-btn" data-id="{{$to_user['id']}}"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
    </form>
</div>