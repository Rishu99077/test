@extends('admin.layout.master')
@section('content')
<script
   src="https://maps.google.com/maps/api/js?key=AIzaSyCpqoRKJ3CM7GGiFWTEY0qCKYYRh00ULF0&libraries=places&callback=initAutocomplete"
   type="text/javascript"></script>
<form method="POST" enctype="multipart/form-data" action="{{ route('admin.tour_page.add') }}" id="add_home_page">
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
   <button class="btn btn-success me-1 mb-1 backButton float-end" type="submit"><span class="fas fa-save"></span>
   {{ $common['button'] }}
   </button>
   <div class="add_product add_product-effect-scale add_product-theme-1">
      <input type="radio" name="add_product" checked id="tab1" class="tab-content-first addProTab">
      <label for="tab1" data-bs-toggle="tooltip" data-bs-placement="right"
         title="{{ translate('Tour Banner') }}"> <i class="icon-general"></i></label>
      <input type="radio" name="add_product" id="tab2" class="tab-content-2 addProTab">
      <label for="tab2" data-bs-toggle="tooltip" data-bs-placement="right"
         title="{{ translate('Tour Slider') }}"><i class="icon-images"></i></label>
      {{-- <input type="radio" name="add_product" id="tab3" class="tab-content-3 addProTab">
      <label for="tab3" data-bs-toggle="tooltip" data-bs-placement="right"
         title="{{ translate('Middle Description') }}"><i class="icon-highlight"></i></label> --}}
      <input type="radio" name="add_product" id="tab4" class="tab-content-4 addProTab">
      <label for="tab4" data-bs-toggle="tooltip" data-bs-placement="right"
         title="{{ translate('Banner Overview') }}"><i class="icon-faq"></i></label>
      <ul>
      <ul>
         {{-- Banners --}}
         <li class="tab-content tab-content-first typography">
            <div class="col-lg-12">
               <div class="card mb-3">
                  <div class="card-body">
                     <h4 class="text-dark">{{ translate('Tour Banner') }}</h4>
                     <div class="row mb-4">
                        <div class="col-md-6 content_title">
                           <label class="form-label" for="duration_from">{{ translate('Side Banner') }}
                           <small>(350 × 780)</small> </label>
                           <div class="input-group mb-3">
                              <input class="form-control " type="file" name="side_banner"
                                 aria-describedby="basic-addon2"
                                 onchange="loadFile(event,'transfer_side_banner')" id="side_banner" />
                              <div class="invalid-feedback">
                              </div>
                           </div>
                           <div class="col-lg-3 mt-2">
                              <div
                                 class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                                 <div class="h-100 w-100  overflow-hidden position-relative">
                                    <img src="{{ isset($MetaGlobalSideBanner['image']) && $MetaGlobalSideBanner['image'] != '' ? asset('uploads/side_banner/' . $MetaGlobalSideBanner['image']) : asset('uploads/placeholder/placeholder.png') }}"
                                       id="transfer_side_banner" width="100" alt="" />
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        @php
                        $banner_title = App\Models\BannerOverviewLanguage::where(['page' => 'tour_banner', 'langauge_id' => $lang_id])->first()->title ?? '';
                        @endphp
                        <!-- Client ne hatwya hai  -->
                        {{-- <div class="col-md-6">
                           <label class="form-label" for="title">{{ translate('Main Title') }}<span
                              class="text-danger">*</span>
                           </label>
                           <input
                              class="form-control {{ $errors->has('banner_title.' . $lang_id) ? 'is-invalid' : '' }}"
                              placeholder="{{ translate('Main Title') }}" id="banner_title"
                              name="banner_title[{{ $lang_id }}]" type="text"
                              value="{{ $banner_title }}" />
                           @error('banner_title.' . $lang_id)
                           <div class="invalid-feedback">
                              {{ $message }}
                           </div>
                           @enderror
                        </div>
                        @php
                        $banner_description = App\Models\BannerOverviewLanguage::where(['page' => 'tour_banner', 'langauge_id' => $lang_id])->first()->description ?? '';
                        @endphp
                        <div class="col-md-6">
                           <label class="form-label" for="title">{{ translate('Description') }}
                           <span class="text-danger">*</span>
                           </label>
                           <input
                              class="form-control {{ $errors->has('banner_title.' . $lang_id) ? 'is-invalid' : '' }}"
                              placeholder="{{ translate('Description') }}" id="banner_description"
                              name="banner_description[{{ $lang_id }}]" type="text"
                              value="{{ $banner_description }}" />
                           @error('banner_description.' . $lang_id)
                           <div class="invalid-feedback">
                              {{ $message }}
                           </div>
                           @enderror
                        </div> --}}
                        {{-- 
                        <div class="col-md-6 content_title">
                           <label class="form-label" for="duration_from">{{ translate('Image') }}
                           <small>(792X450)</small> </label>
                           <div class="input-group mb-3">
                              <input class="form-control " type="file" name="tour_banner"
                                 aria-describedby="basic-addon2" onchange="loadFile(event,'upload_work_logo')"
                                 id="top_destination_image" />
                              <div class="invalid-feedback">
                              </div>
                           </div>
                           <div class="col-lg-3 mt-2">
                              <input type="hidden" name="already_work_image[]" value="">
                              <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                                 <div class="h-100 w-100  overflow-hidden position-relative">
                                    <img src="{{ @$banner_img['image'] != '' ? asset('uploads/tour_banner/banner_overview/' . @$banner_img['image']) : asset('uploads/placeholder/placeholder.png') }}"
                                       id="upload_work_logo" width="100" alt="" />
                                 </div>
                              </div>
                           </div>
                        </div>
                        --}}
                     </div>
                  </div>
               </div>
            </div>
         </li>
         {{-- Banners End --}}
         {{-- Tour Page silder  --}}
         <li class="tab-content tab-content-2 typography">
            <div class="col-lg-12">
               <div class="card mb-3">
                  <div class="card-body ">
                     <div class="row">
                        <h4 class="text-dark">{{ translate('Tour Page Slider details') }}</h4>
                        <div class="colcss">
                           @php
                           $data = 0;
                           @endphp
                           @foreach ($get_slider_images as $LSI)
                           @include('admin.tour_page._slider_images')
                           @php
                           $data++;
                           @endphp
                           @endforeach
                           @if (count($get_slider_images) == 0)
                           @include('admin.tour_page._slider_images')
                           @endif
                           <div class="show_image">
                           </div>
                           <div class="row">
                              <div class="col-md-12 add_more_button">
                                 <button class="btn btn-success btn-sm float-end" type="button"
                                    id="add_slider" title='Add more'>
                                 <span class="fa fa-plus"></span>
                                 {{ translate('Add more') }}</button>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </li>
         {{-- Middle Discription  --}}
         
          {{-- <li class="tab-content tab-content-3 typography">
            <div class="col-lg-12">
               <div class="card mb-3">
                  <div class="card-body ">
                     <h4 class="text-dark">{{ translate('Middle Description') }}</h4>
                     <div class="row">
                        <div class="col-md-12">
                           <label class="form-label" for="title">{{ translate('Link') }}
                           <span class="text-danger">*</span>
                           </label>
                           <input class="form-control" placeholder="{{ translate('Link') }}"
                              id="city_guide_link" name="city_guide_link" type="text"
                              value="{{ $LodgeTour->link ?? '' }}" />
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <label class="form-label" for="title">{{ translate('Description') }}<span
                              class="text-danger">*</span>
                           </label>
                           <textarea class="form-control extra" placeholder="{{ translate('Enter Option Note') }}"
                              name="tour_description[{{ $lang_id }}]"> @if (array_key_exists($lang_id, $LodgeTourLanguage))
                            {!! $LodgeTourLanguage[$lang_id] !!}
                            @endif
                            </textarea>
                           @error('tour_description.' . $lang_id)
                           <div class="invalid-feedback">
                              {{ $message }}
                           </div>
                           @enderror
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </li> --}}

         {{-- Middle Discription End --}}
         {{-- Best Selling --}}
         <li class="tab-content tab-content-4 typography">
            <div class="col-lg-12">
               <div class="card mb-3">
                  <div class="card-body">
                     <h4 class="text-dark">{{ translate('Best Selling') }}</h4>
                     <div class="row">
                        <div class="col-md-6">
                           <label class="form-label" for="title">{{ translate('Heading') }}
                           <span class="text-danger">*</span>
                           </label>
                           <input class="form-control" placeholder="{{ translate('Heading') }}"
                              id="best_selling_heading"
                              name="best_selling_heading[{{ $lang_id }}]" type="text"
                              value="{{ array_key_exists($lang_id, $MetaGlobalLanguageBEST_SELLING) ? $MetaGlobalLanguageBEST_SELLING[$lang_id] : '' }}" />
                           @error('best_selling_heading.' . $lang_id)
                           <div class="invalid-feedback">
                              {{ $message }}
                           </div>
                           @enderror
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </li>
         {{-- Best Selling End --}}
      </ul>
   </div>
