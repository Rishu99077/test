@extends('admin.layout.master')
@section('content')
<script
   src="https://maps.google.com/maps/api/js?key=AIzaSyCpqoRKJ3CM7GGiFWTEY0qCKYYRh00ULF0&libraries=places&callback=initAutocomplete"
   type="text/javascript"></script>
<style>
   .new_class {
   background-color: #fff;
   border-radius: 10px;
   }
   .duration-box {
   overflow: hidden;
   }
   .duration-updown {
   display: none !important;
   }
   .material-icons {
   display: none !important;
   }
   .mybox {
   background: #f1f6f9;
   padding: 10px;
   border-radius: 7px;
   margin-right: 10px;
   margin-bottom: 10px;
   }
</style>
<form method="post" id="add_product" enctype="multipart/form-data" action="">
   @csrf
   <ul class="breadcrumb">
      <li>
         <a href="#" style="width: auto;">
         <span class="text">{{ $common['language_title'] }} <img
            src="{{ url('uploads/language_flag', $common['language_flag']) }}" class="lang_img"></span>
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
   <button class="btn btn-success me-1 mb-1 backButton float-end" href="javascript:void(0)" id="add_product_btn"
      type="submit"><span class="fas fa-save"></span>
   {{ $common['button'] }}
   </button>
   @if ($get_product['id'] !== '' && $get_product['status'] !== 'Deactive')
   <a class="btn btn-primary me-1 mb-1 backButton float-end" target="_blank"
      href="{{ env('APP_URL') }}golf-club/{{ $get_product['slug'] }}" id="add_product_btn" type="submit"><span
      class="fas fa-globe"></span>
   {{ translate('Product View') }}
   </a>
   @endif
   <div class="add_product add_product-effect-scale add_product-theme-1">
      {{-- General Tab --}}
      <input type="radio" name="add_product" checked id="tab1" class="tab-content-first addProTab">
      <label for="tab1" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('General') }}"> <i
         class="icon-general"></i></label>

      {{-- General Tab --}}
      <input type="radio" name="add_product" id="tab2" class="tab-content-2 addProTab">
      <label for="tab2" data-bs-toggle="tooltip" data-bs-placement="right"
         title="{{ translate('Highlight') }}"><i class="icon-highlight"></i></label>

      <input type="radio" name="add_product" id="tab3" class="tab-content-3 addProTab">
      <label for="tab3" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('Timing') }}"><i
         class="icon-time"></i></label>

      <input type="radio" name="add_product" id="tab5" class="tab-content-5 addProTab">
      <label for="tab5" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('Images') }}"><i
         class="icon-images"></i></label>

      <input type="radio" name="add_product" id="tab7" class="tab-content-7 addProTab">
      <label for="tab7" data-bs-toggle="tooltip" data-bs-placement="right"
         title="{{ translate('Site Advertisement') }}"><i class="icon-adver"></i></label>

      <input type="radio" name="add_product" id="tab8" class="tab-content-8 addProTab">
      <label for="tab8" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('Extras') }}"><i
         class="icon-extra"></i></label>

      <input type="radio" name="add_product" id="tab14" class="tab-content-14 addProTab">
      <label for="tab14" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('Hotels') }}"><i
         class="icon-ring"></i></label>

      <input type="radio" name="add_product" id="tab17" class="tab-content-17 addProTab">
      <label for="tab17" data-bs-toggle="tooltip" data-bs-placement="right"
         title="{{ translate('Request Pop-up') }}"><i class="icon-group"></i></label>

      <input type="radio" name="add_product" id="tab15" class="tab-content-15 addProTab">
      <label for="tab15" data-bs-toggle="tooltip" data-bs-placement="right"
         title="{{ translate('Rooms') }}"><i class="icon-ring"></i></label>

      <input type="radio" name="add_product" id="tab19" class="tab-content-19 addProTab">
      <label for="tab19" data-bs-toggle="tooltip" data-bs-placement="right"
         title="{{ translate('Expirence Icon Header') }}"><i class="icon-option"></i></label>

      <input type="radio" name="add_product" id="tab20" class="tab-content-20 addProTab">
      <label for="tab20" data-bs-toggle="tooltip" data-bs-placement="right"
         title="{{ translate('Experience Icon Middle') }}"><i class="icon-option"></i></label>

      <input type="radio" name="add_product" id="tab6" class="tab-content-6 addProTab">
      <label for="tab6" data-bs-toggle="tooltip" data-bs-placement="right"
         title="{{ translate('Product Pop-up') }}"><i class="icon-images"></i></label>

      <input type="radio" name="add_product" id="tab16" class="tab-content-16 addProTab">
      <label for="tab16" data-bs-toggle="tooltip" data-bs-placement="right"
         title="{{ translate('Time Slot') }}"><i class="icon-time"></i></label>    

      <input type="radio" name="add_product" id="tab18" class="tab-content-18 addProTab">
        <label for="tab18" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('Related Products') }}"><i class="icon-car"></i></label>   
      <ul>
         {{-- General Tab  Detail Start --}}
         <li class="tab-content tab-content-first typography">
            <div class="row">
               <input id="" name="id" type="hidden" value="{{ $get_product['id'] }}" />
               <div class="col-lg-8  col-md-8 colcss">
                  <div class="row">
                     <div class="col-md-6">
                        <label class="form-label" for="title">{{ translate('Golf Title') }}<span
                           class="text-danger">*</span>
                        </label>
                        <input
                           class="form-control {{ $errors->has('title.' . $lang_id) ? 'is-invalid' : '' }}"
                           placeholder="{{ translate('Title') }}" id="title_{{ $lang_id }}"
                           name="title[{{ $lang_id }}]" type="text"
                           value="{{ old('title.' . $lang_id, getLanguageTranslate($get_product_language, $lang_id, $get_product['id'], 'description', 'product_id')) }}" />
                        <div class="invalid-feedback">
                        </div>
                     </div>
                     <div class="col-md-6">
                        <label class="form-label" for="price">{{ translate('Short Description') }}<span
                           class="text-danger">*</span>
                        </label>
                        <textarea class="form-control {{ $errors->has('short_description.' . $lang_id) ? 'is-invalid' : '' }}" rows="8"
                           id="short_description_{{ $lang_id }}" name="short_description[{{ $lang_id }}]"
                           placeholder="{{ translate('Short Description') }}">{{ getLanguageTranslate($get_product_language, $lang_id, $get_product['id'], 'short_description', 'product_id') }}</textarea>
                        <div class="invalid-feedback">
                        </div>
                     </div>
                     <div class="col-md-12">
                        <label class="form-label" for="price">{{ translate('Golf Description') }}
                        </label>
                        <textarea class="form-control footer_text {{ $errors->has('main_description.' . $lang_id) ? 'is-invalid' : '' }}"
                           rows="8" id="main_description" name="main_description[{{ $lang_id }}]"
                           placeholder="{{ translate('Description') }}">{{ getLanguageTranslate($get_product_language, $lang_id, $get_product['id'], 'main_description', 'product_id') }}</textarea>
                        @error('main_description.' . $lang_id)
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror
                     </div>
                     <div class="col-md-4 content_title ">
                        <label class="form-label" for="price">{{ translate('Country') }}
                        <span class="text-danger">*</span>
                        </label>
                        <select
                           class="form-select single-select country  {{ $errors->has('country') ? 'is-invalid' : '' }}"
                           name="country" id="country" onchange="getStateCity('country')">
                           <option value="">{{ translate('Select Country') }}</option>
                           @foreach ($country as $C)
                           <option value="{{ $C['id'] }}"
                           {{ getSelected($C['id'], old('country', $get_product['country'])) }}>
                           {{ $C['name'] }}
                           </option>
                           @endforeach
                        </select>
                        <div class="invalid-feedback">
                        </div>
                     </div>
                     <div class="col-md-4">
                        <label class="form-label" for="title">{{ translate('State') }}<span
                           class="text-danger">*</span>
                        </label>
                        <select
                           class="single-select form-control {{ $errors->has('state') ? 'is-invalid' : '' }}"
                           name="state" id="state" onchange="getStateCity('state')">
                           <option value="">{{ translate('Select State') }}</option>
                        </select>
                        @error('state')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror
                     </div>
                     <div class="col-md-4">
                        <label class="form-label" for="title">{{ translate('City') }}<span
                           class="text-danger">*</span>
                        </label>
                        <select
                           class="single-select form-control {{ $errors->has('city') ? 'is-invalid' : '' }}"
                           name="city" id="city">
                           <option value="">{{ translate('Select City') }}</option>
                        </select>
                        @error('city')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror
                     </div>
                     <div class="col-md-6 content_title">
                        <label class="form-label" for="duration_from">{{ translate('Upload Logo') }}
                        <small>(792X450)</small> </label>
                        <div class="input-group mb-3">
                           <input class="form-control " type="file" name="logo"
                              aria-describedby="basic-addon2" onchange="loadFile(event,'upload_logo')"
                              id="logo" />
                           <div class="invalid-feedback">
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6 content_title">
                        <label class="form-label"
                           for="duration_from">{{ translate('Upload Video Thumbnail') }}
                        <small>(792X450)</small> </label>
                        <div class="input-group mb-3">
                           <input class="form-control " type="file" name="video_thumbnail"
                              aria-describedby="basic-addon2" onchange="loadFile(event,'video_thumbnail')"
                              id="video_thumbnail_img" />

                           <input type="hidden" name="video_thumbnail_dlt"
                                            value="{{ $get_product['video_thumbnail'] }}">    

                           <div class="invalid-feedback">
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6 content_title">
                        <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                           <div class="h-100 w-100  overflow-hidden position-relative">
                              <img src="{{ $get_product['logo'] != '' ? asset('uploads/product_images/' . $get_product['logo']) : asset('uploads/placeholder/placeholder.png') }}"
                                 id="upload_logo" width="100" alt="" />
                           </div>
                        </div>
                     </div>

                     <div class="col-md-6 content_title imgs_div img-thumbnail-preview" style="display:none;">   
                        <div>
                            <button class="delete_thumbnail bg-card btn btn-danger btn-sm float-end"
                                type="button"><span class="fa fa-trash"></span></button>
                        </div>

                        <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                           <div class="h-100 w-100  overflow-hidden position-relative">
                              <img src="{{ $get_product['video_thumbnail'] != '' ? asset('uploads/product_images/' . $get_product['video_thumbnail']) : asset('uploads/placeholder/placeholder.png') }}"
                                 id="video_thumbnail" width="100" alt="" />
                           </div>
                        </div>
                     </div>
                  
                     <div class="col-md-6 content_title">
                        <label class="form-label" for="title">{{ translate('Video') }}
                        </label>
                        <input class="form-control {{ $errors->has('video') ? 'is-invalid' : '' }}"
                           id="Video" name="video" type="text"
                           value="{{ $get_product['video'] }}"
                           placeholder="{{ translate('Enter video url') }}" />
                        <div class="invalid-feedback">
                        </div>
                     </div>
                  
                     <div class="col-md-6 content_title">
                        <label class="form-label" for="title">{{ translate('Blackout Dates') }}
                        </label>
                        <input class="form-control  blackout_date" id="blackout_date" name="blackout_date"
                           type="text" placeholder="Y-m-d" value="" />
                        <div class="invalid-feedback">
                        </div>
                     </div>

                     <div class="col-md-4 content_title">
                        <label class="form-label"
                           for="duration_from">{{ translate('Number of Holes') }}</label>
                        <div class="input-group mb-3">
                           <input class="form-control numberonly" type="text" name="holes"
                              placeholder="{{ translate('Holes') }}"
                              value="{{ old('holes', $get_product['holes']) }}"
                              aria-describedby="basic-addon2" id="holes" />
                           <div class="invalid-feedback">
                           </div>
                        </div>
                     </div>

                     <div class="col-md-4 content_title">
                        <label class="form-label" for="duration_from">{{ translate('Pars') }}</label>
                        <div class="input-group mb-3">
                           <input class="form-control numberonly" type="text" name="pars"
                              placeholder="{{ translate('Pars') }}"
                              value="{{ old('pars', $get_product['pars']) }}"
                              aria-describedby="basic-addon2" id="pars" />
                           <div class="invalid-feedback">
                           </div>
                        </div>
                     </div>
                     <div class="col-md-4 content_title">
                        <label class="form-label" for="duration_from">{{ translate('Yards') }}</label>
                        <div class="input-group mb-3">
                           <input class="form-control numberonly" type="text" name="yards"
                              placeholder="{{ translate('Yard') }}"
                              value="{{ old('yard', $get_product['yards']) }}"
                              aria-describedby="basic-addon2" id="yard" />
                           <div class="invalid-feedback">
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6 content_title">
                        <label class="form-label"
                           for="duration_from">{{ translate('How Many Are Sold') }}</label>
                        <div class="input-group mb-3">
                           <input class="form-control numberonly" type="text" name="how_many_are_sold"
                              placeholder="{{ translate('How Many Are Sold') }}"
                              value="{{ old('how_many_are_sold', $get_product['how_many_are_sold']) }}"
                              aria-describedby="basic-addon2" id="how_many_are_sold" />
                           <div class="invalid-feedback">
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6 content_title">
                        <label class="form-label" for="title">{{ translate('Not On Sale') }}</label>
                        <input class="form-control datetimepicker note_on_sale_date" id="note_on_sale_date"
                           name="note_on_sale_date" type="text" placeholder="Y-m-d"
                           value="{{ $get_product['note_on_sale_date'] }}" />
                        <div class="invalid-feedback">
                        </div>
                     </div>
                     <div class="col-md-12 content_title">
                        <label class="form-label" for="title">{{ translate('Address') }}
                        <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" rows="3" cols="50"
                           placeholder="{{ translate('Enter Location') }}" id="input_store_address_id" name="address">{{ old('address', $get_product['address']) }}</textarea>
                        <input type="hidden" name="address_lattitude" id="address_lattitude"
                           class="form-control" value="{{ $get_product['address_lattitude'] }}">
                        <input type="hidden" name="address_longitude" id="address_longitude"
                           class="form-control" value="{{ $get_product['address_longitude'] }}">
                        <div class="invalid-feedback">
                        </div>
                     </div>

                     <h5 class="text-black mt-2 fw-semi-bold fs-0">{{ translate('Golf Tooltip') }}</h5>
                     <div class="row add_info_row mb-2">

                        <div class="col-md-6">
                           <label class="form-label" for="rantel_tip">{{ translate('Rantel set tip') }}<span class="text-danger">*</span>
                           </label>
                           <input class="form-control {{ $errors->has('rantel_tip.' . $lang_id) ? 'is-invalid' : '' }}"
                           placeholder="{{ translate('Rantel set tip') }}" id="rantel_tip_{{ $lang_id }}"
                           name="rantel_tip[{{ $lang_id }}]" type="text"
                           value="{{ old('rantel_tip.' . $lang_id, getLanguageTranslate($get_product_language, $lang_id, $get_product['id'], 'rantel_tip', 'product_id')) }}" />
                           <div class="invalid-feedback">
                           </div>
                        </div>

                        <div class="col-md-6">
                           <label class="form-label"
                              for="transfer_tip">{{ translate('Transfer tip') }}<span class="text-danger">*</span>
                           </label>
                           <input class="form-control {{ $errors->has('transfer_tip.' . $lang_id) ? 'is-invalid' : '' }}"
                           placeholder="{{ translate('Transfer tip') }}" id="transfer_tip_{{ $lang_id }}"
                           name="transfer_tip[{{ $lang_id }}]" type="text"
                           value="{{ old('transfer_tip.' . $lang_id, getLanguageTranslate($get_product_language, $lang_id, $get_product['id'], 'transfer_tip', 'product_id')) }}" />
                           <div class="invalid-feedback">
                           </div>
                        </div>

                     </div>


                     <h5 class="text-black mt-2 fw-semi-bold fs-0">{{ translate('Additional Information') }}
                     </h5>
                     <div class="row mb-2">
                        <div class="col-md-6">
                           <label class="form-label"
                              for="additional_heading">{{ translate('Additional information') }}<span
                              class="text-danger">*</span>
                           </label>
                           <input
                              class="form-control {{ $errors->has('additional_heading.' . $lang_id) ? 'is-invalid' : '' }}"
                              placeholder="{{ translate('Title') }}"
                              id="additional_heading{{ $lang_id }}"
                              name="additional_heading[{{ $lang_id }}]" type="text"
                              value="{{ old('additional_heading.' . $lang_id, getLanguageTranslate($additional_heading, $lang_id, 'heading_title', 'title', 'meta_title')) }}" />
                           <div class="invalid-feedback">
                           </div>
                        </div>
                     </div>
                     <div class="add_info_row">
                        @php
                        $data = 0;
                        @endphp
                        @foreach ($get_product_additional_info as $GPAI)
                        @include('admin.product.golf._info')
                        @php
                        $data++;
                        @endphp
                        @endforeach
                        @if (empty($get_product_highlight))
                        @include('admin.product.golf._info')
                        @endif
                        <div class="row">
                           <div class="show_info">
                           </div>
                           <div class="col-md-12 add_more_button mt-3">
                              <button class="btn btn-success btn-sm float-end" type="button"
                                 id="add_info" title='Add more'> <span class="fa fa-plus"></span>
                              {{ translate('Add More') }}</button>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               {{-- Divide Row --}}
               <div class="col-lg-4 col-md-4 colcss content_title">
                  <div class="row">
                     <div class="col-md-12 content_title">
                        <div class="form-check form-switch pl-0">
                           <input class="form-check-input float-end excertion_status "
                           {{ getChecked('Active', old('excertion_status', $get_product['status'])) }}
                           id="excertion_status" type="checkbox" value="Active"
                           name="excertion_status">
                           <label class="form-check-label form-label"
                              for="excertion_status">{{ translate('Status') }}
                           </label>
                        </div>
                     </div>
                     <div class="col-md-12 content_title">
                        <label class="form-label" for="title">{{ translate('Availability') }} </label>
                        <div class="input-group mb-3">
                           <input class="form-control" type="text" name="availability"
                              placeholder="{{ translate('Availability') }}"
                              value="{{ old('availability', $get_product['availability']) }}"
                              aria-describedby="basic-addon2" id="availability" />
                           <div class="invalid-feedback"></div>
                        </div>
                     </div>
                     @if (check_table_count('user_review', $get_product['id'], 'product_id') == 0)
                     <div class="col-md-12 content_title">
                        <label class="form-label" for="title">{{ translate('Review Rating') }}
                        </label>
                        <div class="input-group mb-3">
                           <select name="rating" class="form-control">
                           <option value="1"
                           {{ $get_product['random_rating'] == 1 ? 'selected' : '' }}>1</option>
                           <option value="2"
                           {{ $get_product['random_rating'] == 2 ? 'selected' : '' }}>2</option>
                           <option value="3"
                           {{ $get_product['random_rating'] == 3 ? 'selected' : '' }}>3</option>
                           <option value="4"
                           {{ $get_product['random_rating'] == 4 ? 'selected' : '' }}>4</option>
                           <option value="5"
                           {{ $get_product['random_rating'] == 5 ? 'selected' : '' }}>5</option>
                           </select>
                        </div>
                     </div>
                     @endif
                     <div class="col-md-12 content_title pro_status">
                        <label class="form-label" for="price">{{ translate('Golf Type') }}</label>
                        <div class="input-group mb-3">
                           <input class="form-control" type="text" name="golf_type"
                              placeholder="{{ translate('Golf Type') }}"
                              value="{{ old('golf_type', $get_product['excursion_type']) }}"
                              aria-describedby="basic-addon2" id="golf_type" />
                           <div class="invalid-feedback">
                           </div>
                        </div>
                     </div>
                     <div class="col-md-12 content_title pro_status">
                        <label class="form-label" for="price">{{ translate('Golf Information') }}
                        </label>
                        <div class="input-group mb-3">
                           <textarea class="form-control" type="text" name="product_info[golf_type]"
                              placeholder="{{ translate('Golf Information') }}" aria-describedby="basic-addon2" id="golf_typr">{{ old('product_info.golf_typr', getAllInfo('product_info', ['title' => 'golf_type', 'product_id' => $get_product['id']], 'value')) }}</textarea>
                           <div class="invalid-feedback">
                           </div>
                        </div>
                     </div>
                     <?php
                        $get_transportation_vehicle = [];
                        if (isset($get_product['transportation_vehicle'])) {
                            if (!empty($get_product['transportation_vehicle']) and $get_product['transportation_vehicle']) {
                                $get_transportation_vehicle = explode(',', $get_product['transportation_vehicle']);
                            }
                        }
                        ?>
                     <div class="col-md-12 content_title pro_status" style="display: none;">
                        <label class="form-label"
                           for="transportation_vehicle">{{ translate('Transportation Vehicle') }}</label>
                        <div class="form-check form-switch pl-0">
                           <select class="multi-select" name="transportation_vehicle[]" multiple="multiple">
                              <?php foreach ($transportation_vehicle as $key => $value) { ?>
                              <option value="{{ $value->id }}" <?php if (in_array($value->id, $get_transportation_vehicle)) {
                                 echo 'selected="selected"';
                                 } ?>>{{ $value->title }}
                              </option>
                              <?php } ?>
                           </select>
                           <div class="invalid-feedback">
                           </div>
                        </div>
                     </div>
                     <div class="col-md-12 content_title mt-3">
                        <div class="form-check form-switch pl-0">
                           <input class="form-check-input float-end "
                           name="product_setting[add_to_recom_tours]" id="recom_tours" type="checkbox"
                           {{ getChecked('on', old('product_setting.add_to_recom_tours', getProductSetting('golf', $get_product['id'], 'add_to_recom_tours'))) }}>
                           <label class="form-check-label form-label"
                              for="recom_tours">{{ translate('Add to recommended tours') }}
                           </label>
                        </div>
                     </div>
                     <div class="col-md-12 content_title mt-3">
                        <div class="form-check form-switch pl-0">
                           <input class="form-check-input float-end "
                           name="product_setting[recom_tours_main_page_big_picture]"
                           id="recom_tours_main_page_big_picture" type="checkbox"
                           {{ getChecked('on', old('product_setting.recom_tours_main_page_big_picture', getProductSetting('golf', $get_product['id'], 'recom_tours_main_page_big_picture'))) }}>
                           <label class="form-check-label form-label w-90"
                              for="recom_tours_main_page_big_picture">{{ translate('Add to Recommended main tour in main page the big picture') }}
                           </label>
                        </div>
                     </div>
                     <div class="col-md-12 content_title {{ getProductSetting('golf', $get_product['id'], 'recom_tours_main_page_big_picture') != 'on' ? 'd-none' : '' }}"
                        id="recom_big_div">
                        <label class="form-label"
                           for="duration_from">{{ translate('Recommended Tours Big Pictures') }}
                        <small>(600×400)</small> </label>
                        <div class="input-group mb-3">
                           <input class="form-control " type="file" name="recom_big_pic"
                              aria-describedby="basic-addon2" onchange="loadFile(event,'recom_big_pic_pre')"
                              id="recom_big_pic" />
                           <div class="invalid-feedback">
                           </div>
                        </div>
                        <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls"
                           style="width: 200px; height: 100px;">
                           <div class="h-100 w-100  overflow-hidden position-relative">
                              <img src="{{ $get_product['recommend_pic'] != '' ? asset('uploads/product_images/recom_big_pic/' . $get_product['recommend_pic']) : asset('uploads/placeholder/placeholder.png') }}"
                                 id="recom_big_pic_pre" width="100" alt="" />
                           </div>
                        </div>
                     </div>
                     <div class="col-md-12 content_title mt-3">
                        <div class="form-check form-switch pl-0">
                           <input class="form-check-input float-end "
                           name="product_setting[recom_tours_main_page_small_picture]"
                           id="recom_tours_main_page_small_picture" type="checkbox"
                           {{ getChecked('on', old('product_setting.recom_tours_main_page_small_picture', getProductSetting('golf', $get_product['id'], 'recom_tours_main_page_small_picture'))) }}>
                           <label class="form-check-label form-label w-90"
                              for="recom_tours_main_page_small_picture">{{ translate('Add to Recommended main tour in main page the small picture') }}
                           </label>
                        </div>
                     </div>
                     <div class="col-md-12 content_title mt-3">
                        <div class="form-check form-switch pl-0">
                           <input class="form-check-input float-end "
                           name="product_setting[add_to_world_adventure_main_page]"
                           id="add_to_world_adventure_main_page" type="checkbox"
                           {{ getChecked('on', old('product_setting.add_to_world_adventure_main_page', getProductSetting('golf', $get_product['id'], 'add_to_world_adventure_main_page'))) }}>
                           <label class="form-check-label form-label w-90"
                              for="add_to_world_adventure_main_page">{{ translate('Add to world of adventures awaits you on main page') }}
                           </label>
                        </div>
                     </div>
                     <div class="col-md-12 content_title mt-3">
                        <div class="form-check form-switch pl-0">
                           <input class="form-check-input float-end "
                           name="product_setting[add_to_luxury_main_page]" id="add_to_luxury_main_page"
                           type="checkbox"
                           {{ getChecked('on', old('product_setting.add_to_luxury_main_page', getProductSetting('golf', $get_product['id'], 'add_to_luxury_main_page'))) }}>
                           <label class="form-check-label form-label w-90"
                              for="add_to_luxury_main_page">{{ translate('Add to luxury treats on main page') }}
                           </label>
                        </div>
                     </div>
                     <div class="col-md-12 content_title mt-3">
                        <div class="form-check form-switch pl-0">
                           <input class="form-check-input float-end "
                           name="product_setting[add_to_top_seller_in_uae]" id="add_to_top_seller_in_uae"
                           type="checkbox"
                           {{ getChecked('on', old('product_setting.add_to_top_seller_in_uae', getProductSetting('golf', $get_product['id'], 'add_to_top_seller_in_uae'))) }}>
                           <label class="form-check-label form-label w-90"
                              for="add_to_top_seller_in_uae">{{ translate('Add to top sellers in UAE') }}
                           </label>
                        </div>
                     </div>
                     <div class="col-md-12 content_title mt-3">
                        <div class="form-check form-switch pl-0">
                           <input class="form-check-input float-end "
                           name="product_setting[related_top_rated_activity]"
                           id="related_top_rated_activity" type="checkbox"
                           {{ getChecked('on', old('product_setting.city_best_selling_tour', getProductSetting('golf', $get_product['id'], 'related_top_rated_activity'))) }}>
                           <label class="form-check-label form-label w-90"
                              for="related_top_rated_activity">{{ translate('Top Rated Activities') }}
                           </label>
                        </div>
                     </div>
                     <div class="col-md-12 content_title mt-3">
                        <div class="form-check form-switch pl-0">
                           <input class="form-check-input float-end " name="is_recently" id="is_recently"
                           type="checkbox" {{ $get_product['is_recently'] == 1 ? 'checked' : '' }}>
                           <label class="form-check-label form-label w-90"
                              for="is_recently">{{ translate('Recently Product') }}
                           </label>
                        </div>
                     </div>
                     <div
                        class="col-md-12 content_title mt-3 top_seller_sort_div _18xMp
                        @php if (getChecked('on',old('product_setting.add_to_top_seller_in_uae',getProductSetting('golf', $get_product['id'], 'add_to_top_seller_in_uae'))) != ' checked')  { echo ' d-none ' ;} @endphp">
                        <label class="form-label"
                           for="price">{{ translate('Select Top Seller Sort Number') }}
                        </label>
                        <div class="form-check form-switch pl-0">
                           <select name="product_setting[top_seller_in_uae_sort_no]"
                              class="top_seller_sort form-select single-select" id="top_seller_sort">
                           @for ($i = 1; $i <= 10; $i++)
                           <option value="{{ $i }}"
                           {{ getSelected($i, old('product_setting.top_seller_in_uae_sort_no', getProductSetting('golf', $get_product['id'], 'top_seller_in_uae_sort_no'))) }}>
                           {{ $i }}
                           </option>
                           @endfor
                           </select>
                        </div>
                     </div>
                     <div class="col-md-12">
                        <button class="btn btn-sm btn-success mb-2 add_week_days_general_price week_days_btn"
                           data-val="1" type="button"> <span class="fa fa-plus"></span>
                        {{ translate('Add Week Days Price') }}
                        </button>
                        <div class="show_week_days_price_div">
                           @php
                              $generalWeek = 1;
                              $id = 1;
                              $wreekArr = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                              $getWeek = getDataFromDB('product_option_week_tour', ['product_id' => $GPO['product_id'], 'for_general' => 1]);
                              $existWeek = [];
                              foreach ($getWeek as $key => $GW) {
                                 $existWeek[] = $GW->week_day;
                              }
                           @endphp
                           @foreach ($get_product_option_general_week_tour as $KK => $GPOGWT)
                              @include('admin.product.golf._general_week_tour')
                              @php
                                 $generalWeek++;
                                 $id++;
                              @endphp
                           @endforeach
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </li>
         {{-- General Tab  Detail End --}}

         {{-- Highlight Feature TAb  Start --}}
         <li class="tab-content tab-content-2 typography " style="display: none">
            <div class="colcss mb-1 row">
               <div class="col-md-12">
                  <div class="yatch_highlight_feature">
                     <h5 class="text-black mt-2 fw-semi-bold fs-0">{{ translate('Onsite Facilities') }}</h5>
                     <div class="row">
                        <div class="col-md-6">
                           <label class="form-label"
                              for="title">{{ translate('Onsite Facilities Text') }}
                           </label>
                           <input
                              class="form-control {{ $errors->has('title.' . $lang_id) ? 'is-invalid' : '' }}"
                              placeholder="{{ translate('Title') }}" id="title_{{ $lang_id }}"
                              name="facilities_title[{{ $lang_id }}]" type="text"
                              value="{{ old('title.' . $lang_id, getLanguageTranslate($get_yatch_fetaure_highlight_heading, $lang_id, $get_product['id'], 'title', 'product_id')) }}" />
                           <div class="invalid-feedback">
                           </div>
                        </div>
                     </div>
                     <h5 class="text-black mt-2 fw-semi-bold fs-0 mt-4">
                        {{ translate('Facilities Highlight Key') }}
                     </h5>
                     @php
                        $feature_highlight_count = 0;
                     @endphp
                     @foreach ($get_yatch_fetaure_highlight as $GYFH)
                        @include('admin.product.golf._feature_highlight')
                        @php
                           $feature_highlight_count++;
                        @endphp
                     @endforeach
                     @if (count($get_yatch_fetaure_highlight) == 0)
                        @include('admin.product.golf._feature_highlight')
                     @endif
                     <div class="show_feature_highlights mb-2">
                     </div>
                     <div class="row ">
                        <div class="col-md-12 add_more_button">
                           <button class="btn btn-success btn-sm float-end" type="button"
                              id="add_yacht_highlights_key" title='Add more'>
                           <span class="fa fa-plus"></span>{{ translate('Add more') }}</button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="colcss">
               <h3 class="text-black mt-2 fw-semi-bold fs-0">{{ translate('Disclaimer') }}</h3>
               @php
                  $data = 0;
               @endphp
               @foreach ($get_product_highlight as $GPH)
                  @include('admin.product.golf._highlight')
                  @php
                     $data++;
                  @endphp
               @endforeach
               @if (count($get_product_highlight) == 0)
                  @include('admin.product.golf._highlight')
               @endif
               <div class="show_highlights">
               </div>
               <div class="row">
                  <div class="col-md-12 add_more_button">
                     <button class="btn btn-success btn-sm float-end" type="button" id="add_highlights"
                        title='Add more'>
                     <span class="fa fa-plus"></span> Add more</button>
                  </div>
               </div>
            </div>
         </li>
         {{-- Highlight Feature TAb  End --}}

         {{-- Timing TAb Start --}}
         <li class="tab-content tab-content-3 typography " style="display: none">
            <div class="row colcss">
               <div class="col-md-1"></div>
               <div class="col-md-10 content_title">
                  <div class="row">
                     <div class="col-md-6">
                        <label class="form-label"
                           for="opening_time_heading">{{ translate('Opening Time') }}<span
                           class="text-danger">*</span>
                        </label>
                        <input
                           class="form-control {{ $errors->has('opening_time_heading.' . $lang_id) ? 'is-invalid' : '' }}"
                           placeholder="{{ translate('Title') }}"
                           id="opening_time_heading{{ $lang_id }}"
                           name="opening_time_heading[{{ $lang_id }}]" type="text"
                           value="{{ old('opening_time_heading.' . $lang_id, getLanguageTranslate($opening_time_heading, $lang_id, 'heading_title', 'title', 'meta_title')) }}" />
                        <div class="invalid-feedback">
                        </div>
                     </div>
                  </div>
                  <div class="form-check form-switch pl-0">
                     <input class="form-check-input float-end timing_status"
                     {{ getChecked(1, $get_product['timing_status']) }} id="timing_status"
                     type="checkbox" value="Active" name="timing_status">
                     <label class="form-check-label form-label"
                        for="timing_status">{{ translate('Active/Not Active') }}
                     </label>
                  </div>
                  @php
                    $check_daily = [];
                  @endphp
                  @foreach ($get_timings as $key => $value)
                  @php
                    $check_daily[] = $value['day'];
                  @endphp
                  <div class="row week_box">
                     <div class="col-md-3 content_title align-self-end">
                        <h5 class="text-primary">{{ $value['day'] }}</h5>
                        <input type="hidden" name="day[]" value="{{ $value['day'] }}">
                     </div>
                     <div class="col-md-4">
                        <label class="form-label" for="timepicker1">{{ translate('From') }}</label>
                        <input class="form-control datetimepicker pick_from" id="timepicker1"
                           name="time_from[]" type="text" placeholder="H:i"
                           data-options='{"enableTime":true,"dateFormat":"H:i","disableMobile":true}'
                           value="{{ $value['time_from'] }}" />
                     </div>
                     <div class="col-md-4">
                        <label class="form-label" for="timepicker1">To</label>
                        <input class="form-control datetimepicker pick_to" id="timepicker1"
                           name="time_to[]" type="text" placeholder="H:i"
                           data-options='{"enableTime":true,"noCalendar":true,"dateFormat":"H:i","disableMobile":true}'
                           value="{{ $value['time_to'] }}" />
                     </div>
                     <div class="col-md-1 align-self-end">
                        <label class="form-check-label" for="flexCheckChecked">Close</label>
                        <input class="form-check-input min_close" id="flexCheckChecked" type="checkbox"
                        name="is_close[{{ $value['day'] }}]"
                        {{ getChecked('1', $value['is_close']) }} />
                     </div>
                  </div>
                  @endforeach
                  @if (!in_array('Daily', $check_daily))
                  <div class="row week_box">
                     <div class="col-md-3 content_title align-self-end">
                        <h5 class="text-primary">Daily</h5>
                        <input type="hidden" name="day[]" value="Daily">
                     </div>
                     <div class="col-md-4">
                        <label class="form-label" for="timepicker1">{{ translate('From') }}</label>
                        <input class="form-control datetimepicker pick_from" id="timepicker1"
                           name="time_from[]" type="text" placeholder="H:i"
                           data-options='{"enableTime":true,"dateFormat":"H:i","disableMobile":true}'
                           value="9:00" />
                     </div>
                     <div class="col-md-4">
                        <label class="form-label" for="timepicker1">To</label>
                        <input class="form-control datetimepicker pick_to" id="timepicker1"
                           name="time_to[]" type="text" placeholder="H:i"
                           data-options='{"enableTime":true,"noCalendar":true,"dateFormat":"H:i","disableMobile":true}'
                           value="11:00" />
                     </div>
                     <div class="col-md-1 align-self-end">
                        <label class="form-check-label" for="flexCheckChecked">Close</label>
                        <input class="form-check-input min_close" id="flexCheckChecked" type="checkbox"
                        name="is_close['Daily']" {{ getChecked('1', 0) }} />
                     </div>
                  </div>
                  @endif
               </div>
            </div>
         </li>
         {{-- Timing TAb End --}}

         {{-- Images Tab  Start --}}
         <li class="tab-content tab-content-5  typography" style="display: none">
            <div class="row colcss">
               <div class="col-md-12">
                  <div class="row">
                     <div class="col-md-6 content_title">
                        <label class="form-label" for="duration_from">{{ translate('Image') }}<span
                           class="text-danger">*</span> <small>(792X450)</small> </label>
                        <div class="input-group mb-3">
                           <input class="form-control " type="file" name="image"
                              aria-describedby="basic-addon2" onchange="loadFile(event,'preview_image')"
                              id="image" />
                           <div class="invalid-feedback">
                           </div>
                        </div>
                        <div class="col-lg-3 mt-2">
                           <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                              <div class="h-100 w-100  overflow-hidden position-relative">
                                 <img src="{{ $get_product['image'] != '' ? asset('uploads/product_images/' . $get_product['image']) : asset('uploads/placeholder/placeholder.png') }}"
                                    id="preview_image" width="100" alt="" />
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6 content_title">
                        <label class="form-label" for="duration_from">{{ translate('Image Text') }}
                        </label>
                        <div class="input-group mb-3">
                           <input class="form-control " type="text" name="image_text"
                              aria-describedby="basic-addon2" id="image_text"
                              value="{{ old('image_text', $get_product['image_text']) }}" />
                           <div class="invalid-feedback">
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="mb-3">
                     <div class="col-md-6 content_title">
                        <input class="{{ $errors->has('files_count') ? 'is-invalid' : '' }}" type="hidden"
                           name="files_count" placeholder="{{ translate('Files Count') }}"
                           id="files_count" />
                        <div class="invalid-feedback">
                        </div>
                     </div>
                     <label class="form-label" data-bs-toggle="tooltip" data-bs-placement="top"
                        for="customFile">{{ translate('Multiple Banner Image') }}
                     <small>(792X450)</small>
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
                                 <input id="files" id="files" multiple="true" name="files[]"
                                    type="file" />
                              </div>
                              <output id="list"></output>
                              <div class="row appenImage"></div>
                           </div>
                        </div>
                        @if (count($get_product_images) > 0)
                        <?php $i = 1; ?>
                        <div class="row">
                           @foreach ($get_product_images as $key => $image)
                           <div class='col-md-2'>
                              <div class="image-item upload_img_list">
                                 <img src="{{ asset('uploads/product_images/' . $image['product_images']) }}"
                                    alt="" width="20" title="">
                                 <div class="image_name_sort">
                                    <input type="number"
                                       name="sort_order_images[{{ $key }}]"
                                       class="form-control"
                                       placeholder="{{ translate('Enter Sort value') }}"
                                       value="{{ $image['sort_order_images'] }}">
                                 </div>
                                 <div class="image_name_size">
                                    <input type="hidden" name="image_id[]"
                                       value="{{ $image['id'] }}">
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
         </li>
         {{-- Images Tab  End --}}

         {{-- Advertisement Tab Start --}}
         <li class="tab-content tab-content-7    typography" style="display: none">
            <div class="colcss">
               @php
               $adver_count = 0;
               @endphp
               @foreach ($get_product_site_adver as $GPSD)
               @include('admin.product.golf._site_advertisement')
               @php
               $adver_count++;
               @endphp
               @endforeach
               @if (count($get_product_site_adver) == 0)
               @include('admin.product.golf._site_advertisement')
               @endif
               <div class="show_adver">
               </div>
               <div class="row">
                  <div class="col-md-12 add_more_button">
                     <button class="btn btn-success btn-sm float-end" type="button" id="add_adver"
                        title='Add more'>
                     <span class="fa fa-plus"></span> {{ translate('Add more') }}</button>
                  </div>
               </div>
            </div>
         </li>
         {{-- Advertisement Tab End --}}

         {{-- Extras Tab Strt --}}
         <li class="tab-content tab-content-8 typography " style="display: none">
            <div class="colcss">
               <div class="row">
                  <div class="col-md-3 col-lg-3  content_title box">
                     <label class="form-label" for="price">{{ translate('Supplier') }} </label>
                     <select class="form-select multi-select" name="suppliers[]" id="suppliers" multiple>
                     @foreach ($get_supplier as $GS)
                     <option value="{{ $GS['id'] }}"
                     {{ getSelectedInArray($GS['id'], $get_product['supplier']) }}>
                     {{ $GS['company_name'] }}</option>
                     @endforeach
                     </select>
                  </div>
                  <div class="col-md-3 col-lg-3 content_title box">
                     <div class="row">
                        <div class="col-md-12">
                           <label class="form-label" for="title">{{ translate('Child Age Limit') }}
                           </label>
                           <input class="form-control"
                              placeholder="{{ translate('Enter Age Child Limit') }}" id="title"
                              name="child_age_limit" type="text"
                              value="{{ old('child_age_limit', $get_product['child_age_limit']) }}" />
                        </div>
                        <div class="col-md-12">
                           <label class="form-label" for="title">{{ translate('Infant Age Limit') }}
                           </label>
                           <input class="form-control"
                              placeholder="{{ translate('Enter Infant Child Limit') }}" id="title"
                              name="infant_age_limit" type="text"
                              value="{{ old('infant_age_limit', $get_product['infant_age_limit']) }}" />
                        </div>
                     </div>
                  </div>
                  {{-- --- --}}
                  <div class="col-md-3 col-lg-3 content_title box">
                     <div class="row">
                        <div class="col-md-12">
                           <label class="form-label"
                              for="title">{{ translate('Product Rate Valid Until') }}
                           </label>
                           <input class="form-control datetimepicker" id="rate_valid_until"
                              name="rate_valid_until" type="text"
                              value="{{ old('rate_valid_until', $get_product['rate_valid_until']) }}" />
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3 col-lg-3 content_title box">
                     <div class="row">
                        <div class="col-md-6">
                           <label class="form-label" for="title">{{ translate('Client Reward Points') }}
                           </label>
                           <input class="form-control numberonly"
                              placeholder="{{ translate('Enter Client Reward Points') }}" id="title"
                              name="client_reward_point" type="text"
                              value="{{ old('client_reward_point', $get_product['client_reward_point']) }}" />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="price">{{ translate('Reward Points type') }}</label>
                            <select class="form-select single-select client_reward_point_type" name="client_reward_point_type" id="client_reward_point_type">
                                <option value="">{{ translate('Select') }}</option>
                               
                                <option value="Flat" <?php if($get_product['client_reward_point_type'] == 'Flat'){ echo 'selected="selected"'; } ?>>Flat</option>
                                <option value="Percentage" <?php if($get_product['client_reward_point_type'] == 'Percentage'){ echo 'selected="selected"'; } ?>>Percentage</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                           <label class="form-label"
                              for="title">{{ translate('How Many Point To Purchase This Product') }}
                           </label>
                           <input class="form-control numberonly"
                              placeholder="{{ translate('Enter Point') }}" id="title"
                              name="point_to_purchase_product" type="text"
                              value="{{ old('point_to_purchase_product', $get_product['point_to_purchase_product']) }}" />
                        </div>
                     </div>
                  </div>
                  {{-- 
                  <div class="col-md-6 col-lg-6  content_title box" style="width: 49% !important;">
                     <label class="form-label" for="price">{{ translate('Option Note') }}</label>
                     <textarea class="form-control" placeholder="{{ translate('Enter Option Note') }}" name="option_note" id="option_note">{{ $get_product['option_note'] }}</textarea>
                  </div>
                  <div class="col-md-6 col-lg-6  content_title box" style="width: 49% !important;">
                     <label class="form-label" for="price">{{ translate('Booking Policy') }}</label>
                     <textarea class="form-control extra" placeholder="{{ translate('Enter Booking Policy') }}" name="booking_policy" id="booking_policy">{{ $get_product['booking_policy'] }}</textarea>
                  </div>
                  --}}
                  <div class="row">
                     <div class="col-md-6">
                        <label class="form-label" for="price">{{ translate('Option Note') }}<span
                           class="text-danger">*</span>
                        </label>
                        <textarea class="form-control footer_text" rows="8" id="option_note_{{ $lang_id }}"
                           name="option_note[{{ $lang_id }}]" placeholder="{{ translate('Option Note') }}">{{ getLanguageTranslate($get_product_language, $lang_id, $get_product['id'], 'option_note', 'product_id') }}</textarea>
                        <div class="invalid-feedback">
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-6">
                        <label class="form-label" for="price">{{ translate('Booking Policy') }}<span
                           class="text-danger">*</span>
                        </label>
                        <textarea class="form-control footer_text" rows="8" id="booking_policy_{{ $lang_id }}"
                           name="booking_policy[{{ $lang_id }}]" placeholder="{{ translate('Booking Policy') }}">{{ getLanguageTranslate($get_product_language, $lang_id, $get_product['id'], 'booking_policy', 'product_id') }}</textarea>
                        <div class="invalid-feedback">
                        </div>
                     </div>
                  </div>
               </div>
               <h5 class="text-black mt-2 fw-semi-bold fs-0">{{ translate('Other Booking Details') }}</h5>
               <div class="row">
                  <div class="col-md-4">
                     <p class="form-label">{{ translate('Can be booked up to in advanced') }}
                     <div id="BookedUpTo"></div>
                     <input type='hidden' name='can_be_booked_up_to_advance'
                        id="can_be_booked_up_to_advance" value=""> </p>
                  </div>
                  <div class="col-md-4">
                     <p class="form-label">{{ translate('Can be cancelled up to in advanced') }}
                     <div id="CancelledUpTo"></div>
                     <input type='hidden' name='can_be_cancelled_up_to_advance'
                        id="can_be_cancelled_up_to_advance" value=""> </p>
                  </div>
                  <div class="col-md-8 mt-2">
                     <div class="form-check form-switch pl-0">
                        <input class="form-check-input float-end" id="per_modifi_or_cancellation"
                        {{ getChecked(1, $get_product['per_modifi_or_cancellation']) }} type="checkbox"
                        value="1" name="per_modifi_or_cancellation">
                        <label class="fs-0"
                           for="per_modifi_or_cancellation">{{ translate('Not refundable. This activity does not permit modification or cancellation.') }}</label>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-3 mt-2">
                        <div class="form-check form-switch pl-0">
                           <input class="form-check-input float-end" id="product_bookable"
                           {{ getChecked('bookable', $get_product['product_bookable_type']) }}
                           type="radio" value="bookable" name="product_bookable_type" checked>
                           <label class="fs-0"
                              for="product_bookable">{{ translate('Bookable') }}</label>
                        </div>
                     </div>
                     <div class="col-md-3 mt-2">
                        <div class="form-check form-switch pl-0">
                           <input class="form-check-input float-end" id="product_on_request"
                           {{ getChecked('on_request', $get_product['product_bookable_type']) }}
                           type="radio" value="on_request" name="product_bookable_type">
                           <label class="fs-0"
                              for="product_on_request">{{ translate('On Request') }}</label>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </li>
         {{-- Extras Tab End --}}

         {{-- Hotels --}}
         <li class="tab-content tab-content-14 typography " style="display: none">
            <div class="colcss mb-1 row">
               <h3 class="text-black mt-2 fw-semi-bold ">{{ translate('Hotels') }}</h3>
               <div class="colcss" style="padding: 10px 35px 40px;">
                  @php
                  $hotels_count = 0;
                  @endphp
                  @foreach ($get_product_transfer_option as $GYTO)
                  @include('admin.product.golf._hotels')
                  @php
                  $hotels_count++;
                  @endphp
                  @endforeach
                  @if (empty($get_product_transfer_option))
                  @include('admin.product.golf._hotels')
                  @endif
                  <div class="show_hotels">
                  </div>
                  <div class="row">
                     <div class="col-md-12 add_more_button">
                        <button class="btn btn-success btn-sm float-end" type="button" id="add_hotels"
                           title='Add more'>
                        <span class="fa fa-plus"></span> {{ translate('Add more') }}</button>
                     </div>
                  </div>
               </div>
            </div>
         </li>
         {{-- Hotels End --}}

         {{-- Rooms --}}
         <li class="tab-content tab-content-15 typography " style="display: none">
            <div class="colcss mb-1 row">
               <h3 class="text-black mt-2 fw-semi-bold">{{ translate('Rooms') }}</h3>
               <div class="colcss" style="padding: 10px 35px 40px;">
                  @php
                  $room_count = 0;
                  @endphp
                  @foreach ($get_golf_rooms as $GGR)
                  @include('admin.product.golf._rooms')
                  @php
                  $room_count++;
                  @endphp
                  @endforeach
                  @if (count($get_golf_rooms) == 0)
                  @include('admin.product.golf._rooms')
                  @endif
                  <div class="show_rooms">
                  </div>
                  <div class="row">
                     <div class="col-md-12 add_more_button">
                        <button class="btn btn-success btn-sm float-end" type="button" id="add_rooms"
                           title='Add more'>
                        <span class="fa fa-plus"></span> {{ translate('Add more') }}</button>
                     </div>
                  </div>
               </div>
            </div>
         </li>
         {{-- Rooms End --}}

         {{-- REQUEST POPUP Tab --}}
         <li class="tab-content tab-content-17    typography" style="display: none">
            <div class="colcss">
               <div class="col-md-6 content_title">
                  <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                     <div class="h-100 w-100  overflow-hidden position-relative">
                        <img src="{{ $get_product['popup_image'] != '' ? asset('uploads/product_images/' . $get_product['popup_image']) : asset('uploads/placeholder/placeholder.png') }}"
                           id="upload_logo_23" width="100" alt="" />
                     </div>
                  </div>
               </div>
               <div class="col-md-6 content_title">
                  <label class="form-label" for="duration_from">{{ translate('Pop Up Image') }}
                  <small>(792X450)</small> </label>
                  <div class="input-group mb-3">
                     <input class="form-control " type="file" name="popup_image"
                        aria-describedby="basic-addon2" onchange="loadFile(event,'upload_logo_23')"
                        id="popup_image" />
                     <div class="invalid-feedback">
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <label class="form-label" for="popup_heading">{{ translate('Pop Up Heading') }}<span
                        class="text-danger">*</span>
                     </label>
                     <input class="form-control" placeholder="{{ translate('Heading') }}"
                        id="title_{{ $lang_id }}" name="popup_heading[{{ $lang_id }}]"
                        type="text"
                        value="{{ old('popup_heading.' . $lang_id, getLanguageTranslate($get_product_language, $lang_id, $get_product['id'], 'popup_heading', 'product_id')) }}" />
                     <div class="invalid-feedback">
                     </div>
                  </div>
               </div>
               <div class="row mb-3">
                  <div class="col-md-6">
                     <label class="form-label" for="price">{{ translate('Pop Up Title') }}
                     </label>
                     <input class="form-control" placeholder="{{ translate('Pop Up Title') }}"
                        id="title_{{ $lang_id }}" name="popup_title[{{ $lang_id }}]"
                        type="text"
                        value="{{ old('popup_title.' . $lang_id, getLanguageTranslate($get_product_language, $lang_id, $get_product['id'], 'popup_title', 'product_id')) }}" />
                  </div>
               </div>
               @php
               $data = 0;
               @endphp
               @foreach ($get_product_request_popup as $POPUP)
               @include('admin.product.yacht._request_popup')
               @php
               $data++;
               @endphp
               @endforeach
               @if (empty($get_product_request_popup))
               @include('admin.product.yacht._request_popup')
               @endif
               <div class="show_popup">
               </div>
               <div class="row">
                  <div class="col-md-12 add_more_button">
                     <button class="btn btn-success btn-sm float-end" type="button" id="add_popup"
                        title='Add more'>
                     <span class="fa fa-plus"></span> {{ translate('Add more') }}</button>
                  </div>
               </div>
            </div>
         </li>

         {{-- Experience Icon Tab  --}}
         <li class="tab-content tab-content-19 typography " style="display: none">
            <div class="colcss">
               <div class="row">
                  <div class="col-md-6">
                     <label class="form-label" for="price">{{ translate('Experience Icon heading') }}
                     </label>
                     <input
                        class="form-control {{ $errors->has('experience_heading.' . $lang_id) ? 'is-invalid' : '' }}"
                        id="experience_heading_{{ $lang_id }}"
                        name="experience_heading[{{ $lang_id }}]"
                        placeholder="{{ translate('Experience Icon heading') }}"
                        value="{{ getLanguageTranslate($experience_icon_heading, $lang_id, 'heading_title', 'title', 'meta_title') }}">
                     <div class="invalid-feedback">
                     </div>
                  </div>
               </div>
               @php
               $data = 0;
               @endphp
               @foreach ($get_product_experience_icon as $PEI)
               @include('admin.product.golf._experience_icon')
               @php
               $data++;
               @endphp
               @endforeach
               @if (empty($get_product_experience_icon))
               @include('admin.product.golf._experience_icon')
               @endif
               <div class="show_expe">
               </div>
               <div class="row">
                  <div class="col-md-12 add_more_button">
                     <button class="btn btn-success btn-sm float-end" type="button" id="add_expe"
                        title='Add more'>
                     <span class="fa fa-plus"></span> Add more</button>
                  </div>
               </div>
            </div>
         </li>
         {{-- Experience Icon Header Tab  --}}
         <li class="tab-content tab-content-20 typography " style="display: none">
            <div class="colcss">
               <div class="row">
                  <div class="col-md-6">
                     <label class="form-label"
                        for="price">{{ translate('Header Experience Icon heading') }}
                     </label>
                     <input
                        class="form-control {{ $errors->has('header_experience_heading.' . $lang_id) ? 'is-invalid' : '' }}"
                        id="header_experience_heading_{{ $lang_id }}"
                        name="header_experience_heading[{{ $lang_id }}]"
                        placeholder="{{ translate('Experience Icon heading') }}"
                        value="{{ getLanguageTranslate($experience_icon_upper_heading, $lang_id, 'heading_title', 'title', 'meta_title') }}">
                     <div class="invalid-feedback">
                     </div>
                  </div>
               </div>
               @php
               $data = 0;
               @endphp
               @foreach ($get_product_experience_icon_upper as $PEIH)
               @include('admin.product.golf._experience_icon_header')
               @php
               $data++;
               @endphp
               @endforeach
               @if (count($get_product_experience_icon_upper) == 0)
               @include('admin.product.golf._experience_icon_header')
               @endif
               <div class="show_expe_header">
               </div>
               <div class="row">
                  <div class="col-md-12 add_more_button">
                     <button class="btn btn-success btn-sm float-end" type="button" id="add_expe_header"
                        title='Add more'>
                     <span class="fa fa-plus"></span> Add more</button>
                  </div>
               </div>
            </div>
         </li>

         {{-- Product Pop-up Tab  --}}
         <li class="tab-content tab-content-6 typography " style="display: none">
            <div class="colcss">
               <div class="row">
                  <div class="col-md-6 content_title">
                     <label class="form-label" for="duration_from">{{ translate('Product Pop Up Image') }}
                     <small>(792X450)</small> </label>
                     <div class="input-group mb-3">
                        <input class="form-control " type="file" name="pro_popup_image"
                           aria-describedby="basic-addon2" onchange="loadFile(event,'Pro_pop')"
                           id="pro_popup_image" />
                        <div class="invalid-feedback">
                        </div>
                     </div>
                     <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                        <div class="h-100 w-100  overflow-hidden position-relative">
                           <img src="{{ $get_product['pro_popup_image'] != '' ? asset('uploads/product_images/' . $get_product['pro_popup_image']) : asset('uploads/placeholder/placeholder.png') }}"
                              id="Pro_pop" width="100" alt="" />
                        </div>
                     </div>
                  </div>
                  <!-- <div class="col-md-6">
                     <label class="form-label" for="price">{{ translate('Product Pop Up Link') }}
                     </label>
                     
                     <input class="form-control" placeholder="{{ translate('Product Pop Up Link') }}"
                         id="title" name="pro_popup_link" type="text"
                         value="{{ $get_product['pro_popup_link'] }}" />
                     </div> -->
                  <div class="col-md-6 content_title">
                     <label class="form-label"
                        for="duration_from">{{ translate('Product Pop Up Thumnail Image') }}
                     <small>(792X450)</small> </label>
                     <div class="input-group mb-3">
                        <input class="form-control " type="file" name="pro_popup_thumnail_image"
                           aria-describedby="basic-addon2"
                           onchange="loadFile(event,'pro_popup_thumnail_image_')"
                           id="pro_popup_thumnail_image" />
                        <div class="invalid-feedback">
                        </div>
                     </div>
                     <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                        <div class="h-100 w-100  overflow-hidden position-relative">
                           <img style="width: 100px;height: 100px;"
                              src="{{ $get_product['pro_popup_thumnail_image'] != '' ? asset('uploads/product_images/popup_image/' . $get_product['pro_popup_thumnail_image']) : asset('uploads/placeholder/placeholder.png') }}"
                              id="pro_popup_thumnail_image_" width="100" alt="" />
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6 content_title">
                     <label class="form-label"
                        for="duration_from">{{ translate('Product Pop Up Video') }}</label>
                     <div class="input-group mb-3">
                        <input class="form-control " type="file" name="pro_popup_video"
                           aria-describedby="basic-addon2" id="pro_popup_video" />
                        <div class="invalid-feedback">
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <label class="form-label" for="price">{{ translate('Product Pop Up Title') }}
                     </label>
                     <input class="form-control" placeholder="{{ translate('Product Pop Up Title') }}"
                        id="title_{{ $lang_id }}" name="pro_popup_title[{{ $lang_id }}]"
                        type="text"
                        value="{{ old('pro_popup_title.' . $lang_id, getLanguageTranslate($get_product_language, $lang_id, $get_product['id'], 'pro_popup_title', 'product_id')) }}" />
                  </div>
               </div>
               <div class="row mb-3">
                  <div class="col-md-6">
                     <label class="form-label"
                        for="popup_heading">{{ translate('Product Pop Up Description') }}<span
                        class="text-danger">*</span>
                     </label>
                     <textarea class="form-control {{ $errors->has('pro_popup_desc.' . $lang_id) ? 'is-invalid' : '' }}" rows="8"
                        id="short_description_{{ $lang_id }}" name="pro_popup_desc[{{ $lang_id }}]"
                        placeholder="{{ translate('Product Pop Up Description') }}">{{ getLanguageTranslate($get_product_language, $lang_id, $get_product['id'], 'pro_popup_desc', 'product_id') }}</textarea>
                     <div class="invalid-feedback">
                     </div>
                  </div>
               </div>
            </div>
         </li>

         {{-- TIme Slot Tab Start --}}
         <li class="tab-content tab-content-16    typography" style="display: none">
            <div class="colcss">
            @php
                $adver_count = 0;
            @endphp
            @foreach ($get_golf_time_slot as $GTS)
                @include('admin.product.golf._time_slot')
                @php
                    $adver_count++;
                @endphp
            @endforeach
            @if (count($get_golf_time_slot) == 0)
                @include('admin.product.golf._time_slot')
            @endif
            <div class="show_time_slot">
            </div>
            <div class="row">
            <div class="col-md-12 add_more_button">
             <button class="btn btn-success btn-sm float-end" type="button" id="add_time_slot"
                title='Add more'>
             <span class="fa fa-plus"></span> {{ translate('Add more') }}</button>
            </div>
            </div>
            </div>
         </li>
         {{-- TIme Slot Tab End --}}


         {{-- Related Tab --}}
          <li class="tab-content tab-content-18 typography" style="display: none">
              <div class="colcss">

                  <div class="row mb-3">
                     <div class="col-md-6">
                          <label class="form-label"
                              for="related_product_title">{{ translate('Related Products Title') }}<span
                                  class="text-danger">*</span>
                          </label>
                          <input
                              class="form-control {{ $errors->has('related_product_title.' . $lang_id) ? 'is-invalid' : '' }}"
                              placeholder="{{ translate('Related Products Title') }}"
                              id="title_{{ $lang_id }}"
                              name="related_product_title[{{ $lang_id }}]" type="text"
                              value="{{ old('related_product_title.' . $lang_id, getLanguageTranslate($get_product_language, $lang_id, $get_product['id'], 'related_product_title', 'product_id')) }}" />

                          <div class="invalid-feedback">

                          </div>
                      </div>
                  </div>

                  @php
                     $data = 0;
                  @endphp
                  @foreach ($get_product_related_boats as $GYRB)
                     @include('admin.product.golf._realated_boats')
                     @php
                        $data++;
                     @endphp
                  @endforeach
                  <div class="show_boats">
                  </div>
                  <div class="row">

                      <div class="col-md-12 add_more_button">
                          <button class="btn btn-success btn-sm float-end" type="button" id="add_boats" title='Add more'>
                              <span class="fa fa-plus"></span>{{ translate('Add more') }}</button>
                      </div>
                  </div>

              </div>
          </li>
         {{-- Related Tab --}}

      </ul>
   </div>
