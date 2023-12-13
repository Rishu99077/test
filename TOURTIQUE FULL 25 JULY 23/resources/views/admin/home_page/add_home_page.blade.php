@extends('admin.layout.master')
@section('content')
    <script
        src="https://maps.google.com/maps/api/js?key=AIzaSyCpqoRKJ3CM7GGiFWTEY0qCKYYRh00ULF0&libraries=places&callback=initAutocomplete"
        type="text/javascript"></script>
    <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
    <form method="POST" enctype="multipart/form-data" action="{{ route('admin.home_page.add') }}" id="add_home_page">
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
                title="{{ translate('Top Destination') }}"> <i class="icon-general"></i></label>

            <input type="radio" name="add_product" id="tab2" class="tab-content-2 addProTab">
            <label for="tab2" data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ translate('Home Counter') }}"><i class="icon-highlight"></i></label>

            <input type="radio" name="add_product" id="tab3" class="tab-content-3 addProTab">
            <label for="tab3" data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ translate('Top 10 Seller') }}">
                <i class="icon-adver"></i></label>

            <input type="radio" name="add_product" id="tab4" class="tab-content-4 addProTab">
            <label for="tab4" data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ translate('Recommended Tours') }}"><i class="icon-faq"></i></label>

            <input type="radio" name="add_product" id="tab5" class="tab-content-5 addProTab">
            <label for="tab5" data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ translate('World Of Adventures') }}">
                <i class="icon-adver"></i></label>

            {{-- <input type="radio" name="add_product" id="tab6" class="tab-content-6 addProTab">
            <label for="tab6" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('Faqs') }}"><i
                    class="icon-faq"></i></label>     --}}

            <input type="radio" name="add_product" id="tab7" class="tab-content-7 addProTab">
            <label for="tab7" data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ translate('Main Slider Image') }}">
                <i class="icon-images"></i></label>

            <input type="radio" name="add_product" id="tab8" class="tab-content-8 addProTab">
            <label for="tab8" data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ translate('Destination Overview') }}">
                <i class="icon-highlight"></i></label>

            {{-- <input type="radio" name="add_product" id="tab9" class="tab-content-9 addProTab">
            <label for="tab9" data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ translate('Special Offers') }}"><i class="icon-faq"></i></label> --}}

            <input type="radio" name="add_product" id="tab10" class="tab-content-10 addProTab">
            <label for="tab10" data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ translate('Banner Overview') }}"><i class="icon-faq"></i></label>

            <input type="radio" name="add_product" id="tab11" class="tab-content-11 addProTab">
            <label for="tab11" data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ translate('Middle Slider Image') }}">
                <i class="icon-images"></i></label>

            <input type="radio" name="add_product" id="tab13" class="tab-content-13 addProTab">
            <label for="tab13" data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ translate('Search Zones') }}">
                <i class="icon-faq"></i></label>

            {{-- <input type="radio" name="add_product" id="tab18" class="tab-content-18 addProTab">
            <label for="tab18" data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ translate('Pop-up') }}"><i class="icon-images"></i></label>  --}}

            <ul>

                {{-- Top Destinations --}}
                <li class="tab-content tab-content-first typography">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-body ">
                                <div class="row mb-2">
                                    <div class="row">
                                        
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label"
                                                for="title">{{ translate('Luxury Treats Main Title') }}<span
                                                    class="text-danger">*</span>
                                            </label>
                                            <input
                                                class="form-control {{ $errors->has('luxuary_treats_heading.' . $lang_id) ? 'is-invalid' : '' }}"
                                                placeholder="{{ translate('Main Title') }}"
                                                id="luxuary_treats_heading"
                                                name="luxuary_treats_heading[{{ $lang_id }}]" type="text"
                                                value="{{ getLanguageTranslate($get_luxuary_treats_heading, $lang_id, 'heading_title', 'title', 'meta_title') }}" />
                                            @error('luxuary_treats_heading.' . $lang_id)
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label"
                                                for="title">{{ translate('Recently Main Title') }}<span
                                                    class="text-danger">*</span>
                                            </label>
                                            <input
                                                class="form-control {{ $errors->has('recently_main_heading.' . $lang_id) ? 'is-invalid' : '' }}"
                                                placeholder="{{ translate('Main Title') }}"
                                                id="recently_main_heading"
                                                name="recently_main_heading[{{ $lang_id }}]" type="text"
                                                value="{{ getLanguageTranslate($get_recently_main_heading, $lang_id, 'heading_title', 'title', 'meta_title') }}" />
                                            @error('recently_main_heading.' . $lang_id)
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                     
                                    </div>


                                    
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label"
                                            for="airport_transfer_search_text">{{ translate('Airport Transfer Search Text') }}
                                        </label>
                                        <textarea
                                            class="form-control editor {{ $errors->has('airport_transfer_search_text.' . $lang_id) ? 'is-invalid' : '' }}"
                                            placeholder="{{ translate('Enter  Text') }}" id="airport_transfer_search_text"
                                            name="airport_transfer_search_text[{{ $lang_id }}]" type="text">{{ getLanguageTranslate($get_aiport_transfer_text_langauge, $lang_id, $GPF['id'], 'title', 'top_destination_id') }}</textarea>
                                        @error('airport_transfer_search_text.' . $lang_id)
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    
                                </div>
                                <h4 class="text-dark">{{ translate('Top Destinations') }}</h4>
                                <div class="row">
                                    
                                    <div class="col-md-6">
                                        <label class="form-label"
                                            for="title">{{ translate('Main Title') }}<span
                                                class="text-danger">*</span>
                                        </label>
                                        <input
                                            class="form-control {{ $errors->has('top_destination_title.' . $lang_id) ? 'is-invalid' : '' }}"
                                            placeholder="{{ translate('Main Title') }}" id="top_destination_title"
                                            name="top_destination_title[{{ $lang_id }}]" type="text"
                                            value="{{ getLanguageTranslate($get_top_destination_title, $lang_id, 'heading_title', 'title', 'meta_title') }}" />
                                        @error('top_destination_title.' . $lang_id)
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="colcss">
                                        @php
                                            $top_data = 0;
                                        @endphp
                                        @foreach ($top_destinations as $GPF)
                                            @include('admin.home_page._top_destinations')
                                            @php
                                                $top_data++;
                                            @endphp
                                        @endforeach
                                        @if (empty($top_destinations))
                                            @include('admin.home_page._top_destinations')
                                        @endif

                                        <div class="show_top_destination">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 add_more_button">
                                                <button class="btn btn-success btn-sm float-end" type="button"
                                                    id="add_top_destination" title='Add more'>
                                                    <span class="fa fa-plus"></span> {{ translate('Add more') }}</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                {{-- Top Destinations End --}}

                {{-- Home Counts --}}
                <li class="tab-content tab-content-2 typography">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-body ">
                                <div class="row">
                                    <h4 class="text-dark">{{ translate('Home Counts') }}</h4>
                                    <div class="colcss">
                                        @php
                                            $data = 0;
                                        @endphp
                                        @foreach ($get_home_count as $GHC)
                                            @include('admin.home_page._home_counts')
                                            @php
                                                $data++;
                                            @endphp
                                        @endforeach
                                        @if (empty($get_home_count))
                                            @include('admin.home_page._home_counts')
                                        @endif

                                        <div class="show_works">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 add_more_button">
                                                {{-- <button class="btn btn-success btn-sm float-end" type="button"
                                                        id="add_home_count" title='Add more'>
                                                        <span class="fa fa-plus"></span> {{ translate('Add more') }}</button> --}}
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                {{-- Home Counts End --}}

                {{-- Top 10 Seller --}}
                <li class="tab-content tab-content-3 typography">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-body ">
                                <div class="row">
                                    <h4 class="text-dark">{{ translate('Top 10 Seller') }}</h4>
                                    <div class="row">
                                        
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label"
                                                for="title">{{ translate('Main Title') }}<span
                                                    class="text-danger">*</span>
                                            </label>
                                            <input
                                                class="form-control {{ $errors->has('top_ten_main_title.' . $lang_id) ? 'is-invalid' : '' }}"
                                                placeholder="{{ translate('Main Title') }}" id="top_ten_main_title"
                                                name="top_ten_main_title[{{ $lang_id }}]" type="text"
                                                value="{{ getLanguageTranslate($get_top_10_uae_heading, $lang_id, 'heading_title', 'title', 'meta_title') }}" />
                                            @error('top_ten_main_title.' . $lang_id)
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        

                                    </div>

                                    <div class="colcss">
                                        @php
                                            $data = 0;
                                        @endphp
                                        @foreach ($get_topTen_seller as $TTS)
                                            @include('admin.home_page._top_10_seller')
                                            @php
                                                $data++;
                                            @endphp
                                        @endforeach
                                        @if (count($get_topTen_seller) == 0)
                                            @include('admin.home_page._top_10_seller')
                                        @endif

                                        <div class="show_top_ten">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 add_more_button">
                                                <button class="btn btn-success btn-sm float-end" type="button"
                                                    id="top_10_seller" title='Add more'>
                                                    <span class="fa fa-plus"></span> {{ translate('Add more') }}</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                {{--  Top 10 Seller  --}}

                {{-- Recomeded Tour --}}
                <li class="tab-content tab-content-4 typography">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-body ">
                                <h4 class="text-dark">{{ translate('Recommended Tours') }}</h4>
                                <div class="row">
                                    
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label"
                                            for="title">{{ translate('Main Title') }}<span
                                                class="text-danger">*</span>
                                        </label>
                                        <input
                                            class="form-control {{ $errors->has('recommend_product_title.' . $lang_id) ? 'is-invalid' : '' }}"
                                            placeholder="{{ translate('Main Title') }}" id="recommend_product_title"
                                            name="recommend_product_title[{{ $lang_id }}]" type="text"
                                            value="{{ getLanguageTranslate($get_recommend_title, $lang_id, 'heading_title', 'title', 'meta_title') }}" />
                                        @error('recommend_product_title.' . $lang_id)
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="row mb-2">
                                        <?php
                                            $get_recomm_country_arr = [];
                                            /*$get_recomm_country = get_table_data('meta_global_language', 'content', 'recommended_tours', 'meta_parent');*/

                                            $get_meta_data = App\Models\MetaGlobalLanguage::select('*')
                                                        ->where('meta_parent', 'recommended_tours')
                                                        ->where('language_id', $lang_id)
                                                        ->first();
                                            $get_recomm_country = [];            
                                            if ($get_meta_data) {
                                                $get_recomm_country = $get_meta_data['content'];            
                                            }            

                                            if ($get_recomm_country) {
                                                $get_recomm_country_arr = explode(',', $get_recomm_country);
                                            }
                                        ?>
                                        <?php 
                                            $getcountry = array();
                                            foreach ($get_country as $country_key => $value){
                                                $getcountry[$value['id']] = $value['name'];
                                            }

                                            $get_country_selected = array();
                                            foreach ($get_recomm_country_arr as $country_key => $value){
                                                $get_country_selected[$value] = $getcountry[$value]; 
                                            }

                                            foreach ($get_country as $country_key => $value){
                                                if(in_array($value['id'], $get_recomm_country_arr)){
                                                }else{
                                                    $get_country_selected[$value['id']] = $value['name'];
                                                }
                                            }
                                        ?>
                                        <div class="col-md-4 content_title ">
                                            <label class="form-label" for="price">{{ translate('Country') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select
                                                class="form-select limit_5 single_select  {{ $errors->has('recom_country') ? 'is-invalid' : '' }}"
                                                name="recom_country[]" id="recom_country" multiple onchange="">
                                                <option value="" disabled>{{ translate('Select Country') }}</option>
                                                @foreach ($get_country_selected as $country_key => $value)
                                                    <option value="{{ $country_key }}"
                                                        {{ in_array($country_key, $get_recomm_country_arr) ? 'selected' : '' }}>
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                {{--  Recomeded Tour  --}}

                {{-- A World Of Adventures Awaits You --}}
                <li class="tab-content tab-content-5 typography">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-body ">
                                <h4 class="text-dark">{{ translate('World Of Adventures') }}</h4>
                                <div class="row">
                                    
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label"
                                            for="title">{{ translate('Main Title') }}<span
                                                class="text-danger">*</span>
                                        </label>
                                        <input
                                            class="form-control {{ $errors->has('adventures_awaits.' . $lang_id) ? 'is-invalid' : '' }}"
                                            placeholder="{{ translate('Main Title') }}" id="recommend_product_title"
                                            name="adventures_awaits[{{ $lang_id }}]" type="text"
                                            value="{{ getLanguageTranslate($get_adventure_title, $lang_id, 'heading_title', 'title', 'meta_title') }}" />
                                        @error('adventures_awaits.' . $lang_id)
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-md-4 content_title ">
                                            <label class="form-label" for="price">{{ translate('Country') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <?php
                                                $get_adventure_country_arr = [];
                                                /*$get_adventure_country = get_table_data('meta_global_language', 'content', 'world_of_adventure', 'meta_parent');*/

                                                $get_meta_data = App\Models\MetaGlobalLanguage::select('*')
                                                        ->where('meta_parent', 'world_of_adventure')
                                                        ->where('language_id', $lang_id)
                                                        ->first();
                                                $get_adventure_country = [];            
                                                if ($get_meta_data) {
                                                    $get_adventure_country = $get_meta_data['content'];            
                                                }        


                                                if ($get_adventure_country) {
                                                    $get_adventure_country_arr = explode(',', $get_adventure_country);
                                                }
                                            ?>
                                            <?php 
                                                $get_country_selected = array();
                                                foreach ($get_adventure_country_arr as $country_key => $value){
                                                    $get_country_selected[$value] = $getcountry[$value]; 
                                                }

                                                foreach ($get_country as $country_key => $value){
                                                    if(in_array($value['id'], $get_adventure_country_arr)){
                                                    }else{
                                                        $get_country_selected[$value['id']] = $value['name'];
                                                    }
                                                }
                                            ?>
                                            <select
                                                class="form-select limit_5 single_select  {{ $errors->has('adventures_country') ? 'is-invalid' : '' }}"
                                                name="adventures_country[]" id="adventures_country" multiple
                                                onchange="">
                                                <option value="" disabled>{{ translate('Select Country') }}</option>
                                                @foreach ($get_country_selected as $country_key => $value)
                                                    <option value="{{ $country_key }}"
                                                        {{ in_array($country_key, $get_adventure_country_arr) ? 'selected' : '' }}>
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                {{-- A World Of Adventures Awaits You --}}

                {{-- Main Banner Images Tab --}}
                <li class="tab-content tab-content-7  typography" style="display: none">
                    <div class="row colcss">
                        <div class="col-md-12">
                            <h4 class="text-dark">{{ translate('Home Banner Images') }}</h4>
                           
                                
                                {{-- <div class="col-md-6 mb-2">
                                    <label class="form-label"
                                        for="main_title">{{ translate('Main Title') }}<span
                                            class="text-danger">*</span>
                                    </label>
                                    <input
                                        class="form-control {{ $errors->has('main_banner_title.' . $lang_id) ? 'is-invalid' : '' }}"
                                        placeholder="{{ translate('Main Title') }}" id="main_banner_title"
                                        name="main_banner_title[{{ $lang_id }}]" type="text"
                                        value="{{ getLanguageTranslate($get_main_banner_title, $lang_id, 'home_main_banner_heading_title', 'title', 'meta_title') }}" />
                                    @error('main_banner_title.' . $lang_id)
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                           
                                <div class="col-md-6 mb-2">
                                    <label class="form-label"
                                        for="main_title_text">{{ translate('Title') }}<span
                                            class="text-danger">*</span>
                                    </label>
                                    <input
                                        class="form-control {{ $errors->has('main_banner_text.' . $lang_id) ? 'is-invalid' : '' }}"
                                        placeholder="{{ translate('Main Title') }}" id="recommend_product_title"
                                        name="main_banner_text[{{ $lang_id }}]" type="text"
                                        value="{{ getLanguageTranslate($get_main_banner_title, $lang_id, 'home_main_banner_heading_title', 'content', 'meta_title') }}" />
                                    @error('main_banner_text.' . $lang_id)
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div> --}}
                                
                            <div class="mb-3">
                                @php
                                    $data = 0;
                                @endphp
                                @foreach ($get_slider_images as $HSI)
                                    @include('admin.home_page._slider_images')
                                    @php
                                        $data++;
                                    @endphp
                                @endforeach
                                @if (count($get_slider_images) == 0)
                                    @include('admin.home_page._slider_images')
                                @endif
                                <div class="show_slider">
                                </div>
                                <div class="row">
                                    <div class="col-md-12 add_more_button">
                                        <button class="btn btn-success btn-sm float-end" type="button" id="add_slider"
                                            title='Add more'>
                                            <span class="fa fa-plus"></span> {{ translate('Add more') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                {{-- Slider Images Tab --}}

                {{-- Destination overview --}}
                <li class="tab-content tab-content-8 typography">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-body ">
                                <div class="row">
                                    <h4 class="text-dark">{{ translate('Destination Overview') }}</h4>

                                    
                                        <div class="col-md-6">
                                            <label class="form-label"
                                                for="title">{{ translate('Heading Title') }}<span
                                                    class="text-danger">*</span>
                                            </label>
                                            <input
                                                class="form-control {{ $errors->has('destination_overview_title.' . $lang_id) ? 'is-invalid' : '' }}"
                                                placeholder="{{ translate('Heading Title') }}"
                                                id="destination_overview_title"
                                                name="destination_overview_title[{{ $lang_id }}]" type="text"
                                                value="{{ getLanguageTranslate($get_destination_overview_title, $lang_id, 'destination_overview', 'title', 'meta_parent') }}" />
                                            @error('destination_overview_title.' . $lang_id)
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                   

                                    <div class="colcss">
                                        @php
                                            $data = 0;
                                        @endphp
                                        @foreach ($get_destination_overview as $HDO)
                                            @include('admin.home_page._destination_overview')
                                            @php
                                                $data++;
                                            @endphp
                                        @endforeach
                                        @if (empty($get_destination_overview))
                                            @include('admin.home_page._destination_overview')
                                        @endif

                                        <div class="show_overview">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 add_more_button">
                                                <button class="btn btn-success btn-sm float-end" type="button"
                                                    id="add_destination_overview" title='Add more'>
                                                    <span class="fa fa-plus"></span> {{ translate('Add more') }}</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                {{-- Destination overview End --}}

                {{-- Special Offer Tour --}}
                {{-- <li class="tab-content tab-content-9 typography">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-body ">
                                <h4 class="text-dark">{{ translate('Special Offers') }}</h4>
                                <div class="row">
                                    
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label"
                                                for="title">{{ translate('Main Title') }}<span
                                                    class="text-danger">*</span>
                                            </label>
                                            <input
                                                class="form-control {{ $errors->has('special_offer_title.' . $lang_id) ? 'is-invalid' : '' }}"
                                                placeholder="{{ translate('Main Title') }}" id="special_offer_title"
                                                name="special_offer_title[{{ $lang_id }}]" type="text"
                                                value="{{ getLanguageTranslate($get_special_offer_title, $lang_id, 'special_offer_heading_title', 'title', 'meta_title') }}" />
                                            @error('special_offer_title.' . $lang_id)
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                   

                                    <div class="row mb-2">
                                        <?php
                                        $get_recomm_country_arr = [];
                                        $get_recomm_country = get_table_data('meta_global_language', 'content', 'special_offers_tours', 'meta_parent');
                                        if ($get_recomm_country) {
                                            $get_recomm_country_arr = explode(',', $get_recomm_country);
                                        }
                                        
                                        ?>
                                        <div class="col-md-4 content_title ">
                                            <label class="form-label" for="price">{{ translate('Country') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select
                                                class="form-select limit_5 single_select  {{ $errors->has('special_offer_county') ? 'is-invalid' : '' }}"
                                                name="special_offer_county[]" id="special_offer_county" multiple
                                                onchange="">
                                                <option value="" disabled>{{ translate('Select Country') }}</option>
                                                @foreach ($get_country as $country_key => $value)
                                                    <option value="{{ $value['id'] }}"
                                                        {{ in_array($value['id'], $get_recomm_country_arr) ? 'selected' : '' }}>
                                                        {{ $value['name'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li> --}}
                {{--  Special Offer Tour  --}}

                {{-- Banner Overview --}}
                <li class="tab-content tab-content-10 typography">
                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-body ">
                                <h4 class="text-dark">{{ translate('Banner Overview') }}</h4>
                                <div class="colcss">
                                    @php
                                        $overview_count = 0;
                                    @endphp
                                    @foreach ($get_banner_over_view as $GBO)
                                        @include('admin.home_page._banner_overview')
                                        @php
                                            $overview_count++;
                                        @endphp
                                    @endforeach
                                    @if (count($get_banner_over_view) == 0)
                                        @include('admin.home_page._banner_overview')
                                    @endif
                                    <div class="show_banner_overview">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 add_more_button">
                                            <button class="btn btn-success btn-sm float-end" type="button"
                                                id="add_banner_overview" title='Add more'>
                                                <span class="fa fa-plus"></span> {{ translate('Add more') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                {{--  Special Offer Tour  --}}

                {{-- Slider Images Tab --}}
                <li class="tab-content tab-content-11  typography" style="display: none">
                    <div class="row colcss">
                        <div class="col-md-12">
                            <h4 class="text-dark">{{ translate('Home Middle Slider') }}</h4>
                            <div class="mb-3">
                                <label class="form-label" data-bs-toggle="tooltip" data-bs-placement="top"
                                    for="customFile2">{{ translate('Slider Image') }}<span
                                        class="fas fa-info-circle"></span>
                                </label>
                                @php
                                    $data = 0;
                                @endphp
                                @foreach ($get_middle_slider_images as $MSI)
                                    @include('admin.home_page._middle_slider_images')
                                    @php
                                        $data++;
                                    @endphp
                                @endforeach
                                @if (count($get_middle_slider_images) == 0)
                                    @include('admin.home_page._middle_slider_images')
                                @endif
                                <div class="show_middle_slider">
                                </div>
                                <div class="row">
                                    <div class="col-md-12 add_more_button">
                                        <button class="btn btn-success btn-sm float-end" type="button"
                                            id="add_middle_slider" title='Add more'>
                                            <span class="fa fa-plus"></span> {{ translate('Add more') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                {{-- Slider Images Tab --}}

                {{-- Zones add  --}}
                <li class="tab-content tab-content-13 typography">

                    {{-- <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-body ">
                                <h4 class="text-dark">{{ translate('Top destination') }}</h4>
                                <div class="colcss">

                                    <?php
                                    $get_top_dest_city_arr = [];
                                    $get_top_dest_city = get_table_data('meta_global_language', 'content', 'search_top_destination', 'meta_parent');
                                    
                                    if ($get_top_dest_city) {
                                        $get_top_dest_city_arr = explode(',', $get_top_dest_city);
                                    }
                                    
                                    ?>

                                    <div class="col-md-4 content_title ">
                                        <label class="form-label" for="price">{{ translate('City') }}
                                            <span class="text-danger">*</span>
                                        </label>

                                        <select
                                            class="form-select  single_select  {{ $errors->has('top_destination_city') ? 'is-invalid' : '' }}"
                                            name="top_destination_city[]" id="top_destination_city" multiple>

                                            <option value="" disabled>{{ translate('Select City') }}</option>

                                            @foreach ($get_city as $city_key => $value)
                                                @if ($value['city'] != null)
                                                    @php
                                                        $cityData = getDataFromDB('cities', ['id' => $value['city']], 'row');
                                                    @endphp
                                                    @if ($cityData !== '')
                                                        <option value="{{ $cityData->id }}"
                                                            {{ in_array($value['city'], $get_top_dest_city_arr) ? 'selected' : '' }}>
                                                            {{ $cityData->name }}
                                                        </option>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    <div class="col-lg-12">
                        <div class="card mb-3">
                            <div class="card-body ">
                                <h4 class="text-dark mt-3">{{ translate('Search Zones') }}</h4>
                                <div class="colcss" style="padding: 0px 20px 40px;">
                                    @php
                                        $data = 0;
                                        
                                    @endphp
                                    @foreach ($get_home_zone as $GHZ)
                                        @include('admin.home_page._add_zones')
                                        @php
                                            $data++;
                                        @endphp
                                    @endforeach
                                    @if (empty($get_home_zone))
                                        @include('admin.home_page._add_zones')
                                    @endif

                                    <div class="show_zones">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 add_more_button">
                                            <button class="btn btn-success btn-sm float-end" type="button"
                                                id="add_zones" title='Add more'>
                                                <span class="fa fa-plus"></span> {{ translate('Add more') }}</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                {{-- Zones add  --}}

            </ul>
        </div>

    </form>

    <!--Add Zones -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = '{{ count($get_home_zone) }}';
            $('#add_zones').click(function(e) {
                var ParamArr = {
                    'view': 'admin.home_page._add_zones',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_zones');
                e.preventDefault();
                count++;
            });

            $(document).on('click', ".delete_zones", function(e) {
                var length = $(".delete_zones").length;
                if (length > 1) {
                    deleteMsg('Are you sure to delete ?').then((result) => {
                        if (result.isConfirmed) {
                            $(this).parent().closest('.zones_div').remove();
                            e.preventDefault();
                        }
                    });
                }
            });
        });
    </script>

    <script type="text/javascript">
        count = 1;
        $(document).on("click", ".add_countries", function(e) {
            var DataID = $(this).data('val');
            // alert(DataID);
            let data = [];
            var ParamArr = {
                'view': 'admin.home_page._countries',
                'data': DataID,
                'id': count,
            }
            getAppendPage(ParamArr, '.show_country' + DataID);
            e.preventDefault();
            count++;
        });
        $(document).on('click', ".delete_country", function(e) {
            var length = $(".delete_country").length;
            if (length > 1) {
                deleteMsg('Are you sure to delete ?').then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent().closest('.country_div').remove();
                        e.preventDefault();
                    }
                });
            }
        });
    </script>

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


            $(".pick_from").each(function() {
                var time = $(this).val();
                $(this).flatpickr({
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "H:i",
                    defaultDate: time

                })
            });

            $(".pick_to").each(function() {
                var time = $(this).val();
                $(this).flatpickr({
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "H:i",
                    defaultDate: time

                })
            });
        });
    </script>

    {{-- <!--top_destination--> --}}
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
            var count = "{{ $top_data }}";
            $('#add_top_destination').click(function(e) {

                var ParamArr = {
                    'view': 'admin.home_page._top_destinations',
                    'top_data': count
                }
                getAppendPage(ParamArr, '.show_top_destination');
                const domNode = document.querySelector('body');
                // google.maps.event.addDomListenerOnce(domNode, 'mouseover', initialize);
                domNode.addEventListenerOnce('mouseover', initialize);


                e.preventDefault();
                count++;
            });
            $(document).on('click', ".delete_top_destination", function(e) {
                var length = $(".delete_top_destination").length;
                if (length > 1) {
                    deleteMsg('Are you sure to delete ?').then((result) => {
                        if (result.isConfirmed) {
                            $(this).parent().closest('.top_destination_div').remove();
                            e.preventDefault();
                        }
                    });
                }
            });
        });
        $(document).ready(function() {
            var count = 1;
            $('#add_home_count').click(function(e) {

                var ParamArr = {
                    'view': 'admin.home_page._home_counts',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_works');
                e.preventDefault();
                count++;
            });
            // $(document).on('click', ".delete_faq", function(e) {
            //     var length = $(".delete_faq").length;
            //     if (length > 1) {
            //         deleteMsg('Are you sure to delete ?').then((result) => {
            //             if (result.isConfirmed) {
            //                 $(this).parent().closest('.faq_div').remove();
            //                 e.preventDefault();
            //             }
            //         });
            //     }
            // });
        });
        $(document).ready(function() {
            // $(".single_select").each(function(evt) {
            //     // ...
            //     console.log("evt",evt)
            //     var element = evt.params.data.element;
            //     var $element = $(element);
                
            //     $element.detach();
            //     $(this).append($element);
            //     $(this).trigger("change");
            // });
            
            
            $(".single_select").select2();
            $(".single_select").on("select2:select", function (evt) {
                console.log("evt",evt)
                var element = evt.params.data.element;
                var $element = $(element);
                
                $element.detach();
                $(this).append($element);
                $(this).trigger("change");
            });
            
            
            $(".limit_5").select2({
                maximumSelectionLength: 5,
            });
            var count = 1;
            $('#top_10_seller').click(function(e) {
                var ParamArr = {
                    'view': 'admin.home_page._top_10_seller',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_top_ten');
                e.preventDefault();
                count++;

            });
        });

        $(document).on('click', ".delete_top_10_seller", function(e) {
            var length = $(".delete_top_10_seller").length;
            if (length > 1) {
                deleteMsg('Are you sure to delete ?').then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent().closest('.top_10_seller_div').remove();
                        e.preventDefault();
                    }
                });
            }
        });


        $(document).ready(function() {
            var count = 1;
            $('#add_destination_overview').click(function(e) {

                var ParamArr = {
                    'view': 'admin.home_page._destination_overview',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_overview');
                e.preventDefault();
                count++;
            });
            $(document).on('click', ".delete_overview", function(e) {
                var length = $(".delete_overview").length;
                if (length > 1) {
                    deleteMsg('Are you sure to delete ?').then((result) => {
                        if (result.isConfirmed) {
                            $(this).parent().closest('.overview_div').remove();
                            e.preventDefault();
                        }
                    });
                }
            });
        });
    </script>

    <!-- Why chooose affiliate -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = 1;
            $('#add_choose').click(function(e) {

                var ParamArr = {
                    'view': 'admin.affiliate_page._why_choose',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_choose');

                e.preventDefault();
                count++;
            });


            $(document).on('click', ".delete_faq", function(e) {
                var length = $(".delete_faq").length;
                if (length > 1) {
                    deleteMsg('Are you sure to delete ?').then((result) => {
                        if (result.isConfirmed) {
                            $(this).parent().closest('.choose_div').remove();
                            e.preventDefault();
                        }
                    });
                }
            });


        });
    </script>

    <!--Affiliate FAQS -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = 1;
            $('#add_faqs').click(function(e) {
                var ParamArr = {
                    'view': 'admin.affiliate_page._affiliate_faq',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_faqs');
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
    {{-- My JS Start --}}
    <script>
        // function getCountry(country, selectedCat, count = "") {
        //     var categoryArr = [];
        //     if (count != "") {
        //         $(".category").each(function(k, v) {
        //             console.log($(v).val());
        //             if ($(v).val() != "") {
        //                 categoryArr.push($(v).val());
        //             }
        //         });
        //     } else {
        //         $(".show_category").html("");
        //     }
        //     $.ajax({
        //         "type": "POST",
        //         "url": "{{ route('admin.get_category_by_country') }}",
        //         "data": {
        //             _token: "{{ csrf_token() }}",
        //             country: country,
        //             selectedCat: selectedCat,
        //             data: categoryArr,
        //             array: ""
        //         },
        //         "success": function(response) {
        //             if (count == "") {
        //                 $(".category").each(function(kk, vv) {
        //                     $(vv).html(response);
        //                 })
        //             } else {
        //                 setTimeout(() => {
        //                     $("#category_" + count).html(response);
        //                 }, 1000);

        //             }
        //         }

        //     })

        // }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            var count = "{{ $overview_count }}";
            $('#add_banner_overview').click(function(e) {
                var length = $(".banner_over_view_row").length;
                console.log("length", length)
                if (length <= 3) {
                    var ParamArr = {
                        'view': 'admin.home_page._banner_overview',
                        'data': count,
                        'overview_count': count,
                    }
                    getAppendPage(ParamArr, '.show_banner_overview');
                    e.preventDefault();
                    count++;
                }
            });


            $(document).on('click', ".banner_over_view_delete", function(e) {
                var length = $(".banner_over_view_delete").length;
                if (length > 1) {
                    deleteMsg('Are you sure to delete ?').then((result) => {
                        if (result.isConfirmed) {
                            $(this).parent().closest('.banner_over_view_row').remove();
                            e.preventDefault();
                        }
                    });
                }
            });


        });
    </script>
    <script>
        if (window.File && window.FileList && window.FileReader) {
            $("#slider_images").on("change", function(e) {
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
                        $(".sliderappenImage").append(html);
                    });
                    fileReader.readAsDataURL(f);
                }
            });
        } else {
            alert("Your browser doesn't support to File API")
        }
    </script>

    {{-- My JS End --}}

    <!-- Slider Overview -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = 1;
            $('#add_slider').click(function(e) {
                var length = $(".slider_row").length;

                var ParamArr = {
                    'view': 'admin.home_page._slider_images',
                    'data': count,
                }
                getAppendPage(ParamArr, '.show_slider');
                e.preventDefault();
                count++;

            });


            $(document).on('click', ".slider_delete", function(e) {
                var length = $(".slider_delete").length;
                if (length > 1) {
                    deleteMsg('Are you sure to delete ?').then((result) => {
                        if (result.isConfirmed) {
                            $(this).parent().closest('.slider_row').remove();
                            e.preventDefault();
                        }
                    });
                }
            });


        });
    </script>

    <!-- Middle Slider Overview -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = 1;
            $('#add_middle_slider').click(function(e) {
                var length = $(".middle_slider_row").length;

                var ParamArr = {
                    'view': 'admin.home_page._middle_slider_images',
                    'data': count,
                }
                getAppendPage(ParamArr, '.show_middle_slider');
                e.preventDefault();
                count++;

            });


            $(document).on('click', ".middle_slider_delete", function(e) {
                var length = $(".middle_slider_delete").length;
                if (length > 1) {
                    deleteMsg('Are you sure to delete ?').then((result) => {
                        if (result.isConfirmed) {
                            $(this).parent().closest('.middle_slider_row').remove();
                            e.preventDefault();
                        }
                    });
                }
            });
        });
    </script>
    <script type="text/javascript">
        $(function() {
            $('.editor').each(function(e) {
                CKEDITOR.replace(this.name);
            });
        });
    </script>
@endsection