</form>
<script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script>
   CKEDITOR.replaceAll('extra');
</script>
<script type="text/javascript">
   google.maps.event.addDomListener(window, 'load', initialize);
   
   function initialize() {
       var input = document.getElementsByClassName('location');
       $(input).each(function(index) {
           var id = $(this).attr('id');
           var input_ = document.getElementById(id);
           var autocomplete = new google.maps.places.Autocomplete(input_);
           autocomplete.addListener('place_changed', function() {
               var place = autocomplete.getPlace();
           });
       });
   
   }
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
<!-- Slider Overview -->
<script type="text/javascript">
   $(document).ready(function() {
       var count = 1;
       $('#add_slider').click(function(e) {
           var length = $(".over_image_row").length;
   
           var ParamArr = {
               'view': 'admin.tour_page._slider_images',
               'data': count,
           }
           getAppendPage(ParamArr, '.show_image');
           e.preventDefault();
           count++;
   
       });
   
   
       $(document).on('click', ".over_image_delete", function(e) {
           var length = $(".over_image_delete").length;
           if (length > 1) {
               deleteMsg('Are you sure to delete ?').then((result) => {
                   if (result.isConfirmed) {
                       $(this).parent().closest('.over_image_row').remove();
                       e.preventDefault();
                   }
               });
           }
       });
   
   
   });
</script>
<!-- Slider Images -->
@endsection