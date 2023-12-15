@include('front.layout.header')
@include('front.layout.top_bar')
<div class="featured_list_main" id="access_request">
   <div class="container" style="min-height: 340px;">
      <div class="row">
         <div class="col-md-12">
            <h2 class="featured_title">
               Requests to access 
            </h2>
         </div>
      </div>
      <div class="row">
         @if(count($data)>0)
            @foreach($data as $row => $value) 
               <div class="col-md-3 col-sm-3 col-lg-3">
                  <div class="featured_item_box">
                     <img src="{{ $value['image'] }}" height="130" width="235"> 
                     <h2>{{$value['full_name']}}</h2>
                     <p> <span class="fa fa-mobile"> </span> {{$value['phone_number']}}</p>
                     <p> <span class="fa fa-envelope"> </span> {{$value['email']}}</p>
                     <p> <span class="fa fa-dot-circle-o"> </span> {{$value['designation']}}</p>
                     <p> <span class="fa fa-map-marker"> </span> {{$value['address']}} </p>
                     <h3>{{$value['company_name']}}</h3>
                     <div class="action_section">
                        @if($value['request_status']=='Pending')
                           <button class="btn btn-warning" id="change_status" data-status='Accept' data-id="{{ $value['request_id'] }}">Accept</button>
                           <button class="btn btn-danger" id="change_status" data-status='Reject' data-id="{{ $value['request_id'] }}">Reject</button>
                        @elseif($value['request_status']=='Accept')
                           <button class="btn btn-success">Accepted</button>
                        @elseif($value['request_status']=='Reject')
                           <button class="btn btn-danger">Rejected</button>   
                        @endif      
                     </div>
                  </div>
               </div>
            @endforeach
         @else   
           <div class="col-md-12">
              <img src="{{ asset('frontassets/image/no_record.jpg') }}" id="upload_users"  alt="" />
           </div>
         @endif        
      </div>
   </div>
</div>
@include('front.layout.footer')

<script type="text/javascript">
   
   $(document).ready(function(){
      $('body').on('click', '#change_status', function(e) {

         var request_id = $(this).attr('data-id');
         var status     = $(this).attr('data-status');
      
         jQuery.ajax({
            type:'POST',
            url:"{{route('change_request_status')}}",
            data:{'request_id': request_id,'status':status,_token: "{{ csrf_token() }}"},
            
            success:function(result){

               success_msg("Status update successfully");
               setTimeout(function(){ 
                  window.location.reload();     
               }, 1500);
            }
         });
         
      });
   });
</script>