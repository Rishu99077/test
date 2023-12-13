@extends('admin.layout.master')
@section('content')
<form  method="POST" action="{{ route('admin.giftcard_page.add') }}" enctype="multipart/form-data">
   @csrf
   <ul class="breadcrumb">
      <li>
        <a href="#" style="width: auto;">
            <span class="text">{{ $common['language_title'] }} <img src="{{ url('uploads/language_flag', $common['language_flag']) }}" class="lang_img"></span>
        </a>
      </li>
      <li>
         <a href="#" style="width: auto;">
         <span class="text">{{ $common['title'] }}</span>
         </a>
      </li>
      <li>
         <a href="javascript:void(0)">
         {{ Session::get('TopMenu') }}
         </a>
      </li>
      <li>
         <a href="{{ route('admin.dashboard') }}">
         <span class="fa fa-home"></span>
         </a>
      </li>
   </ul>

   <a class="btn btn-falcon-primary  backButton float-end" href="javascript:void(0)" onclick="back()"
      type="button"><span class="fas fa-arrow-alt-circle-left text-primary "></span> {{ translate('Back') }}
   </a>
   <button class="btn btn-success me-1 mb-1 backButton float-end"  type="submit"><span
      class="fas fa-save"></span>
   {{ $common['button'] }}
   </button>

   <div class="add_product add_product-effect-scale add_product-theme-1">
      <input type="radio" name="add_product" checked id="tab1" class="tab-content-first addProTab">
      <label for="tab1" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('General') }}"> <i
         class="icon-general"></i></label>
      {{-- <input type="radio" name="add_product" id="tab2" class="tab-content-2 addProTab">
      <label for="tab2" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('Gift Card Slider Images') }}"><i
         class="icon-images"></i></label>    --}}
      <input type="radio" name="add_product" id="tab3" class="tab-content-3 addProTab">
      <label for="tab3" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('Gift Card Facilities') }}"><i
         class="icon-highlight"></i></label>
      <input type="radio" name="add_product" id="tab4" class="tab-content-4 addProTab">
      <label for="tab4" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('Gift Cards') }}"><i
         class="icon-faq"></i></label>        
      <ul>

         {{-- General Tab  --}}
         <li class="tab-content tab-content-first typography">
            <div class="col-lg-12">
               <div class="card mb-3">
                  <div class="card-body ">
                     <div class="row">
                        <input id="" name="id" type="hidden" value="{{ $get_giftcard_page['id'] }}" />
                     
                        <div class="row">
                          <h4 class="text-dark">{{ translate('Gift Card Page Slider details') }}</h4>
                          <div class="colcss">
                              @php
                                  $data = 0;
                              @endphp
                              @foreach ($get_slider_images as $LSI)
                                  @include('admin.gift_card_page._slider_images')
                                  @php
                                      $data++;
                                  @endphp
                              @endforeach
                              @if (count($get_slider_images) == 0)
                                  @include('admin.gift_card_page._slider_images')
                              @endif
                              <div class="show_overview">
                              </div>
                              <div class="row">
                                  <div class="col-md-12 add_more_button">
                                      <button class="btn btn-success btn-sm float-end" type="button"
                                          id="add_slider" title='Add more'>
                                          <span class="fa fa-plus"></span> {{ translate('Add more') }}</button>
                                  </div>
                              </div>
                          </div>
                        </div>

                     </div>
                  </div>
               </div>
            </div>
         </li>

         {{-- Gift Card silder  --}}           
         {{-- <li class="tab-content tab-content-2 typography">
            <div class="col-lg-12">
               <div class="card mb-3">
                  <div class="card-body ">
                     <div class="row">
                        <h4 class="text-dark">{{ translate('Gift Card Slider details') }}</h4>
                        <div class="col-md-12">
                           <div class="mb-3">
                              <label class="form-label" data-bs-toggle="tooltip" data-bs-placement="top"
                                 for="customFile">{{ translate('Slider Images') }} <small>(792X450)</small>
                              <span class="fas fa-info-circle"></span>
                              </label>
                              <div class="upload_img">
                                 <div class="uploader_file wrapper">
                                    <div class="drop">
                                       <div class="cont">
                                          <span class="image-file">
                                          <img src="{{ asset('assets/img/add-image.png') }}"
                                             class="img-fluid">
                                          </span>
                                          <div class="browse">
                                             <span class="upload-icon">
                                             <img src="{{ asset('assets/img/pro_upload.png') }}"
                                                class="img-fluid"></span>
                                             {{ translate('Drop your image here.or') }}
                                             <span class="browse_txt">{{ translate('Browse') }}</span>
                                          </div>
                                          <input id="files" id="files" multiple="true" name="files[]" type="file" />
                                       </div>
                                       <output id="list"></output>
                                       <div class="row appenImage"></div>
                                    </div>
                                 </div>
                                 @if (count($get_giftcard_page_slider_image) > 0)
                                 <?php $i = 1; ?>
                                 <div class="row">
                                    @foreach ($get_giftcard_page_slider_image as $key => $image)
                                    <div class='col-md-2'>
                                       <div class="image-item upload_img_list">
                                          <input type="hidden" name="image_id[]" value="{{ $image['id'] }}"> 
                                          <img src="{{ asset('uploads/GiftCardPage/' . $image['slider_images']) }}"
                                             alt="" width="20" title="">
                                          <div class="image_name_size">
                                             <input type="hidden" name="image_id[]" value="{{ $image['id'] }}">
                                          </div>
                                          <div class="image-item__btn-wrapper">
                                             <button type="button" class="btn btn-default remove btn-sm"
                                                data-count="{{ $i++ }}">
                                             <i class="fa fa-times" aria-hidden="true"></i>
                                             </button>
                                          </div>
                                       </div>
                                    </div>
                                    @endforeach
                                 </div>
                                 @endif
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </li> --}}

         {{-- Gift Card Facilities  --}}
         <li class="tab-content tab-content-3 typography">
            <div class="col-lg-12">
               <div class="card mb-3">
                  <div class="card-body ">
                     <div class="row">
                        <h4 class="text-dark">{{ translate('Facilities') }}</h4>
                        <div class="colcss">
                           @php
                              $data = 0;
                           @endphp
                           @foreach ($get_giftcard_page_facilities as $GPF)
                              @include('admin.gift_card_page._facilities')
                              @php
                                 $data++;
                              @endphp
                           @endforeach
                           @if (empty($get_giftcard_page_facilities))
                              @include('admin.gift_card_page._facilities')
                           @endif
                           <div class="show_works">
                           </div>
                           <div class="row">
                              <div class="col-md-12 add_more_button">
                                 <!-- <button class="btn btn-success btn-sm float-end" type="button" id="add_works"
                                    title='Add more'> <span class="fa fa-plus"></span> {{ translate('Add more') }}</button> -->
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </li>

         {{-- Gift Cards --}}
         <li class="tab-content tab-content-4 typography">
            <div class="col-lg-12">
               <div class="card mb-3">
                  <div class="card-body ">
                     <div class="row">
                        <h4 class="text-dark"> {{ translate('Gift Cards') }}</h4>
                        <div class="col-md-12">
                           <div class="mb-3">
                              <label class="form-label" data-bs-toggle="tooltip" data-bs-placement="top"
                                 for="customFile">{{ translate('Gift card Images') }} <small>(792X450)</small>
                              <span class="fas fa-info-circle"></span>
                              </label>
                              <div class="upload_img">
                                 <div class="uploader_file wrapper">
                                    <div class="drop">
                                       <div class="cont">
                                          <span class="image-file">
                                          <img src="{{ asset('assets/img/add-image.png') }}" class="img-fluid">
                                          </span>
                                          <div class="browse">
                                             <span class="upload-icon">
                                             <img src="{{ asset('assets/img/pro_upload.png') }}" class="img-fluid">
                                             </span>
                                             {{ translate('Drop your image here.or') }}
                                             <span class="browse_txt">{{ translate('Browse') }}</span>
                                          </div>
                                          <input id="files_2" id="files_2" multiple="true" name="files_2[]" type="file" />
                                       </div>
                                       <output id="list"></output>
                                       <div class="row appenImage_2"></div>
                                    </div>
                                 </div>
                                 @if (count($get_giftcard_page_card_image) > 0)
                                 <?php $i = 1; ?>
                                 <div class="row">
                                    @foreach ($get_giftcard_page_card_image as $key => $image)
                                    <div class='col-md-2'>
                                       <div class="image-item upload_img_list">
                                          <input type="hidden" name="image_id[]" value="{{ $image['id'] }}"> 
                                          <img src="{{ asset('uploads/GiftCardPage/' . $image['card_images']) }}"
                                             alt="" width="20" title="">
                                          <div class="image_name_size">
                                             <input type="hidden" name="image_id[]" value="{{ $image['id'] }}">
                                          </div>
                                          <div class="image-item__btn-wrapper">
                                             <button type="button" class="btn btn-default remove btn-sm"
                                                data-count="{{ $i++ }}">
                                             <i class="fa fa-times" aria-hidden="true"></i>
                                             </button>
                                          </div>
                                       </div>
                                    </div>
                                    @endforeach
                                 </div>
                                 @endif
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </li>
      </ul>
   </div>
   
