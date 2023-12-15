@include('front.layout.header')
@include('front.layout.top_bar')
<div class="main_signup">
   <div class="container">
      <div class="row">
         <div class="col-md-12">
   
            <form action="{{route('my_profile')}}" method="post" enctype="multipart/form-data" class="signup_form_section">
            	@csrf
            	<input type="hidden" name="id" value="{{ $user['id'] }}">
               <div class="row">
                  <div class="col-md-8 profile_img">
                     <h2>My Profile</h2>
                     <img src="{{ asset('uploads/users/' . $user['image'])  }}" height="100" width="100" style="border-radius: 50%;">
                     <i class="fa fa-camera" aria-hidden="true"></i>
                  </div>
                  <div class="col-md-4">
                     <select class="form-control select2" id="all_fav_user" multiple name="favourite_users[]">
                  		@foreach($get_all_user as $row => $value) 
                        	<option value="{{$value['id']}}" >{{$value['first_name']}} {{$value['last_name']}}</option>
                    		@endforeach 
                     </select>
                     <button class="btn btn-success mt-3" type="button" id="add_to_fav">Add to favourites</button>
                  </div>
               </div>
               <hr>
               <div class="row">
                  <div class="form-group col-md-2">
                     <i class="fa fa-user" aria-hidden="true"></i>
                     <select class="form-control" name="prefix">
                        <option value="Mr." <?php echo ($user['prefix']== 'Mr.') ?  "selected" : "" ;  ?>>Mr.</option>
                        <option value="Dr." <?php echo ($user['prefix']== 'Dr.') ?  "selected" : "" ;  ?>>Dr.</option>
                        <option value="Prof." <?php echo ($user['prefix']== 'Prof.') ?  "selected" : "" ;  ?>>Prof.</option>
                        <option value="Miss" <?php echo ($user['prefix']== 'Miss') ?  "selected" : "" ;  ?>>Miss</option>
                     </select>
                  </div>
                  <div class="form-group col-md-5">
                     <i class="fa fa-user" aria-hidden="true"></i>
                     <input type="text" placeholder="Enter First name" class="form-control" name="first_name"  value="{{$user['first_name']}}">
                  </div>
                  <div class="form-group col-md-5">
                     <i class="fa fa-user" aria-hidden="true"></i>
                     <input type="text" placeholder="Enter Last name" class="form-control" name="last_name"  value="{{$user['last_name']}}">
                  </div>
                  <div class="form-group col-md-6">
                     <i class="fa fa-envelope" aria-hidden="true"></i>
                     <input type="text" readonly placeholder="Enter Email" class="form-control" name="email" value="{{$user['email']}}">
                  </div>
                  <div class="form-group col-md-6">
                     <i class="fa fa-building" aria-hidden="true"></i>
                     <input type="text" placeholder="Enter Company name" class="form-control" name="company_name"  value="{{$user['company_name']}}">
                  </div>
                  <div class="form-group col-md-6">
                     <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                     <input type="text" placeholder="Enter Designation" class="form-control" name="designation" value="{{$user['designation']}}">
                  </div>
                  <div class="form-group col-md-6">
                     <i class="fa fa-mobile" aria-hidden="true"></i>
                     <input type="number" placeholder="Enter Contact" class="form-control" name="contact" value="{{$user['contact']}}">
                  </div>
                  <div class="form-group col-md-12">
                     <i class="fa fa-map-marker" aria-hidden="true"></i>
                     <textarea class="form-control" name="address" placeholder="Enter Your Address">{{$user['address']}}</textarea>
                  </div>
                  <div class="form-group col-md-12">
                     <i class="fa fa-map-marker" aria-hidden="true"></i>
                     <select class="form-control" name="create_group">
                        <option value="personal" <?php echo ($user['create_group']== 'personal') ?  "selected" : "" ;  ?>> Personal </option>
                        <option value="business" <?php echo ($user['create_group']== 'business') ?  "selected" : "" ;  ?>>Business</option>
                        <option value="acquintance" <?php echo ($user['create_group']== 'acquintance') ?  "selected" : "" ;  ?>>Acquintance</option>
                     </select>
                  </div>
                  <div class="form-group col-md-6">
                     <i class="fa fa-facebook-official" aria-hidden="true"></i>
                     <input type="text" placeholder="Enter your Facebook url" class="form-control" name="facebook" value="{{$user['facebook']}}">
                  </div>
                  <div class="form-group col-md-6">
                     <i class="fa fa-twitter" aria-hidden="true"></i>
                     <input type="text" placeholder="Enter your twitter url" class="form-control" name="twitter" value="{{$user['twitter']}}">
                  </div>
                  <div class="form-group col-md-6">
                     <i class="fa fa-linkedin-square" aria-hidden="true"></i>
                     <input type="text" placeholder="Enter your Linkedin url" class="form-control" name="linkedin" value="{{$user['linkedin']}}">
                  </div>
                  <div class="form-group col-md-6">
                     <i class="fa fa-instagram" aria-hidden="true"></i>
                     <input type="text" placeholder="Enter your Instagram url" class="form-control" name="instagram" value="{{$user['instagram']}}">
                  </div>
                  
               </div>
               <!-- ////// Multiple row -->
               @if(!$get_user_desc->isEmpty())
               	@foreach($get_user_desc as $row => $value) 
	            		<?php $count = $row+1; ?>
		               <div class="multiple_rows mt-5">
		                  <div class="row row_business">
		                     <div class="form-group col-md-12">
		                        <label> Business Detail : {{ $count }}</label><br>
		                     </div>
		                     <div class="form-group col-md-6">
		                        <label> Company name :</label><br>
		                        <i class="fa fa-building" aria-hidden="true"></i>
		                        <input type="text" placeholder="Enter Company name" class="form-control" name="company[]" value="{{$value['company']}}">
		                     </div>
		                     <div class="form-group col-md-6">
		                        <label> Location :</label><br>
		                        <i class="fa fa-map-marker" aria-hidden="true"></i>
		                        <input type="text" placeholder="Enter Location" class="form-control" name="location[]" value="{{$value['location']}}">
		                     </div>
		                     <div class="form-group col-md-6">
		                        <label> Services / Products :</label><br>
		                        <i class="fa fa-building" aria-hidden="true"></i>
		                        <input type="text" placeholder="Enter Services / Products" class="form-control" name="services[]" value="{{$value['services']}}" >
		                     </div>
		                     <div class="form-group col-md-6">
		                        <label> Role/position :</label><br>
		                        <i class="fa fa-building" aria-hidden="true"></i>
		                        <input type="text" placeholder="Enter Role/position" class="form-control" name="role[]" value="{{$value['role']}}">
		                     </div>
		                     <div class="form-group col-md-6">
		                        <label> Company contact :</label><br>
		                        <i class="fa fa-building" aria-hidden="true"></i>
		                        <input type="text" placeholder="Enter Company contact" class="form-control" name="company_contact[]" value="{{$value['company_contact']}}">
		                     </div>
		                     <div class="form-group col-md-6">
		                        <label> Company Email :</label><br>
		                        <i class="fa fa-envelope" aria-hidden="true"></i>
		                        <input type="text" placeholder="Enter Company Email" class="form-control" name="company_email[]" value="{{$value['company_email']}}">
		                     </div>
		                     <div class="form-group col-md-6">
		                        <label> Linkedin url :</label><br>
		                        <i class="fa fa-linkedin-square" aria-hidden="true"></i>
		                        <input type="text" placeholder="Enter your Linkedin url" class="form-control" name="linkedin_url[]" value="{{$value['linkedin_url']}}">
		                     </div>
		                     <div class="form-group col-md-6">
		                        <label> Facebook url :</label><br>
		                        <i class="fa fa-facebook-official" aria-hidden="true"></i>
		                        <input type="text" placeholder="Enter Facebook url" class="form-control" name="facebook_url[]" value="{{$value['facebook_url']}}">
		                     </div>
		                     <div class="form-group col-md-6">
		                        <label> Twitter url :</label><br>
		                        <i class="fa fa-twitter" aria-hidden="true"></i>
		                        <input type="text" placeholder="Enter Twitter url" class="form-control" name="twitter_url[]" value="{{$value['twitter_url']}}">
		                     </div>
		                     <div class="form-group col-md-6">
		                        <label> Instagram url :</label><br>
		                        <i class="fa fa-instagram" aria-hidden="true"></i>
		                        <input type="text" placeholder="Enter Instagram url" class="form-control" name="instagram_url[]" value="{{$value['instagram_url']}}">
		                     </div>
		                     @if($count > 1)
			                     <div class="form-group col-md-12 text-end">
				                  	<button class="btn btn-danger remove_row" id="remove_row">Remove(-)</button>
				                  </div>
				               @endif   
		                  </div>
		               </div>
         			@endforeach   
	            @else
						<div class="multiple_rows mt-5">
						  <div class="row">
						     <div class="form-group col-md-12">
						        <label> Business Detail :</label><br>
						     </div>
						     <div class="form-group col-md-6">
						        <label> Company name :</label><br>
						        <i class="fa fa-building" aria-hidden="true"></i>
						        <input type="text" placeholder="Enter Company name" class="form-control" name="company[]">
						     </div>
						     <div class="form-group col-md-6">
						        <label> Location :</label><br>
						        <i class="fa fa-map-marker" aria-hidden="true"></i>
						        <input type="text" placeholder="Enter Location" class="form-control" name="location[]" >
						     </div>
						     <div class="form-group col-md-6">
						        <label> Services / Products :</label><br>
						        <i class="fa fa-building" aria-hidden="true"></i>
						        <input type="text" placeholder="Enter Services / Products" class="form-control" name="services[]"  >
						     </div>
						     <div class="form-group col-md-6">
						        <label> Role/position :</label><br>
						        <i class="fa fa-building" aria-hidden="true"></i>
						        <input type="text" placeholder="Enter Role/position" class="form-control" name="role[]">
						     </div>
						     <div class="form-group col-md-6">
						        <label> Company contact :</label><br>
						        <i class="fa fa-building" aria-hidden="true"></i>
						        <input type="text" placeholder="Enter Company contact" class="form-control" name="company_contact[]">
						     </div>
						     <div class="form-group col-md-6">
						        <label> Company Email :</label><br>
						        <i class="fa fa-envelope" aria-hidden="true"></i>
						        <input type="text" placeholder="Enter Company Email" class="form-control" name="company_email[]">
						     </div>
						     <div class="form-group col-md-6">
						        <label> Linkedin url :</label><br>
						        <i class="fa fa-linkedin-square" aria-hidden="true"></i>
						        <input type="text" placeholder="Enter your Linkedin url" class="form-control" name="linkedin_url[]">
						     </div>
						     <div class="form-group col-md-6">
						        <label> Facebook url :</label><br>
						        <i class="fa fa-facebook-official" aria-hidden="true"></i>
						        <input type="text" placeholder="Enter Facebook url" class="form-control" name="facebook_url[]">
						     </div>
						     <div class="form-group col-md-6">
						        <label> Twitter url :</label><br>
						        <i class="fa fa-twitter" aria-hidden="true"></i>
						        <input type="text" placeholder="Enter Twitter url" class="form-control" name="twitter_url[]">
						     </div>
						     <div class="form-group col-md-6">
						        <label> Instagram url :</label><br>
						        <i class="fa fa-instagram" aria-hidden="true"></i>
						        <input type="text" placeholder="Enter Instagram url" class="form-control" name="instagram_url[]">
						     </div>
						  </div>
						</div>
	            @endif    
               <div class="response_append multiple_rows mt-4"></div>
               <div class="row">
                  <div class="form-group col-md-12 text-end">
                     <button class="add_more_btn" type="button" id="add_more_business">Add more</button>
                  </div>
               </div>
               <div class="row " id="personal_contact" >
                  <div class="form-group col-md-6">
                     <label>Personal Contact:</label><br>
                     <label for="public">
                     <input type="radio" class="public" id="public" name="status" <?php echo ($user['status']== '0') ?  "checked" : "" ;  ?> value="0">
                     Public
                     </label>
                     <label for="private">
                     <input type="radio" class="private" id="private" name="status" <?php echo ($user['status']== '1') ?  "checked" : "" ;  ?> value="1">
                     Private
                     </label>
                     <label for="only-share-with" >
                     <input type="radio" class="share_with" id="only-share-with" name="status" <?php echo ($user['status']== '2') ?  "checked" : "" ;  ?> value="2">
                     Only Share With
                     </label>
                  </div>
               </div>
               <div class="row">
                  <div class="form-group col-md-4 show_users" <?php if ($user['status']!='2') { ?> style="display: none;" <?php } ?> >
                     <div id="get_users_id"> 
	                        <select class="form-control select2 all_users" id="all_user_id" multiple name="contact_users[]">
	                           @foreach($get_all_user as $row => $value) 
		                        	<option value="{{$value['id']}}"  >{{$value['first_name']}} {{$value['last_name']}}</option>
		                    		@endforeach 
	                        </select>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-12 submit_btn text-end">
                     <button type="submit">Update</button>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