</form>
@php
$blackouDate = '';
if ($get_product['id'] != '') {
$blackouDate = "'" . implode("', '", json_decode($get_product['blackout_date'])) . "'";
$duration = explode('-', $get_product['duration']);
}
@endphp
<input type="hidden" name="count" id="count" value="{{ $data }}">
<script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script>
   CKEDITOR.replace('booking_policy');
   CKEDITOR.replace('option_note');
</script>
@if ($get_product['id'] != '' && count($get_product_category) == 0)
<script>
   $(document).ready(function() {
       var loadCountry = "{{ old('country', $get_product['country']) }}";
       var loadCategory = "{{ old('category', $get_product['category']) }}";
   
       getCountry(loadCountry, loadCategory, count = "")
   });
</script>
@endif
<script>
   $(document).ready(function() {
       var loadCountry = "{{ old('country', $get_product['country']) }}";
       var loadCategory = "{{ old('category', $get_product['category']) }}";
   
       var state = "{{ old('state', $get_product['state']) }}";
       var city = "{{ old('city', $get_product['city']) }}";
       if (state != "") {
           setTimeout(() => {
               getStateCity("country", state);
               setTimeout(() => {
                   getStateCity("state", city);
               }, 500);
           }, 500);
       }
       // if (loadCountry != "") {
       //     getCountry(loadCountry, loadCategory)
       // }
       // Get Category By Country
       $(".country").change(function() {
           var country = $(this).val();
           var selectedCat = ""
           getCountry(country, selectedCat)
       })
   })
   // Get Country FUnction
   function getCountry(country, selectedCat, count = "") {
       var categoryArr = [];
       if (count != "") {
           $(".category").each(function(k, v) {
               console.log($(v).val());
               if ($(v).val() != "") {
                   categoryArr.push($(v).val());
               }
           });
       } else {
           $(".show_category").html("");
       }
   
   
       $.ajax({
           "type": "POST",
           "url": "{{ route('admin.get_category_by_country') }}",
           "data": {
               _token: "{{ csrf_token() }}",
               country: country,
               selectedCat: selectedCat,
               data: categoryArr,
               array: ""
           },
           "success": function(response) {
               if (count == "") {
                   $(".category").each(function(kk, vv) {
                       $(vv).html(response);
                   })
               } else {
                   setTimeout(() => {
                       $("#category_" + count).html(response);
                   }, 1000);
   
               }
           }
   
       })
   
   }
