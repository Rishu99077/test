@include('front.layout.header')
@include('front.layout.top_bar')
<div class="main_signup">
	<div class="container" style="min-height: 454px;">
		<div class="row justify-content-md-center">
			<div class="col-md-6">
				<form action="{{route('login')}}" method="post" enctype="multipart/form-data" class="signup_form_section">
					@csrf	
				    <div class="row">
                        <div class="col-md-12">
					    	<h2>Log IN</h2>
						</div>
					</div>    
				    <hr>
				    <div class="row">
				    	
				    	<div class="form-group col-md-12">
				    		<i class="fa fa-envelope" aria-hidden="true"></i>
				    		<input type="text" placeholder="Enter Your Email" class="form-control" name="email" >
				    		<div class="text-danger">
					    		@if ($errors->has('email'))
			                        {{ $errors->first('email') }}
			                    @endif
			                </div>
				    	</div>

				    	<div class="form-group col-md-12">
				    		<i class="fa fa-key" aria-hidden="true"></i>
				    		<input type="password" placeholder="Enter your Password" class="form-control" name="password" >
				    		<div class="text-danger">
					    		@if ($errors->has('password'))
			                        {{ $errors->first('password') }}
			                    @endif
			                </div>
				    	</div>

				    </div> 
				    <div class="row">
					    <div class="col-md-12 submit_btn text-end">
					      <button type="submit">LOG IN</button>
					    </div>
				    </div>
				</form>
			</div>
		</div>
	</div>
</div>
@include('front.layout.footer')

