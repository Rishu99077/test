@include('front.layout.header')
@include('front.layout.top_bar')
<div class="main_signup">
	<div class="container">
		<div class="row justify-content-md-center">
			<div class="col-md-8">
				<form action="{{route('signup')}}" method="post" enctype="multipart/form-data" class="signup_form_section">
					@csrf
					<div class="row">
                        <div class="col-md-12">
					    	<h2>Sign Up</h2>
						</div>
					</div>    
				    <hr>
				    <div class="row">
				    	<div class="form-group col-md-6">
				    		<i class="fa fa-user" aria-hidden="true"></i>
				    		<input type="text" placeholder="Enter First name" class="form-control" value="{{old('first_name')}}" name="first_name">
				    		<div class="text-danger">
								@if ($errors->has('first_name'))
			                        {{ $errors->first('first_name') }}
			                    @endif
			                </div>
				    	</div>

				    	<div class="form-group col-md-6">
				    		<i class="fa fa-user" aria-hidden="true"></i>
				    		<input type="text" placeholder="Enter Last name" class="form-control" value="{{old('last_name')}}" name="last_name">
				    		<div class="text-danger">
								@if ($errors->has('last_name'))
			                        {{ $errors->first('last_name') }}
			                    @endif
			                </div>
				    	</div>

				    	<div class="form-group col-md-6">
				    		<i class="fa fa-envelope" aria-hidden="true"></i>
				    		<input type="email" placeholder="Enter Email" class="form-control" value="{{old('email')}}" name="email" >
				    		<div class="text-danger">
					    		@if ($errors->has('email'))
			                        {{ $errors->first('email') }}
			                    @endif
			                </div>
				    	</div>

				    	<div class="form-group col-md-6">
				    		<i class="fa fa-key" aria-hidden="true"></i>
				    		<input type="password" placeholder="Enter Password" class="form-control" name="password" >
				    		<div class="text-danger">
					    		@if ($errors->has('password'))
			                        {{ $errors->first('password') }}
			                    @endif
			                </div>
				    	</div>


				    	<div class="form-group col-md-6">
				    		<i class="fa fa-building" aria-hidden="true"></i>
				    		<input type="text" placeholder="Enter Company name" class="form-control" value="{{old('company_name')}}" name="company_name" >
				    		<div class="text-danger">
					    		@if ($errors->has('company_name'))
			                        {{ $errors->first('company_name') }}
			                    @endif
			                </div>
				    	</div>

				    	<div class="form-group col-md-6">
				    		<i class="fa fa-dot-circle-o" aria-hidden="true"></i>
				    		<input type="text" placeholder="Enter Designation" class="form-control" value="{{old('designation')}}" name="designation" >
				    		<div class="text-danger">
					    		@if ($errors->has('designation'))
			                        {{ $errors->first('designation') }}
			                    @endif
			                </div>
				    	</div>

				    	<div class="form-group col-md-6">
				    		<i class="fa fa-mobile" aria-hidden="true"></i>
				    		<input type="number" placeholder="Enter Contact" class="form-control" value="{{old('contact')}}" name="contact" >
				    		<div class="text-danger">
					    		@if ($errors->has('contact'))
			                        {{ $errors->first('contact') }}
			                    @endif
			                </div>
				    	</div>

				    	<div class="form-group col-md-6">
				    		<i class="fa fa-picture-o" aria-hidden="true"></i>
				    		<input type="file"  name="image"  class="form-control">
				    		@if ($errors->has('image'))
		                        {{ $errors->first('image') }}
		                    @endif
				    	</div>

				    	<div class="form-group col-md-6">
				    		<select class="form-control select2" name="country" id="country">
				    			<option>Select country</option>
				    			@foreach($get_country as $row)
						    		<option value="{{ $row['id'] }}" >{{ $row['name'] }}</option>
						    	@endforeach
				    		</select>
				    		<div class="text-danger">
					    		@if ($errors->has('country'))
			                        {{ $errors->first('country') }}
			                    @endif
			                </div>
				    	</div>

				    	<div class="form-group col-md-6">
				    		<i class="fa fa-dot-circle-o" aria-hidden="true"></i>
				    		<input type="text" placeholder="Enter Town" class="form-control" name="town" value="{{old('town')}}">
				    	</div>
				    			

				    	<div class="form-group col-md-12">
				    		<i class="fa fa-map-marker" aria-hidden="true"></i>
				    		<textarea class="form-control textarea" name="address" placeholder="Enter Your Address"></textarea>
				    	</div>

				    	<div class="form-group col-md-6">
				    		<i class="fa fa-map-marker" aria-hidden="true"></i>
				    		<select class="form-control" name="create_group">
				    			<option value="personal">Personal</option>
				    			<option value="business">Business</option>
				    			<option value="acquintance">Acquintance</option>
				    		</select>
				    	</div>

				    	<div class="form-group col-md-6">
				    		<i class="fa fa-user-plus" aria-hidden="true"></i>
				    		<select class="form-control" name="role">
				    			<option value="Individual">Individual</option>
				    			<option value="Company">Company</option>
				    		</select>
				    	</div>



				    	<div class="form-group col-md-6" id="personal_contact">
				    		<label>Personal Contact:</label><br>

							<label for="public">
								<input type="radio" class="public" id="public"  name="status" value="0">
								Public
							</label>
							
							<label for="private">
								<input type="radio" class="private" id="private"  name="status" value="1">
								Private
							</label>

							<label for="only-share-with">
								<input type="radio" class="share_with" id="only-share-with" name="status" value="2">
								Only Share With
							</label>
							<div class="text-danger">
								@if ($errors->has('status'))
			                        {{ $errors->first('status') }}
			                    @endif
			                </div>
				    	</div>

						<div class="form-group col-md-6 show_users" style="display: none;">
							<label>Select Member:</label><br>
							<select class="form-control select2" id="all_user_id" multiple name="contact_users[]">
								@foreach($get_all_user as $row => $value) 
									<option value="{{$value['id']}}"  >{{$value['first_name']}} {{$value['last_name']}}</option>
								@endforeach 
							</select>
						</div>

				    </div> 
				    <div class="row">
					    <div class="col-md-12 text-end submit_btn">
					      <button type="submit">Sign Up</button>
					    </div>
				    </div>
				</form>
			</div>
		</div>
	</div>
</div>
@include('front.layout.footer')
<script type="text/javascript">
	$(".share_with").click(function(){
		$('.show_users').show();
	});

	$(".public").click(function(){
		$('.show_users').hide();
		$('#all_user_id').val('');
	});
	$(".private").click(function(){
		$('.show_users').hide();
		$('#all_user_id').val('');
	});
</script>