</script>
{{-- Google Api Code --}}
<script>
   var x = document.getElementById("store_address_id");
   
   function getLocation() {
       if (navigator.geolocation) {
           navigator.geolocation.getCurrentPosition(showPosition);
       } else {
           x.innerHTML = "{{ translate('Get Location Not Supported') }}";
       }
   }
   
   function showPosition(position) {
       console.log(position);
       x.innerHTML = "Latitude: " + position.coords.latitude +
           "<br>Longitude: " + position.coords.longitude;
   }
</script>
<script
   src="https://maps.google.com/maps/api/js?key=AIzaSyCpqoRKJ3CM7GGiFWTEY0qCKYYRh00ULF0&libraries=places&callback=initAutocomplete"
   type="text/javascript"></script>
<script type="text/javascript">
   google.maps.event.addDomListener(window, 'load', initialize);
   
   function initialize() {
       var input = document.getElementById('input_store_address_id');
       var autocomplete = new google.maps.places.Autocomplete(input);
       autocomplete.addListener('place_changed', function() {
           var place = autocomplete.getPlace();
           $('#address_lattitude').val(place.geometry['location'].lat());
           $('#address_longitude').val(place.geometry['location'].lng());
       });
   }
</script>
<!-- Request Popup -->
<script type="text/javascript">
   $(document).ready(function() {
       var count = 1;
       $('#add_popup').click(function(e) {
   
           var ParamArr = {
               'view': 'admin.product.yacht._request_popup',
               'data': count
           }
           getAppendPage(ParamArr, '.show_popup');
   
           e.preventDefault();
           count++;
       });
   
   
       $(document).on('click', ".delete_popup", function(e) {
           var length = $(".delete_popup").length;
           if (length > 1) {
               deleteMsg('Are you sure to delete ?').then((result) => {
                   if (result.isConfirmed) {
                       $(this).parent().closest('.popup_div').remove();
                       e.preventDefault();
                   }
               });
           }
       });
   
   
   });
