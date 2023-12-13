@extends('admin.layout.master')
@section('content')
<form  method="POST" action="{{ route('admin.city_guide_page.add') }}" enctype="multipart/form-data">
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
   <button class="btn btn-success me-1 mb-1 backButton float-end"  type="submit"><span class="fas fa-save"></span> 
      {{ $common['button'] }}
   </button>

   <div class="add_product add_product-effect-scale add_product-theme-1">
    
      <input type="radio" name="add_product" checked id="tab1" class="tab-content-first addProTab">
      <label for="tab1" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('General') }}"> <i
         class="icon-general"></i></label>

      <input type="radio" name="add_product" id="tab2" class="tab-content-2 addProTab">
      <label for="tab2" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('City Guide Slider Images') }}"><i
         class="icon-images"></i></label>

      {{-- <input type="radio" name="add_product" id="tab3" class="tab-content-3 addProTab">
      <label for="tab3" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('City Guide Locations') }}"><i
         class="icon-highlight"></i></label> --}}

      <!-- <input type="radio" name="add_product" id="tab4" class="tab-content-4 addProTab">
      <label for="tab4" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('City Guides') }}"><i
         class="icon-faq"></i></label>     -->    
      <ul>

         {{-- General Tab  --}}
         <li class="tab-content tab-content-first typography">
            <div class="col-lg-12">
               <div class="card mb-3">
                  <div class="card-body ">
                     <div class="row">
                        <h4 class="text-dark"> {{ translate('General') }}</h4>

                        <input id="" name="id" type="hidden" value="{{ $get_city_guide_page['id'] }}" />

                        
                       
                        {{-- <div class="col-md-6">
                           <label class="form-label" for="title">{{ translate('Main Title') }}<span
                              class="text-danger">*</span>
                           </label>
                           <input class="form-control {{ $errors->has('title.' . $lang_id) ? 'is-invalid' : '' }}"
                              placeholder="{{ translate('Main Title') }}" id="title" name="title[{{ $lang_id }}]"
                              type="text"
                              value="{{ getLanguageTranslate($get_city_guide_page_language, $lang_id, $get_city_guide_page['id'], 'title', 'city_guide_id') }}" />
                           @error('title.' . $lang_id)
                           <div class="invalid-feedback">
                              {{ $message }}
                           </div>
                           @enderror
                        </div>
                      
                        <div class="col-md-6">
                          <label class="form-label" for="title">{{ translate('Description') }} </label>
                          <textarea class="form-control  {{ $errors->has('description.' . $lang_id) ? 'is-invalid' : '' }} footer_text" placeholder="{{ translate('Enter Description') }}" id="title" name="description[{{ $lang_id }}]"> {{ getLanguageTranslate($get_city_guide_page_language, $lang_id, $get_city_guide_page['id'], 'description', 'city_guide_id') }}
                          </textarea>
                          @error('description.' . $lang_id)
                              <div class="invalid-feedback">
                                  {{ $message }}
                              </div>
                          @enderror
                        </div> --}}
                        
                        <div class="col-md-6">
                           <label class="form-label" for="location_heading">{{ translate('Location Heading') }}<span
                              class="text-danger">*</span>
                           </label>
                           <input class="form-control {{ $errors->has('location_heading.' . $lang_id) ? 'is-invalid' : '' }}"
                              placeholder="{{ translate('Location Heading') }}" id="location_heading" name="location_heading[{{ $lang_id }}]"
                              type="text"
                              value="{{ getLanguageTranslate($get_city_guide_page_language, $lang_id, $get_city_guide_page['id'], 'location_heading', 'city_guide_id') }}" />
                           @error('location_heading.' . $lang_id)
                           <div class="invalid-feedback">
                              {{ $message }}
                           </div>
                           @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label" for="title">{{ translate('Location Description') }} </label>
                            <textarea class="form-control  {{ $errors->has('location_description.' . $lang_id) ? 'is-invalid' : '' }} footer_text" placeholder="{{ translate('Enter Description') }}" id="title" name="location_description[{{ $lang_id }}]"> {{ getLanguageTranslate($get_city_guide_page_language, $lang_id, $get_city_guide_page['id'], 'location_description', 'city_guide_id') }}
                            </textarea>
                            @error('location_description.' . $lang_id)
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                          </div>
                       
                        
                        {{-- <div class="col-md-6 content_title">
                           <label class="form-label" for="duration_from">{{ translate('Banner Image') }}
                               <small>(792X450)</small> </label>
                           <div class="input-group mb-3">
                               <input class="form-control " type="file" name="image" aria-describedby="basic-addon2" onchange="loadFile(event,'image_banner')" id="image"/>
                   
                               <div class="invalid-feedback">
                               </div>
                           </div>
                           <div class="col-lg-3 mt-2">
                               <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                                   <div class="h-100 w-100  overflow-hidden position-relative">
                                       <img src="{{ $get_city_guide_page['image'] != '' ? asset('uploads/MediaPage/' . $get_city_guide_page['image']) : asset('uploads/placeholder/placeholder.png') }}" id="image_banner" width="100" alt="" />
                                   </div>
                               </div>
                           </div>
                        </div> --}}

                     </div>
                  </div>
               </div>
            </div>
         </li>

         {{-- City Guide silder  --}}           
         <li class="tab-content tab-content-2 typography">
            <div class="col-lg-12">
               <div class="card mb-3">
                  <div class="card-body ">
                     <div class="row">
                        <h4 class="text-dark">{{ translate('City Slider details') }}</h4>
                        <div class="colcss">
                            @php
                                $data = 0;
                            @endphp
                            @foreach ($get_slider_images as $LSI)
                                @include('admin.city_guide_page._slider_images')
                                @php
                                    $data++;
                                @endphp
                            @endforeach
                            @if (count($get_slider_images) == 0)
                                @include('admin.city_guide_page._slider_images')
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
         </li> 

          {{-- City Guide Locations  --}}
         {{-- <li class="tab-content tab-content-3 typography">
            <div class="col-lg-12">
               <div class="card mb-3">
                  <div class="card-body ">
                     <div class="row">
                        <h4 class="text-dark">{{ translate('Locations') }}</h4>
                        <div class="colcss">
                          @php
                             $data = 0;
                          @endphp
                             @foreach ($get_city_guide_page_locations as $LOCS)
                               @include('admin.city_guide_page._locations')
                               @php
                                 $data++;
                               @endphp
                             @endforeach
                           @if (empty($get_city_guide_page_locations))
                             @include('admin.city_guide_page._locations')
                           @endif
                           <div class="show_locations">
                           </div>
                           <div class="row">
                              <div class="col-md-12 add_more_button">
                                 <button class="btn btn-success btn-sm float-end" type="button" id="add_works"
                                    title='Add more'>
                                 <span class="fa fa-plus"></span> {{ translate('Add more') }}</button>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </li> --}}
         
      </ul>
   </div>
   
</form>

<script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replaceAll('footer_text');
</script>


<!-- How it Work -->
<script type="text/javascript">
   $(document).ready(function() {
       var count = 1;
       $('#add_works').click(function(e) {
   
           var ParamArr = {
               'view': 'admin.city_guide_page._locations',
               'data': count
           }
           getAppendPage(ParamArr, '.show_locations');
   
           e.preventDefault();
           count++;
       });
   
   
       $(document).on('click', ".delete_media", function(e) {
           var length = $(".delete_media").length;
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
              var length = $(".over_view_row").length;
              
                  var ParamArr = {
                      'view': 'admin.city_guide_page._slider_images',
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

@endsection