@include('front.layout.footer')
<script type="text/javascript">

	$('#all_user_id').select2();
	$('#all_fav_user').select2();

	$(document).ready(function(){
		$('body').on('click', "#add_more_business", function(e) {
			$(".response_append").append('<div class="row row_business"><div class="form-group col-md-12"><label> Business Detail :</label><br></div><div class="form-group col-md-6"><label> Company name :</label><br><i class="fa fa-building" aria-hidden="true"></i><input type="text" placeholder="Enter Company name" class="form-control" name="company[]"></div><div class="form-group col-md-6"><label> Location :</label><br><i class="fa fa-map-marker" aria-hidden="true"></i><input type="text" placeholder="Enter Location" class="form-control" name="location[]" ></div><div class="form-group col-md-6"><label> Services / Products :</label><br><i class="fa fa-building" aria-hidden="true"></i><input type="text" placeholder="Enter Services / Products" class="form-control" name="services[]"  ></div><div class="form-group col-md-6"><label> Role/position :</label><br><i class="fa fa-building" aria-hidden="true"></i><input type="text" placeholder="Enter Role/position" class="form-control" name="role[]" ></div><div class="form-group col-md-6"><label> Company contact :</label><br><i class="fa fa-building" aria-hidden="true"></i><input type="text" placeholder="Enter Company contact" class="form-control" name="company_contact[]"></div><div class="form-group col-md-6"><label> Company Email :</label><br><i class="fa fa-envelope" aria-hidden="true"></i><input type="text" placeholder="Enter Company Email" class="form-control" name="company_email[]"></div><div class="form-group col-md-6"><label> Linkedin url :</label><br><i class="fa fa-linkedin-square" aria-hidden="true"></i><input type="text" placeholder="Enter your Linkedin url" class="form-control" name="linkedin_url[]"></div><div class="form-group col-md-6"><label> Facebook url :</label><br><i class="fa fa-facebook-official" aria-hidden="true"></i><input type="text" placeholder="Enter Facebook url" class="form-control" name="facebook_url[]"></div><div class="form-group col-md-6"><label> Twitter url :</label><br><i class="fa fa-twitter" aria-hidden="true"></i><input type="text" placeholder="Enter Twitter url" class="form-control" name="twitter_url[]"></div><div class="form-group col-md-6"><label> Instagram url :</label><br><i class="fa fa-instagram" aria-hidden="true"></i><input type="text" placeholder="Enter Instagram url" class="form-control" name="instagram_url[]"></div><div class="form-group col-md-12 text-end"><button class="btn btn-danger remove_row" id="remove_row">Remove(-)</button></div></div>');
		});

		$('body').on('click', ".remove_row", function(e) {
	        /*if (!confirm("Are you sure you want to delete this row?"))
	        return false;*/
				var length = $(".row_business").length;
				if (length > 1) {
		        $(this).closest('.row_business').remove();
		        e.preventDefault();
				}else{
					return false;
				}

	    });
	});
</script>

<script type="text/javascript">
	$(document).ready(function(){
		$('body').on('click', '#add_to_fav', function(e) {
			var ID = "{{$user['id']}}";
			// alert(ID);
			var fav_users = $("#all_fav_user").val();
			
			jQuery.ajax({
	            type:'POST',
	            url:"{{route('save_favourites')}}",
	            data:{'ID': ID,'fav_users':fav_users,_token: "{{ csrf_token() }}"},
	            datatype: 'JSON',
	            success:function(result){
	               success_msg("Favorite update successfully");
	               setTimeout(function(){ 
	                  window.location.reload();     
	               }, 1500); 
	            }
	        });
	        return false;
		});
	});
</script>

<script type="text/javascript">
	$(document).ready(function(){
		if ($user['status']=='2') {
			$(".show_users").css("display", "block");
		}
	});

	$(".share_with").click(function(){
		$('.show_users').show();
	});

	$(".public").click(function(){
		$('.show_users').hide();
		$('.all_users').val('');
	});

	$(".private").click(function(){
		$('.show_users').hide();
		$('.all_users').val('');
	});
</script>