</script>
<!-- HIGHLIGHTS -->
<script type="text/javascript">
   $(document).ready(function() {
       var count = 1;
   
       $('#add_highlights').click(function(e) {
           var ParamArr = {
               'view': 'admin.product.golf._highlight',
               'data': count
           }
           getAppendPage(ParamArr, '.show_highlights');
           e.preventDefault();
           count++;
       });
   
   
       $(document).on('click', ".delete_highlight", function(e) {
           var length = $(".delete_highlight").length;
           if (length > 1) {
               deleteMsg('Are you sure to delete ?').then((result) => {
                   if (result.isConfirmed) {
                       $(this).parent().closest('.highlight_div').remove();
                       e.preventDefault();
                   }
               });
           }
       });
   });
</script>
<!-- ExPERINCE -->
<script type="text/javascript">
   $(document).ready(function() {
       var count = 1;
   
       $('#add_expe').click(function(e) {
           var ParamArr = {
               'view': 'admin.product.golf._experience_icon',
               'data': count
           }
           getAppendPage(ParamArr, '.show_expe');
           e.preventDefault();
           count++;
       });
   
   
       $(document).on('click', ".delete_expe", function(e) {
           var length = $(".delete_expe").length;
           if (length > 1) {
               deleteMsg('Are you sure to delete ?').then((result) => {
                   if (result.isConfirmed) {
                       $(this).parent().closest('.expe_div').remove();
                       e.preventDefault();
                   }
               });
           }
       });
   });
