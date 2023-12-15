<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('admin/images/favicon2_logo.png') }}" >
        <!-- bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous" /><script src="{{ asset('admin/plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
        <link href="{{ asset('admin/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet" id="bootstrap-css">
        <link href="{{ asset('admin/css/parsley.css') }}" rel="stylesheet" id="bootstrap-css">
        <script src="{{ asset('admin/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <!-- toast CSS -->
        <link href="{{ asset('admin/plugins/bower_components/toast-master/css/jquery.toast.css') }}" rel="stylesheet">
        <script src="{{ asset('admin/plugins/bower_components/toast-master/js/jquery.toast.js') }}"></script>
        <script src="{{ asset('admin/js/parsley.js') }}"></script>
        <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet" id="bootstrap-css">
    </head>
    <body>
        <!------ Include the above in your HEAD tag ---------->
        <div id="fullscreen_bg" class="fullscreen_bg"/>
          <div class="container text-center main-text">
             <h2 class="text-light">BAR PATROL</h2>
          </div>
          @foreach (['danger', 'warning', 'success', 'info', 'error'] as $key)
          @if(Session::has($key))
          <p id="success_msg" class="alert alert-{{ $key }}">{{ Session::get($key) }}</p>
          @endif
          @endforeach
          <div id="regContainer" class="container">
             <div class="row">
                <div class="col-md-6 col-md-offset-3">
                   <div class="panel panel-login">
                      <div class="panel-heading">
                         <div class="row">
                            <div class="col-xs-12">
                               <a href="#" class="active" id="login-form-link">Login</a>
                            </div>
                         </div>
                         <hr>
                      </div>
                      <div class="panel-body">
                         <div class="row">
                            <div class="col-lg-12">
                               <form action="{{url('Login')}}" autocomplete="off" id="validate_form">
                                  @csrf
                                  <!-- Email Field -->
                                  <div class="form-group {{ $errors->has('email') ? 'is-invalid' : ''}}">
                                     <label>Email</label>
                                     <br>
                                     <input type="email" name="email"  required placeholder="Enter your email">
                                  </div>
                                  <!-- Password Field -->
                                  <div class="form-group {{ $errors->has('password') ? 'is-invalid' : ''}}">
                                     <label>Password</label>
                                     <br>
                                     <input type="password" name="password" required placeholder="Enter Password">
                                  </div>
                                  <div class="form-group">
                                     <div class="row">
                                        <div class="col-sm-6 col-sm-offset-3">
                                           <input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Log In">
                                        </div>
                                     </div>
                                     <br>
                                     <div class="signup_action text-right">
                                        <a href="{{('Signup')}}">Not an account <span class="text-danger">Signup</span></a>
                                     </div>
                                  </div>
                               </form>
                            </div>
                         </div>
                      </div>
                   </div>
                </div>
             </div>
          </div>
        </div>
    </body>    
<script type="text/javascript">
   $(document).ready(function(){
       $('#success_msg').show();
       $('#success_msg').fadeOut(5000);
       $('html, body').animate({ scrollTop: $("#success_msg").offset() }, 2500);
        setTimeout(explode, 2000);
   });
   
</script>
<script>
   $(function() {
    $('#login-form-link').click(function(e) {
       $("#login-form").delay(100).fadeIn(100); 
       $("#register-form").fadeOut(100); 
       $('#register-form-link').removeClass('active'); 
       $(this).addClass('active');  
       e.preventDefault();  
   });
   
   $('#register-form-link').click(function(e) {
   
   $("#register-form").delay(100).fadeIn(100);
   
    $("#login-form").fadeOut(100);
   
   $('#login-form-link').removeClass('active');
   
   $(this).addClass('active');
   
   e.preventDefault();
   
   });
 
   });
   
</script>
<script>
   $(document).ready(function(){
    $('#validate_form').parsley();  
    $('#validate_form').on('submit', function(event){   
     event.preventDefault();
     if($('#validate_form').parsley().isValid())
     {
      document.getElementById('validate_form').submit();
     }
    });
   });
   
</script>
@if($errors->has('error'))
<script>
   $.toast({   
           heading: 'Error',  
           text: "{{ $errors->first('error') }}",  
           position: 'top-right',   
           loaderBg: '#fff',   
           icon: 'error',   
           hideAfter: 3500,   
           stack: 6   
       });
   
</script>
@endif
@if($errors->has('success'))
<script>
   $.toast({
       heading: 'Success',
       text: "{{ $errors->first('success') }}",
       position: 'top-right',
       loaderBg: '#fff',
       icon: 'success',
       hideAfter: 3500,
       stack: 6
   });
</script>
@endif