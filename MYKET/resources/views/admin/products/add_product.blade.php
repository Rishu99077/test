@extends('admin.layout.master')
@section('content')

    <div class="page-wrapper add_product">
        <div class="step" id="step_form_id">
            @php
                $class = '';
            @endphp
            @if (!isset($_GET['tourId']))
                <form enctype="multipart/form-data" action="" id="stepOneform">
                    @csrf
                    <div class="addProduct_content" id="form-step1">
                        <h2><b>{{ translate('Create a new product') }}</b> </h2>
                        <div class="how-it-works">
                            <p class="how-it-works__intro f-w-600">{{ translate('Check our') }}
                                <a class="link-text" href="#"
                                    target="blank">{{ translate('general product guidelines') }} </a>
                                {{ translate(' in order to provide the most accurate information to your customers. Remember to provide all content in') }}
                                <strong>{{ translate('English') }}</strong>.
                            </p>
                            <ul class="work_list">
                                <li><span class="bold_txt">{{ translate('Tip') }} :</span><a class="link-text"
                                        href="#" target="_blank">
                                        {{ translate('Check') }}</a>
                                    {{ translate('first whether you should create a new activity or a new option for an existing activity.') }}
                                </li>

                                <li><span class="bold_txt">{{ translate('Tip') }} : </span>{{ translate('Read our') }}<a
                                        class="link-text" href="#" target="_blank">
                                        {{ translate('responsible tourism guidelines') }}</a>{{ translate(' Any product that doesn’t follow these guidelines will be removed.') }}
                                </li>
                            </ul>
                            <div class="yourProd_txt alert alert-info  background-info" role="alert">
                                <h6 class="title-padding "><span class="icon-info text-dark"></span>
                                    {{ translate('Your product will go live immediately') }}
                                </h6>
                                <p class=" d-block">
                                    {{ translate('As soon as you finish creating your product, customers will be able to book it on GetYourGuide\'s website. You can continue to make edits whenever you like') }}
                                </p>
                            </div>
                            <div class="describe-activity">
                                <div class="descrbActivity_content">
                                    <p class="section-question">{{ translate(' Which best describes your activity?') }}
                                    </p>
                                    <p>{{ translate('This helps us categorize your product so customers can find it.') }}
                                        <strong> {{ translate('Choose carefully, you can’t change this later.') }}</strong>
                                    </p>
                                </div>
                                <div class="descrbActivity_List">
                                    <ul class="radio-buttons-container" data-test-id="product-create-type-list">
                                        <li class="selection-item radio-with-explanation">
                                            <div class="inline-input-container"><input class="custom-radioBtn"
                                                    id="attraction-ticket" name="product_type" type="radio"
                                                    value="attraction_ticket"><label for="attraction-ticket"
                                                    class="radio-label"><span
                                                        class="main d-block font-weight-bold">{{ translate('Attraction ticket') }}</span><span
                                                        class="explanation small-label">{{ translate('Like entry to a landmark, theme park, show') }}</span></label>
                                            </div>
                                        </li>
                                        <li class="selection-item radio-with-explanation">
                                            <div class="inline-input-container"><input class="custom-radioBtn"
                                                    id="tour" name="product_type" type="radio" value="tour"><label
                                                    for="tour" class="radio-label"><span
                                                        class="main d-block font-weight-bold">{{ translate('Tour') }}</span><span
                                                        class="explanation small-label">{{ translate('Like a guided walking tour, day trip, city cruise') }}</span></label>
                                            </div>
                                        </li>
                                        <li class="selection-item radio-with-explanation">
                                            <div class="inline-input-container"><input class="custom-radioBtn"
                                                    id="city-card" name="product_type" type="radio"
                                                    value="city_card"><label for="city-card" class="radio-label"><span
                                                        class="main d-block font-weight-bold">{{ translate('City card') }}</span><span
                                                        class="explanation small-label">
                                                        {{ translate('A pass for multiple attractions or transport within a city') }}
                                                    </span></label>
                                            </div>
                                        </li>

                                    </ul>
                                    <div class="col-form-alert-label"></div>
                                </div>
                            </div>
                        </div>
                        <div class="continueBtn">
                            <button type="submit" id="verifyBtn" class="next action-button step-one-btn"
                                disabled="disabled">
                                <i class="icofont icofont-refresh rotate-refresh mt-1 d-none"></i>
                                {{ translate('Save and continue') }}</button>
                            <!--  <button  onClick="submitForm(this);" type="button"name="next" class="next action-button" disabled="disabled">Save and continue</button> -->
                        </div>
                    </div>
                </form>
                @php
                    $class = 'step_hidden_cls';
                @endphp
            @endif

            <div class="{{ $class }} step-two" id="form-step2">

                <div class="tab-vertical">
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
                            <div class="verticalTab">

                                <ul class="nav nav-tabs allTab @if (isset($_GET['optionId'])) d-none @endif "
                                    id="myTab3" role="tablist">
                                    <li class="nav-item titleNav">
                                        <a class="nav-link {{ get_active_tab(get_url_segment(), 'title') }}"
                                            id="title-vertical-tab" data-toggle="tab" href="#title-vertical" role="tab"
                                            aria-controls="title" aria-selected="true"> {{ translate('Title') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <h6 class="f-18 font-weight-bold mt-3 pl-4">{{ translate('Basic Info') }}</h6>
                                    </li>
                                    <li class=" titleList">

                                        <ul class="nav nav-tabs sublist" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link {{ get_active_tab(get_url_segment(), 'location') }}"
                                                    id="loc-vertical-tab" data-toggle="tab" href="#loc-vertical"
                                                    role="tab" aria-controls="location"
                                                    aria-selected="false">{{ translate('Location') }}</a>
                                            </li>

                                            <li class="nav-item">
                                                <a class="nav-link {{ get_active_tab(get_url_segment(), 'transportation') }}"
                                                    id="trans-vertical-tab" data-toggle="tab" href="#trans-vertical"
                                                    role="tab" aria-controls="transportation"
                                                    aria-selected="false">{{ translate('Transportation') }}</a>
                                            </li>
                                            @if (@$data['product']->type != 'city_card')
                                                <li class="nav-item">
                                                    <a class="nav-link nav-city {{ get_active_tab(get_url_segment(), 'activityInfo') }}"
                                                        id="activityInfo" data-toggle="tab" href="#activityInfo-vertical"
                                                        role="tab" aria-controls="activityInfo"
                                                        aria-selected="false">{{ translate('Guide & activity info') }}</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link  nav-city {{ get_active_tab(get_url_segment(), 'food') }}"
                                                        id="food" data-toggle="tab" href="#food-vertical"
                                                        role="tab" aria-controls="food"
                                                        aria-selected="false">{{ translate('Food & drink') }}</a>
                                                </li>
                                            @endif
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <h6 class="f-18 font-weight-bold mt-3 pl-4">{{ translate('Activity details') }}
                                        </h6>
                                    </li>
                                    <li class="titleList nav-item">
                                        <ul class="nav nav-tabs sublist" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link {{ get_active_tab(get_url_segment(), 'inclusion') }}"
                                                    id="inclus-vertical-tab" data-toggle="tab" href="#inclus-vertical"
                                                    role="tab" aria-controls="inclusion"
                                                    aria-selected="false">{{ translate('Inclusions & highlights') }}</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link {{ get_active_tab(get_url_segment(), 'keyword') }}"
                                                    id="key-vertical-tab" data-toggle="tab" href="#key-vertical"
                                                    role="tab" aria-controls="keyword"
                                                    aria-selected="false">{{ translate('Keywords') }}</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link {{ get_active_tab(get_url_segment(), 'information') }}"
                                                    id="information-vertical-tab" data-toggle="tab"
                                                    href="#information-vertical" role="tab"
                                                    aria-controls="information"
                                                    aria-selected="false">{{ translate('Important Information') }}</a>
                                            </li>
                                            {{-- <li class="nav-item">
                                                <a class="nav-link {{ get_active_tab(get_url_segment(), 'covid') }}"
                                                    id="covid-vertical-tab" data-toggle="tab" href="#covid-vertical"
                                                    role="tab" aria-controls="covid" aria-selected="false">Covid-19
                                                    info</a>
                                            </li> --}}
                                            <li class="nav-item">
                                                <a class="nav-link {{ get_active_tab(get_url_segment(), 'photos') }}"
                                                    id="imag-vertical-tab" data-toggle="tab" href="#imag-vertical"
                                                    role="tab" aria-controls="photos"
                                                    aria-selected="false">{{ translate('Gallery') }}</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link {{ get_active_tab(get_url_segment(), 'about_activity') }}"
                                                    id="about-activity-vertical-tab" data-toggle="tab"
                                                    href="#about-activity-vertical" role="tab"
                                                    aria-controls="about_activity"
                                                    aria-selected="false">{{ translate('About Activity') }}</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ get_active_tab(get_url_segment(), 'others') }}"
                                            id="others-vertical-tab" data-toggle="tab" href="#others-vertical"
                                            role="tab" aria-controls="others"
                                            aria-selected="true">{{ translate('Others') }}</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link {{ get_active_tab(get_url_segment(), 'options') }}"
                                            id="options-vertical-tab" data-toggle="tab" href="#options-vertical"
                                            role="tab" aria-controls="options"
                                            aria-selected="true">{{ translate('Options') }}</a>
                                    </li>

                                </ul>

                                <ul class="nav nav-tabs optionTab sublist @if (!isset($_GET['optionId'])) d-none @endif"
                                    id="optionTab" role="tablist">

                                    <div class="create_btn mb-3">
                                        <button type="button" class="learnMore ml-3 backToProduct" id="backToProduct">
                                            <span class="fa fa-caret-left"></span>
                                            {{ translate('Back to product') }}</a>
                                        </button>
                                    </div>
                                    <li class="nav-item">

                                        <a class="nav-link {{ get_active_tab(get_url_segment(), 'optionSetup') }}"
                                            id="setup-vertical-tab" data-toggle="tab" href="#setup-vertical"
                                            role="tab" aria-controls="optionSetup"
                                            aria-selected="true">{{ translate('Option Setup') }}</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link {{ get_active_tab(get_url_segment(), 'optionPrice') }}"
                                            id="option-price-vertical-tab" data-toggle="tab"
                                            href="#option-price-vertical" role="tab" aria-controls="optionPrice"
                                            aria-selected="true">{{ translate('Pricing') }}</a>
                                    </li>

                                </ul>

                            </div>
                        </div>
                        <div class="col-xl-9 col-lg-9 col-md-8 col-sm-12 col-12">
                            <div class="tab-content allTabContent @if (isset($_GET['optionId'])) d-none @endif"
                                id="myTabContent3">
                                <div class="tab-pane fade {{ get_active_tab(get_url_segment(), 'title') }}"
                                    id="title-vertical" role="tabpanel" aria-labelledby="title-vertical-tab">
                                    <div class="stepOne-form">
                                        <div class="title_stepOne">
                                            <h2>{{ translate('Title') }}</h2>
                                        </div>
                                        <div class="section title">
                                            <h6 class="section-question">
                                                {{ translate('What is the title of your activity?') }}
                                                <a href="#" class="learnMore">{{ translate('Learn more') }} </a>
                                            </h6>
                                            <div class="instructions">
                                                <p class="instruction">
                                                    {{ translate('Write a short descriptive title to help customers understand your product. It should include:') }}
                                                </p>
                                                <ul class="instruction">
                                                    <li> {{ translate('the activity’s main location (where the activity starts from or takes place)') }}
                                                    </li>
                                                    <li>{{ translate('the type of activity (e.g. an entry ticket, a walking tour, a full-day trip, etc)') }}
                                                    </li>
                                                    <li>{{ translate('any important inclusions (e.g. transportation, meals, etc)') }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- Example Box -->
                                        <div class="examples">
                                            <div class="example-grid-container">
                                                <div class="good-examples">
                                                    <h3 class="examples-title"> {{ translate('Examples') }} </h3>
                                                    <ul>
                                                        <li>
                                                            <p><span>
                                                                    <i class="fa fa-check" aria-hidden="true"></i>
                                                                </span>
                                                                {{ translate('Santorini: Highlights Tour with Wine Tasting & Sunset in Oia') }}
                                                            </p>
                                                        </li>
                                                        <li>
                                                            <p><span><i class="fa fa-check" aria-hidden="true"></i>
                                                                </span>
                                                                {{ translate('Rome: Vatican, Sistine Chapel, and St. Peter\'s Tour') }}
                                                            </p>
                                                        </li>
                                                        <li>
                                                            <p><span>
                                                                    <i class="fa fa-check" aria-hidden="true"></i>
                                                                </span>
                                                                {{ translate('From Dublin: Giant\'s Causeway and Belfast City Full-Day Trip') }}
                                                            </p>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="bad-examples">
                                                    <h3 class="examples-title"> {{ translate('Examples') }} </h3>
                                                    <ul>
                                                        <li>
                                                            <p><span>
                                                                    <i class="fa fa-check" aria-hidden="true"></i>
                                                                </span>
                                                                {{ translate('Santorini: Highlights Tour with Wine Tasting & Sunset in Oia') }}
                                                            </p>
                                                        </li>
                                                        <li>
                                                            <p><span><i class="fa fa-check" aria-hidden="true"></i>
                                                                </span>
                                                                {{ translate('Rome: Vatican, Sistine Chapel, and St. Peter\'s Tour') }}
                                                            </p>
                                                        </li>
                                                        <li>
                                                            <p><span>
                                                                    <i class="fa fa-check" aria-hidden="true"></i>
                                                                </span>
                                                                {{ translate('From Dublin: Giant\'s Causeway and Belfast City Full-Day Trip') }}
                                                            </p>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <form enctype="multipart/form-data" action="" id="stepTwoform">
                                            @csrf
                                            <div class="inputfield title_filed">
                                                <input class="form-control input_txt w-75"
                                                    value="{{ isset($data['ProductDescription']) ? $data['ProductDescription']->title : 'Default Title' }}"
                                                    onkeyup="CharcterCount(this,60)" id="title" maxlength="60"
                                                    minlength="1" name="title" errors="">

                                                <p class="charCount">60 characters left </p>
                                                <div class=" col-form-alert-label">

                                                </div>
                                            </div>
                                            <div class="inputfield title_filed product_code">
                                                <h5>{{ translate('Description') }}</h5>
                                                <textarea name="description" class="form-control input_txt w-7" id="description" cols="30" rows="10">{{ @$data['ProductDescription']->description }}</textarea>
                                                <div class=" col-form-alert-label">
                                                </div>
                                            </div>
                                            <div class="product_code">
                                                <h5>{{ translate('Product reference code') }}</h5>
                                                <p>{{ translate('To help you keep track of your products on GetYourGuide, add your own reference code or name.') }}
                                                </p>
                                                <p>{{ translate('We’ll also assign our own code.') }}</p>
                                                <div class="inputfield title_filed">
                                                    <input class="form-control input_txt w-75"
                                                        value="{{ @$data['product']->reference_code }}"
                                                        onkeyup="CharcterCount(this,20)" id="refrence_code"
                                                        maxlength="20" minlength="1" name="refrence_code"
                                                        errors="">
                                                    <p class="charCount">20 characters left</p>
                                                    <div class=" col-form-alert-label">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6 col-md-6 col-sm-12">
                                                    <div class="inputfield title_filed product_code">
                                                        <h5>{{ translate('Categories') }}</h5>
                                                        <select class="js-example-basic-hide-search col-sm-12"
                                                            id="category" name="category" style="width: 75%">
                                                            <option selected disabled value="">
                                                                {{ translate('Select Category') }}</option>
                                                            @foreach ($categories as $key => $C)
                                                                <option value="{{ $C['id'] }}"
                                                                    {{ getSelected(@$data['product']->category, $C['id']) }}>
                                                                    {{ $C['title'] }}
                                                                </option>
                                                            @endforeach

                                                        </select>
                                                        <div class=" col-form-alert-label">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-6 col-md-6 col-sm-12">
                                                    <div class="inputfield title_filed product_code interests_div">
                                                        <h5>{{ translate('Interests') }}</h5>
                                                        @php
                                                            $interest = [];
                                                            if (isset($data['product'])) {
                                                                $interest = $data['product']->interest;
                                                            }
                                                        @endphp

                                                        <select class="js-example-basic-hide-search col-sm-12" multiple
                                                            id="interest" name="interest[]">

                                                            @foreach ($interests as $key => $I)
                                                                <option value="{{ $I['id'] }}"
                                                                    {{ getSelectedInArray($I['id'], $interest) }}>
                                                                    {{ $I['title'] }}
                                                                </option>
                                                            @endforeach

                                                        </select>
                                                        <div class=" col-form-alert-label">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-xl-6 col-md-6 col-sm-12">
                                                    <div class="inputfield title_filed product_code">
                                                        <h5>{{ translate('Black Out Date') }}</h5>
                                                        <input class="form-control multidatePick note_on_sale_date"
                                                            id="note_on_sale_date" name="note_on_sale_date"
                                                            type="text"
                                                            value="{{ isset($data['product']) ? $data['product']->not_on_sale : '' }}"
                                                            readonly="readonly">

                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-md-6 col-sm-12">
                                                    <div class="inputfield title_filed product_code product_type_div">
                                                        <h5>{{ translate('Product Type') }}</h5>
                                                        @php
                                                            $product_type = [];
                                                            if (isset($data['product'])) {
                                                                $product_type = $data['product']->product_type;
                                                            }
                                                        @endphp

                                                        <select class="js-example-basic-hide-search col-sm-12" multiple
                                                            id="product_title_type" name="product_title_type[]">

                                                            @foreach ($ProductType as $key => $PT)
                                                                <option value="{{ $PT['id'] }}"
                                                                    {{ getSelectedInArray($PT['id'], $product_type) }}>
                                                                    {{ $PT['title'] }}
                                                                </option>
                                                            @endforeach

                                                        </select>
                                                        <div class=" col-form-alert-label">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-12 col-md-12 col-sm-12">
                                                    <div class="inputfield title_filed product_code top_attraction_div">
                                                        <h5>{{ translate('Top Attraction') }}</h5>
                                                        @php
                                                            $top_attraction = [];
                                                            if (isset($data['product'])) {
                                                                $top_attraction = $data['product']->top_attraction;
                                                            }
                                                        @endphp

                                                        <select class="js-example-basic-hide-search col-sm-12" multiple
                                                            id="top_attraction" name="top_attraction[]">

                                                            @foreach ($topAttraction as $key => $TA)
                                                                <option value="{{ $TA['id'] }}"
                                                                    {{ getSelectedInArray($TA['id'], $top_attraction) }}>
                                                                    {{ $TA['title'] }}
                                                                </option>
                                                            @endforeach

                                                        </select>
                                                        <div class=" col-form-alert-label">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6 col-md-6 col-sm-12">
                                                    <div class="inputfield title_filed product_code">
                                                        <div class="checkbox-fade fade-in-primary">
                                                            <label>
                                                                <input type="checkbox" name="recommended_tour"
                                                                    {{ getChecked(@$data['product']->recommended_tour, 'yes') }}
                                                                    value="yes">
                                                                <span class="cr">
                                                                    <i
                                                                        class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                                                </span> <span>{{ translate('Recommended Tours') }}</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-md-6 col-sm-12">
                                                    <div class="inputfield title_filed product_code">
                                                        <div class="checkbox-fade fade-in-primary">
                                                            <label>
                                                                <input type="checkbox" name="awaits_for_you"
                                                                    {{ getChecked(@$data['product']->awaits_for_you, 'yes') }}
                                                                    value="yes">
                                                                <span class="cr">
                                                                    <i
                                                                        class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                                                </span>
                                                                <span>{{ translate('Adventures Await For You') }}</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-md-6 col-sm-12">
                                                    <div class="inputfield title_filed product_code">
                                                        <div class="checkbox-fade fade-in-primary">
                                                            <label>
                                                                <input type="checkbox" name="cultural_experiences"
                                                                    {{ getChecked(@$data['product']->cultural_experiences, 'yes') }}
                                                                    value="yes">
                                                                <span class="cr">
                                                                    <i
                                                                        class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                                                </span>
                                                                <span>{{ translate('Unforgettable cultural experiences') }}</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-md-6 col-sm-12">
                                                    <div class="inputfield title_filed product_code">
                                                        <div class="checkbox-fade fade-in-primary">
                                                            <label>
                                                                <input type="checkbox" name="cultural_attractions"
                                                                    {{ getChecked(@$data['product']->cultural_attractions, 'yes') }}
                                                                    value="yes">
                                                                <span class="cr">
                                                                    <i
                                                                        class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                                                </span>
                                                                <span>{{ translate('Must-see cultural attractions') }}</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-6 col-md-6 col-sm-12">
                                                    <div class="inputfield title_filed product_code">
                                                        <h5>{{ translate('Country') }}</h5>
                                                        <select id="country" name="country"
                                                            onchange="getStateCity('country')"
                                                            class="form-control select2">
                                                            <option value="" disabled selected>
                                                                {{ translate('Select') }}</option>
                                                            @foreach ($Countries as $C)
                                                                <option value="{{ $C['id'] }}"
                                                                    {{ getSelected($C['id'], @$data['product']->country) }}>
                                                                    {{ $C['name'] }}
                                                                </option>
                                                            @endforeach

                                                        </select>
                                                        <div class=" col-form-alert-label">

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-6 col-md-6 col-sm-12">
                                                    <div class="inputfield title_filed product_code">
                                                        <h5>{{ translate('State') }}</h5>
                                                        <select id="state" name="state"
                                                            onchange="getStateCity('state')" class="form-control select2">
                                                            <option value="" disabled selected>
                                                                {{ translate('Select') }}</option>
                                                            @foreach ($States as $S)
                                                                <option value="{{ $S['id'] }}"
                                                                    {{ getSelected($S['id'], @$data['product']->state) }}>
                                                                    {{ $S['name'] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <div class=" col-form-alert-label">

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-6 col-md-6 col-sm-12">
                                                    <div class="inputfield title_filed product_code">
                                                        <h5>{{ translate('City') }}</h5>
                                                        <select id="city" name="city"
                                                            class="form-control select2">
                                                            <option value="" disabled selected>
                                                                {{ translate('Select') }}</option>
                                                            @foreach ($Cities as $CI)
                                                                <option value="{{ $CI['id'] }}"
                                                                    {{ getSelected($CI['id'], @$data['product']->city) }}>
                                                                    {{ $CI['name'] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <div class=" col-form-alert-label">

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-6 col-md-6 col-sm-12">
                                                    <div class="inputfield title_filed product_code">
                                                        <h5>{{ translate('Duration text') }}</h5>
                                                        <input class="form-control input_txt"
                                                            value="{{ isset($data['product']) ? $data['product']->duration_text : '' }}"
                                                            id="duration_text" name="duration_text" errors="">
                                                        <div class=" col-form-alert-label">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-md-6 col-sm-12">
                                                    <div class="inputfield title_filed product_code">
                                                        <h5>{{ translate('Activity') }}</h5>
                                                        <input class="form-control input_txt"
                                                            value="{{ isset($data['product']) ? $data['product']->activity_text : '' }}"
                                                            id="activity_text" name="activity_text" errors="">
                                                        <div class=" col-form-alert-label">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-md-6 col-sm-12">
                                                    <div class="inputfield title_filed product_code">
                                                        <h5>{{ translate('Status') }}</h5>
                                                        <select name="product_status" id="product_status"
                                                            class="form-control single-select">
                                                            <option value="Draft" selected>
                                                                {{ translate('Draft') }}</option>
                                                            <option value="Active"
                                                                {{ getSelected(@$data['product']->status, 'Active') }}>
                                                                {{ translate('Active') }}</option>
                                                            <option value="Deactive"
                                                                {{ getSelected(@$data['product']->status, 'Deactive') }}>
                                                                {{ translate('Deactive') }}</option>
                                                        </select>

                                                    </div>
                                                </div>
                                                {{-- <div class="col-xl-6 col-md-6 col-sm-12">
                                                    <div class="inputfield title_filed product_code">
                                                        <h5>{{ translate('Approved') }}</h5>
                                                        <select name="is_approved" id="is_approved"
                                                            class="form-control single-select">

                                                            <option value="Approved"
                                                                {{ getSelected(@$data['product']->is_approved, 'Approved') }}>
                                                                {{ translate('Approved') }}</option>
                                                            <option value="Not approved"
                                                                {{ getSelected(@$data['product']->is_approved, 'Not approved') }}>
                                                                {{ translate('Not approved') }}</option>
                                                        </select>

                                                    </div>
                                                </div> --}}

                                                <div class="col-xl-12 col-md-12 col-sm-12">
                                                    <p class="text-danger mt-2"><span>{{ translate('Note') }}:</span>
                                                        {{ translate('After create option price you can make product status active') }}
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="continueBtn">
                                                <button type="submit" id=""
                                                    class="next action-button step-two-btn"
                                                    {{ @$data['product'] ? '' : 'disabled' }}>
                                                    <i class="icofont icofont-refresh rotate-refresh mt-1 d-none"></i>
                                                    {{ translate('Save and continue') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade  {{ get_active_tab(get_url_segment(), 'location') }}"
                                    id="loc-vertical" role="tabpanel" aria-labelledby="loc-vertical-tab">
                                    <div class="stepTwo-form">
                                        <div class="title_stepOne title_step">
                                            <h2>{{ translate('Location') }}</h2>
                                        </div>
                                        <div class="section title">
                                            <h6 class="section-question">
                                                {{ translate(' What will customers visit?') }}
                                                <a href="#" class="learnMore"> {{ translate('Learn more') }} </a>
                                            </h6>
                                            <div class="instructions">
                                                <p class="instruction">
                                                    {{ translate('List all the major sites and locations that your customers will visit. Select the most relevant entry type.') }}
                                                </p>
                                                <ul class="instruction">
                                                    <li><span
                                                            class="bold_txt">{{ translate('Entry ticket included') }}:</span>
                                                        {{ translate('the ticket to visit this location is included in the activity price') }}
                                                    </li>
                                                    <li><span
                                                            class="bold_txt">{{ translate('Entry ticket not included') }}:</span>
                                                        {{ translate('the ticket is not included and your customers will pay an extra entry fee') }}
                                                    </li>
                                                    <li><span
                                                            class="bold_txt">{{ translate('Outside only') }}:</span>{{ translate('your customers stop and visit this location, but they don’t enter inside') }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- Example Box -->
                                        <div class="examples">
                                            <div class="example-grid-container">
                                                <div class="good-examples">
                                                    <h3 class="examples-title"> {{ translate('Examples') }} </h3>
                                                    <ul>
                                                        <li>
                                                            <p><span><i class="fa fa-check"
                                                                        aria-hidden="true"></i></span>{{ translate('Hong Kong Disneyland — Entry ticket included') }}
                                                            </p>
                                                        </li>
                                                        <li>
                                                            <p><span><i class="fa fa-check"
                                                                        aria-hidden="true"></i></span>{{ translate('Eiffel Tower Summit — Entry ticket not included') }}
                                                            </p>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="bad-examples">
                                                    <h3 class="examples-title"> {{ translate('Examples') }} </h3>
                                                    <ul>
                                                        <li>
                                                            <p><span><i class="fa fa-times"
                                                                        aria-hidden="true"></i></span>{{ translate('Italy') }}
                                                            </p>
                                                        </li>
                                                        <li>
                                                            <p><span><i class="fa fa-times"
                                                                        aria-hidden="true"></i></span>{{ translate('An ice cream shop') }}
                                                            </p>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <form enctype="multipart/form-data" action="" id="stepThreeform">
                                            @csrf
                                            <div class="inputfield">
                                                <span class="search_icon"><i class="fa fa-search"
                                                        aria-hidden="true"></i></span>
                                                <input class="location-search-input" name="location" id="set_address"
                                                    placeholder="Search locations" autocomplete="off" type="text">
                                                <div class="col-form-alert-label">

                                                </div>
                                            </div>
                                            <div id="show_selected_loc" class="mt-2">

                                                @if (isset($data['ProductLocation']))
                                                    @foreach ($data['ProductLocation'] as $PL)
                                                        <h6>{{ $PL['address'] }}
                                                            <span class='fa fa-times text-danger remove_address'></span>
                                                            <input type='hidden' name='set_address[]'
                                                                value='{{ $PL['address'] }}'>
                                                            <input type='hidden' name='country[]'
                                                                value='{{ $PL['country'] }}'>
                                                            <input type='hidden' name='state[]'
                                                                value='{{ $PL['state'] }}'>
                                                            <input type='hidden' name='city[]'
                                                                value='{{ $PL['city'] }}'>
                                                            <input type='hidden' name='location_id[]'
                                                                value='{{ $PL['id'] }}'>
                                                            <input type='hidden' name='address_latitude[]'
                                                                value="{{ $PL['latitude'] }}">
                                                            <input type='hidden' name='address_longitude[]'
                                                                value="{{ $PL['longitude'] }}">
                                                        </h6>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div class="continueBtn">
                                                <button type="submit" class="next action-button step-three-btn"
                                                    {{-- disabled="disabled" --}}> <i
                                                        class="icofont icofont-refresh rotate-refresh mt-1 d-none"></i>
                                                    {{ translate('Save and continue') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade {{ get_active_tab(get_url_segment(), 'transportation') }}"
                                    id="trans-vertical" role="tabpanel" aria-labelledby="trans-vertical-tab">
                                    <div class="stepThree-form">
                                        <div class="title_stepOne title_step">
                                            <h2>{{ translate('Transportation') }}</h2>
                                        </div>
                                        <form enctype="multipart/form-data" action="" id="stepFourform">
                                            @csrf
                                            <div class="section title">
                                                <h6 class="section-question">
                                                    {{ translate('Is transportation used for this activity?') }}
                                                </h6>
                                                <div class="instructions">
                                                    <p class="instruction">
                                                        {{ translate('Specify if transportation is used during the activity. Transport related to pickup or drop-off services can be added later.') }}
                                                    </p>
                                                    <ul class="instruction transport-radio form-radio">
                                                        <li class="selection-item guide_list_radio">
                                                            <div class="radio radio-inline">
                                                                <label>
                                                                    <input type="radio" value="no"
                                                                        name="transportation"
                                                                        {{ getChecked(@$data['product']->transportation, 'no') }}
                                                                        checked="checked">
                                                                    <i class="helper"></i>{{ translate('No') }}

                                                                </label>
                                                            </div>
                                                        </li>
                                                        <li class="selection-item guide_list_radio">
                                                            <div class="radio radio-inline">
                                                                <label>
                                                                    <input type="radio" value="yes"
                                                                        {{ getChecked(@$data['product']->transportation, 'yes') }}
                                                                        name="transportation">
                                                                    <i class="helper"></i>{{ translate('Yes') }}
                                                                </label>
                                                            </div>
                                                        </li>

                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="continueBtn">
                                                <button type="submit" class="next action-button step-four-btn">
                                                    <i class="icofont icofont-refresh rotate-refresh mt-1 d-none"></i>
                                                    {{ translate('Save and continue') }}</button>
                                            </div>
                                        </form>
                                        @php

                                            $transportation_class = 'd-none';
                                            if (@$data['product']) {
                                                if ($data['product']->transportation == 'yes') {
                                                    $transportation_class = 'd-block';
                                                }
                                            }
                                        @endphp
                                        <div class="{{ $transportation_class }} ml-5 mt-4 pl-3 transportation_modal_div">
                                            <div class="transportation_entry">
                                                <div class="transportation_entry_data">
                                                    @if (@$data['ProductTransportation'])
                                                        @foreach ($data['ProductTransportation'] as $DPTKey => $DPT)
                                                            @php

                                                                $is_edit = 0;
                                                                $ProductTransportation = $DPT;
                                                                $TransportationDescription = App\Models\TransportationDescription::where(['transportation_id' => $DPT['transportation_id'], 'language_id' => $language_id])->first();
                                                                $TransportationData = App\Models\Transportation::find($DPT['transportation_id']);
                                                                $private_shared = '';
                                                                if ($TransportationData) {
                                                                    $private_shared = $TransportationData->private_shared == 'no' ? '' : $TransportationData->private_shared;
                                                                }
                                                            @endphp
                                                            @include('admin.products._transportation_entry')
                                                        @endforeach
                                                    @endif
                                                </div>
                                                <button type="button" data-toggle="modal" data-target="#transport-Modal"
                                                    class="btn btn-primary btn-outline-primary btn-round transportation_modal">
                                                    {{ translate('Add Entry') }}</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade {{ get_active_tab(get_url_segment(), 'activityInfo') }}"
                                    id="activityInfo-vertical" role="tabpanel"
                                    aria-labelledby="activityInfo-vertical-tab">
                                    <div class="stepFour-form">
                                        <div class="title_stepOne">
                                            <h2>{{ translate('Guide & activity info') }}</h2>
                                            <p>{{ translate('Who will your customers mainly interact with during your activity?') }}
                                            </p>
                                        </div>
                                        <form enctype="multipart/form-data" action="" id="stepFiveform">
                                            @csrf
                                            <div class="guide_List">
                                                <ul class="radio-buttons-container form-radio" data-test-id="guide-list">
                                                    <li class="selection-item guide_list_radio">
                                                        <div class="radio radio-inline">
                                                            <label>
                                                                <input type="radio" value="NONE" name="interact"
                                                                    {{ getChecked(@$data['product']->interact, 'NONE') }}
                                                                    checked="checked">
                                                                <i class="helper"></i>{{ translate('Nobody') }}

                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li class="selection-item guide_list_radio">
                                                        <div class="radio radio-inline">
                                                            <label>
                                                                <input type="radio" value="TOUR_GUIDE"
                                                                    {{ getChecked(@$data['product']->interact, 'TOUR_GUIDE') }}
                                                                    name="interact">
                                                                <i class="helper"></i>{{ translate('Tour guide') }}
                                                                <span class="explanation small-label">
                                                                    {{ translate('Leads a group of customers through a tour and explains destination/attraction.') }}</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li class="selection-item guide_list_radio">
                                                        <div class="radio radio-inline">
                                                            <label>
                                                                <input type="radio" value="HOST_GREETER"
                                                                    {{ getChecked(@$data['product']->interact, 'HOST_GREETER') }}
                                                                    name="interact">
                                                                <i class="helper"></i>{{ translate('Host or greeter') }}
                                                                <span class="explanation small-label">
                                                                    {{ translate('Provides guidance in the form of purchasing a ticket and waiting in line with customers, but doesn\'t provide a full guided tour of the attraction. A greeter might give an introduction to an activity.') }}</span>
                                                            </label>
                                                        </div>
                                                    </li>

                                                    <li class="selection-item guide_list_radio">
                                                        <div class="radio radio-inline">
                                                            <label>
                                                                <input type="radio" value="INSTRUCTOR" name="interact"
                                                                    {{ getChecked(@$data['product']->interact, 'INSTRUCTOR') }}>
                                                                <i class="helper"></i>{{ translate('Instructor') }}
                                                                <span class="explanation small-label">
                                                                    {{ translate('Shows customers how to use equipment or teaches them how to do something') }}</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li class="selection-item guide_list_radio">
                                                        <div class="radio radio-inline">
                                                            <label>
                                                                <input type="radio" value="DRIVER" name="interact"
                                                                    {{ getChecked(@$data['product']->interact, 'DRIVER') }}>
                                                                <i class="helper"></i>{{ translate('Driver only') }}
                                                                <span class="explanation small-label">
                                                                    {{ translate('Drives the customer somewhere but doesn’t explain anything along the way') }}</span>
                                                            </label>
                                                        </div>
                                                    </li>

                                                </ul>
                                            </div>
                                            <div class="activityOvernight">
                                                <p>{{ translate('Will customers sleep overnight somewhere as part of the activity?') }}
                                                </p>
                                                <ul class="form-radio">
                                                    <li class="selection-item radio-with-explanation ">
                                                        <div class="radio radio-inline">
                                                            <label>
                                                                <input type="radio" value="no"
                                                                    {{ getChecked(@$data['product']->customers_sleep_overnight, 'no') }}
                                                                    checked name="customers_sleep_overnight">
                                                                <i class="helper"></i>{{ translate('No') }}
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li class="selection-item radio-with-explanation">
                                                        <div class="radio radio-inline">
                                                            <label>
                                                                <input type="radio" value="yes"
                                                                    {{ getChecked(@$data['product']->customers_sleep_overnight, 'yes') }}
                                                                    name="customers_sleep_overnight">
                                                                <i class="helper"></i>{{ translate('Yes') }}
                                                            </label>
                                                        </div>
                                                    </li>

                                                </ul>

                                                @php
                                                    $accommodation_included_price = 'd-none';
                                                    if (@$data['product']) {
                                                        if ($data['product']->customers_sleep_overnight == 'yes') {
                                                            $accommodation_included_price = 'd-block';
                                                        }
                                                    }
                                                @endphp
                                                <div
                                                    class="{{ $accommodation_included_price }} accommodation_included_price_div ml-5 pl-3">
                                                    <p>{{ translate('Is accommodation included in the price?') }}</p>
                                                    <ul class="form-radio">
                                                        <li class="selection-item radio-with-explanation">
                                                            <div class="radio radio-inline">
                                                                <label>
                                                                    <input type="radio" value="no"
                                                                        {{ getChecked(@$data['product']->accommodation_included_price, 'no') }}
                                                                        checked name="accommodation_included_price">
                                                                    <i class="helper"></i>{{ translate('No') }}
                                                                </label>
                                                            </div>
                                                        </li>
                                                        <li class="selection-item radio-with-explanation">
                                                            <div class="radio radio-inline">
                                                                <label>
                                                                    <input type="radio" value="yes"
                                                                        {{ getChecked(@$data['product']->accommodation_included_price, 'yes') }}
                                                                        name="accommodation_included_price">
                                                                    <i class="helper"></i>{{ translate('Yes') }}
                                                                </label>
                                                            </div>
                                                        </li>

                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="continueBtn">
                                                <button type="submit" class="next action-button step-five-btn"><i
                                                        class="icofont icofont-refresh rotate-refresh mt-1 d-none"></i>
                                                    {{ translate('Save and continue') }} </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade {{ get_active_tab(get_url_segment(), 'food') }}"
                                    id="food-vertical" role="tabpanel" aria-labelledby="food-vertical-tab">
                                    <div class="stepFive-form">
                                        <div class="title_stepOne title_step">
                                            <h2>{{ translate('Food & drink') }}</h2>
                                        </div>
                                        <form enctype="multipart/form-data" action="" id="stepSixform">
                                            @csrf
                                            <div class="section title">
                                                <p class="section-question">
                                                    {{ translate('You can specify if food and drinks are included in your activity. If your activity is available with different menu options (example: 2-course meal or 3-course meal), or if your activity includes multiple meals (example: lunch and dinner), please list them as separate entries.') }}
                                                </p>
                                                <div class="instructions">
                                                    <p class="instruction">
                                                        {{ translate('Are food or drinks included in your activity?') }}
                                                    </p>
                                                    <ul class="instruction transport-radio form-radio">
                                                        <li class="selection-item guide_list_radio">
                                                            <div class="radio radio-inline">
                                                                <label>
                                                                    <input type="radio" value="no"
                                                                        {{ getChecked(@$data['product']->food_drink, 'no') }}
                                                                        name="food_drink" checked="checked">
                                                                    <i class="helper"></i>{{ translate('No') }}

                                                                </label>
                                                            </div>
                                                        </li>
                                                        <li class="selection-item guide_list_radio">
                                                            <div class="radio radio-inline">
                                                                <label>
                                                                    <input type="radio" value="yes"
                                                                        {{ getChecked(@$data['product']->food_drink, 'yes') }}
                                                                        name="food_drink">
                                                                    <i class="helper"></i>{{ translate('Yes') }}
                                                                </label>
                                                            </div>
                                                        </li>

                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="continueBtn">
                                                <button type="submit" id=""
                                                    class="next action-button step-six-btn">
                                                    <i class="icofont icofont-refresh rotate-refresh mt-1 d-none"></i>
                                                    {{ translate('Save and continue') }}</button>
                                            </div>
                                        </form>
                                        @php
                                            $food_drink = 'd-none';
                                            if (@$data['ProductFoodDrink']) {
                                                $food_drink = 'd-block';
                                            }
                                        @endphp
                                        <div class="{{ $food_drink }} ml-5 mt-4 pl-3 food_drink_modal_div">
                                            <div class="food_drink_entry">
                                                <div class="food_drink_entry_data">
                                                    @if (@$data['ProductFoodDrink'])
                                                        @foreach ($data['ProductFoodDrink'] as $DPFDKey => $DPFD)
                                                            @php

                                                                $is_edit = 0;
                                                                $ProductFoodDrink = $DPFD;
                                                                $type_of_meal_description = App\Models\ProductFoodDescription::where(['product_food_id' => $DPFD['type_of_meal'], 'language_id' => $language_id])->first();
                                                                $time_of_day_description = App\Models\ProductFoodDescription::where(['product_food_id' => $DPFD['time_of_day'], 'language_id' => $language_id])->first();
                                                                $food_tags = explode(',', $DPFD['food_tags']);
                                                                $drink_tags = explode(',', $DPFD['drink_tags']);
                                                                $foodTagsArr = [];
                                                                $drinkTagsArr = [];
                                                                foreach ($food_tags as $key => $FT) {
                                                                    $foogTags = App\Models\ProductFoodDescription::where(['product_food_id' => $FT, 'language_id' => $language_id])->first();
                                                                    if ($foogTags) {
                                                                        $foodTagsArr[] = $foogTags->title;
                                                                    }
                                                                }

                                                                foreach ($drink_tags as $key => $DT) {
                                                                    $drinkTags = App\Models\ProductFoodDescription::where(['product_food_id' => $DT, 'language_id' => $language_id])->first();
                                                                    if ($drinkTags) {
                                                                        $drinkTagsArr[] = $drinkTags->title;
                                                                    }
                                                                }
                                                                $drinkTagArr = implode(',', $drinkTagsArr);
                                                                $foodTagArr = implode(',', $foodTagsArr);

                                                            @endphp
                                                            @include('admin.products._food_drink_entry')
                                                        @endforeach
                                                    @endif
                                                </div>

                                            </div>
                                            <button type="button" data-toggle="modal" data-target="#food-drink-Modal"
                                                class="btn btn-primary btn-outline-primary btn-round food_drink_modal">
                                                {{ translate('Add Entry') }}</button>
                                        </div>

                                    </div>
                                </div>

                                <div class="tab-pane fade {{ get_active_tab(get_url_segment(), 'inclusion') }}"
                                    id="inclus-vertical" role="tabpanel" aria-labelledby="inclus-vertical-tab">
                                    <div class="stepSix-form">
                                        <div class="title_stepOne">
                                            <h2>{{ translate('Inclusions & highlights') }}</h2>
                                        </div>
                                        <div class="section title">
                                            <div class="instructions">
                                                <p class="instruction">
                                                    {{ translate('This is the main information that customers will use on your activity details page to read, compare, and book an activity.') }}
                                                </p>
                                                <ul class="instruction">
                                                    <li> {{ translate('Write all information below in English') }}</li>
                                                    <li>{{ translate('Avoid writing “we,” “our,” or mentioning your company’s name') }}
                                                    </li>
                                                </ul>
                                                <ul class="instruction2">
                                                    <li><span> {{ translate('Tip') }}:</span>
                                                        {{ translate('Personalize the content for customers by saying “you”, “you’ll”, and action verbs, such as “explore”, “experience”, etc.') }}
                                                    </li>
                                                    <li><span>{{ translate('Tip') }}:</span>{{ translate('Avoid copying and pasting text from an existing website. We need to keep your content unique so we encourage more organic SEO traffic to your page.') }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <form enctype="multipart/form-data" action="" id="stepSevenform">
                                            @csrf
                                            <div class="media_content">
                                                <div class="title_stepOne">
                                                    <h4>{{ translate('Inclusions ') }}</h4>
                                                </div>
                                                <div class="mediaTitle">
                                                    <h5>{{ translate('Gear and/or media inclusions') }}</h5>
                                                    <p>{{ translate('Name any equipment you provide that customers need for your activity, all included in your price from the customer perspective.') }}
                                                    </p>
                                                </div>
                                                <div class="examples">
                                                    <div class="example-grid-container">
                                                        <div class="good-examples">
                                                            <h3 class="examples-title">{{ translate('Gear examples') }}
                                                            </h3>
                                                            <ul>

                                                                <li>
                                                                    <p><span><i class="fa fa-check"
                                                                                aria-hidden="true"></i></span>{{ translate('Helmet') }}
                                                                    </p>
                                                                </li>
                                                                <li>
                                                                    <p><span><i class="fa fa-check"
                                                                                aria-hidden="true"></i></span>{{ translate('Snorkeling gear') }}
                                                                    </p>
                                                                </li>
                                                                <li>
                                                                    <p><span><i class="fa fa-check"
                                                                                aria-hidden="true"></i></span>{{ translate('Life vest') }}
                                                                    </p>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="bad-examples">
                                                            <h3 class="examples-title">{{ translate('Media examples') }}
                                                            </h3>
                                                            <ul>
                                                                <li>
                                                                    <p><span><i class="fa fa-check"
                                                                                aria-hidden="true"></i></span>{{ translate('Map') }}
                                                                    </p>
                                                                </li>
                                                                <li>
                                                                    <p><span><i class="fa fa-check"
                                                                                aria-hidden="true"></i></span>{{ translate('Headset to hear the guide better') }}
                                                                    </p>
                                                                </li>
                                                                <li>
                                                                    <p><span><i class="fa fa-check"
                                                                                aria-hidden="true"></i></span>{{ translate('App') }}
                                                                    </p>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="media_radio">
                                                    <p>{{ translate('Is gear or media included in the price?') }}</p>
                                                    <ul class="form-radio">
                                                        <li>
                                                            <div class="radio radio-inline">
                                                                <label>
                                                                    <input type="radio" value="no"
                                                                        onclick="CheckedBtnAttr('seven')"
                                                                        name="gear_media"
                                                                        {{ getChecked(@$data['product']->gear_media, 'no') }}
                                                                        checked="checked">
                                                                    <i class="helper"></i>{{ translate('No') }}

                                                                </label>
                                                            </div>

                                                        </li>
                                                        <li>
                                                            <div class="radio radio-inline">
                                                                <label>
                                                                    <input type="radio" value="yes"
                                                                        onclick="CheckedBtnAttr('seven')"
                                                                        {{ getChecked(@$data['product']->gear_media, 'yes') }}
                                                                        name="gear_media">
                                                                    <i class="helper"></i>{{ translate('Yes') }}

                                                                </label>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    @php
                                                        $gear_media_class = 'd-none';
                                                        if (@$data['product']) {
                                                            if ($data['product']->gear_media == 'yes') {
                                                                $gear_media_class = 'd-block';
                                                            }
                                                        }
                                                    @endphp
                                                    <div
                                                        class="{{ $gear_media_class }} ml-5 mt-4 pl-3 gear_media_modal_div">
                                                        <div class="inputfield title_filed product_code mt-3">
                                                            <h6 class="font-weight-bold">
                                                                {{ translate('Select any included gear') }}</h6>
                                                            <select class="select2 gears"
                                                                onchange="CheckedBtnAttr('seven')" name="gears[]"
                                                                id="gears" multiple="multiple">
                                                                @foreach ($Gears as $G)
                                                                    <option value="{{ $G['id'] }}"
                                                                        {{ getSelectedInArray($G['id'], @$data['ProductGears']) }}>
                                                                        {{ $G['title'] }}
                                                                    </option>
                                                                @endforeach

                                                            </select>
                                                            <div class=" col-form-alert-label">
                                                            </div>
                                                        </div>
                                                        <div class="inputfield title_filed product_code mt-3">
                                                            <h6 class="font-weight-bold">
                                                                {{ translate('Select any included media') }}</h6>
                                                            <select class="select2 media"
                                                                onchange="CheckedBtnAttr('seven')" name="media[]"
                                                                id="media" multiple="multiple">
                                                                @foreach ($Media as $M)
                                                                    <option value="{{ $M['id'] }}"
                                                                        {{ getSelectedInArray($M['id'], @$data['ProductMedia']) }}>
                                                                        {{ $M['title'] }}
                                                                    </option>
                                                                @endforeach

                                                            </select>
                                                            <div class=" col-form-alert-label">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="main-inclusions">
                                                <div class="mainInclus_title">
                                                    <h5>{{ translate('Main inclusions') }}
                                                        <a href="#" target="_blank" class="learnMore">
                                                            {{ translate('Learn more') }}
                                                        </a>
                                                    </h5>
                                                </div>
                                                <div class="main-inclusionsContent">
                                                    <p>{{ translate('Include all the main features that are included in the price. This allows customers to see the value for money for this activity.') }}
                                                    </p>
                                                    <ul>
                                                        <li><span>{{ translate('Tip') }}:</span>
                                                            {{ translate('Stick to objective, tangible inclusions — avoid adjectives and subjective language') }}
                                                        </li>
                                                        <li><span>{{ translate('Tip') }}:</span>
                                                            {{ translate('Keep your text short — no full sentences needed') }}
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="examples">
                                                    <div class="example-grid-container">
                                                        <div class="good-examples">
                                                            <h3 class="examples-title">
                                                                {{ translate('Good inclusion examples') }} </h3>
                                                            <ul>
                                                                <li>
                                                                    <p><span><i class="fa fa-check"
                                                                                aria-hidden="true"></i></span>{{ translate('Hotel pickup and drop-off') }}
                                                                    </p>
                                                                </li>
                                                                <li>
                                                                    <p><span><i class="fa fa-check"
                                                                                aria-hidden="true"></i></span>{{ translate('Headsets to hear the tour guide clearly') }}
                                                                    </p>
                                                                </li>
                                                                <li>
                                                                    <p><span><i class="fa fa-check"
                                                                                aria-hidden="true"></i></span>{{ translate('Entry tickets to Alhambra, Nasrid Palaces, and Generalife') }}
                                                                    </p>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="bad-examples">
                                                            <h3 class="examples-title">
                                                                {{ translate('Inclusion examples to avoid') }}</h3>
                                                            <ul>
                                                                <li>
                                                                    <p><span><i class="fa fa-times"
                                                                                aria-hidden="true"></i></span>{{ translate('Most amazing and excellent tour ever') }}
                                                                    </p>
                                                                </li>
                                                                <li>
                                                                    <p><span><i class="fa fa-times"
                                                                                aria-hidden="true"></i></span>{{ translate('The professional, local guide will explain to you all there is to know.') }}
                                                                    </p>
                                                                </li>
                                                                <li>
                                                                    <p><span><i class="fa fa-times"
                                                                                aria-hidden="true"></i></span>{{ translate('Photo opportunities and an amazing time') }}
                                                                    </p>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text_areaBox">
                                                    <div class="inputfield title_filed product_code mt-3">

                                                        <select class="select2 inclusion w-100" name="inclusion[]"
                                                            id="inclusion" onchange="CheckedBtnAttr('seven')"
                                                            multiple="multiple">

                                                            @foreach ($Inclusion as $I)
                                                                <option value="{{ $I['id'] }}"
                                                                    {{ getSelectedInArray($I['id'], @$data['ProductInclusion']) }}>
                                                                    {{ $I['title'] }}
                                                                </option>
                                                            @endforeach

                                                        </select>
                                                        <div class=" col-form-alert-label">
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <!-- Exclusions  -->

                                            <div class="main-inclusions descriptions_content">

                                                <div class="main_descb_box">
                                                    <div class="mainInclus_title">
                                                        <h5>{{ translate('Not suitable for') }}

                                                        </h5>
                                                    </div>
                                                    <div class="text_areaBox">
                                                        <div class="inputfield title_filed product_code mt-3">
                                                            <select class="select2 restriction w-100"
                                                                onchange="CheckedBtnAttr('seven')" name="restriction[]"
                                                                id="restriction" multiple="multiple">
                                                                @foreach ($Restriction as $R)
                                                                    <option value="{{ $R['id'] }}"
                                                                        {{ getSelectedInArray($R['id'], @$data['ProductRestriction']) }}>
                                                                        {{ $R['title'] }}
                                                                    </option>
                                                                @endforeach

                                                            </select>
                                                            <div class=" col-form-alert-label">
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Descriptions  -->
                                            <div class="main-inclusions descriptions_content">

                                                <div class="main_descb_box">
                                                    <div class="mainInclus_title">
                                                        <h5>{{ translate('Activity highlights') }}
                                                            <a href="#" target="_blank" class="learnMore">
                                                                Learn
                                                                more
                                                            </a>
                                                        </h5>
                                                    </div>
                                                    <div class="main-inclusionsContent">
                                                        <p>{{ translate('Write 3-5 short phrases about what makes your activity special. Avoid repeating the itinerary. Ask yourself: what makes this activity stand out from others?') }}
                                                        </p>
                                                        <ul>
                                                            <li><span>{{ translate('Tip') }}:</span>{{ translate('Start each highlight with an action word, such as “Discover...”, “Admire...”, or “Learn...” to let customers mentally visualize the experience') }}
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="examples">
                                                        <div class="example-grid-container">
                                                            <div class="good-examples">
                                                                <h3 class="examples-title">
                                                                    {{ translate('Good highlight examples') }}</h3>
                                                                <ul>
                                                                    <li>
                                                                        <p><span><i class="fa fa-check"
                                                                                    aria-hidden="true"></i></span>{{ translate('Savor the bright flavors of Vietnamese food with an immersive cooking class') }}
                                                                        </p>
                                                                    </li>
                                                                    <li>
                                                                        <p><span><i class="fa fa-check"
                                                                                    aria-hidden="true"></i></span>{{ translate('Be transported back to Ancient Rome as you stroll through the Colosseum') }}
                                                                        </p>
                                                                    </li>
                                                                    <li>
                                                                        <p><span><i class="fa fa-check"
                                                                                    aria-hidden="true"></i></span>{{ translate('Discover 35,000 works of art up close and at your own pace') }}
                                                                        </p>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="bad-examples">
                                                                <h3 class="examples-title">
                                                                    {{ translate('Examples to avoid') }}</h3>
                                                                <ul>
                                                                    <li>
                                                                        <p><span><i class="fa fa-times"
                                                                                    aria-hidden="true"></i></span>{{ translate('Vatican Museums, Sistine Chapel, St. Peter’s Basilica') }}
                                                                        </p>
                                                                    </li>
                                                                    <li>
                                                                        <p><span><i class="fa fa-times"
                                                                                    aria-hidden="true"></i></span>{{ translate('Amazing views!') }}
                                                                        </p>
                                                                    </li>
                                                                    <li>
                                                                        <p><span><i class="fa fa-times"
                                                                                    aria-hidden="true"></i></span>{{ translate('Entrance tickets, local guide, and lunch') }}
                                                                        </p>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text_areaBox">
                                                        @php
                                                            $highlight_count = 0;
                                                            $activity_highlight = isset($data['ProductHighlight']) ? $data['ProductHighlight'] : [];
                                                        @endphp
                                                        @if (count($activity_highlight) == 0)
                                                            @include('admin.products._highlight')
                                                            @php
                                                                $highlight_count++;
                                                            @endphp
                                                        @else
                                                            @foreach ($activity_highlight as $AH)
                                                                @php
                                                                    $ProductHighlightDescription = App\Models\ProductHighlightDescription::where(['highlight_id' => $AH['id'], 'language_id' => $language_id])->first();
                                                                @endphp
                                                                @include('admin.products._highlight')
                                                                @php
                                                                    $highlight_count++;
                                                                @endphp
                                                            @endforeach
                                                        @endif
                                                        <div class="append_activity_highlight"></div>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="continueBtn">
                                                <button type="submit" id="mediaType_btn" {{-- disabled="disabled" --}}
                                                    class="next action-button step-seven-btn">
                                                    <i
                                                        class="icofont icofont-refresh rotate-refresh mt-1 d-none"></i>{{ translate('Save and continue') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade {{ get_active_tab(get_url_segment(), 'keyword') }}"
                                    id="key-vertical" role="tabpanel" aria-labelledby="key-vertical-tab">
                                    <div class="step7-form">
                                        <div class="title_stepOne key_step">
                                            <h2>{{ translate('Keywords') }}</h2>
                                            <h6 class="instruction"> {{ translate('Add up to 15 keywords (optional)') }}
                                            </h6>
                                            <p>{{ translate('What words would a customer use to search for your activity on our site? What makes it unique? Use all 15 keywords to help customers find your activity.') }}
                                            </p>
                                        </div>
                                        <div class="section title key_tab">
                                            <div class="instructions">
                                                <p>{{ translate('Keywords should answer questions like') }}:</p>
                                                <ul class="instruction keywordsList">
                                                    <li>
                                                        <p>{{ translate('What is the overall theme of your activity? (River cruise? Wine tasting?)') }}
                                                        </p>
                                                    </li>
                                                    <li>
                                                        <p>{{ translate('Does it happen at a special time? (Sunset? Night? Christmas? Springtime?)') }}
                                                        </p>
                                                    </li>
                                                    <li>
                                                        <p>{{ translate('What subject matter do you focus on? (Medieval art? Ancient history? Street food?)') }}
                                                        </p>
                                                    </li>
                                                    <li>
                                                        <p>{{ translate('Who is it for? (For families? For children? For adults only?)') }}
                                                        </p>
                                                    </li>
                                                    <li>
                                                        <p>{{ translate('You don’t need to add keywords for the city or location.') }}
                                                        </p>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <form enctype="multipart/form-data" action="" id="stepEightform">
                                            @csrf
                                            <div class="key_find">
                                                <div class="learnbtn">
                                                    <a href="#" class="learnMore"> {{ translate('Learn more') }}
                                                    </a>
                                                </div>
                                                <div class="tags_add">

                                                    <input type="text" class="form-control"
                                                        placeholder="Enter keyword" name="keyword"
                                                        value="{{ @$data['ProductKeyword'] }}" data-role="tagsinput"
                                                        style="display: none;">
                                                </div>
                                            </div>
                                            <div class="continueBtn">
                                                <button type="submit" id="mediaType_btn"
                                                    class="next action-button step-eight-btn">
                                                    <i
                                                        class="icofont icofont-refresh rotate-refresh mt-1 d-none"></i>{{ translate('Save and continue') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade {{ get_active_tab(get_url_segment(), 'information') }}"
                                    id="information-vertical" role="tabpanel" aria-labelledby="covid-vertical-tab">
                                    <div class="step9-form">
                                        <div class="title_stepOne covid_step">
                                            <h2>{{ translate('Important information') }}</h2>
                                        </div>
                                        <form enctype="multipart/form-data" action="" id="stepNineform">
                                            @csrf
                                            <div class="section title covid_tab">
                                                <div class="instructions">
                                                    @php
                                                        $information_count = 0;
                                                        $important_information = isset($data['ProductInformation']) ? $data['ProductInformation'] : [];
                                                    @endphp
                                                    @if (count($important_information) == 0)
                                                        @include('admin.products._information')
                                                        @php
                                                            $information_count++;
                                                        @endphp
                                                    @else
                                                        @foreach ($important_information as $II)
                                                            @php
                                                                $ProductInformationDescription = App\Models\ProductInformationDescription::where(['information_id' => $II['id'], 'language_id' => $language_id])->first();

                                                            @endphp
                                                            @include('admin.products._information')
                                                            @php
                                                                $information_count++;
                                                            @endphp
                                                        @endforeach
                                                    @endif
                                                    <div class="append_important_information"></div>
                                                </div>
                                            </div>
                                            <div class="continueBtn">
                                                <button type="submit" class="next action-button step-nine-btn"
                                                    {{-- disabled="disabled" --}}>
                                                    <i class="icofont icofont-refresh rotate-refresh mt-1 d-none"></i>
                                                    {{ translate('Save and continue') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="tab-pane fade {{ get_active_tab(get_url_segment(), 'photos') }}"
                                    id="imag-vertical" role="tabpanel" aria-labelledby="imag-vertical-tab">

                                    @include('admin.products._images')
                                </div>

                                <div class="tab-pane fade {{ get_active_tab(get_url_segment(), 'about_activity') }}"
                                    id="about-activity-vertical" role="tabpanel"
                                    aria-labelledby="about-activity-vertical-tab">
                                    <div class="step9-form">
                                        <div class="title_stepOne covid_step">
                                            <h2>{{ translate('About Activity') }}</h2>
                                        </div>
                                        <form enctype="multipart/form-data" action="" id="stepAboutform">
                                            @csrf
                                            <div class="section title covid_tab">
                                                <div class="instructions">
                                                    @php
                                                        $about_activity_count = 0;
                                                        $about_activity = isset($data['AboutActivity']) ? $data['AboutActivity'] : [];
                                                    @endphp
                                                    @if (count($about_activity) == 0)
                                                        @include('admin.products._about_activity')
                                                        @php
                                                            $about_activity_count++;
                                                        @endphp
                                                    @else
                                                        @foreach ($about_activity as $AA)
                                                            @php
                                                                $ProductAboutActivityDescription = App\Models\ProductAboutActivityDescription::where(['about_activity_id' => $AA['id'], 'language_id' => $language_id])->first();

                                                            @endphp
                                                            @include('admin.products._about_activity')
                                                            @php
                                                                $about_activity_count++;
                                                            @endphp
                                                        @endforeach
                                                    @endif
                                                    <div class="append_about_activity"></div>
                                                </div>
                                            </div>
                                            <div class="continueBtn">
                                                <button type="submit" class="next action-button step-about-btn"
                                                    {{-- disabled="disabled" --}}>
                                                    <i class="icofont icofont-refresh rotate-refresh mt-1 d-none"></i>
                                                    {{ translate('Save and continue') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                    {{-- @include('admin.products._images') --}}
                                </div>

                                <div class="tab-pane fade {{ get_active_tab(get_url_segment(), 'others') }}"
                                    id="others-vertical" role="tabpanel" aria-labelledby="others-vertical-tab">
                                    <div class="step9-form">
                                        <div class="title_stepOne covid_step">
                                            <h2>{{ translate('Others') }}</h2>
                                        </div>
                                        <form enctype="multipart/form-data" action="" id="stepOthersform">
                                            @csrf
                                            <div class="section title covid_tab">
                                                <div class="stepOne-form row">
                                                    <div class="title_stepOne col-md-6 col-lg-6 col-sm-12">
                                                        <div class="inputfield title_filed product_code">
                                                            <h5>{{ translate('Affilliate Commission') }}</h5>
                                                            <input class="form-control input_txt numberonly"
                                                                value="{{ @$data['product']->affiliate_commission }}"
                                                                onkeyup="CharcterCount(this,20)"
                                                                id = "affiliate_commission" name="affiliate_commission"
                                                                errors="">

                                                            <div class=" col-form-alert-label">

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="title_stepOne col-md-6 col-lg-6 col-sm-12">
                                                        <div class="inputfield title_filed product_code">
                                                            <h5>{{ translate('Side Banner Title') }}</h5>
                                                            <input class="form-control input_txt "
                                                                value="{{ @$data['SideBannerDescription']->title }}"
                                                                id = "side_banner_title" name="side_banner_title"
                                                                errors="">

                                                            <div class=" col-form-alert-label">

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="title_stepOne col-md-12 col-lg-12 col-sm-12">
                                                        <div class="inputfield title_filed product_code">
                                                            <h5>{{ translate('Side Banner Desciption') }}</h5>
                                                            <textarea class="form-control" rows="4" name="side_banner_description">{{ @$data['SideBannerDescription']->description }}</textarea>

                                                            <div class=" col-form-alert-label">

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="title_stepOne">
                                                                <div class="inputfield title_filed product_code">
                                                                    <h5>{{ translate('Banner Image') }}</h5>
                                                                    <input type="file" name="banner_image"
                                                                        id="top_image"
                                                                        onchange="loadFile(event,'preview_top_image')"
                                                                        errors="">
                                                                    <img class="user-img img-circle img-css"
                                                                        src="{{ @$data['SideBanner']->image != '' ? url('uploads/products', @$data['SideBanner']->image) : asset('uploads/placeholder/placeholder.png') }}"
                                                                        id="preview_top_image">

                                                                    <div class=" col-form-alert-label">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="title_stepOne">
                                                                <div class="inputfield title_filed product_code">
                                                                    <h5>{{ translate('Video Thumbnail Image') }}</h5>
                                                                    <input type="file" name="thumbnail_image"
                                                                        id="top_image"
                                                                        onchange="loadFile(event,'preview_thumb_image')"
                                                                        errors="">
                                                                    <img class="user-img img-circle img-css"
                                                                        src="{{ @$data['product']->video_thumbnail_image != '' ? url('uploads/products', @$data['product']->video_thumbnail_image) : asset('uploads/placeholder/placeholder.png') }}"
                                                                        id="preview_thumb_image">

                                                                    <div class=" col-form-alert-label">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="title_stepOne col-md-6 col-lg-6 col-sm-12">
                                                        <div class="inputfield title_filed product_code">
                                                            <h5>{{ translate('Link') }}</h5>
                                                            <input class="form-control input_txt "
                                                                value="{{ @$data['SideBanner']->link }}"
                                                                id="side_banner_link" name="side_banner_link"
                                                                errors="">

                                                            <div class=" col-form-alert-label">

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="title_stepOne col-md-6 col-lg-6 col-sm-12">
                                                        <div class="inputfield title_filed product_code">
                                                            <h5>{{ translate('Video Url') }}</h5>
                                                            <input class="form-control input_txt "
                                                                value="{{ @$data['product']->video_url }}"
                                                                id="video_url" name="video_url" errors="">

                                                            <div class=" col-form-alert-label">

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="title_stepOne col-md-12 col-lg-12 col-sm-12">
                                                        <div class="inputfield title_filed product_code">
                                                            <h5>{{ translate('Meta Keywords') }}</h5>
                                                            <input class="form-control input_txt "
                                                                value="{{ @$data['MetaData']->keyword }}"
                                                                id="meta_keyword" name="meta_keyword" errors="">

                                                            <div class=" col-form-alert-label">

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="title_stepOne col-md-12 col-lg-12 col-sm-12">
                                                        <div class="inputfield title_filed product_code">
                                                            <h5>{{ translate('Meta Description') }}</h5>
                                                            <textarea class="form-control" rows="4" name="meta_description">{{ @$data['MetaData']->description }}</textarea>

                                                            <div class=" col-form-alert-label">

                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="continueBtn">
                                                <button type="submit" class="next action-button step-others-btn"
                                                    {{-- disabled="disabled" --}}>
                                                    <i class="icofont icofont-refresh rotate-refresh mt-1 d-none"></i>
                                                    {{ translate('Save and continue') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                    {{-- @include('admin.products._images') --}}
                                </div>

                                <div class="tab-pane fade {{ get_active_tab(get_url_segment(), 'options') }}"
                                    id="options-vertical" role="tabpanel" aria-labelledby="options-vertical-tab">
                                    <div class="step11-form">
                                        <div class="title_stepOne option_step">
                                            <h2>{{ translate('Options') }}</h2>
                                        </div>
                                        <div class="section title option_tab">
                                            <div class="instructions">
                                                <p class="instruction">
                                                    {{ translate('Options are different variations of the same activity that can be booked by your customers. For example, different activity options could contain different') }}:
                                                </p>
                                                <ul class="instruction optionList">
                                                    <li>{{ translate('durations or validity times (1-hour tour vs. 2-hour tour)') }}
                                                    </li>
                                                    <li>{{ translate('group sizes (small-group tour vs. large-group tour)') }}
                                                    </li>
                                                    <li>{{ translate('languages (guided tour in English vs. guided tour in Spanish)') }}
                                                    </li>
                                                    <li>{{ translate('inclusions (tour with lunch vs. tour without lunch)') }}
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="option_content">
                                                <p>{{ translate('You’ll always need to create at least one “default” option for new activities. However, you only create multiple options only if your activity can be booked with tailored differences.') }}
                                                </p>
                                                <p>{{ translate('Variations that include very different itineraries should be configured as a separate activity.') }}
                                                </p>
                                            </div>

                                            <div class="option_btn">
                                                <div class="learnbtn">
                                                    <a href="#" class="learnMore"> Learn more
                                                    </a>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-xl-12 col-md-12 col-sm-12">
                                                        <h5>{{ translate('Option type') }}</h5>
                                                        <span>
                                                            {{ translate('Lorem ipsum dolor sit, amet consectetur adipisicing elit. Sequi distinctio ducimus praesentium culpa debitis quis labore dolore ullam fuga possimus iusto molestiae, consequatur sapiente fugit placeat tempora aperiam expedita dolorem.') }}
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-8 col-md-8 col-sm-12">
                                                        <div class="inputfield title_filed product_code">

                                                            <select name="product_option_type" id="product_option_type"
                                                                class="form-control single-select">
                                                                <option value="multiple" selected>
                                                                    {{ translate('Multiple') }}</option>

                                                                <option value="single"
                                                                    {{ getSelected(@$data['product']->option_type, 'single') }}>
                                                                    {{ translate('Single') }}</option>
                                                            </select>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="options-list">

                                                    @include('admin.products.option._option_list')

                                                </div>
                                                @php
                                                    $optionSetup = '';

                                                    if (isset($data['product'])) {
                                                        if ($data['product']->option_type == 'single') {
                                                            $optionSetup = 'd-none';
                                                        }
                                                    }

                                                @endphp
                                                <div class="create_btn">
                                                    <button type="button"
                                                        class="learnMore createOption {{ $optionSetup }}"
                                                        id="createOption">{{ translate('Create new option') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="continueBtn">
                                            <button type="button" class="next action-button final-step"
                                                {{-- disabled="disabled" --}}>{{ translate('Save and continue') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-content optionTabContent @if (!isset($_GET['optionId'])) d-none @endif"
                                id="optionTabContent">
                                @include('admin.products.option._edit_option')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal static-->
        {{-- Transportation Modal --}}
        <div class="modal fade" id="transport-Modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <form action="" id="transport_modal_form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header b-none">

                            <h4 class="modal-title">{{ translate('Add Transport') }}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span class="fa fa-times"></span>
                            </button>

                        </div>
                        <div class="modal-body">
                            <h6 class="font-weight-bold">{{ translate('Transport') }}</h6>
                            <select name="transportation" id="transportation" class="form-control w-50">
                                <option value="" selected disabled>{{ translate('Select') }}</option>
                                @foreach ($Transportation as $T)
                                    <option value="{{ $T['id'] }}">{{ $T['title'] }}</option>
                                @endforeach
                            </select>
                            <div class="transportation_data mt-3 pl-4 ml-4">

                            </div>
                        </div>
                        <div class="modal-footer p-1">
                            <button type="button" class="btn btn-default waves-effect "
                                data-dismiss="modal">{{ translate('Cancel') }}</button>
                            <button type="submit" class="btn btn-primary waves-effect waves-light trans-modal-btn">
                                <i class="icofont icofont-refresh rotate-refresh mt-1 d-none"></i>
                                {{ translate('Save Entry') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Food Drink Moda --}}
        <div class="modal fade" id="food-drink-Modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <form action="" id="food_drink_modal_form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="" class="product_food_drink_id">
                    <div class="modal-content">
                        <div class="modal-header b-none">
                            <h4 class="modal-title">{{ translate('Add Entry') }}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span class="fa fa-times"></span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="food_div">
                                <h4 class="font-weight-bold">{{ translate('Food') }}</h4>
                                <ul class="instruction transport-radio form-radio">
                                    <li class="selection-item guide_list_radio">
                                        <div class="radio radio-inline">
                                            <label>
                                                <input type="radio" class="food" value="no" name="food"
                                                    checked="checked">
                                                <i class="helper"></i>{{ translate('No') }}
                                            </label>
                                        </div>
                                    </li>
                                    <li class="selection-item guide_list_radio">
                                        <div class="radio radio-inline">
                                            <label>
                                                <input type="radio" class="food" value="yes" name="food">
                                                <i class="helper"></i>{{ translate('Yes') }}
                                            </label>
                                        </div>
                                    </li>
                                </ul>
                                <div class="food_data mt-3 pl-4 ml-4">
                                </div>
                            </div>
                            <div class="drink_div mt-3">
                                <h4 class="font-weight-bold">{{ translate('Drink') }}</h4>
                                <ul class="instruction transport-radio form-radio">
                                    <li class="selection-item guide_list_radio">
                                        <div class="radio radio-inline">
                                            <label>
                                                <input type="radio" class="drink" value="no" name="drink"
                                                    checked="checked">
                                                <i class="helper"></i>{{ translate('No') }}
                                            </label>
                                        </div>
                                    </li>
                                    <li class="selection-item guide_list_radio">
                                        <div class="radio radio-inline">
                                            <label>
                                                <input type="radio" class="drink" value="yes" name="drink">
                                                <i class="helper"></i>{{ translate('Yes') }}
                                            </label>
                                        </div>
                                    </li>
                                </ul>
                                <div class="drink_data mt-3 pl-4 ml-4">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer p-1">
                            <button type="button" class="btn btn-default waves-effect "
                                data-dismiss="modal">{{ translate('Cancel') }}</button>
                            <button type="submit"
                                class="btn btn-primary waves-effect waves-light food-drink-modal-btn">
                                <i class="icofont icofont-refresh rotate-refresh mt-1 d-none"></i>
                                {{ translate('Save Entry') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="md-overlay"></div>
    @section('script')
        <script>
            $(document).ready(function() {
                // Add Activity Highlight
                $(".add_highlight").click(function(e) {

                    var count = $('.highlight_row').length;
                    var ParamArr = {
                        'view': 'admin.products._highlight',
                        'highlight_count': count
                    }
                    getAppendPage(ParamArr, '.append_activity_highlight');

                    e.preventDefault();
                    setTimeout(() => {
                        CheckedBtnAttr('seven');
                    }, 500);

                });

                // Remove Highlight
                $(document).on('click', '.remove_highlight', function(e) {
                    $remove_highlight = $(this)
                    deleteMsg('Are you sure to delete ?').then((result) => {
                        if (result.isConfirmed) {
                            $.post("{{ route('admin.remove_product_highlight') }}", {
                                id: $(this).attr("id"),
                                _token: "{{ csrf_token() }}"
                            }, function(data) {
                                $remove_highlight.parent().parent().remove();
                                // if ($(".counter-card-1").length == 0) {
                                //     $(".step-four-btn").attr('disabled', true);
                                // } else {
                                //     $(".step-four-btn").attr('disabled', false);

                                // }
                            });
                            e.preventDefault();
                        }
                    });
                });

                // Add Information
                $(".add_information").click(function(e) {

                    var count = $('.information_row').length;
                    var ParamArr = {
                        'view': 'admin.products._information',
                        'information_count': count
                    }
                    getAppendPage(ParamArr, '.append_important_information');

                    e.preventDefault();
                    setTimeout(() => {
                        tiny()
                        CheckedBtnAttr('nine');
                    }, 500);


                });

                // Remove Information

                $(document).on('click', '.remove_information', function(e) {
                    $remove_information = $(this)
                    deleteMsg('Are you sure to delete ?').then((result) => {
                        if (result.isConfirmed) {
                            $.post("{{ route('admin.remove_product_information') }}", {
                                id: $(this).attr("id"),
                                _token: "{{ csrf_token() }}"
                            }, function(data) {
                                $remove_information.parent().parent().remove();
                                // if ($(".counter-card-1").length == 0) {
                                //     $(".step-four-btn").attr('disabled', true);
                                // } else {
                                //     $(".step-four-btn").attr('disabled', false);

                                // }
                            });
                            e.preventDefault();
                        }
                    });
                });


                // Add About Activity
                $(".add_about_activity").click(function(e) {
                    var count = $('.about_activity_row').length;
                    var ParamArr = {
                        'view': 'admin.products._about_activity',
                        'about_activity_count': count
                    }
                    getAppendPage(ParamArr, '.append_about_activity');

                    e.preventDefault();
                    setTimeout(() => {

                        CheckedBtnAttr('about');
                    }, 500);


                });

                // Remove About Activity

                $(document).on('click', '.remove_about_activity', function(e) {
                    $remove_about_activity = $(this)
                    deleteMsg('Are you sure to delete ?').then((result) => {
                        if (result.isConfirmed) {
                            $.post("{{ route('admin.remove_about_activity') }}", {
                                id: $(this).attr("id"),
                                _token: "{{ csrf_token() }}"
                            }, function(data) {
                                $remove_about_activity.parent().parent().remove();
                            });
                            e.preventDefault();
                        }
                    });
                });




            });
        </script>
        <script>
            var tourId = "{{ isset($_GET['tourId']) ? $_GET['tourId'] : '' }}";
            var optionId = "{{ isset($_GET['optionId']) ? $_GET['optionId'] : '' }}";
            optionId = GetURLParameterID("optionId");
            jQuery(function($) {

                $("#filer_input1").change(function() {
                    if (('.jFiler-item').length > 0) {
                        $(".step-ten-btn").attr("disabled", false);
                    } else {
                        // $(".step-ten-btn").attr("disabled", true);

                    }
                })



                $("input[name='product_type']").change(function() {
                    $("#verifyBtn").prop("disabled", false);
                });

                $("input[name='transportation']").change(function() {
                    if ($(this).val() == "yes") {
                        $(".transportation_modal_div").addClass('d-block');
                        $(".transportation_modal_div").removeClass('d-none');
                        if ($(".counter-card-1").length == 0) {
                            // $(".step-four-btn").attr('disabled', true);
                        }

                    } else {
                        $(".transportation_modal_div").addClass('d-none');
                        $(".transportation_modal_div").removeClass('d-block')
                    }
                });

                $("input[name='food_drink']").change(function() {
                    if ($(this).val() == "yes") {
                        $(".food_drink_modal_div").addClass('d-block');
                        $(".food_drink_modal_div").removeClass('d-none');

                        if ($(".food-drink-counter").length == 0) {
                            // $(".step-six-btn").attr('disabled', true);
                        }

                    } else {
                        $(".food_drink_modal_div").addClass('d-none');
                        $(".food_drink_modal_div").removeClass('d-block')
                        $(".step-six-btn").attr('disabled', false);
                    }
                });

                $("input[name='gear_media']").change(function() {
                    if ($(this).val() == "yes") {
                        $(".gear_media_modal_div").addClass('d-block');
                        $(".gear_media_modal_div").removeClass('d-none');
                        // if ($(".food-counter").length == 0) {
                        //     $(".step-six-btn").attr('disabled', true);
                        // }

                    } else {
                        $(".gear_media_modal_div").addClass('d-none');
                        $(".gear_media_modal_div").removeClass('d-block')
                    }
                });




                $("input[name='customers_sleep_overnight']").change(function() {
                    if ($(this).val() == "yes") {
                        $(".accommodation_included_price_div").addClass("d-block");
                        $(".accommodation_included_price_div").removeClass("d-none");
                    } else {
                        $(".accommodation_included_price_div").addClass("d-none");
                        $(".accommodation_included_price_div").removeClass("d-block");
                    }
                });

                // setTimeout(() => {
                //     $(".select2").select2();
                //     $(".single-select").select2();
                // }, 500);

            });

            // Step Seven Buttton 
            function CheckedBtnAttr(form) {
                var checkProp = 0;
                if (form == "seven") {
                    if ($("input[name='gear_media']:checked").val() == "yes") {
                        if ($('.gears').val() != "") {
                            checkProp = 1;
                        } else {
                            checkProp = 0;
                        }
                        if ($('.media').val() != "") {
                            checkProp = 1;
                        } else {
                            checkProp = 0;
                        }
                    } else {
                        checkProp = 1;
                    }
                    if ($(".inclusion").val() != "") {
                        checkProp = 1;
                    } else {
                        checkProp = 0;
                    }
                    if ($(".restriction").val() != "") {
                        checkProp = 1;
                    } else {
                        checkProp = 0;
                    }

                    $(".highlight").get().forEach(function(entry, index, array) {

                        if ($(entry).val() == "") {
                            checkProp = 0;
                            return false;
                        } else {
                            checkProp = 1;
                        }
                    });
                    if (checkProp == 1) {
                        $(".step-seven-btn").attr('disabled', false);
                    } else {
                        // $(".step-seven-btn").attr('disabled', true);
                    }

                }

                if (form == "nine") {
                    $(".information_decscription").get().forEach(function(entry, index, array) {

                        if ($(entry).val() == "") {
                            checkProp = 0;
                            return false;
                        } else {
                            checkProp = 1;
                        }
                    });

                    $(".information_title").get().forEach(function(entry, index, array) {

                        if ($(entry).val() == "") {
                            checkProp = 0;
                            return false;
                        } else {
                            checkProp = 1;
                        }
                    });
                    if (checkProp == 1) {
                        $(".step-nine-btn").attr('disabled', false);
                    } else {
                        // $(".step-nine-btn").attr('disabled', true);
                    }
                    $(".select2").select2();
                }
            }

            $(".select2").select2({
                placeholder: 'Search',
            });

            // Form Step One
            $('#stepOneform').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append("step", "one");
                $(".step-one-btn").attr("disabled", true);
                $(".step-one-btn i").removeClass('d-none');
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.add_product', ['tab' => 'title']) }}",
                    datatype: 'JSON',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.error) {
                            $.each(response.error, function(index, value) {
                                if (value != '') {
                                    var index = index.replace(/\./g, '_');
                                    $("#stepOneform").find(".radio-buttons-container").addClass(
                                        "danger-border");
                                    $('#stepOneform').find('.col-form-alert-label ')
                                        .html(value[0]);
                                }
                            });
                        } else {
                            tourId = response.id;
                            history.pushState(null, null, "{{ url('/add-product/title/') }}?tourId=" +
                                response
                                .id);
                            $('#form-step1').hide();
                            $('#form-step2').show();
                            if ($("input[name='product_type']:checked").val() == "city_card") {
                                $(".nav-city").each(function(key, value) {
                                    if ($(value).attr('id') == 'activityInfo' || $(value).attr(
                                            'id') == 'food') {
                                        $(value).parent().remove();
                                    }
                                })
                            }


                            $(".tab-pane").each(function(key, value) {
                                $(value).removeClass('active show');
                                $(".nav-link").removeClass('active');
                                if ($(value).attr('id') == 'title-vertical') {
                                    $(value).addClass('active show');
                                }
                            })
                            $(".nav-link").each(function(key, value) {
                                if ($(value).attr('href') == '#title-vertical') {
                                    $(value).addClass('active');
                                }
                            })
                            // success_msg("Product {{ $common['button'] }} Successfully...")
                        }

                        $(".step-one-btn").attr("disabled", false);
                        $(".step-one-btn i").addClass('d-none');
                    }
                });

            });


            // Form Step Two
            $('#stepTwoform').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append("step", "two");
                formData.append("product_option_type", $("#product_option_type").val());
                formData.append("tourId", tourId);

                // $(".step-two-btn").attr("disabled", true);
                $(".step-two-btn i").removeClass('d-none');

                $(this).find(".form-control-danger").removeClass(
                    'form-control-danger');
                $(this).find(".has-danger").removeClass(
                    'has-danger');
                $(this).find(".col-form-alert-label").html('');

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.add_product') }}",
                    datatype: 'JSON',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {

                        if (response.error) {
                            $.each(response.error, function(index, value) {
                                if (value != '') {
                                    var index = index.replace(/\./g, '_');

                                    $("#stepTwoform").find('#' + index).addClass(
                                        'form-control-danger');
                                    $("#stepTwoform").find('#' + index).focus();
                                    $("#stepTwoform").find('#' + index).parent().addClass(
                                        'has-danger');

                                    $("#stepTwoform").find('#' + index).next().next()
                                        .html(value[0]);
                                }
                            });
                        } else {
                            $(".tab-pane").each(function(key, value) {
                                $(value).removeClass('active show');
                                $(".nav-link").removeClass('active');
                                if ($(value).attr('id') == 'loc-vertical') {
                                    $(value).addClass('active show');
                                }
                            })
                            $(".nav-link").each(function(key, value) {
                                if ($(value).attr('href') == '#loc-vertical') {
                                    $(value).addClass('active');
                                }
                            })

                        }
                        $(".step-two-btn").attr("disabled", false);
                        $(".step-two-btn i").addClass('d-none');
                    }
                });

            });


            // Form Step Three
            $('#stepThreeform').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append("step", "three");
                formData.append("tourId", tourId);

                // $(".step-three-btn").attr("disabled", true);
                $(".step-three-btn i").removeClass('d-none');

                $(this).find(".form-control-danger").removeClass(
                    'form-control-danger');
                $(this).find(".has-danger").removeClass(
                    'has-danger');
                $(this).find(".col-form-alert-label").html('');

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.add_product') }}",
                    datatype: 'JSON',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {

                        if (response.error) {
                            $.each(response.error, function(index, value) {
                                if (value != '') {
                                    var index = index.replace(/\./g, '_');

                                    $("#stepThreeform").find('#' + index).addClass(
                                        'form-control-danger');
                                    $("#stepThreeform").find('#' + index).focus();
                                    $("#stepThreeform").find('#' + index).parent().addClass(
                                        'has-danger');

                                    $("#stepThreeform").find('#' + index).next()
                                        .html(value[0]);
                                }
                            });
                        } else {
                            $(".tab-pane").each(function(key, value) {
                                $(value).removeClass('active show');
                                $(".nav-link").removeClass('active');
                                if ($(value).attr('id') == 'trans-vertical') {
                                    $(value).addClass('active show');
                                }
                            })
                            $(".nav-link").each(function(key, value) {
                                if ($(value).attr('href') == '#trans-vertical') {
                                    $(value).addClass('active');
                                }
                            })

                        }
                        $(".step-three-btn").attr("disabled", false);
                        $(".step-three-btn i").addClass('d-none');
                    }
                });

            });


            // Form Step Four
            $('#stepFourform').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append("step", "four");
                formData.append("tourId", tourId);

                // $(".step-four-btn").attr("disabled", true);
                $(".step-four-btn i").removeClass('d-none');

                $(this).find(".form-control-danger").removeClass(
                    'form-control-danger');
                $(this).find(".has-danger").removeClass(
                    'has-danger');
                $(this).find(".col-form-alert-label").html('');

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.add_product') }}",
                    datatype: 'JSON',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {

                        if (response.error) {
                            $.each(response.error, function(index, value) {
                                if (value != '') {
                                    var index = index.replace(/\./g, '_');

                                    $("#stepThreeform").find('#' + index).addClass(
                                        'form-control-danger');
                                    $("#stepThreeform").find('#' + index).focus();
                                    $("#stepThreeform").find('#' + index).parent().addClass(
                                        'has-danger');

                                    $("#stepThreeform").find('#' + index).next()
                                        .html(value[0]);
                                }
                            });
                        } else {
                            $(".tab-pane").each(function(key, value) {
                                $(value).removeClass('active show');
                                $(".nav-link").removeClass('active');
                                if ($(value).attr('id') == 'activityInfo-vertical') {
                                    $(value).addClass('active show');
                                }
                            })
                            $(".nav-link").each(function(key, value) {
                                if ($(value).attr('href') == '#activityInfo-vertical') {
                                    $(value).addClass('active');
                                }
                            })

                        }
                        $(".step-four-btn").attr("disabled", false);
                        $(".step-four-btn i").addClass('d-none');
                    }
                });

            });

            // Form Step Five
            $('#stepFiveform').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append("step", "five");
                formData.append("tourId", tourId);

                // $(".step-five-btn").attr("disabled", true);
                $(".step-five-btn i").removeClass('d-none');

                $(this).find(".form-control-danger").removeClass(
                    'form-control-danger');
                $(this).find(".has-danger").removeClass(
                    'has-danger');
                $(this).find(".col-form-alert-label").html('');

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.add_product') }}",
                    datatype: 'JSON',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {

                        if (response.error) {
                            $.each(response.error, function(index, value) {
                                if (value != '') {
                                    var index = index.replace(/\./g, '_');

                                    $("#stepThreeform").find('#' + index).addClass(
                                        'form-control-danger');
                                    $("#stepThreeform").find('#' + index).focus();
                                    $("#stepThreeform").find('#' + index).parent().addClass(
                                        'has-danger');

                                    $("#stepThreeform").find('#' + index).next()
                                        .html(value[0]);
                                }
                            });
                        } else {
                            $(".tab-pane").each(function(key, value) {
                                $(value).removeClass('active show');
                                $(".nav-link").removeClass('active');
                                if ($(value).attr('id') == 'food-vertical') {
                                    $(value).addClass('active show');
                                }
                            })
                            $(".nav-link").each(function(key, value) {
                                if ($(value).attr('href') == '#food-vertical') {
                                    $(value).addClass('active');
                                }
                            })

                        }
                        $(".step-five-btn").attr("disabled", false);
                        $(".step-five-btn i").addClass('d-none');
                    }
                });

            });



            // Form Step Six
            $('#stepSixform').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append("step", "six");
                formData.append("tourId", tourId);

                // $(".step-six-btn").attr("disabled", true);
                $(".step-six-btn i").removeClass('d-none');

                $(this).find(".form-control-danger").removeClass(
                    'form-control-danger');
                $(this).find(".has-danger").removeClass(
                    'has-danger');
                $(this).find(".col-form-alert-label").html('');

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.add_product') }}",
                    datatype: 'JSON',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {

                        if (response.error) {
                            $.each(response.error, function(index, value) {
                                if (value != '') {
                                    var index = index.replace(/\./g, '_');

                                    $("#stepSixform").find('#' + index).addClass(
                                        'form-control-danger');
                                    $("#stepSixform").find('#' + index).focus();
                                    $("#stepSixform").find('#' + index).parent().addClass(
                                        'has-danger');

                                    $("#stepSixform").find('#' + index).next()
                                        .html(value[0]);
                                }
                            });
                        } else {
                            $(".tab-pane").each(function(key, value) {
                                $(value).removeClass('active show');
                                $(".nav-link").removeClass('active');
                                if ($(value).attr('id') == 'inclus-vertical') {
                                    $(value).addClass('active show');
                                }
                            })
                            $(".nav-link").each(function(key, value) {
                                if ($(value).attr('href') == '#inclus-vertical') {
                                    $(value).addClass('active');
                                }
                            })

                        }
                        $(".step-six-btn").attr("disabled", false);
                        $(".step-six-btn i").addClass('d-none');
                    }
                });

            });

            // Form Step Seven
            $('#stepSevenform').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append("step", "seven");
                formData.append("tourId", tourId);

                // $(".step-seven-btn").attr("disabled", true);
                $(".step-seven-btn i").removeClass('d-none');

                $(this).find(".form-control-danger").removeClass(
                    'form-control-danger');
                $(this).find(".has-danger").removeClass(
                    'has-danger');
                $(this).find(".col-form-alert-label").html('');

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.add_product') }}",
                    datatype: 'JSON',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {

                        if (response.error) {
                            $.each(response.error, function(index, value) {
                                if (value != '') {
                                    var index = index.replace(/\./g, '_');

                                    $("#stepSevenform").find('#' + index).addClass(
                                        'form-control-danger');
                                    $("#stepSevenform").find('#' + index).focus();
                                    $("#stepSevenform").find('#' + index).parent().addClass(
                                        'has-danger');

                                    $("#stepSevenform").find('#' + index).next().next()
                                        .html(value[0]);
                                }
                            });
                        } else {
                            $(".tab-pane").each(function(key, value) {
                                $(value).removeClass('active show');
                                $(".nav-link").removeClass('active');
                                if ($(value).attr('id') == 'key-vertical') {
                                    $(value).addClass('active show');
                                }
                            })
                            $(".nav-link").each(function(key, value) {
                                if ($(value).attr('href') == '#key-vertical') {
                                    $(value).addClass('active');
                                }
                            })

                        }
                        $(".step-seven-btn").attr("disabled", false);
                        $(".step-seven-btn i").addClass('d-none');
                    }
                });

            });

            // Form Step Eight
            $('#stepEightform').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append("step", "eight");
                formData.append("tourId", tourId);

                // $(".step-eight-btn").attr("disabled", true);
                $(".step-eight-btn i").removeClass('d-none');

                $(this).find(".form-control-danger").removeClass(
                    'form-control-danger');
                $(this).find(".has-danger").removeClass(
                    'has-danger');
                $(this).find(".col-form-alert-label").html('');

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.add_product') }}",
                    datatype: 'JSON',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {

                        if (response.error) {
                            $.each(response.error, function(index, value) {
                                if (value != '') {
                                    var index = index.replace(/\./g, '_');

                                    $("#stepEightform").find('#' + index).addClass(
                                        'form-control-danger');
                                    $("#stepEightform").find('#' + index).focus();
                                    $("#stepEightform").find('#' + index).parent().addClass(
                                        'has-danger');

                                    $("#stepEightform").find('#' + index).next().next()
                                        .html(value[0]);
                                }
                            });
                        } else {
                            $(".tab-pane").each(function(key, value) {
                                $(value).removeClass('active show');
                                $(".nav-link").removeClass('active');
                                if ($(value).attr('id') == 'information-vertical') {
                                    $(value).addClass('active show');
                                }
                            })
                            $(".nav-link").each(function(key, value) {
                                if ($(value).attr('href') == '#information-vertical') {
                                    $(value).addClass('active');
                                }
                            })

                        }
                        $(".step-eight-btn").attr("disabled", false);
                        $(".step-eight-btn i").addClass('d-none');
                    }
                });

            });

            // Form Step Nine
            $('#stepNineform').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append("step", "nine");
                formData.append("tourId", tourId);

                // $(".step-nine-btn").attr("disabled", true);
                $(".step-nine-btn i").removeClass('d-none');

                $(this).find(".form-control-danger").removeClass(
                    'form-control-danger');
                $(this).find(".has-danger").removeClass(
                    'has-danger');
                $(this).find(".col-form-alert-label").html('');

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.add_product') }}",
                    datatype: 'JSON',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {

                        if (response.error) {
                            $.each(response.error, function(index, value) {
                                if (value != '') {
                                    var index = index.replace(/\./g, '_');

                                    $("#stepNineform").find('#' + index).addClass(
                                        'form-control-danger');
                                    $("#stepNineform").find('#' + index).focus();
                                    $("#stepNineform").find('#' + index).parent().addClass(
                                        'has-danger');

                                    $("#stepNineform").find('#' + index).next()
                                        .html(value[0]);
                                }
                            });
                        } else {
                            $(".tab-pane").each(function(key, value) {
                                $(value).removeClass('active show');
                                $(".nav-link").removeClass('active');
                                if ($(value).attr('id') == 'imag-vertical') {
                                    $(value).addClass('active show');
                                }
                            })
                            $(".nav-link").each(function(key, value) {
                                if ($(value).attr('href') == '#imag-vertical') {
                                    $(value).addClass('active');
                                }
                            })

                        }
                        $(".step-nine-btn").attr("disabled", false);
                        $(".step-nine-btn i").addClass('d-none');
                    }
                });

            });

            // Form Step Nine
            $('#stepTenform').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append("step", "ten");
                formData.append("tourId", tourId);

                // $(".step-ten-btn").attr("disabled", true);
                $(".step-ten-btn i").removeClass('d-none');

                $(this).find(".form-control-danger").removeClass(
                    'form-control-danger');
                $(this).find(".has-danger").removeClass(
                    'has-danger');
                $(this).find(".col-form-alert-label").html('');

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.add_product') }}",
                    datatype: 'JSON',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {

                        if (response.error) {
                            $.each(response.error, function(index, value) {
                                if (value != '') {
                                    var index = index.replace(/\./g, '_');

                                    $("#stepTenform").find('#' + index).addClass(
                                        'form-control-danger');
                                    $("#stepTenform").find('#' + index).focus();
                                    $("#stepTenform").find('#' + index).parent().addClass(
                                        'has-danger');

                                    $("#stepTenform").find('#' + index).next()
                                        .html(value[0]);
                                }
                            });
                        } else {
                            $(".tab-pane").each(function(key, value) {
                                $(value).removeClass('active show');
                                $(".nav-link").removeClass('active');
                                if ($(value).attr('id') == 'about-activity-vertical') {
                                    $(value).addClass('active show');
                                }
                            })
                            $(".nav-link").each(function(key, value) {
                                if ($(value).attr('href') == '#about-activity-vertical') {
                                    $(value).addClass('active');
                                }
                            })

                        }
                        $(".step-ten-btn").attr("disabled", false);
                        $(".step-ten-btn i").addClass('d-none');
                    }
                });

            });


            // Form Step About Activity
            $('#stepAboutform').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append("step", "about");
                formData.append("tourId", tourId);

                // $(".step-ten-btn").attr("disabled", true);
                $(".step-about-btn i").removeClass('d-none');


                $(this).find(".form-control-danger").removeClass(
                    'form-control-danger');
                $(this).find(".has-danger").removeClass(
                    'has-danger');
                $(this).find(".col-form-alert-label").html('');

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.add_product') }}",
                    datatype: 'JSON',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {

                        if (response.error) {
                            $.each(response.error, function(index, value) {
                                if (value != '') {
                                    var index = index.replace(/\./g, '_');

                                    $("#stepAboutform").find('#' + index).addClass(
                                        'form-control-danger');
                                    $("#stepAboutform").find('#' + index).focus();
                                    $("#stepAboutform").find('#' + index).parent().addClass(
                                        'has-danger');

                                    $("#stepAboutform").find('#' + index).next()
                                        .html(value[0]);
                                }
                            });
                        } else {
                            $(".tab-pane").each(function(key, value) {
                                $(value).removeClass('active show');
                                $(".nav-link").removeClass('active');
                                if ($(value).attr('id') == 'others-vertical') {
                                    $(value).addClass('active show');
                                }
                            })
                            $(".nav-link").each(function(key, value) {
                                if ($(value).attr('href') == '#others-vertical') {
                                    $(value).addClass('active');
                                }
                            })

                        }
                        $(".step-about-btn").attr("disabled", false);
                        $(".step-about-btn i").addClass('d-none');
                    }
                });

            });


            // Form Step Others
            $('#stepOthersform').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append("step", "others");
                formData.append("tourId", tourId);

                // $(".step-ten-btn").attr("disabled", true);
                $(".step-others-btn i").removeClass('d-none');

                $(this).find(".form-control-danger").removeClass(
                    'form-control-danger');
                $(this).find(".has-danger").removeClass(
                    'has-danger');
                $(this).find(".col-form-alert-label").html('');

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.add_product') }}",
                    datatype: 'JSON',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {

                        if (response.error) {
                            $.each(response.error, function(index, value) {
                                if (value != '') {
                                    var index = index.replace(/\./g, '_');

                                    $("#stepOthersform").find('#' + index).addClass(
                                        'form-control-danger');
                                    $("#stepOthersform").find('#' + index).focus();
                                    $("#stepOthersform").find('#' + index).parent().addClass(
                                        'has-danger');

                                    $("#stepOthersform").find('#' + index).next()
                                        .html(value[0]);
                                }
                            });
                        } else {
                            $(".tab-pane").each(function(key, value) {
                                $(value).removeClass('active show');
                                $(".nav-link").removeClass('active');
                                if ($(value).attr('id') == 'options-vertical') {
                                    $(value).addClass('active show');
                                }
                            })
                            $(".nav-link").each(function(key, value) {
                                if ($(value).attr('href') == '#options-vertical') {
                                    $(value).addClass('active');
                                }
                            })

                        }
                        $(".step-others-btn").attr("disabled", false);
                        $(".step-others-btn i").addClass('d-none');
                    }
                });

            });



            // Form Step option Setup
            $(document).on('submit', '#setpOptionSetupForm', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append("step", "option_setup");
                formData.append("tourId", tourId);
                formData.append("optionId", GetURLParameterID("optionId"));

                // $(".step-optionSetup-btn").attr("disabled", true);
                $(".step-optionSetup-btn i").removeClass('d-none');

                $(this).find(".form-control-danger").removeClass(
                    'form-control-danger');
                $(this).find(".has-danger").removeClass(
                    'has-danger');
                $(this).find(".col-form-alert-label").html('');

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.add_product') }}",
                    datatype: 'JSON',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {

                        if (response.error) {
                            $.each(response.error, function(index, value) {
                                if (value != '') {
                                    var index = index.replace(/\./g, '_');

                                    $("#setpOptionSetupForm").find('#' + index).addClass(
                                        'form-control-danger');
                                    $("#setpOptionSetupForm").find('#' + index).focus();
                                    $("#setpOptionSetupForm").find('#' + index).parent().addClass(
                                        'has-danger');

                                    if (index == 'guide_headphone_langauge' || index ==
                                        "information_booklet_language" || index ==
                                        "existing_line_type" || index == "duration_time" ||
                                        index == "duration_time_type" || index ==
                                        "validity_time_type" || index == "validity_time") {
                                        $("#setpOptionSetupForm").find('#' + index).next().next()
                                            .html(value[0]);
                                    } else {

                                        $("#setpOptionSetupForm").find('#' + index).next()
                                            .html(value[0]);

                                    }

                                }
                            });
                        } else {
                            $(".tab-pane").each(function(key, value) {
                                $(value).removeClass('active show');
                                $(".nav-link").removeClass('active');
                                if ($(value).attr('id') == 'option-price-vertical') {
                                    $(value).addClass('active show');
                                }
                            })
                            $(".nav-link").each(function(key, value) {
                                if ($(value).attr('href') == '#option-price-vertical') {
                                    $(value).addClass('active');
                                }
                            })

                        }
                        $(".step-optionSetup-btn").attr("disabled", false);
                        $(".step-optionSetup-btn i").addClass('d-none');
                    }
                });

            });

            // Form Step option Pricing
            $(document).on('submit', '#setpOptionPricingForm', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append("step", "option_pricing");
                formData.append("tourId", tourId);
                formData.append("optionId", GetURLParameterID("optionId"));
                formData.append("pricing_type", $(".pricing_type:checked").val());

                // $(".step-optionPricing-btn").attr("disabled", true);
                $(".step-optionPricing-btn i").removeClass('d-none');

                $(this).find(".form-control-danger").removeClass(
                    'form-control-danger');
                $(this).find(".has-danger").removeClass(
                    'has-danger');
                $(this).find(".col-form-alert-label").html('');

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.add_product') }}",
                    datatype: 'JSON',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.error) {
                            $.each(response.error, function(index, value) {
                                if (value != '') {
                                    var index = index.replace(/\./g, '_');
                                    $("#setpOptionPricingForm").find('#' + index).addClass(
                                        'form-control-danger');
                                    $("#setpOptionPricingForm").find('#' + index).focus();
                                    $("#setpOptionPricingForm").find('#' + index).parent().addClass(
                                        'has-danger');
                                    $("#setpOptionPricingForm").find('#' + index).next()
                                        .html(value[0]);
                                }
                            });
                        } else {


                            var pricing_type = $(".pricing_type:checked").val()
                            if (pricing_type == 'person') {

                                $(".price_per_person").addClass("d-none");

                            } else {
                                $(".price_per_group").addClass('d-none');
                            }
                            $(".price_type_div").removeClass("d-none");
                            $(".tab-pane").each(function(key, value) {
                                $(value).removeClass('active show');
                                $(".nav-link").removeClass('active');
                                if ($(value).attr('id') == 'option-price-vertical') {
                                    $(value).addClass('active show');
                                }
                            })
                            $(".nav-link").each(function(key, value) {
                                if ($(value).attr('href') == '#option-price-vertical') {
                                    $(value).addClass('active');
                                }
                            })
                            $('.saved_pricing_list').html(response.view);
                            if ($(".pricing-display").length > 0) {
                                $(".add-new-price").addClass('d-none');
                            }
                        }
                        $(".step-optionPricing-btn").attr("disabled", false);
                        $(".step-optionPricing-btn i").addClass('d-none');
                    }
                });

            });

            // Form Step option Pricing
            $(document).on('submit', '#setpOptionForm', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append("step", "option");
                formData.append("tourId", tourId);
                formData.append("optionId", GetURLParameterID("optionId"));

                // $(".step-option-btn").attr("disabled", true);
                $(".step-option-btn i").removeClass('d-none');

                $(this).find(".form-control-danger").removeClass(
                    'form-control-danger');
                $(this).find(".has-danger").removeClass(
                    'has-danger');
                $(this).find(".col-form-alert-label").html('');

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.add_product') }}",
                    datatype: 'JSON',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $(".allTab").removeClass("d-none");
                        $(".optionTab").addClass("d-none");
                        $(".allTabContent").removeClass("d-none");
                        $(".optionTabContent").addClass("d-none");
                        optionId = response.optionId;
                        history.pushState(null, null, "{{ url('/add-product/options/') }}?tourId=" +
                            tourId);

                        $(".tab-pane").each(function(key, value) {
                            $(value).removeClass('active show');
                            $(".nav-link").removeClass('active');
                            if ($(value).attr('id') == 'options-vertical') {
                                $(value).addClass('active show');
                            }
                        })
                        $(".nav-link").each(function(key, value) {
                            if ($(value).attr('href') == '#options-vertical') {
                                $(value).addClass('active');
                            }
                        })
                        $('.options-list').html(response.view);
                        $(".step-option-btn").attr("disabled", false);
                        $(".step-option-btn i").addClass('d-none');
                    },


                });

            });



            // {{-- Create Option --}}

            $("#createOption").click(function(e) {
                e.preventDefault();
                var formData = new FormData();
                formData.append("step", "create_option");
                formData.append("tourId", tourId);
                formData.append("option_type", $("#product_option_type").val());
                formData.append("_token", '{{ csrf_token() }}');
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.add_product') }}",
                    datatype: 'JSON',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.error) {
                            danger_msg('Change option type to multiple create new option');
                        } else {
                            $(".allTab").addClass("d-none");
                            $(".optionTab").removeClass("d-none");
                            $(".allTabContent").addClass("d-none");
                            $(".optionTabContent").removeClass("d-none");
                            optionId = response.optionId;
                            history.pushState(null, null,
                                "{{ url('/add-product/optionSetup/') }}?tourId=" +
                                tourId + "&optionId=" + optionId);


                            $(".tab-pane").each(function(key, value) {
                                $(value).removeClass('active show');
                                $(".nav-link").removeClass('active');
                                if ($(value).attr('id') == 'setup-vertical') {
                                    $(value).addClass('active show');
                                }
                            })
                            $(".nav-link").each(function(key, value) {
                                if ($(value).attr('href') == '#setup-vertical') {
                                    $(value).addClass('active');
                                }
                            })

                            setTimeout(() => {
                                $(':input', '#optionTabContent')
                                    .not(
                                        ':button, :submit, :reset, :hidden'
                                    )
                                    .val('')
                                    .removeAttr('checked')
                                    .removeAttr('selected');
                                $('.guide_headphone').attr('checked', false);
                                $('.information_booklet').attr('checked', false);
                                $('.guide_headphone_language_div').addClass('d-none');
                                $('.information_booklet_language_div').addClass('d-none');
                                $('.existing_line_div').addClass('d-none');
                                $('.duration_div').addClass('d-none');
                                $('.validity_div').addClass('d-none');
                            }, 300);
                        }
                    }
                });
            })

            // Edit Option
            $(document).on("click", ".editOption", function(e) {
                e.preventDefault();
                var formData = new FormData();
                var optionId = $(this).data('option');
                formData.append("tourId", tourId);
                formData.append("optionId", optionId);
                formData.append("_token", '{{ csrf_token() }}');
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.edit_product_option') }}",
                    datatype: 'JSON',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {

                        $(".allTab").addClass("d-none");
                        $(".optionTab").removeClass("d-none");
                        $(".allTabContent").addClass("d-none");
                        $(".optionTabContent").removeClass("d-none");
                        $("#optionTabContent").html(response);
                        // optionId = response.optionId;
                        history.pushState(null, null,
                            "{{ url('/add-product/optionSetup/') }}?tourId=" +
                            tourId + "&optionId=" + optionId);


                        $(".tab-pane").each(function(key, value) {
                            $(value).removeClass('active show');
                            $(".nav-link").removeClass('active');
                            if ($(value).attr('id') == 'setup-vertical') {
                                $(value).addClass('active show');
                            }
                        })
                        $(".nav-link").each(function(key, value) {
                            if ($(value).attr('href') == '#setup-vertical') {
                                $(value).addClass('active');
                            }
                        })
                    }
                });
            });


            // back To Product
            $("#backToProduct").click(function(e) {

                e.preventDefault();
                var formData = {
                    "step": "option",
                    "tourId": tourId,
                    "optionId": GetURLParameterID("optionId"),
                    '_token': "{{ csrf_token() }}"
                };


                // $(".step-option-btn").attr("disabled", true);
                $(".step-option-btn i").removeClass('d-none');
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.add_product') }}",

                    data: formData,

                    success: function(response) {
                        $(".allTab").removeClass("d-none");
                        $(".optionTab").addClass("d-none");
                        $(".allTabContent").removeClass("d-none");
                        $(".optionTabContent").addClass("d-none");
                        optionId = response.optionId;
                        history.pushState(null, null, "{{ url('/add-product/options/') }}?tourId=" +
                            tourId);

                        $(".tab-pane").each(function(key, value) {
                            $(value).removeClass('active show');
                            $(".nav-link").removeClass('active');
                            if ($(value).attr('id') == 'options-vertical') {
                                $(value).addClass('active show');
                            }
                        })
                        $(".nav-link").each(function(key, value) {
                            if ($(value).attr('href') == '#options-vertical') {
                                $(value).addClass('active');
                            }
                        })
                        $('.options-list').html(response.view);
                        $(".step-option-btn").attr("disabled", false);
                        $(".step-option-btn i").addClass('d-none');
                    },


                });
            })


            // Form Step Option Availablity setpAvailabilityForm

            $(document).on('submit', '#setpAvailabilityForm', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append("step", "availability");
                formData.append("tourId", tourId);
                formData.append("optionId", GetURLParameterID("optionId"));

                // $(".step-option-btn").attr("disabled", true);
                $(".step-availability-btn i").removeClass('d-none');

                $(this).find(".form-control-danger").removeClass(
                    'form-control-danger');
                $(this).find(".has-danger").removeClass(
                    'has-danger');
                $(this).find(".col-form-alert-label").html('');

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.add_product') }}",
                    datatype: 'JSON',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.error) {
                            $.each(response.error, function(index, value) {
                                if (value != '') {
                                    var index = index.replace(/\./g, '_');
                                    $("#setpAvailabilityForm").find('#' + index)
                                        .addClass(
                                            'form-control-danger');
                                    $("#setpAvailabilityForm").find('#' + index)
                                        .focus();
                                    $("#setpAvailabilityForm").find('#' + index)
                                        .parent().addClass(
                                            'has-danger');

                                    $("#setpAvailabilityForm").find('#' + index).next()
                                        .html(value[0]);

                                }
                            });
                        } else {
                            $(".tab-pane").each(function(key, value) {
                                $(value).removeClass('active show');
                                $(".nav-link").removeClass('active');
                                if ($(value).attr('id') == 'option-price-vertical') {
                                    $(value).addClass('active show');
                                }
                            })
                            $(".nav-link").each(function(key, value) {
                                if ($(value).attr('href') == '#option-price-vertical') {
                                    $(value).addClass('active');
                                }
                            })
                            success_msg('Product add successfully..');
                            // setTimeout(() => {
                            //     window.location.replace("{{ route('admin.get_products') }}")
                            // }, 1000);
                        }
                        $(".step-availability-btn").attr("disabled", false);
                        $(".step-availability-btn i").addClass('d-none');
                    },

                });

            });


            // Form Step Option Discount

            $(document).on('submit', '#setpDiscountForm', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append("step", "discount");
                formData.append("tourId", tourId);
                formData.append("optionId", GetURLParameterID("optionId"));

                // $(".step-option-btn").attr("disabled", true);
                $(".step-discount-btn i").removeClass('d-none');

                $(this).find(".form-control-danger").removeClass(
                    'form-control-danger');
                $(this).find(".has-danger").removeClass(
                    'has-danger');
                $(this).find(".col-form-alert-label").html('');

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.add_product') }}",
                    datatype: 'JSON',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.error) {
                            $.each(response.error, function(index, value) {
                                if (value != '') {
                                    var index = index.replace(/\./g, '_');
                                    $("#setpDiscountForm").find('#' + index)
                                        .addClass(
                                            'form-control-danger');
                                    $("#setpDiscountForm").find('#' + index)
                                        .focus();
                                    $("#setpDiscountForm").find('#' + index)
                                        .parent().addClass(
                                            'has-danger');

                                    $("#setpDiscountForm").find('#' + index).next()
                                        .html(value[0]);

                                }
                            });
                        } else {
                            $(".tab-pane").each(function(key, value) {
                                $(value).removeClass('active show');
                                $(".nav-link").removeClass('active');
                                if ($(value).attr('id') == 'option-price-vertical') {
                                    $(value).addClass('active show');
                                }
                            })
                            $(".nav-link").each(function(key, value) {
                                if ($(value).attr('href') == '#option-price-vertical') {
                                    $(value).addClass('active');
                                }
                            })
                            success_msg('Product add successfully..');
                            // setTimeout(() => {
                            //     window.location.replace("{{ route('admin.get_products') }}")
                            // }, 1000);
                        }
                        $(".step-discount-btn").attr("disabled", false);
                        $(".step-discount-btn i").addClass('d-none');
                    },

                });

            });





            // Remaining Charcter COunt
            function CharcterCount(data, number) {
                $(data).next(".charCount").html(number - data.value.length + " characters left ")

            }


            // Step2
            jQuery(function($) {
                $(".title_filed input").change(function() {
                    $(".action-button").prop("disabled", false);
                });
            });

            // step 6

            jQuery(function($) {
                $("input[name='mediaRadio-type']").change(function() {
                    $("#mediaType_btn").prop("disabled", false);
                });
            });

            $(".textArea").click(function() {
                $("#counterShow").addClass('show');
                $("#field_txt").addClass('hide');
            });

            // $("body").click(function() {
            //     $("#counterShow").addClass('hide');
            //     $("#field_txt").removeClass('hide');
            // });
        </script>

        <script>
            // Tranaportation modal data 

            $(".transportation_modal").click(function() {
                $('#transportation').prop('selectedIndex', 0);
                $(".transportation_data").html("")
            })

            $("#transportation").on("change", function() {
                $.post("{{ route('admin.get_transportation_modal_view') }}", {
                    id: $(this).val(),
                    product_transportation_id: $("input[name='ProductTransportationId']").val(),
                    _token: "{{ csrf_token() }}"
                }, function(data) {
                    $(".transportation_data").html(data.view);
                });
            })

            // Remove Transportation
            $(document).on("click", ".remove_trans", function(e) {
                deleteMsg('Are you sure to delete ?').then((result) => {
                    if (result.isConfirmed) {
                        $.post("{{ route('admin.remove_product_transportation') }}", {
                            id: $(this).attr("id"),
                            _token: "{{ csrf_token() }}"
                        }, function(data) {
                            $("#counter_" + data).remove();
                            if ($(".counter-card-1").length == 0) {
                                // $(".step-four-btn").attr('disabled', true);
                            } else {
                                $(".step-four-btn").attr('disabled', false);

                            }
                        });
                        e.preventDefault();
                    }
                });

            })

            // Edit Trnsportation data
            $(document).on("click", ".edit_transportation", function() {
                $.post("{{ route('admin.get_transportation_modal_view') }}", {

                    product_transportation_id: $(this).next().val(),
                    _token: "{{ csrf_token() }}"
                }, function(data) {
                    $('#transportation').val(data.transportation_id);
                    $(".transportation_data").html(data.view);
                    $("#transport-Modal").modal("toggle");
                });
            })

            $('#transport_modal_form').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append("tourId", tourId);

                // $(".trans-modal-btn").attr("disabled", true);
                $(".trans-modal-btn i").removeClass('d-none');

                $(this).find(".form-control-danger").removeClass(
                    'form-control-danger');
                $(this).find(".has-danger").removeClass(
                    'has-danger');
                $(this).find(".col-form-alert-label").html('');

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.add_product_transportation') }}",
                    datatype: 'JSON',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {

                        if (response.error) {
                            $.each(response.error, function(index, value) {
                                if (value != '') {
                                    var index = index.replace(/\./g, '_');

                                    $("#transport_modal_form").find('#' + index).addClass(
                                        'form-control-danger');
                                    $("#transport_modal_form").find('#' + index).focus();
                                    $("#transport_modal_form").find('#' + index).parent().addClass(
                                        'has-danger');

                                    $("#transport_modal_form").find('#' + index).next()
                                        .html(value[0]);
                                }
                            });
                        } else {
                            if (response.is_edit > 0) {
                                $("#counter_" + response.is_edit).html(response.view);
                            } else {
                                $(".transportation_entry_data").append(response.view);
                            }
                            $("#transport-Modal").modal("toggle");
                            $('#transportation').prop('selectedIndex', 0);
                            $(".transportation_data").html("")

                            if ($(".counter-card-1").length == 0) {
                                // $(".step-four-btn").attr('disabled', true);
                            } else {
                                $(".step-four-btn").attr('disabled', false);

                            }
                        }


                        $(".trans-modal-btn").attr("disabled", false);
                        $(".trans-modal-btn i").addClass('d-none');
                    }
                });

            });
        </script>

        {{-- Food And Drink Script --}}
        <script>
            $(".food").on("click", function() {
                if ($(this).val() == "yes") {
                    $.post("{{ route('admin.get_food_modal_view') }}", {
                        // id: $(this).val(),
                        // product_transportation_id: $("input[name='ProductTransportationId']").val(),
                        _token: "{{ csrf_token() }}"
                    }, function(data) {
                        $(".food_data").html(data.view);
                        $(".select2").select2({
                            dropdownParent: $("#food-drink-Modal")
                        });
                        $(".food_tags").select2({
                            placeholder: 'Search',
                            dropdownParent: $("#food-drink-Modal"),
                            maximumSelectionLength: 5,
                        });
                    });
                } else {
                    $(".food_data").html("");
                }
            })


            $(".drink").on("click", function() {
                if ($(this).val() == "yes") {
                    $.post("{{ route('admin.get_drink_modal_view') }}", {
                        // id: $(this).val(),
                        // product_transportation_id: $("input[name='ProductTransportationId']").val(),
                        _token: "{{ csrf_token() }}"
                    }, function(data) {
                        $(".drink_data").html(data.view);
                        $(".select2").select2({
                            dropdownParent: $("#food-drink-Modal")
                        });
                        $(".drink_tags").select2({
                            placeholder: 'Search',
                            dropdownParent: $("#food-drink-Modal"),
                            maximumSelectionLength: 5,
                        });
                    });
                } else {
                    $(".drink_data").html("");
                }
            })

            // Add Food Drinnk
            $("#food_drink_modal_form").on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append("tourId", tourId);


                // $(".food-drink-modal-btn").attr("disabled", true);
                $(".food-drink-modal-btn i").removeClass('d-none');

                $(this).find(".form-control-danger").removeClass(
                    'form-control-danger');
                $(this).find(".has-danger").removeClass(
                    'has-danger');
                $(this).find(".col-form-alert-label").html('');


                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.add_product_food_drink') }}",
                    datatype: 'JSON',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {

                        if (response.error) {
                            $.each(response.error, function(index, value) {
                                if (value != '') {
                                    var index = index.replace(/\./g, '_');

                                    $("#food_drink_modal_form").find('#' + index).addClass(
                                        'form-control-danger');
                                    $("#food_drink_modal_form").find('#' + index).focus();
                                    $("#food_drink_modal_form").find('#' + index).parent().addClass(
                                        'has-danger');

                                    $("#food_drink_modal_form").find('#' + index).next().next()
                                        .html(value[0]);
                                }
                            });
                        } else {
                            if (response.is_edit > 0) {
                                $("#food_drink_counter_" + response.is_edit).html(response.view);
                            } else {
                                $(".food_drink_entry_data").append(response.view);
                            }
                            $("#food-drink-Modal").modal("toggle");
                            $('#food_drink_modal_form')[0].reset();

                            $(".food_data").html("")
                            $(".drink_data").html("")

                            if ($(".food-drink-counter").length == 0) {
                                // $(".step-six-btn").attr('disabled', true);
                            } else {
                                $(".step-six-btn").attr('disabled', false);

                            }
                        }


                        $(".food-drink-modal-btn").attr("disabled", false);
                        $(".food-drink-modal-btn i").addClass('d-none');
                    }
                });

            })

            // Edit Food Drink data
            $(document).on("click", ".edit_food_drink", function() {
                var product_food_drink_id = $(this).next().val();
                $.post("{{ route('admin.get_food_drink_modal_view') }}", {

                    product_food_drink_id: $(this).next().val(),
                    _token: "{{ csrf_token() }}"
                }, function(data) {
                    // $('#transportation').val(data.transportation_id);
                    $(".food_data").html(data.food_view);
                    $(".drink_data").html(data.drink_view);

                    $(".select2").select2({
                        dropdownParent: $("#food-drink-Modal")
                    });
                    $(".food_tags").select2({
                        placeholder: 'Search',
                        dropdownParent: $("#food-drink-Modal"),
                        maximumSelectionLength: 5,
                    });

                    $(".drink_tags").select2({
                        placeholder: 'Search',
                        dropdownParent: $("#food-drink-Modal"),
                        maximumSelectionLength: 5,
                    });

                    $(".product_food_drink_id").val(product_food_drink_id);
                    $('input[name="food"][value="' + data.food + '"]').prop('checked', true);
                    $('input[name="drink"][value="' + data.drink + '"]').prop('checked', true);


                    $("#food-drink-Modal").modal("toggle");
                });
            })

            // Remove Food Drink remove_food_drink

            $(document).on("click", ".remove_food_drink", function(e) {
                deleteMsg('Are you sure to delete ?').then((result) => {
                    if (result.isConfirmed) {
                        $.post("{{ route('admin.remove_product_food_drink') }}", {
                            id: $(this).attr("id"),
                            _token: "{{ csrf_token() }}"
                        }, function(data) {
                            $("#food_drink_counter_" + data).remove();
                            if ($(".food-drink-counter").length == 0) {
                                // $(".step-six-btn").attr('disabled', true);
                            } else {
                                $(".step-six-btn").attr('disabled', false);

                            }
                        });
                        e.preventDefault();
                    }
                });

            })

            $(document).on('hidden.bs.modal', '#food-drink-Modal', function() {
                $("#food_drink_modal_form")[0].reset();
                $(".food_data").html('');
                $(".drink_data").html('');
                $(".product_food_drink_id").val('');
            });
        </script>
        {{-- Image Upload Code  --}}
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
                                        " <input type='hidden' name='image_id[]' value=''><img src=' " +
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
                        } else {
                            $("#files").val('');

                            alert('Minimum 10 images');
                        }


                    });
                } else {
                    alert("Your browser doesn't support to File API")
                }
                $(document).on("click", ".remove", function() {
                    $("#files").val("");
                    $(this).closest(".col-md-2").remove();
                });



            });
        </script>

        {{-- Google Api Code --}}
        <script
            src="https://maps.google.com/maps/api/js?key={{ get_setting_data('google_key', 'content') }}&libraries=places&callback=initAutocomplete"
            type="text/javascript"></script>
        <script type="text/javascript">
            google.maps.event.addDomListener(window, 'load', initialize);

            function initialize() {
                var input = document.getElementById('set_address');
                var autocomplete = new google.maps.places.Autocomplete(input);
                autocomplete.addListener('place_changed', function() {
                    var place = autocomplete.getPlace();
                    console.log("   dd($request->all());", place);
                    var formatted_address = place.formatted_address;
                    var adr_address = place.adr_address;


                    var country = '';
                    var state = '';
                    var city = '';
                    $(place.address_components).each(function(key, value) {

                        if ($.inArray('country', value.types) == 0) {
                            country = value.long_name;
                        }

                        if ($.inArray('administrative_area_level_1', value.types) == 0) {
                            state = value.long_name;
                        }

                        if ($.inArray('locality', value.types) == 0) {
                            city = value.long_name;
                        }
                    })



                    var show_selected_loc = "<h6>" + place.adr_address +
                        "<span class='fa fa-times text-danger remove_address'></span>" +
                        "<input type='hidden' name='set_address[]'" +
                        "value='" + formatted_address + "'>" +
                        "<input type='hidden' name='location_id[]' value=''>" +
                        "<input type='hidden' name='country[]' value=" + country + ">" +
                        "<input type='hidden' name='state[]' value='" + state + "'>" +
                        "<input type='hidden' name='city[]' value=" + city + ">" +
                        "<input type='hidden' name='address_latitude[]' value=" + place.geometry['location'].lat() +
                        ">" +
                        "<input type='hidden' name='address_longitude[]' value=" + place.geometry['location'].lng() +
                        "></h6>";

                    $("#show_selected_loc").append(show_selected_loc);
                    $(input).val("");

                });
            }

            // Remove Adress Line
            $(document).on("click", ".remove_address", function() {
                $(this).parent().remove();
            })
        </script>
        {{-- verticle tab disbale endable --}}
        <script>
            var tourId = "{{ isset($_GET['tourId']) ? $_GET['tourId'] : '' }}";
            var optionId = "{{ isset($_GET['optionId']) ? $_GET['optionId'] : '' }}";







            $(".add_product .verticalTab .nav-tabs .nav-item .nav-link").click(function() {
                optionId = GetURLParameterID("optionId");

                var tab = $(this).attr("aria-controls");
                if (optionId == "") {
                    history.pushState(null, null, "{{ url('/add-product/') }}/" + tab + "?tourId=" +
                        tourId);
                } else {
                    history.pushState(null, null, "{{ url('/add-product/') }}/" + tab + "?tourId=" +
                        tourId + "&optionId=" + optionId);
                }

                if ($("#product_option_type").val() == "single") {
                    $("#createOption").addClass('d-none');
                } else {
                    $("#createOption").removeClass('d-none');

                }
                setTimeout(() => {
                    $(".price_per_person").addClass("d-none");
                    $(".price_per_group").addClass("d-none");
                    $(".price_type_div").removeClass("d-none");
                    // $(".select2").select2();
                    // $(".single-select").select2();
                }, 500);

                $(".add_product .verticalTab .nav-tabs .nav-item .nav-link").removeClass("active");
            })
        </script>

        {{-- Option setup  --}}
        <script>
            $(document).on("click", '.information_booklet', function() {
                if (this.checked) {
                    $(".information_booklet_language_div").removeClass('d-none');

                } else {
                    $(".information_booklet_language_div").addClass('d-none');

                }
            });

            $(document).on("click", '.guide_headphone', function() {
                if (this.checked) {
                    $(".guide_headphone_language_div").removeClass('d-none');

                } else {
                    $(".guide_headphone_language_div").addClass('d-none');

                }
            });

            $(document).on("click", ".existing_line", function() {
                var existing_line = $('.existing_line:checked').val();
                console.log("existing_line", existing_line);
                if ($(this).val() == "yes") {
                    $(".existing_line_div").removeClass('d-none');
                } else {
                    $(".existing_line_div").addClass('d-none');

                }
            })




            $(document).on("change", '.time_length', function() {
                if ($(this).val() == "duration") {
                    $(".duration_div").addClass('d-flex');
                    $(".duration_div").removeClass('d-none');

                    $(".validity_div").addClass('d-none');

                } else {
                    if ($(this).val() == "validity") {
                        $(".validity_div").removeClass('d-none');
                        $(".duration_div").removeClass('d-flex');
                        $(".duration_div").addClass('d-none');
                    } else {
                        $(".validity_div").addClass('d-none');
                    }


                }
            })


            $(document).on("change", '.validity_type', function() {
                if ($(this).val() == "time_selected") {
                    $(".validity_time_type_div").removeClass('d-flex');
                    $(".validity_time_type_div").addClass('d-none');
                } else {
                    $(".validity_time_type_div").addClass('d-flex');
                    $(".validity_time_type_div").removeClass('d-none');
                }
            })
        </script>

        {{-- Add New Price --}}
        <script>
            $(document).on("click", ".add-new-price", function() {
                var pricing_type = $(".pricing_type:checked").val();
                $("input[name='group_pricing_id']").val('');
                $("input[name='pricing_id']").val('');
                if (pricing_type == "person") {
                    $(".price_per_person").removeClass("d-none");
                    $(".price_type_div").addClass("d-none");

                    $('.adult-pricing-table-row-data').each(function(key, value) {
                        if (key > 0) {
                            $(this).remove();
                        }
                    })
                    $('.per_person_add_on_div').html('');
                } else {

                    $(".price_per_group").removeClass("d-none");
                    $(".price_type_div").addClass("d-none");

                    $('.group-pricing-table-row-data').each(function(key, value) {
                        if (key > 0) {
                            $(this).remove();
                        }
                    })
                    $('.group_add_on_div').html('');

                }


                $('.age_range_adult').text(0);
                $('.age_range_to_adult').val(0);
                $(".append_age_group").find(".child_price_block_category").remove();
                $(".append_age_group").find(".infant_price_block_category").remove();

                $(".add_age_group option[value='infant']").attr('disabled', false);
                $(".add_age_group option[value='child']").attr('disabled', false);





                setTimeout(() => {
                    $(':input', '#setpOptionPricingForm')
                        .not(
                            ':button, :submit, :reset, :hidden,.age_from,.booking_category,.no_of_people_input')
                        .val('')
                        .removeAttr('checked')
                        .removeAttr('selected');
                }, 300);

            });


            // Add New Availability
            $(document).on("click", ".add-new-availability", function() {
                $(".option_availability").removeClass("d-none");
                $(".availability_div").addClass("d-none");
            });


            // Change Pricing Type

            $(".pricing_type").on('click', function(e) {
                var pricing_display = document.getElementsByClassName('pricing-display').length;
                if (pricing_display > 0) {
                    var checkedValue = $(this).val();
                    confirmMsg('Change this pricing system ?',
                        'This will delete the pricing you have already set up for this option.').then((result) => {
                        if (result.isConfirmed) {

                            $.post("{{ route('admin.remove_option_pricing') }}", {
                                tourId: tourId,
                                optionId: GetURLParameterID("optionId"),
                                _token: "{{ csrf_token() }}"
                            }, function(data) {
                                $('.saved_pricing_list').html("");
                            });
                            e.preventDefault();


                            // $(this).parent().closest('.price-block-category').remove();
                            // var age_group_type = $(this).parent().closest('.price-block-category').find(
                            //     ".age_group_type_value").val();

                            $(".add_age_group option[value='" + age_group_type + "']").attr('disabled', false);
                            e.preventDefault();
                        } else {

                            if (checkedValue == "person") {
                                $("#pricing_type_group").prop('checked', true);
                            } else {
                                $("#pricing_type_person").prop('checked', true);

                            }
                        }
                    });
                }
            })
        </script>

        {{-- Add Price Tires --}}
        <script>
            $(document).on("click", '.add_price_tires', function(e) {
                var count = $(this).parent().find('.pricing-table-row-data').last().attr("id");
                count = parseInt(count) + parseInt(1);
                var pricing_table_row = $(this).parent().find('.pricing_table_row');
                var age_group_type_value = $(this).prev().val();

                var booking_category_value = $(this).parent().prev().find('.booking_category:checked').val();

                if (booking_category_value == "" || booking_category_value == undefined) {
                    booking_category_value = "none";
                }

                var next_input_text = 1;
                if (count > 1) {
                    var newCount = count - 1
                    var next_input_text = $("#" + age_group_type_value + "_no_of_people_input_" + newCount).val();
                    next_input_text = parseInt(next_input_text) + parseInt(1);
                }

                var ParamArr = {
                    'view': 'admin.products.option.pricing._pricing_row',
                    'tier_count': count,
                    'next_input_text': next_input_text,
                    'booking_category_value': booking_category_value,
                    'age_group_type': age_group_type_value
                }
                getAppendPage(ParamArr, pricing_table_row);

                e.preventDefault();
                // setTimeout(() => {
                //     CheckedBtnAttr('seven');
                // }, 500);


                // var pricing_table_row = $(".pricing-table-row-data").clone();
                // $(".pricing-table").append(pricing_table_row);
            })

            // Inclde Add On Price Tiers
            $(document).on("click", '.add_include_price_tires', function(e) {
                var AddOnCount = $(this).attr('data-count');

                var count = $(this).prev().find('.add_on-pricing-table-row-data-' + AddOnCount).last().attr(
                    "id")
                count = parseInt(count) + parseInt(1);
                console.log("count", count);
                var pricing_table_row = $(this).parent().find('.pricing_table_row');
                var age_group_type_value = 'add_on'



                var next_input_text = 1;
                if (count > 1) {
                    var newCount = count - 1

                    var next_input_text = $("#" + age_group_type_value + "_no_of_people_input_" + AddOnCount + "_" +
                        newCount).val();
                    next_input_text = parseInt(next_input_text) + parseInt(1);
                }

                var ParamArr = {
                    'AddOnCount': AddOnCount,
                    'view': 'admin.products.option.pricing._add_on_pricing_row',
                    'tier_count': count,
                    'next_input_text': next_input_text,
                    'age_group_type': age_group_type_value
                }
                getAppendPage(ParamArr, pricing_table_row);

                e.preventDefault();
                // setTimeout(() => {
                //     CheckedBtnAttr('seven');
                // }, 500);


                // var pricing_table_row = $(".pricing-table-row-data").clone();
                // $(".pricing-table").append(pricing_table_row);
            })


            // Change Number of input
            function changeNumber(data, type, AddOnCount = 0) {

                if (AddOnCount > 0) {
                    var rowLength = $(data).parent().parent().parent().parent().parent().find('.' + type +
                            '-pricing-table-row-data-' + AddOnCount).last()
                        .attr('id');
                    var count = $(data).val();
                    var number = $(data).data('number');
                    var newNumber = number + 1
                    for (let index = newNumber; index <= rowLength; index++) {
                        var peopleData = $("#" + type + "_no_of_people_input_" + AddOnCount + "_" + number).val();
                        var peopleNewData = $("#" + type + "_no_of_people_input_" + AddOnCount + "_" + newNumber).val();
                        var newonedata = $("#" + type + "_no_of_people_" + AddOnCount + "_" + index).text();
                        $("#" + type + "_no_of_people_" + AddOnCount + "_" + index).html(parseInt(peopleData) + parseInt(1))
                        $("#" + type + "_no_of_to_people_" + AddOnCount + "_" + index).val(parseInt(peopleData) + parseInt(1))
                        if (peopleData >= newonedata) {
                            $("#" + type + "_no_of_people_input_" + AddOnCount + "_" + index).val(parseInt(peopleNewData) +
                                parseInt(2))
                        } else {
                            $("#" + type + "_no_of_people_input_" + AddOnCount + "_" + index).val(parseInt(peopleNewData) -
                                parseInt(2))
                        }
                        newNumber++;
                        number++;
                    }


                } else {
                    var rowLength = $(data).parent().parent().parent().parent().parent().find('.pricing-table-row-data').last()
                        .attr('id');
                    var count = $(data).val();
                    var number = $(data).data('number');
                    var newNumber = number + 1
                    for (let index = newNumber; index <= rowLength; index++) {
                        var peopleData = $("#" + type + "_no_of_people_input_" + number).val();
                        var peopleNewData = $("#" + type + "_no_of_people_input_" + newNumber).val();
                        var newonedata = $("#" + type + "_no_of_people_" + index).text();
                        $("#" + type + "_no_of_people_" + index).html(parseInt(peopleData) + parseInt(1));
                        $("#" + type + "_no_of_to_people_" + index).val(parseInt(peopleData) + parseInt(1));
                        if (peopleData >= newonedata) {
                            $("#" + type + "_no_of_people_input_" + index).val(parseInt(peopleNewData) + parseInt(2))
                        } else {
                            $("#" + type + "_no_of_people_input_" + index).val(parseInt(peopleNewData) - parseInt(2))
                        }
                        newNumber++;
                        number++;
                    }
                }
            }




            // Calculate Payout
            function calculatePayout(data, type, AddOnCount = 0) {

                var percentage = 30;
                var currentValue = $(data).val();
                var number = $(data).data('number');
                var calculatedPercentage = percentage / 100 * currentValue;
                var finalValue = parseFloat(currentValue) - parseFloat(calculatedPercentage);
                if (AddOnCount > 0) {
                    $("#" + type + "_payout_per_person_" + AddOnCount + "_" + number).val(finalValue.toFixed(2));

                } else {
                    $("#" + type + "_payout_per_person_" + number).val(finalValue.toFixed(2));

                }
            }


            // Booking Category Validation

            $(document).on("click", ".booking_category", function() {
                var booking_category_value = $(this).val();


                if (booking_category_value == "free") {
                    if ($(this).closest('.price-block-booking-category').next().hasClass("d-none")) {
                        $(this).closest('.price-block-booking-category').next().find(".commission_payout").addClass(
                            "d-none");
                        $(this).closest('.price-block-booking-category').next().find(".commission_payout_header")
                            .addClass("d-none");
                        $(this).closest('.price-block-booking-category').next().removeClass("d-none")
                        $(this).closest('.price-block-booking-category').next().find(
                            ".commission_payout").prev().find('input').attr('disabled', true)
                    } else {
                        $(this).closest('.price-block-booking-category').next().find(".commission_payout").addClass(
                            "d-none");
                        $(this).closest('.price-block-booking-category').next().find(".commission_payout_header")
                            .addClass("d-none");



                    }
                } else if (booking_category_value == "standard") {
                    $(this).closest('.price-block-booking-category').next().find(".commission_payout").removeClass(
                        "d-none");
                    $(this).closest('.price-block-booking-category').next().find(".commission_payout_header")
                        .removeClass("d-none");
                    $(this).closest('.price-block-booking-category').next().removeClass("d-none");
                    $(this).closest('.price-block-booking-category').next().find(
                        ".commission_payout").prev().find('input').attr('disabled', false)
                } else {
                    $(this).closest('.price-block-booking-category').next().addClass("d-none")
                }
            });


            // Add Age Group Div

            $(document).on("change", ".add_age_group", function(e) {
                var age_group_type = $(this).val();
                var ParamArr = {
                    'view': 'admin.products.option._age_group_section',
                    'tier_count': 1,
                    'next_input_text': 1,
                    'booking_category_value': 'standard',
                    'age_group_type': age_group_type
                }
                getAppendPage(ParamArr, '.append_age_group', age_group_type);
                setTimeout(() => {
                    // $("#select_" + age_group_type).select2();
                    if (age_group_type == "child") {
                        $("#select_" + age_group_type).val("17");
                        $(".age_range_adult").text("18");
                        $(".age_range_to_adult").val(18);
                        for (let i = 0; i <= 16; i++) {
                            // $("#select_" + age_group_type + " option[value='" + i + "']").attr('disabled',
                            //     true);
                        }
                    }
                    if (age_group_type == "infant") {
                        $("#select_" + age_group_type).val("9");
                        $("#select_child").val("18");
                        $(".age_range_child").text("10");
                        $(".age_range_to_child").val(10);
                        $(".age_range_adult").text("11");
                        $(".age_range_to_adult").val(11);
                        // for (let i = 0; i <= 8; i++) {
                        //     $("#select_" + age_group_type + " option[value='" + i + "']").attr('disabled',
                        //         true);
                        // }
                    }
                }, 500);
                $(".add_age_group option[value='" + age_group_type + "']").attr('disabled', true);

                e.preventDefault();
            })

            // remove Group Type Div
            $(document).on('click', '.remove_group', function(e) {

                deleteMsg('Are you sure to delete ?').then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent().closest('.price-block-category').remove();
                        var age_group_type = $(this).parent().closest('.price-block-category').find(
                            ".age_group_type_value").val();

                        $(".add_age_group option[value='" + age_group_type + "']").attr('disabled', false);
                        e.preventDefault();
                    }
                });
            });

            // remove Add On Group Div
            $(document).on('click', '.remove_add_on_group', function(e) {

                deleteMsg('Are you sure to delete ?').then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent().closest('.pricing-addon').remove();
                        e.preventDefault();
                    }
                });
            });

            // Change Age Dropdown

            function changeAgeDropDown(d, type) {
                var dropValue = $(d).val();
                var newdropValue = parseInt(dropValue) + parseInt(1)
                var arr = ['adult', 'child', 'infant'];
                var newArr = jQuery.grep(arr, function(value) {
                    return value != type;
                });
                $.each(newArr, function(key, item) {
                    if (type == "infant") {
                        $("#select_child").val(newdropValue);
                        $(".age_range_child").text(newdropValue);
                        $(".age_range_to_child").val(newdropValue);
                        $(".age_range_adult").text(newdropValue + 1);
                        $(".age_range_to_adult").val(newdropValue + 1);
                        for (let i = 0; i <= 100; i++) {
                            if (i <= dropValue) {
                                if (item == "adult") {
                                    var newI = parseInt(i) + parseInt(1)
                                    // $("#select_" + item + " option[value='" + newI + "']").attr('disabled',
                                    //     true);
                                } else {
                                    // $("#select_" + item + " option[value='" + i + "']").attr('disabled',
                                    //     true);
                                }
                            } else {
                                // $("#select_" + item + " option[value='" + i + "']").attr('disabled',
                                //     false);
                            }
                        }
                    }
                    if (type == "child") {
                        $(".age_range_adult").text(newdropValue);
                        $(".age_range_to_adult").val(newdropValue);
                        for (let i = 0; i <= 100; i++) {
                            if (i <= dropValue) {
                                // $("#select_" + item + " option[value='" + i + "']").attr('disabled',
                                //     true);
                            } else {
                                // $("#select_" + item + " option[value='" + i + "']").attr('disabled',
                                //     false);
                            }
                        }
                    }
                });
            }


            // Remove Pricing Row

            $(document).on("click", '.remove_pricing_row', function() {

                deleteMsg('Are you sure to delete ?').then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent().parent().remove();
                        var type = $(this).parent().parent().data('type');

                        $("." + type + "-pricing-table-row-data").each(function(key, value) {
                            var newKey = parseInt(key) + parseInt(1);
                            $(this).attr("id", newKey);
                        })

                        $("." + type + "_no_of_people").each(function(key, value) {
                            var newKey = parseInt(key) + parseInt(1);
                            $(this).attr("id", type + "_no_of_people_" + newKey);
                        })

                        $("." + type + "_no_of_people_input").each(function(key, value) {
                            var newKey = parseInt(key) + parseInt(1);
                            $(this).attr("id", type + "_no_of_people_input_" + newKey);
                            $(this).attr("data-number", newKey);
                        })

                        $("." + type + "_commission_payout").each(function(key, value) {
                            var newKey = parseInt(key) + parseInt(1);
                            $(this).attr("id", type + "_commission_payout_" + newKey);
                        })

                        $("." + type + "_payout_per_person").each(function(key, value) {
                            var newKey = parseInt(key) + parseInt(1);
                            $(this).attr("id", type + "_payout_per_person_" + newKey);
                        })

                        $("." + type + "_retail_price").each(function(key, value) {
                            var newKey = parseInt(key) + parseInt(1);
                            $(this).attr("data-number", newKey);
                        })


                    }
                });
            })


            // Remove Add On Pricing Row
            $(document).on("click", '.remove_add_on_pricing_row', function() {

                deleteMsg('Are you sure to delete ?').then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent().parent().remove();
                        var type = $(this).parent().parent().data('type');
                        var AddOnCount = $(this).data('count');

                        $("." + type + "-pricing-table-row-data-" + AddOnCount).each(function(key, value) {
                            var newKey = parseInt(key) + parseInt(1);
                            $(this).attr("id", newKey);
                        })

                        $("." + type + "_no_of_people_" + AddOnCount).each(function(key, value) {
                            var newKey = parseInt(key) + parseInt(1);
                            $(this).attr("id", type + "_no_of_people_" + AddOnCount + "_" + newKey);
                        })

                        $("." + type + "_no_of_people_input_" + AddOnCount).each(function(key, value) {
                            var newKey = parseInt(key) + parseInt(1);
                            $(this).attr("id", type + "_no_of_people_input_" + AddOnCount + "_" +
                                newKey);
                            $(this).attr("data-number", newKey);
                        })

                        $("." + type + "_commission_payout_" + AddOnCount).each(function(key, value) {
                            var newKey = parseInt(key) + parseInt(1);
                            $(this).attr("id", type + "_commission_payout_" + AddOnCount + "_" +
                                newKey);
                        })

                        $("." + type + "_payout_per_person_" + AddOnCount).each(function(key, value) {
                            var newKey = parseInt(key) + parseInt(1);
                            $(this).attr("id", type + "_payout_per_person_" + AddOnCount + "_" +
                                newKey);
                        })

                        $("." + type + "_retail_price_" + AddOnCount).each(function(key, value) {
                            var newKey = parseInt(key) + parseInt(1);
                            $(this).attr("data-number", newKey);
                        })
                    }
                });
            })


            // Include Add On

            $(document).on('click', '.include_add_on', function() {
                var AddOnCount = $(".price_add_on_div").length;

                if (AddOnCount == "" || AddOnCount == undefined) {
                    AddOnCount = 0;
                }

                AddOnCount = parseInt(AddOnCount) + parseInt(1);

                var count = $('.add_on-pricing-table-row-data').last().attr("id");

                if (count == "" || count == undefined) {
                    count = 1;
                } else {
                    count = parseInt(count) + parseInt(1);
                }
                var AppendDiv = $(this).prev().attr('class');
                var ParamArr = {
                    'AddOnCount': AddOnCount,
                    'tier_count': count,
                    'next_input_text': 1,
                    'booking_category_value': 'booking_category_value',
                    'age_group_type': 'add_on',
                    'view': 'admin.products.option._include_add_on'
                }
                getAppendPage(ParamArr, "." + AppendDiv);

                setTimeout(() => {
                    $(".select2").select2();
                }, 500);
            })
        </script>

        <script>
            var tourId = "{{ isset($_GET['tourId']) ? $_GET['tourId'] : '' }}";
            var optionId = "{{ isset($_GET['optionId']) ? $_GET['optionId'] : '' }}";
            // Edit Option Pricing
            optionId = GetURLParameterID("optionId");
            $(document).on('click', '.edit_pricing', function(e) {
                var optionPricingId = $(this).data('index');
                var type = $(this).data('type');
                $.post("{{ route('admin.edit_option_pricing') }}", {
                    tourId: tourId,
                    optionId: GetURLParameterID("optionId"),
                    optionPricingId: optionPricingId,
                    type: type,
                    _token: "{{ csrf_token() }}"
                }, function(data) {
                    if (type == "person") {
                        $(".price_per_person").removeClass("d-none");
                        $(".price_per_person").html(data);
                    } else {
                        $(".price_per_group").removeClass("d-none");
                        $(".price_per_group").html(data);
                    }
                    $(".price_type_div").addClass("d-none");
                });

                e.preventDefault();
            })

            // Remove Option Pricing
            $(document).on('click', '.remove_pricing', function(e) {
                var pricing_id = $(this).prev().data('index');
                var remove_div = $(this).parent().parent().parent();
                $.post("{{ route('admin.remove_option_pricing') }}", {
                    tourId: tourId,
                    optionId: GetURLParameterID("optionId"),
                    optionPricingId: pricing_id,
                    _token: "{{ csrf_token() }}"
                }, function(data) {


                    remove_div.remove();
                    if ($(".pricing-display").length == 0) {
                        console.log("remove");
                        $(".add-new-price").removeClass('d-none');
                    }



                })
            })

            // Remove Option

            $(document).on('click', '.remove_option', function(e) {
                $remove_option = $(this)
                deleteMsg('Are you sure to delete ?').then((result) => {
                    if (result.isConfirmed) {

                        $.post("{{ route('admin.remove_product_option') }}", {
                            tourId: tourId,
                            id: $(this).data("option"),
                            _token: "{{ csrf_token() }}"
                        }, function(data) {
                            $remove_option.parent().parent().parent().remove();
                            // if ($(".counter-card-1").length == 0) {
                            //     $(".step-four-btn").attr('disabled', true);
                            // } else {
                            //     $(".step-four-btn").attr('disabled', false);

                            // }
                        });
                        e.preventDefault();
                    }
                });
            });
        </script>
        <script>
            var date = new Date();

            var currentMonth = date.getMonth() + 1;
            var currentDate = date.getDate();
            var currentYear = date.getFullYear();
            var today = currentMonth + '/' + currentDate + '/' + currentYear;


            var tourId = "{{ isset($_GET['tourId']) ? $_GET['tourId'] : '' }}";
            var optionId = "{{ isset($_GET['optionId']) ? $_GET['optionId'] : '' }}";
            // Edit Option Pricing
            optionId = GetURLParameterID("optionId");

            // Add Time 
            $(document).on('click', '.add-time', function() {
                var day = $(this).data('day');
                var is_list = $(".availability-time-" + day).length
                var view = ".day-" + day;


                if (is_list > 0) {
                    view = ".time-list-" + day
                }

                var ParamArr = {
                    'view': 'admin.products.option.pricing._time_list',
                    'is_list': is_list,
                    'day': day
                }
                getAppendPage(ParamArr, view);
            })

            // Addd Time in date
            $(document).on('click', '.add-date-time', function() {
                var count = $(this).data('count');
                var AppendDiv = $(this).prev().find('ul').attr("class");
                var ParamArr = {
                    'view': 'admin.products.option.pricing._time_list',
                    'day': count
                }
                getAppendPage(ParamArr, ".availability-time-list-" + count);
            })




            // Add date 
            $(document).on('click', '.add-date', function() {

                var count = $(".AppendAviableDate").find(".available-date").last().attr("id");
                console.log("countOld", count);

                if (count == undefined) {
                    count = 0;
                } else {
                    count = parseInt(count) + parseInt(1);
                }

                var view = ".AppendAviableDate";
                var ParamArr = {
                    'view': 'admin.products.option.pricing._date_list',
                    'count': count,
                    'day': 1
                }
                getAppendPage(ParamArr, view);
                setTimeout(() => {
                    $('.datepickr').daterangepicker({
                        minDate: today,
                        singleDatePicker: true,
                        showDropdowns: true,
                        locale: {
                            format: 'YYYY-MM-DD'
                        }
                    });
                }, 500);
            })


            // Add Discount date 
            $(document).on('click', '.add-discount-date', function() {

                var count = $(".AppendAviableDiscountDate").find(".available-discount-date").last().attr("id");
                console.log("countOld", count);

                if (count == undefined) {
                    count = 0;
                } else {
                    count = parseInt(count) + parseInt(1);
                }

                var view = ".AppendAviableDiscountDate";
                var ParamArr = {
                    'view': 'admin.products.option.pricing._discount_date_list',
                    'count': count,
                    'day': 1
                }
                getAppendPage(ParamArr, view);
                setTimeout(() => {
                    $('.datepickr').daterangepicker({
                        minDate: today,
                        singleDatePicker: true,
                        showDropdowns: true,
                        locale: {
                            format: 'YYYY-MM-DD'
                        }
                    });
                }, 500);
            })

            // Remove Time remove_time
            $(document).on('click', '.remove_time', function(e) {
                var day = $(this).parent().data('day');
                var is_time_length = $(".availability-time-" + day).length;

                if (is_time_length == 0) {
                    $(this).parent().parent().remove();
                } else {
                    $(this).parent().remove();
                }
                e.preventDefault();
                //     }
                // });
            })

            // Remove Date Time

            $(document).on('click', '.remove_date_time', function(e) {
                $(this).parent().remove();
            })


            // Edit Availability
            $(document).on('click', '.edit_availability', function(e) {
                var PricingId = $(this).data('index');
                $.post("{{ route('admin.edit_price_availability') }}", {
                    tourId: tourId,
                    optionId: GetURLParameterID("optionId"),
                    PricingId: PricingId,
                    _token: "{{ csrf_token() }}"
                }, function(data) {
                    $("#option-availability-vertical").html(data);
                    $('.datepickr').daterangepicker({
                        minDate: today,
                        singleDatePicker: true,
                        showDropdowns: true,
                        locale: {
                            format: 'YYYY-MM-DD'
                        }
                    });

                    $(".tab-pane").each(function(key, value) {
                        $(value).removeClass('active show');
                        $(".nav-link").removeClass('active');
                        if ($(value).attr('id') == 'option-availability-vertical') {
                            $(value).addClass('active show');
                        }
                    })
                    $(".nav-link").each(function(key, value) {
                        if ($(value).attr('href') == '#option-price-vertical') {
                            $(value).addClass('active');
                        }
                    })
                });
                e.preventDefault();
            })

            // Edit Discount
            $(document).on('click', '.edit_discount', function(e) {
                var PricingId = $(this).data('index');
                $.post("{{ route('admin.edit_price_discount') }}", {
                    tourId: tourId,
                    optionId: GetURLParameterID("optionId"),
                    PricingId: PricingId,
                    _token: "{{ csrf_token() }}"
                }, function(data) {
                    $("#option-discount-vertical").html(data);

                    $('.datepickr').daterangepicker({
                        minDate: today,
                        singleDatePicker: true,
                        showDropdowns: true,
                        locale: {
                            format: 'YYYY-MM-DD'
                        }
                    });
                    $(".tab-pane").each(function(key, value) {
                        $(value).removeClass('active show');
                        $(".nav-link").removeClass('active');
                        if ($(value).attr('id') == 'option-discount-vertical') {
                            $(value).addClass('active show');
                        }
                    })
                    $(".nav-link").each(function(key, value) {
                        if ($(value).attr('href') == '#option-price-vertical') {
                            $(value).addClass('active');
                        }
                    })
                });
                e.preventDefault();
            })


            // Change Multiple To single Code

            $(document).on('change', '#product_option_type', function() {
                var option_type = $(this).val();
                var ProductOption = $(".option-card").length;

                if (option_type == 'single' && ProductOption > 1) {

                    warningMsg('Oops...', 'keep only 1 option for single product option');
                    // $('#product_option_type').prop('selectedIndex', 0);
                    $('#product_option_type').val('multiple'); // Select the option with a value of '1'
                    $('#product_option_type').trigger('change');

                } else {
                    $.post("{{ route('admin.add_product') }}", {
                        tourId: tourId,
                        step: "option_type",
                        value: $('#product_option_type').val(),
                        _token: "{{ csrf_token() }}"
                    }, function(data) {
                        if (option_type == 'single') {

                            $(".createOption").addClass('d-none');
                        } else {
                            $(".createOption").removeClass('d-none');

                        }
                    });
                }
            });
        </script>
        <script>
            var date = new Date();

            var currentMonth = date.getMonth() + 1;
            var currentDate = date.getDate();
            var currentYear = date.getFullYear();
            var today = currentMonth + '/' + currentDate + '/' + currentYear;

            $(document).on('change', '.discount_valid_from', function() {

                $('.discount_valid_to').daterangepicker({
                    minDate: today,
                    singleDatePicker: true,
                    showDropdowns: true,
                    minDate: $(this).val(),
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                });
            })
            $(document).on('change', '.valid_from', function() {

                $('.valid_to').daterangepicker({
                    minDate: today,
                    singleDatePicker: true,
                    showDropdowns: true,
                    minDate: $(this).val(),
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                });
            })

            $(document).on('click', '.final-step', function() {
                //  setTimeout(() => {
                window.location.replace("{{ route('admin.get_products') }}")
                // }, 1000);
            })
        </script>
    @endsection
@endsection