</script>
{{-- Expireance Heafer --}}
<script type="text/javascript">
   $(document).ready(function() {
       var count = 1;
   
       $('#add_expe_header').click(function(e) {
           var ParamArr = {
               'view': 'admin.product.golf._experience_icon_header',
               'data': count
           }
           getAppendPage(ParamArr, '.show_expe_header');
           e.preventDefault();
           count++;
       });
   
   
       $(document).on('click', ".delete_expe_header", function(e) {
           deleteMsg('Are you sure to delete ?').then((result) => {
               if (result.isConfirmed) {
                   $(this).parent().closest('.header_expe_div').remove();
                   e.preventDefault();
               }
           });
   
       });
   });
</script>
{{-- feature Highlight   --}}
<script type="text/javascript">
   $(document).ready(function() {
       var count = "{{ $feature_highlight_count + 1 }}";
       $('#add_yacht_highlights_key').click(function(e) {
           var ParamArr = {
               'view': 'admin.product.golf._feature_highlight',
               'data': count,
           }
           getAppendPage(ParamArr, '.show_feature_highlights');
           e.preventDefault();
           count++;
       });
   
   
       $(document).on('click', ".delete_feature_highlight", function(e) {
           var length = $(".delete_feature_highlight").length;
           if (length > 1) {
               deleteMsg('Are you sure to delete ?').then((result) => {
                   if (result.isConfirmed) {
                       $(this).parent().closest('.row_feature_highlight').remove();
                       e.preventDefault();
                   }
               });
           }
       });
   });
