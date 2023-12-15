 <!-- Top Section -->
<?php
   $user_id = Session::get('em_user_id');
   $get_user = App\Models\Users::where('id', $user_id)->first();
?>
<section class="top_section">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-2">
            @if(Session::has('em_user_id'))
               <p class="text-light mt-2" ><i class="fa fa-user" aria-hidden="true"></i> {{$get_user['first_name']}} {{$get_user['last_name']}} </p>
            @endif   
         </div>
         <div class="col-md-9">
            <div class="usre_login_list">
               <ul>
                  @if (Session::has('em_user_id'))

                     @if($get_user['role']=='Company')
                        <li @if($common['title']=='My Staff') class="active" @endif> 
                           <a href="{{route('staffs')}}">My Staff</a> 
                        </li>
                     @endif
                     <li @if($common['title']=='My Request') class="active" @endif> 
                        <a href="{{route('my_request')}}">My Request</a> 
                     </li>
                     <li @if($common['title']=='My Profile') class="active" @endif> 
                        <a href="{{route('my_profile')}}">My Profile</a> 
                     </li>
                     <li @if($common['title']=='Friends') class="active" @endif> 
                        <a href="{{route('my_friends')}}">Friends List</a> 
                     </li>
                     <li @if($common['title']=='Home') class="active" @endif> 
                        <a href="{{route('logout')}}">Logout</a> 
                     </li>
                  @else
                     <li @if($common['title']=='Login') class="active" @endif> 
                        <a href="{{route('login')}}">Login</a> 
                     </li>
                     <li @if($common['title']=='Signup') class="active" @endif> 
                        <a href="{{route('signup')}}">Signup</a> 
                     </li>
                  @endif   
               </ul>
            </div>
         </div>
         <div class="col-md-1">
            <ul>
               <li>
                  <div id="google_translate_element"></div>
                  <div class="patti"></div>
                  <script type="text/javascript">
                     function googleTranslateElementInit() {
                       new google.translate.TranslateElement({pageLanguage: 'en',includedLanguages: 'en,zh,hi,es,fr,ar,ru,pt,in,de'}, 'google_translate_element');
                     }
                  </script>
                  <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
               </li>
            </ul>
         </div>
      </div>
   </div>
</section>
<!--Close Top Section -->


<!-- Header Section -->
<section class="header_section">
   <nav class="navbar navbar-expand-lg ">
      <div class="container">
         <div class="logo_img">
            <a class="navbar-brand" href="{{route('home')}}"><img src="{{ asset('frontassets/image/24_logo.png')}}" class="img-fluid"></a>
         </div>
         <button class="toggle_menu navbar-toggler" type="button" id="menu_toggle_btn" >
            <div class="bars" onclick="myFunction(this)">
               <div class="bar1"></div>
               <div class="bar2"></div>
               <div class="bar3"></div>
            </div>
         </button>
         <div class="mobile_toggle" id="header_menu">
            <ul class="header_nav navbar-nav">
               <li class="nav-item ">
                  <a class="nav-link active" aria-current="page" href="#">About Us</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="#">Contact Us</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="#">FAQ</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="#">Return Policy</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="#">Order Process</a>
               </li>
            </ul>
         </div>
      </div>
   </nav>
</section>