</form>

<script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replaceAll('footer_text');
</script>

<!-- Slider Images -->
<script>
   $(document).ready(function() {
       if (window.File && window.FileList && window.FileReader) {
           $("#files").on("change", function(e) {
               var files = e.target.files,
                   filesLength = files.length;
               for (var i = 0; i < filesLength; i++) {
                   var f = files[i]
                   var fileReader = new FileReader();
                   fileReader.onload = (function(e) {
                       var file = e.target;
                       var html =
                           "<div class='col-md-2'><div class='image-item upload_img_list'>" +
                           "<img src=' " +
                           e.target.result + "' alt='' width='20' title='" + file.name +
                           "'>" + "<div class='image-item__btn-wrapper'>" +
                           "<button type='button' class='btn btn-default remove btn-sm'>" +
                           "<i class='fa fa-times' aria-hidden='true'></i>" +
                           "</button>" +
                           "</div>" +
                           "</div>" +
                           "</div>";
                       // $(html).insertAfter(".appenImage");
                       $(".appenImage").append(html);
                   });
                   fileReader.readAsDataURL(f);
               }
   
           });
       } else {
           alert("Your browser doesn't support to File API")
       }
       $(document).on("click", ".remove", function() {
           $(this).closest(".col-md-2").remove();
       });
   });