</script>
<script type="text/javascript">
   $(document).ready(function() {
       $('.min_close').click(function(e) {
           if ($(this).is(':checked') == true) {
               $(this).closest('.week_box').find('.pick_from').attr("disabled", true);
               $(this).closest('.week_box').find('.pick_from').css("background", "aliceblue");
               $(this).closest('.week_box').find('.pick_to').attr("disabled", true);
               $(this).closest('.week_box').find('.pick_to').css("background", "aliceblue");
           } else {
               $(this).closest('.week_box').find('.pick_from').attr("disabled", false);
               $(this).closest('.week_box').find('.pick_from').css("background", "white");
               $(this).closest('.week_box').find('.pick_to').attr("disabled", false);
               $(this).closest('.week_box').find('.pick_to').css("background", "white");
           }
       });
   
   
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
<!-- ADDITIONAL INFO -->
<script type="text/javascript">
   $(document).ready(function() {
       $('body').on('click', "#add_info", function(e) {
   
           var ParamArr = {
               'view': 'admin.product.golf._info'
           }
           getAppendPage(ParamArr, '.show_info');
   
           e.preventDefault();
   
       });
   
       $(document).on("click", ".delete_info", function(e) {
           var length = $(".delete_info").length;
           if (length > 1) {
               deleteMsg('Are you sure to delete ?').then((result) => {
                   if (result.isConfirmed) {
                       $(this).parent().closest('.info_div').remove();
                       e.preventDefault();
                   }
               });
           }
       });
   });
</script>

<!-- Image Delete -->

 <script type="text/javascript">
     $(document).ready(function() {
         $(document).on('click', ".delete_thumbnail", function(e) {

             deleteMsg('Are you sure to delete ?').then((result) => {
                 if (result.isConfirmed) {
                     $(this).parent().closest('.imgs_div').remove();
                     $("input[name='video_thumbnail_dlt']").val('');
                     e.preventDefault();
                 }
             });

         });
         <?php if ($get_product['video_thumbnail']) { ?>
         $('.img-thumbnail-preview').show();
         <?php } ?>

         $(document).on('change', "#video_thumbnail_img", function(e) {
             $('.img-thumbnail-preview').show();
         });


     });
 </script>

<!-- Site Advertisement -->
<script type="text/javascript">
   $(document).ready(function() {
       var count = "{{ $adver_count }}";
       $('#add_adver').click(function(e) {
   
           var ParamArr = {
               'view': 'admin.product.golf._site_advertisement',
               'data': count
           }
           getAppendPage(ParamArr, '.show_adver');
   
           e.preventDefault();
           count++;
       });
   
   
       $(document).on('click', ".delete_adver", function(e) {
           var length = $(".delete_adver").length;
           if (length > 1) {
               deleteMsg('Are you sure to delete ?').then((result) => {
                   if (result.isConfirmed) {
                       $(this).parent().closest('.adver_div').remove();
                       e.preventDefault();
                   }
               });
           }
       });
   
   
   });
</script>
<script>
   $(document).ready(function() {
       if (window.File && window.FileList && window.FileReader) {
           $("#files").on("change", function(e) {
               var files = e.target.files,
                   filesLength = files.length;
               if (filesLength <= 10) {
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
                               "<input type='number' name='sort_order_images[]' class='form-control' placeholder='{{ translate('Enter Sort value') }}'>" +
                               "</div>";
   
                           // $(html).insertAfter(".appenImage");
                           $(".appenImage").append(html);
                       });
                       fileReader.readAsDataURL(f);
                   }
               } else {
                   $("#files").val('');
   
                   alert('Minimum 10 images');
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
{{-- Add Product --}}
<script>
   $(document).on("submit", "#add_product", function(e) {
       e.preventDefault();
       var duration = "";
       $("#add_product_btn").prop("disabled", true);
       var formData = new FormData(this);
       $.ajax({
           type: "POST",
           url: "{{ route('admin.addgolf') }}",
           datatype: 'JSON',
           data: formData,
           cache: false,
           contentType: false,
           processData: false,
           success: function(response) {
               if (response.error) {
                   $.each(response.error, function(index, value) {
                       if (value != '') {
                           $('.tab-content').each(function() {
                               $(this).css("display", "none");
   
                           })
                           var index = index.replace(".", "_");
                           if (index == "pick_option") {
   
                               var focusDiv = $('input[name^=' + index + ']');
                               $('input[name^=' + index + ']').addClass(
                                   'is-invalid');
                               // $('#pick_option_invalid').addClass('d-block');
                               $('input[name^=' + index + ']').focus();
                               // $('#pick_option_invalid').html(
                               //     value);
   
                               var $cl = $('input[name^=' + index + ']').closest(
                                   '.tab-content');
   
   
                           } else if (index == "duration") {
   
                               $('#' + index).addClass('is-invalid');
                               var $cl = $('#demoDurationRow').closest(
                                   '.tab-content');
                               var focusDiv = $('#demoDurationRow');
   
   
                           } else if (index == "address") {
   
                               $('#input_store_address_id').addClass('is-invalid');
                               var $cl = $('#input_store_address_id').closest(
                                   '.tab-content');
                               var focusDiv = $('#input_store_address_id');
   
                           } else {
   
                               $('#' + index).addClass('is-invalid');
                               var $cl = $('#' + index).closest(
                                   '.tab-content');
                               var focusDiv = $('#' + index);
                           }
   
   
                           var ClassName = $($cl).removeClass("tab-content typography")
                               .attr(
                                   "class");
   
                           $('input[name="add_product"]').each(function() {
                               if ($(this).hasClass(ClassName)) {
                                   $(this).prop('checked', true);
                               }
                               // $(".typography").css("display", "none");
                           })
                           $("li." + ClassName).css("display", "block");
                           $("li." + ClassName).addClass("typography");
                           $("li." + ClassName).addClass("tab-content");
   
                           $('#' + index).parent().find('.invalid-feedback')
                               .html(value);
   
                           setTimeout(() => {
   
                               $(focusDiv).focus();
                           }, 500);
   
   
                       }
                   });
               } else {
   
                   success_msg("Product {{ $common['button'] }} Successfully...")
   
   
               }
           }
       });
       setTimeout(() => {
           $("#add_product_btn").prop("disabled", false);
       }, 500);
   
   });
</script>

{{-- Allowed or not  --}}
<script>
   $(document).on("click", ".tour_infant_limit", function() {
       var nextInput = $(this).parent().prev('td').find('input');
       if ($(this).prop('checked') == true) {
           nextInput.attr("readonly", true);
           nextInput.val("No Limit");
       } else {
           nextInput.attr("readonly", false);
           nextInput.val(0);
       }
   })
</script>
{{-- Add To TOp Seller Slect --}}
<script>
   $(document).on("click", "#add_to_top_seller_in_uae", function() {
       if ($(this).prop('checked') == true) {
           $(".top_seller_sort_div").removeClass('d-none');
           $(".top_seller_sort_div").addClass('d-block');
       } else {
   
           $(".top_seller_sort_div").removeClass('d-block');
           $(".top_seller_sort_div").addClass('d-none');
       }
   })
</script>
{{-- Booked Up To Advance Box --}}
<script>
   $(function() {
       BookedUpTo()
   });
   
   function BookedUpTo() {
       var $demoRow1 = $('<div id="demoDurationRowBookedUpTo" class="demo-row">');
       var $subsection1 = $('<div class="section-row">').append($demoRow1);
       $("#BookedUpTo").append($subsection1);
       $demoRow1.durationjs();
   
   }
   $(document).ready(function() {
       $("#demoDurationRowBookedUpTo .duration-val").on("keyup", function() {
           var duration = "";
           var len = $("#demoDurationRowBookedUpTo .duration-val").length - 1;
           $("#demoDurationRowBookedUpTo .duration-val").each(function(key, value) {
               if (key == len) {
                   duration += $(this).val();
               } else {
                   duration += $(this).val() + "-";
               }
           });
           $("#can_be_booked_up_to_advance").val(duration)
   
       })
   
       if ("{{ $get_product['id'] }}" != "") {
           var durationData = "{{ $get_product['can_be_booked_up_to_advance'] }}"
           if (durationData == "") {
               $("#demoDurationRowBookedUpTo .duration-val").each(function(key, value) {
                   $(this).val("00");
                   $(this).keyup();
               })
           } else {
               var result = durationData.split('-');
               $("#demoDurationRowBookedUpTo .duration-val").each(function(key, value) {
                   $(this).val(result[key]);
                   $(this).keyup();
               })
           }
       } else {
           $("#demoDurationRowBookedUpTo .duration-val").each(function(key, value) {
               $(this).val("00");
               $(this).keyup();
           })
       }
   })
</script>
{{-- Cancelled Up To Advance Box --}}
<script>
   $(function() {
       CancelledUpTo()
   });
   
   function CancelledUpTo() {
       var $demoRow1 = $('<div id="demoDurationRowCancelledUpTo" class="demo-row"></div>');
       var $subsection1 = $('<div class="section-row">').append($demoRow1);
       $("#CancelledUpTo").append($subsection1);
       $demoRow1.durationjs();
   
   }
   $(document).ready(function() {
       $("#demoDurationRowCancelledUpTo .duration-val").on("keyup", function() {
           var duration = "";
           var len = $("#demoDurationRowCancelledUpTo .duration-val").length - 1;
           $("#demoDurationRowCancelledUpTo .duration-val").each(function(key, value) {
   
               if (key == len) {
                   duration += $(this).val();
               } else {
                   duration += $(this).val() + "-";
               }
           });
           $("#can_be_cancelled_up_to_advance").val(duration)
   
       })
   
       if ("{{ $get_product['id'] }}" != "") {
   
           var durationData = "{{ $get_product['can_be_cancelled_up_to_advance'] }}"
           if (durationData == "") {
               $("#demoDurationRowCancelledUpTo .duration-val").each(function(key, value) {
                   $(this).val("00");
                   $(this).keyup();
               })
           } else {
               var result = durationData.split('-');
               $("#demoDurationRowCancelledUpTo .duration-val").each(function(key, value) {
                   $(this).val(result[key]);
                   $(this).keyup();
               })
           }
       } else {
           $("#demoDurationRowCancelledUpTo .duration-val").each(function(key, value) {
               $(this).val("00");
               $(this).keyup();
           })
       }
   })
</script>
<!-- BOATS -->
<script type="text/javascript">
    $(document).ready(function() {
        var count = 1;

        $('#add_boats').click(function(e) {
            var ParamArr = {
                'view': 'admin.product.golf._realated_boats',
                'data': count
            }
            getAppendPage(ParamArr, '.show_boats');
            e.preventDefault();
            count++;
        });



        $(document).on('click', ".delete_boats", function(e) {
            var length = $(".delete_boats").length;
           
             deleteMsg('Are you sure to delete ?').then((result) => {
                 if (result.isConfirmed) {
                     $(this).parent().closest('.boats_div').remove();
                     e.preventDefault();
                 }
             });
            
        });
    });
</script>

<script>
   $(document).ready(function() {
       $(document).on("click", ".minimize_btn", function() {
           if ($(this).text() == "+") {
               $(this).text("-");
           } else {
               $(this).text("+");
           }
           var rowid = $(this).data("rowid");
           $('#option_div' + rowid).slideToggle();
       });
   });
</script>
{{-- Add WeekDays General Price --}}
<script>
   $(document).on("click", ".add_week_days_general_price", function(e) {
       var tourCount = $(".general_tour_option_week_days").length + 1;
       $(this).attr('disabled', true);
       // getAppendPage(ParamArr, '.show_tour_price_tbody' + DataID);
       var SelectedWeekArr = [];
       $(".general_tour_option_week_days").each(function(key, value) {
           SelectedWeekArr.push($(value).val());
       })
       var ParamArr = {
           'view': 'admin.product.limousine._general_week_tour',
           'id': tourCount
       }
       if (SelectedWeekArr.length < 7) {
           getAppendPage(ParamArr, '.show_week_days_price_div');
           $(".show_week_days_price_div").removeClass("d-none");
           var wreekArr = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
           var value = "";
           setTimeout(() => {
               $(wreekArr).each(function(key, value) {
                   if ($.inArray(value, SelectedWeekArr) !== -1) {} else {
                       $("#general_tour_option_week_days_" + tourCount).append(
                           "<option value=" + value + ">" +
                           value +
                           "</option>")
                   }
               })
               GeneralWeekWorkFn(tourCount, value);
               tourCount++;
               $(".single-select").select2();
               setTimeout(() => {
                   $(this).attr('disabled', false);
               }, 200);
           }, 500);
       } else {
           danger_msg("No More Weekdays Available..");
       }
       e.preventDefault();
   });
   
   function GeneralWeekWorkFn(tour, value) {
       $(".general_tour_option_week_days").each(function(key, va) {
           var arrSelectedValue = $(this).val();
           var countID = $(this).data('tour');
           if (arrSelectedValue != value) {
               var wreekArr = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday',
                   'Sunday'
               ];
               $("#general_tour_option_week_days_" + countID).html("");
               $(wreekArr).each(function(key, Weekvalue) {
                   var select = "";
                   var isShow = 0;
                   if (arrSelectedValue == Weekvalue) {
                       select = " selected";
                       var isShow = 1;
                   }
                   var SelectedWeekArr = [];
                   $(".general_tour_option_week_days").each(function(key, selectvalue) {
                       SelectedWeekArr.push($(selectvalue).val());
                   })
                   console.log("value", value);
                   if (value != Weekvalue) {
                       if ($.inArray(Weekvalue, SelectedWeekArr) !== -1) {} else {
                           $("#general_tour_option_week_days_" + countID).append(
                               "<option value=" + Weekvalue + " " + select +
                               ">" +
                               Weekvalue +
                               "</option>");
                       }
                   }
               })
           }
       })
   }
</script>

{{-- Delete Option Weekdays Rows --}}
<script>
    $(document).on("click", ".delete_tour_row", function() {
      var length = $(".delete_tour_row").length;
         if (length > 1) {
           deleteMsg('Are you sure to delete ?').then((result) => {
               if (result.isConfirmed) {
                   $(this).parent().closest('.row_week_tour').remove();
                   var id = $(this).data("id");
                   WeekWorkFn(id, "", "");

               }

           });
        }
    })
</script>


{{-- <!-- Rooms Count --> --}}
<script type="text/javascript">
   $(document).ready(function() {
       var count = "{{ $hotels_count }}";
       $('#add_rooms').click(function(e) {
   
           var ParamArr = {
               'view': 'admin.product.golf._rooms',
               'data': count
           }
           getAppendPage(ParamArr, '.show_rooms');
   
           e.preventDefault();
           count++;
       });
   
   
       $(document).on('click', ".delete_rooms", function(e) {
           var length = $(".delete_rooms").length;
           if (length > 1) {
               deleteMsg('Are you sure to delete ?').then((result) => {
                   if (result.isConfirmed) {
                       $(this).parent().closest('.rooms_div').remove();
                       e.preventDefault();
                   }
               });
           }
       });
   
   
   });
</script>
{{-- <!-- Rooms Count End--> --}}
<!-- TRANSFER OPTION -->
<script type="text/javascript">
   $(document).ready(function() {
       var count = "{{ $hotels_count }}";
       $('#add_hotels').click(function(e) {
   
           var ParamArr = {
               'view': 'admin.product.golf._hotels',
               'data': count
           }
           getAppendPage(ParamArr, '.show_hotels');
   
           e.preventDefault();
           count++;
       });
   
   
       $(document).on('click', ".delete_transfer_option", function(e) {
           var length = $(".delete_transfer_option").length;
           if (length > 1) {
               deleteMsg('Are you sure to delete ?').then((result) => {
                   if (result.isConfirmed) {
                       $(this).parent().closest('.transfer_option_div').remove();
                       e.preventDefault();
                   }
               });
           }
       });
   
   
   });
</script>
<script>
   $(document).ready(function() {
       CKEDITOR.replaceAll('footer_text');
       if ("{{ $get_product['id'] }}" != "") {
           var saleDate = "{{ $get_product['note_on_sale_date'] }}"
           var result = saleDate.split('to');
           $(".note_on_sale_date").flatpickr({
               mode: 'range',
               dateFormat: "Y-m-d",
               defaultDate: [result[0], result[1]]
           });
       } else {
           $(".note_on_sale_date").flatpickr({
               mode: 'range',
               minDate: "today",
               dateFormat: "Y-m-d",
           });
       }
   
       $(".blackout_date").flatpickr({
           mode: "multiple",
           dateFormat: "Y-m-d",
           defaultDate: [<?php echo implode(',', array_unique(explode(',', $blackouDate))); ?>],
   
       });
   
       $(".opening_hours").flatpickr({
           enableTime: true,
           noCalendar: true,
           dateFormat: "H:i",
   
       });
   
       $(".closing_hours").flatpickr({
           enableTime: true,
           noCalendar: true,
           dateFormat: "H:i",
   
       });
   
       $(".option_available_date").flatpickr({
           mode: "multiple",
           dateFormat: "Y-m-d",
       });
   })
</script>
<script>
   function back() {
       window.history.back()
   }
</script>

<!-- Site Advertisement -->
<script type="text/javascript">
   $(document).ready(function() {
       var count = "{{ $adver_count }}";
       $('#add_time_slot').click(function(e) {
            
           var ParamArr = {
               'view': 'admin.product.golf._time_slot',
               'data': count
           }
           getAppendPage(ParamArr, '.show_time_slot');

           e.preventDefault();
           count++;
       });
   
   
       $(document).on('click', ".delete_time_slot", function(e) {
           var length = $(".delete_time_slot").length;
           if (length > 1) {
               deleteMsg('Are you sure to delete ?').then((result) => {
                   if (result.isConfirmed) {
                       $(this).parent().closest('.time_slot_div').remove();
                       e.preventDefault();
                   }
               });
           }
       });
   
   
   });
</script>
<script type="text/javascript">

</script>
@endsection