@include('front.layout.header')
@include('front.layout.top_bar')

<!-- Banner Carousel -->
<section class="banner_section">
   <div class=" owl-carousel owl-theme" id="home_slider">
      <div class="item">
         <div class="slider_image" style="background-image: url('{{ asset("frontassets/image/slide1.png") }}')">
         </div>
      </div>
   </div>
   <div class="container">
      <div class="row">
         <div class="col-md-12">
            <div class="find_form_section">
               <div class="row">
                  <div class="col-md-12">
                     <h2>Find</h2>
                  </div>
               </div>
               <form method="get" id="filterform">
                  <div class="row">
                     <div class="col-md-8 col-sm-8 col-lg-8">
                        <div class="form-group">
                           <i class="fa fa-search" aria-hidden="true"></i>
                           <input type="text" name="Search" class="form-control" id="search" value="{{@$_GET['Search']}}" placeholder="Name,Company name,designation,country name,town etc.">
                        </div>
                     </div>
                     <div class="col-md-2 col-sm-2 col-lg-2">
                        <div class="search_btn">
                           <button type="submit">Search</button>
                        </div>
                     </div>
                     <div class="col-md-2 col-sm-2 col-lg-2">
                        <div class="clear_btn">
                           <a href="{{route('home')}}"> <button type="button">Clear</button></a>
                        </div>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</section>
<!--Close Banner Carousel -->
<div class="featured_list_main">
   <div class="container">
      <div class="row">
         <div class="col-md-12">
            <h2 class="featured_title">
               Featured Listings
            </h2>
         </div>
      </div>
      <div class="row">
         @if(count($get_users)>0)
            @foreach($get_users as $row => $value) 
               <div class="col-md-3 col-sm-3 col-lg-3">
                  <div class="featured_item_box">
                     @if($value['user_id']!='')
                        <div class="text-center">

                           <img src="{{ $value['avatar_file'] != '' ? asset('uploads/staff/' . $value['avatar_file']) : asset('frontassets/image/placeholder.jpg') }}" id="upload_users"  alt="" />
                           
                        </div>
                     @else
                        <div class="text-center">

                           <img src="{{ $value['image'] != '' ? asset('uploads/users/' . $value['image']) : asset('frontassets/image/placeholder.jpg') }}" id="upload_users"  alt="" />
                           
                        </div>   
                     @endif   

                     <h2>{{$value['first_name']}} {{$value['last_name']}}</h2>
                     <h3>{{$value['company_name']}}</h3>
                     <p>  <span class="fa fa-mobile"> </span> {{$value['contact']}}</p>
                     <p> <span class="fa fa-envelope"> </span> {{$value['email']}} </p>
                     <p> <span class="fa fa-dot-circle-o"> </span> {{$value['designation']}}</p>
                     <p> <span class="fa fa-map-marker"> </span> {{$value['address']}}</p>
                     
                     <div class="approve_section">
                        <div style="margin-top: 30%;">
                           @if($value['request_status']=='')
                              <button class="btn btn-warning" type="button" id="send_request" data-customer-id='{{$user_id}}' data-id-to="{{ $value['id'] }}" data-status="Pending">Send a request</button>
                           @elseif($value['request_status']=='Pending')  
                              <button class="btn btn-warning" type="button">Pending</button>
                           @elseif($value['request_status']=='Accept')  
                              <button class="btn btn-success" type="button">Accepted</button>
                           @elseif($value['request_status']=='Reject')  
                              <button class="btn btn-danger" type="button">Rejected</button>      
                           @endif   
                        </div>
                     </div>   
                  </div>
               </div>
            @endforeach
            <div class="custom_pagination">
               {{ $get_users_details->appends(request()->query())->links() }}
           </div>
         @else   
            <div class="row">
                 <div class="col-md-12">
                    <img src="{{ asset('frontassets/image/no_record.jpg') }}" id="upload_users"  alt="" />
                 </div> 
            </div>
         @endif  
      </div>
   </div>
</div>
@include('front.layout.footer')

<script type="text/javascript">
   
   $(document).ready(function(){
      $('body').on('click', '#send_request', function(e) {

         var user_id      = $(this).attr('data-customer-id');
         var to_user_id   = $(this).attr('data-id-to');
         var status       = $(this).attr('data-status');
      
         jQuery.ajax({
            type:'POST',
            url:"{{route('send_request')}}",
            data:{
               'user_id': user_id,
               'to_user_id':to_user_id,
               'status':status,
               _token: "{{ csrf_token() }}"},
            
            success:function(result){
               success_msg("Request Send Successfully");
               setTimeout(function(){ 
                  window.location.reload();     
               }, 1000);
            }
         });
         
      });
   });
</script>

<script type="text/javascript">
    $(document).ready(function(){
        var search_val = $('#search').val();
        $('#search').on('keyup', function() {
            setTimeout(function () {
                 $("#filterform").submit(); 
            }, 1500);
        });
        if (search_val) {
            $('#search').focus();
        }
    }); 
</script>
      