</script>

<!-- How it Work -->
<script type="text/javascript">
   $(document).ready(function() {
       var count = 1;
       $('#add_works').click(function(e) {
   
           var ParamArr = {
               'view': 'admin.gift_card_page._facilities',
               'data': count
           }
           getAppendPage(ParamArr, '.show_works');
   
           e.preventDefault();
           count++;
       });
   
   
       $(document).on('click', ".delete_faq", function(e) {
           var length = $(".delete_faq").length;
           if (length > 1) {
               deleteMsg('Are you sure to delete ?').then((result) => {
                   if (result.isConfirmed) {
                       $(this).parent().closest('.faq_div').remove();
                       e.preventDefault();
                   }
               });
           }
       });
   
   
   });
</script>

<!-- Slider Overview -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = 1;
            $('#add_slider').click(function(e) {
                var length = $(".over_view_row").length;
                
                    var ParamArr = {
                        'view': 'admin.gift_card_page._slider_images',
                        'data': count,
                    }
                    getAppendPage(ParamArr, '.show_overview');
                    e.preventDefault();
                    count++;
                
            });


            $(document).on('click', ".over_view_delete", function(e) {
                var length = $(".over_view_delete").length;
                if (length > 1) {
                    deleteMsg('Are you sure to delete ?').then((result) => {
                        if (result.isConfirmed) {
                            $(this).parent().closest('.over_view_row').remove();
                            e.preventDefault();
                        }
                    });
                }
            });


        });
    </script>


<!-- Gift Card Images -->
<script>
   $(document).ready(function() {
       if (window.File && window.FileList && window.FileReader) {
           $("#files_2").on("change", function(e) {
               var files = e.target.files,
                   filesLength = files.length;
               for (var i = 0; i < filesLength; i++) {
                   var f = files[i]
                   var fileReader = new FileReader();
                   fileReader.onload = (function(e) {
                       var file = e.target;
                       var html =
                           "<div class='col-md-2'><div class='image-item upload_img_list'>" +
                           "<img src=' " +
                           e.target.result + "' alt='' width='20' title='" + file.name +
                           "'>" + "<div class='image-item__btn-wrapper'>" +
                           "<button type='button' class='btn btn-default remove btn-sm'>" +
                           "<i class='fa fa-times' aria-hidden='true'></i>" +
                           "</button>" +
                           "</div>" +
                           "</div>" +
                           "</div>";
                       // $(html).insertAfter(".appenImage");
                       $(".appenImage_2").append(html);
                   });
                   fileReader.readAsDataURL(f);
               }
   
           });
       } else {
           alert("Your browser doesn't support to File API")
       }
       $(document).on("click", ".remove", function() {
           $(this).closest(".col-md-2").remove();
       });
   
   });
</script>

 <script type="text/javascript">
    $(document).ready(function() {

        $('input[name="add_product"]').each(function() {
            $(".typography").css("display", "none");

        })
        $("#tab1").addClass("addProTab");
        $("li.tab-content-first").css("display", "block")

        $(".addProTab").click(function() {
            var ClassName = $(this).removeClass("addProTab").attr("class");

            if ($(this).is(':checked') == true) {
                $('input[name="add_product"]').each(function() {
                    $(".typography").css("display", "none");
                    $(this).addClass("addProTab")
                })
                $("li." + ClassName).css("display", "block");
            }
        })
    });
</script>
@endsection