<!-- Footer Section -->
      <section class="footer_section">
         <div class="container">
            <div class="row">
               <div class="col-xl-4 col-md-6 col-sm-6 col-12">
                  <div class="footer_menu footer_col1">
                     <img src="{{ asset('frontassets/image/footer-logo.png')}}" class="img-fluid">
                     <!-- <div class="footer_desc">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</div> -->
                  </div>
               </div>
               <div class="col-xl-2 col-md-6 col-sm-6 col-12">
                  <div class="footer_menu footer_col2">
                     <div class="footer_list white_txt">
                        <ul>
                           <li><a href="#">Home</a></li>
                           <li><a href="#">Listings </a></li>
                           <li><a href="#">Events </a></li>
                           <li><a href="#">Classifieds </a></li>
                           <li><a href="#">Articles </a></li>
                        </ul>
                     </div>
                  </div>
               </div>
               <div class="col-xl-2 col-md-6 col-sm-6 col-12">
                  <div class="footer_menu footer_col3">
                     <div class="footer_list white_txt">
                        <ul>
                           <li><a href="#">Deals </a></li>
                           <li><a href="#">Blog </a></li>
                           <li><a href="#">Advertise</a></li>
                           <li><a href="#">Contact Us </a></li>
                        </ul>
                     </div>
                  </div>
               </div>
               <div class="col-xl-4 col-md-6 col-sm-6 col-12">
                  <div class="footer_menu footer_col4">
                     <div class="footer_title">
                        <h4 class="white_txt">Contact Us</h4>
                     </div>
                     <div class="footer_list white_txt">
                        <ul>
                           <li>
                              <a>
                              <span>
                              <i class="fa fa-envelope-o" aria-hidden="true"></i>
                              </span>
                              info@24jecards.com
                              </a>
                           </li>
                           <li>
                              <a>
                              <span>
                              <i class="fa fa-phone" aria-hidden="true"></i>
                              </span>
                              +27633015168
                              </a>
                           </li>
                           <li>
                              <a>
                              <span><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                              TonGuy Platforms, 1 Memorial Lan, Craigavon Maroeladal, Johannesburg, South Africa
                              </a>
                           </li>
                        </ul>
                        <div class="footer_social_icon white_txt">
                           <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                           <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                           <a href="#"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a>
                           <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <section>
         <div class="copy_right">
            <p>Copyright © 2022 by 24J-Ecards the Good List All Rights Reserved.</p>
         </div>
      </section>
      <!--Close Footer Section -->
      <script src="{{ asset('frontassets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
      <script src="{{ asset('frontassets/js/jquery-3.6.0.min.js') }}"></script>
      <script src="{{ asset('frontassets/js/app.js') }}"></script>
      <script src="{{ asset('frontassets/OwlCarousel/dist/owl.carousel.js')}}"></script>
      <script src="{{ asset('frontassets/select2/select2.min.js') }}"></script>
      <script>
         jQuery('#home_slider').owlCarousel({
         loop: true,
         margin: 30,
         nav: false,
         dots:true,
         autoplay: true,
         autoplaySpeed: 3000,
         
         responsive: {
            0: {
               items: 1
            },
            600: {
               items: 1
            },
            1000: {
               items: 1
            }
         }
         });
      </script>
      <script src="{{ asset('frontassets/js/jquery-3.6.0.min.js') }}"></script>
      <script src="{{ asset('frontassets/js/bootstrap.bundle.js') }}"></script>


      <script type="text/javascript" src="{{ asset('frontassets/js/jquery.min.js') }}"></script>
      <script src="{{ asset('frontassets/js/notify.js') }}"></script>
      <script src="{{ asset('frontassets/js/notify.min.js') }}"></script>
      <script src="{{ asset('frontassets/js/alert.js') }}"></script>
      <script src="{{ asset('frontassets/select2\select2.min.js') }}"></script>

      <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

       @if ($errors->has('success'))
           <script>
               success_msg("{{ $errors->first('success') }}")
           </script>
       @endif
       @if ($errors->has('error'))
           <script>
               danger_msg("{{ $errors->first('error') }}");
           </script>
       @endif

      <script type="text/javascript">
         $('.select2').select2();
      </script>

      <script>

          function vcard_design(selector = ''){
              $('#StaffFormID').submit();
          }

          jQuery(document).ready(function() {

              $("body").on('click','#download_qr_code_id',function() {
                 
              });


              $("body").on('submit', '#StaffFormID', function() {
                var formData = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: "{{ url('card_design') }}",
                    data: formData,
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        jQuery('#ajax_loader').show();
                    },
                    success: function(response) {
                      jQuery('#ajax_loader').hide();
                      $('#get_card_resp').html(response.render_view);
                    }
                });
                return false;
             });

              $("body").on('click','.btn_list ul > li > button',function() {
                  //alert('dsddsds');
                  var get_status_type = $(this).attr('data-status');

                  $('#get_status_type').val(get_status_type);
                  console.log(get_status_type);

                  jQuery('#StaffFormID .form-group').removeClass('has-error');
                  jQuery('#StaffFormID .help-block').html('');
                  var InputForm = $('#StaffFormID')[0];
                  var formData = new FormData(InputForm);
                  $.ajax({
                    type: "POST",
                    url: "{{ url('my_staff/add') }}",
                    data: formData,
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        jQuery('#ajax_loader').show();
                    },
                    success: function(response) {
                          jQuery('#ajax_loader').hide();
                        if (response.error) {
                            jQuery.each(response.error, function(index, value) {
                                if (value != '') {
                                    jQuery('#Input-' + index).addClass('has-error');
                                    jQuery('#Input-' + index + ' .help-block').html(value);
                                }
                            });
                        } else {

                          /*if(response.download){
                              $('#download_qr_code_id').attr('href',response.qr_code_link);
                              setTimeout(function(){

                                  const data = response.qr_code_link;
                                  const link = document.getElementById('download_qr_code_id');
                                  link.setAttribute('href', data);
                                  link.setAttribute('download', response.qr_code_name); 
                                  link.click();

                              }, 1000);
                          }*/

                          success_msg("Data saved");
                          // $('#successs_msg').show();
                          // $('html, body').animate({ scrollTop: $("#successs_msg").offset().top-90 }, 3000);

                          setTimeout(function(){
                                window.location.href = response.url;
                          }, 2000);
                        }
                    }
                  });
                  return false;
              });


              function get_staff_img(input) {
                if (input.files && input.files[0]) {
                  var reader = new FileReader();
                  reader.onload = function(e) {
                    $('.staff_profile_img img').attr('src', e.target.result);
                    $('#get_avatar_img_url').val(e.target.result);
                    $('.staff_profile_img img').hide();
                    $('.staff_profile_img img').fadeIn(650);
                  }
                  reader.readAsDataURL(input.files[0]);
                }
              }

              $("body").on('change','#avatar_file_id',function() {
                get_staff_img(this);
              });

              function get_company_logo(input) {
                if (input.files && input.files[0]) {
                  var reader = new FileReader();
                  reader.onload = function(e) {
                    $('.staff_info img.company_logo').attr('src', e.target.result);
                    $('#get_company_logo_url').val(e.target.result);
                    $('.staff_info img.company_logo').hide();
                    $('.staff_info img.company_logo').fadeIn(650);
                  }
                  reader.readAsDataURL(input.files[0]);
                }
              }

              $("body").on('change','#company_logo_id',function() {
                get_company_logo(this);
              });
              

          });
      </script>

      <script>
          function doconfirm() {
              status = confirm("Do You want to delete");
              if (status == "false") {
                  return false;
              } else {
                  return true;
              }
          }

          $("body").on('click','.view_qr_link',function() {
            var get_qrcode = $(this).attr('data-qrcode');
            if(get_qrcode){
              jQuery('#qr-code-modal').modal("show");
              jQuery('#qr-code-modal #get_qrcode_input').val(get_qrcode);
            }
          });

          function qr_code_copy() {
            var copyText = document.getElementById("get_qrcode_input");
            copyText.select();
            copyText.setSelectionRange(0, 99999); // For mobile devices
            navigator.clipboard.writeText(copyText.value);
            //alert("Copied the text: " + copyText.value);
              $.toast({
             
                   heading: 'Success',
                   text: "Link Copied",
                   position: 'top-right',
                   loaderBg: '#fff',
                   icon: 'success',
                   hideAfter: 3500,
                   stack: 6
              });
          }
      </script>  

      <script type="text/javascript">
          $("body").on('click','.view_qr_link',function() {
            var get_qrcode = $(this).attr('data-qrcode');
            if(get_qrcode){
              jQuery('#qr-code-modal').modal("show");
              jQuery('#qr-code-modal #get_qrcode_input').val(get_qrcode);
            }
          });

          function qr_code_copy() {
            var copyText = document.getElementById("get_qrcode_input");
            copyText.select();
            copyText.setSelectionRange(0, 99999); // For mobile devices
            navigator.clipboard.writeText(copyText.value);
              success_msg("Link Copied");
          }
      </script>
        
   </body>
</html>