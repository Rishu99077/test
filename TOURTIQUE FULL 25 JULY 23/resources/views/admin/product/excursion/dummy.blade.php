@extends('admin.layout.master')
@section('content')
    <style type="text/css">
        .content_title {
            margin-top: 10px;
        }

        .add_more_button {
            text-align: right;
            margin-top: 10px;
        }

        .btn-danger {
            margin-top: 10px;
        }

        table.table2 {
            border: 1px solid #ccc;
        }

        table.table2 td {
            padding: 10px;
            border: 1px solid #ccc;
        }
    </style>
    <div class="card mb-3">
        <div class="bg-holder d-none d-lg-block bg-card"
            style="background: linear-gradient(90deg, rgba(38,42,73,1) 0%, rgba(61,65,100,1) 71%, rgba(9,193,45,0.44019614681810226) 100%);">
        </div>
        <!--/.bg-holder-->
        <div class="card-body position-relative">
            <div class="row">
                <div class="col-lg-8">
                    <h3>{{ $common['title'] }}</h3>
                </div>
                <div class="col-auto ms-auto">
                    <a class="btn btn-falcon-primary me-1 mb-1" href="javascript:void(0)" onclick="back()"
                        type="button"><span class="fas fa-arrow-alt-circle-left text-primary "></span> Back </a>
                </div>
            </div>
        </div>
    </div>
    <form class="row g-3 " method="POST" action="{{ route('admin.product.add') }}" enctype="multipart/form-data">
        @csrf
        <div class="col-lg-12">

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active test" id="home-tab" data_id="1" data-bs-toggle="tab" href="#tab-home"
                        role="tab" aria-controls="tab-home" aria-selected="true">General</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link test" id="highlight-tab" data_id="2" data-bs-toggle="tab" href="#tab-highlight"
                        role="tab" aria-controls="tab-highlight" aria-selected="false">Highlights</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link test" id="timing-tab" data_id="3" data-bs-toggle="tab" href="#tab-timing"
                        role="tab" aria-controls="tab-timing" aria-selected="false">Timings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link test" id="table-tab" data_id="4" data-bs-toggle="tab" href="#tab-table"
                        role="tab" aria-controls="tab-table" aria-selected="false">Options</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link test" id="info-tab" data_id="5" data-bs-toggle="tab" href="#tab-info"
                        role="tab" aria-controls="tab-info" aria-selected="false">Additional info</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="faqs-tab" data_id="6" data-bs-toggle="tab" href="#tab-faqs" role="tab"
                        aria-controls="tab-faqs" aria-selected="false">Faqs</a>
                </li>
            </ul>

            <div class="tab-content border-x border-bottom p-3" id="myTabContent">

                <!-- GENERAL TAB -->
                <div class="tab-pane fade show active" id="tab-home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="row">
                        <input id="" name="id" type="hidden" value="{{ $get_product['id'] }}" />

                        <div class="col-md-6 content_title">
                            <label class="form-label" for="title">Excursion Title<span
                                    class="text-danger">*</span></label>
                            <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                                placeholder="Excursion Title" id="name" name="title" type="text"
                                value="{{ old('title', $get_product['title']) }}" />
                            @error('title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6 content_title">
                            <label class="form-label" for="title">Availability </label>
                            <div class="row">
                                <div class="col-md-2">
                                    <input class="form-check-input avl_item" id="flexRadioDefault1" type="radio"
                                        name="availability" value="all_days" <?php if ($get_product['availability'] == 'all_days') {
                                            echo 'checked="checked"';
                                        } ?> checked="" />
                                    <label class="form-check-label" for="flexRadioDefault1">All Days</label>
                                </div>
                                <div class="col-md-2">
                                    <input class="form-check-input avl_item" id="flexRadioDefault2" type="radio"
                                        name="availability" value="week_days" <?php if ($get_product['availability'] == 'week_days') {
                                            echo 'checked="checked"';
                                        } ?> />
                                    <label class="form-check-label" for="flexRadioDefault2">Week days</label>
                                </div>
                            </div>
                        </div>

                        <?php $product = json_decode($get_product['days']); ?>

                        @if ($product != '')
                            <div class="col-md-12 content_title show_timings">
                                <label class="form-label" for="title">Select day </label>
                                <div class="row">
                                    <div class="col-md-1">
                                        <input class="form-check-input" id="flexCheckDefault" type="checkbox"
                                            name="days[]" value="monday" <?php
                                            if (in_array('monday', $product)) {
                                                echo 'checked="checked"';
                                            } ?> />
                                        <label class="form-check-label" for="flexCheckDefault">Monday</label>
                                    </div>
                                    <div class="col-md-1">
                                        <input class="form-check-input" id="flexCheckDefault" type="checkbox"
                                            name="days[]" value="tuesday" <?php
                                            if (in_array('tuesday', $product)) {
                                                echo 'checked="checked"';
                                            } ?> />
                                        <label class="form-check-label" for="flexCheckDefault">Tuesday</label>
                                    </div>
                                    <div class="col-md-1">
                                        <input class="form-check-input" id="flexCheckDefault" type="checkbox"
                                            name="days[]" value="wednesday" <?php
                                            if (in_array('wednesday', $product)) {
                                                echo 'checked="checked"';
                                            } ?> />
                                        <label class="form-check-label" for="flexCheckDefault">Wednesday</label>
                                    </div>
                                    <div class="col-md-1">
                                        <input class="form-check-input" id="flexCheckDefault" type="checkbox"
                                            name="days[]" value="thrusday" <?php
                                            if (in_array('thrusday', $product)) {
                                                echo 'checked="checked"';
                                            } ?> />
                                        <label class="form-check-label" for="flexCheckDefault">Thrusday</label>
                                    </div>
                                    <div class="col-md-1">
                                        <input class="form-check-input" id="flexCheckDefault" type="checkbox"
                                            name="days[]" value="friday" <?php
                                            if (in_array('friday', $product)) {
                                                echo 'checked="checked"';
                                            } ?> />
                                        <label class="form-check-label" for="flexCheckDefault">Friday</label>
                                    </div>
                                    <div class="col-md-1">
                                        <input class="form-check-input" id="flexCheckDefault" type="checkbox"
                                            name="days[]" value="saturday" <?php
                                            if (in_array('saturday', $product)) {
                                                echo 'checked="checked"';
                                            } ?> />
                                        <label class="form-check-label" for="flexCheckDefault">Saturday</label>
                                    </div>
                                    <div class="col-md-1">
                                        <input class="form-check-input" id="flexCheckDefault" type="checkbox"
                                            name="days[]" value="sunday" <?php
                                            if (in_array('sunday', $product)) {
                                                echo 'checked="checked"';
                                            } ?> />
                                        <label class="form-check-label" for="flexCheckDefault">Sunday</label>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="col-md-12 content_title show_timings" style="display: none;">
                                <label class="form-label" for="title">Select day </label>
                                <div class="row">
                                    <div class="col-md-1">
                                        <input class="form-check-input" id="flexCheckDefault" type="checkbox"
                                            name="days[]" value="monday" />
                                        <label class="form-check-label" for="flexCheckDefault">Monday</label>
                                    </div>
                                    <div class="col-md-1">
                                        <input class="form-check-input" id="flexCheckDefault" type="checkbox"
                                            name="days[]" value="tuesday" />
                                        <label class="form-check-label" for="flexCheckDefault">Tuesday</label>
                                    </div>
                                    <div class="col-md-1">
                                        <input class="form-check-input" id="flexCheckDefault" type="checkbox"
                                            name="days[]" value="wednesday" />
                                        <label class="form-check-label" for="flexCheckDefault">Wednesday</label>
                                    </div>
                                    <div class="col-md-1">
                                        <input class="form-check-input" id="flexCheckDefault" type="checkbox"
                                            name="days[]" value="thrusday" />
                                        <label class="form-check-label" for="flexCheckDefault">Thrusday</label>
                                    </div>
                                    <div class="col-md-1">
                                        <input class="form-check-input" id="flexCheckDefault" type="checkbox"
                                            name="days[]" value="friday" />
                                        <label class="form-check-label" for="flexCheckDefault">Friday</label>
                                    </div>
                                    <div class="col-md-1">
                                        <input class="form-check-input" id="flexCheckDefault" type="checkbox"
                                            name="days[]" value="saturday" />
                                        <label class="form-check-label" for="flexCheckDefault">Saturday</label>
                                    </div>
                                    <div class="col-md-1">
                                        <input class="form-check-input" id="flexCheckDefault" type="checkbox"
                                            name="days[]" value="sunday" />
                                        <label class="form-check-label" for="flexCheckDefault">Sunday</label>
                                    </div>
                                </div>
                            </div>
                        @endif




                        <div class="col-md-6 content_title">
                            <label class="form-label" for="duration_from">Duration<span
                                    class="text-danger">*</span></label>
                            <div class="input-group mb-3">
                                <input class="form-control {{ $errors->has('duration_from') ? 'is-invalid' : '' }}"
                                    type="number" name="duration_from" placeholder="Enter Duration in hours"
                                    aria-describedby="basic-addon2"
                                    value="{{ old('duration_from', $get_product['duration_from']) }}" /><span
                                    class="input-group-text" id="basic-addon2">Hours</span>
                            </div>
                            @error('duration_from')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6 content_title pro_status">
                            <label class="form-label" for="price">Excursion Type </label>
                            <select class="form-select single-select" name="excursion_type" id="excursion_type">
                                <option value="non_refundable" <?php if ($get_product['excursion_type'] == 'non_refundable') {
                                    echo 'selected="selected"';
                                } ?>>Non-refundable </option>
                                <option value="can_be_cancled" <?php if ($get_product['excursion_type'] == 'can_be_cancled') {
                                    echo 'selected="selected"';
                                } ?>>Can be canceled</option>
                            </select>
                        </div>

                        @if ($get_product['cancel_duration'] != '')
                            <div class="col-md-6 content_title cncl_duration">
                            @else
                                <div class="col-md-6 content_title cncl_duration" style="display: none;">
                        @endif
                        <label class="form-label" for="cancel_duration">Cancled Duration</label>
                        <div class="input-group mb-3">
                            <input class="form-control" type="number" name="cancel_duration"
                                placeholder="Enter Cancled Duration in hours" aria-describedby="basic-addon2"
                                value="{{ $get_product['cancel_duration'] }}" /><span class="input-group-text"
                                id="basic-addon2">Hours</span>
                        </div>
                    </div>

                    <div class="col-md-6 content_title">
                        <label class="form-label" for="price">Pick Options <span class="text-danger">*</span></label>
                        <div class="row">
                            <?php $Pick_opt = json_decode($get_product['pick_option']); ?>

                            <div class="col-md-2">
                                <input class="form-check-input {{ $errors->has('pick_option') ? 'is-invalid' : '' }}"
                                    id="flexCheckDefault" type="checkbox" name="pick_option[]" value="pick_up"
                                    <?php if ($Pick_opt != '') {
                                        if (in_array('pick_up', $Pick_opt)) {
                                            echo 'checked="checked"';
                                        }
                                    } ?> />
                                <label class="form-check-label" for="flexCheckDefault">Pick Up</label>
                            </div>
                            <div class="col-md-2">
                                <input class="form-check-input {{ $errors->has('pick_option') ? 'is-invalid' : '' }}"
                                    id="flexCheckChecked" type="checkbox" name="pick_option[]" value="drop_back"
                                    <?php if ($Pick_opt != '') {
                                        if (in_array('drop_back', $Pick_opt)) {
                                            echo 'checked="checked"';
                                        }
                                    } ?> />
                                <label class="form-check-label" for="flexCheckChecked">Drop Back</label>
                            </div>
                        </div>
                        @error('pick_option')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6 content_title">
                        <label class="form-label" for="price">Excursion Status</label>
                        <select class="form-select single-select" name="status">
                            <option value="Active" <?php if ($get_product['status'] == 'Active') {
                                echo 'selected="selected"';
                            } ?>>Active</option>
                            <option value="Deactive" <?php if ($get_product['status'] == 'Deactive') {
                                echo 'selected="selected"';
                            } ?>>
                                Deactive
                            </option>
                        </select>
                    </div>

                    <div class="col-md-12 content_title">
                        <label class="form-label" for="price">Video</label>
                        <input type="file" name="video" class="form-control">
                    </div>

                    <div class="col-md-12 content_title">
                        <label class="form-label" for="address">Address</label>
                        <input type="text" id="txtSource"
                            class="pac-target-input form-control {{ $errors->has('address') ? 'is-invalid' : '' }}"
                            name="address" placeholder="Enter a location" autocomplete="off"
                            value="{{ old('address', $get_product['address']) }}">
                        @error('address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-12 content_title text-end">
                        <input id="Next" type="button" value=">" class="btn btn-primary"
                            onclick="doTab('Next','1')" />
                    </div>
                </div>
            </div>

            <!-- HIGHLIGHTS TAB -->
            <div class="tab-pane fade" id="tab-highlight" role="tabpanel" aria-labelledby="highlight-tab">
                <div class="row">
                    <div class="col-md-12 content_title">
                        @if (count($get_higlights) > 0)
                            @foreach ($get_higlights as $key => $value)
                                <input type="hidden" name="highlights_id[]" value="{{ $value['id'] }}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label" for="title">Higlights Title<span
                                                class="text-danger">*</span></label>
                                        <input class="form-control" name="highlights_title[]" type="text"
                                            placeholder="Enter Higlights Title"
                                            value="{{ $value['highlights_title'] }}" />
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label" for="title">Higlights Description<span
                                                class="text-danger">*</span></label>
                                        <textarea name="highlights_description[]" class="form-control" id="footer_text"
                                            placeholder="Enter Higlights Description">{{ $value['highlights_description'] }}"</textarea>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="hidden" name="highlights_id[]" value="">
                                    <label class="form-label" for="title">Higlights Title<span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" name="highlights_title[]" type="text"
                                        placeholder="Enter Higlights Title" />
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label" for="title">Higlights Description<span
                                            class="text-danger">*</span></label>
                                    <textarea name="highlights_description[]" class="form-control" id="footer_text"
                                        placeholder="Enter Higlights Description"></textarea>
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            <div class="show_highlights">
                            </div>
                            <div class="col-md-12 add_more_button">
                                <button class="btn btn-success btn-sm" type="button" id="add_highlights"
                                    title='Add more' />Add more</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 content_title text-end">
                        <input id="Previous" type="button" value="<" class="btn btn-primary"
                            onclick="doTab('Previous','2')" />
                        <input id="Next" type="button" value=">" class="btn btn-primary"
                            onclick="doTab('Next','2')" />
                    </div>
                </div>
            </div>

            <!-- TIMINGS TAB -->
            <div class="tab-pane fade" id="tab-timing" role="tabpanel" aria-labelledby="timing-tab">
                <div class="row">
                    <div class="col-md-6 content_title">
                        @if (count($get_timings) > 0)
                            @foreach ($get_timings as $key => $value)
                                <div class="row week_box">
                                    <div class="col-md-3 content_title">
                                        <h3 class="text-primary">{{ $value['day'] }}</h3>
                                        <input type="hidden" name="day[]" value="{{ $value['day'] }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="timepicker1">From</label>
                                        <input class="form-control datetimepicker pick_from" id="timepicker1"
                                            name="time_from[]" type="text" placeholder="H:i"
                                            data-options='{"enableTime":true,"noCalendar":true,"dateFormat":"H:i","disableMobile":true}'
                                            value="{{ $value['time_from'] }}" />
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="timepicker1">To</label>
                                        <input class="form-control datetimepicker pick_to" id="timepicker1"
                                            name="time_to[]" type="text" placeholder="H:i"
                                            data-options='{"enableTime":true,"noCalendar":true,"dateFormat":"H:i","disableMobile":true}'
                                            value="{{ $value['time_to'] }}" />
                                    </div>
                                    <div class="col-md-1">
                                        <label class="form-check-label" for="flexCheckChecked">Close</label>
                                        <input class="form-check-input min_close" id="flexCheckChecked" type="checkbox"
                                            name="is_close[]" <?php if ($value['is_close'] == '1') {
                                                echo 'checked="checked"';
                                            } ?> />
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="row week_box">
                                <div class="col-md-3 content_title">
                                    <h3 class="text-primary">Monday</h3>
                                    <input type="hidden" name="day[]" value="monday">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="timepicker1">From</label>
                                    <input class="form-control datetimepicker pick_from" id="timepicker1"
                                        name="time_from[]" type="text" placeholder="H:i"
                                        data-options='{"enableTime":true,"noCalendar":true,"dateFormat":"H:i","disableMobile":true}' />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="timepicker1">To</label>
                                    <input class="form-control datetimepicker pick_to" id="timepicker1" name="time_to[]"
                                        type="text" placeholder="H:i"
                                        data-options='{"enableTime":true,"noCalendar":true,"dateFormat":"H:i","disableMobile":true}' />
                                </div>
                                <div class="col-md-1">
                                    <label class="form-check-label" for="flexCheckChecked">Close</label>
                                    <input class="form-check-input min_close" id="flexCheckChecked" type="checkbox"
                                        name="is_close[]" />
                                </div>
                            </div>
                            <div class="row week_box">
                                <div class="col-md-3 content_title">
                                    <h3 class="text-primary">Tuesday</h3>
                                    <input type="hidden" name="day[]" value="tuesday">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="timepicker1">From</label>
                                    <input class="form-control datetimepicker pick_from" id="timepicker1"
                                        name="time_from[]" type="text" placeholder="H:i"
                                        data-options='{"enableTime":true,"noCalendar":true,"dateFormat":"H:i","disableMobile":true}' />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="timepicker1">To</label>
                                    <input class="form-control datetimepicker pick_to" id="timepicker1" name="time_to[]"
                                        type="text" placeholder="H:i"
                                        data-options='{"enableTime":true,"noCalendar":true,"dateFormat":"H:i","disableMobile":true}' />
                                </div>
                                <div class="col-md-1">
                                    <label class="form-check-label" for="flexCheckChecked">Close</label>
                                    <input class="form-check-input min_close" id="flexCheckChecked" type="checkbox"
                                        name="is_close[]" />
                                </div>
                            </div>
                            <div class="row week_box">
                                <div class="col-md-3 content_title">
                                    <h3 class="text-primary">Wednesday</h3>
                                    <input type="hidden" name="day[]" value="wednesday">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="timepicker1">From</label>
                                    <input class="form-control datetimepicker pick_from" id="timepicker1"
                                        name="time_from[]" type="text" placeholder="H:i"
                                        data-options='{"enableTime":true,"noCalendar":true,"dateFormat":"H:i","disableMobile":true}' />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="timepicker1">To</label>
                                    <input class="form-control datetimepicker pick_to" id="timepicker1" name="time_to[]"
                                        type="text" placeholder="H:i"
                                        data-options='{"enableTime":true,"noCalendar":true,"dateFormat":"H:i","disableMobile":true}' />
                                </div>
                                <div class="col-md-1">
                                    <label class="form-check-label" for="flexCheckChecked">Close</label>
                                    <input class="form-check-input min_close" id="flexCheckChecked" type="checkbox"
                                        name="is_close[]" />
                                </div>
                            </div>
                            <div class="row week_box">
                                <div class="col-md-3 content_title">
                                    <h3 class="text-primary">Thrusday</h3>
                                    <input type="hidden" name="day[]" value="thrusday">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="timepicker1">From</label>
                                    <input class="form-control datetimepicker pick_from" id="timepicker1"
                                        name="time_from[]" type="text" placeholder="H:i"
                                        data-options='{"enableTime":true,"noCalendar":true,"dateFormat":"H:i","disableMobile":true}' />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="timepicker1">To</label>
                                    <input class="form-control datetimepicker pick_to" id="timepicker1" name="time_to[]"
                                        type="text" placeholder="H:i"
                                        data-options='{"enableTime":true,"noCalendar":true,"dateFormat":"H:i","disableMobile":true}' />
                                </div>
                                <div class="col-md-1">
                                    <label class="form-check-label" for="flexCheckChecked">Close</label>
                                    <input class="form-check-input min_close" id="flexCheckChecked" type="checkbox"
                                        name="is_close[]" />
                                </div>
                            </div>
                            <div class="row week_box">
                                <div class="col-md-3 content_title">
                                    <h3 class="text-primary">Friday</h3>
                                    <input type="hidden" name="day[]" value="friday">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="timepicker1">From</label>
                                    <input class="form-control datetimepicker pick_from" id="timepicker1"
                                        name="time_from[]" type="text" placeholder="H:i"
                                        data-options='{"enableTime":true,"noCalendar":true,"dateFormat":"H:i","disableMobile":true}' />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="timepicker1">To</label>
                                    <input class="form-control datetimepicker pick_to" id="timepicker1" name="time_to[]"
                                        type="text" placeholder="H:i"
                                        data-options='{"enableTime":true,"noCalendar":true,"dateFormat":"H:i","disableMobile":true}' />
                                </div>
                                <div class="col-md-1">
                                    <label class="form-check-label" for="flexCheckChecked">Close</label>
                                    <input class="form-check-input min_close" id="flexCheckChecked" type="checkbox"
                                        name="is_close[]" />
                                </div>
                            </div>
                            <div class="row week_box">
                                <div class="col-md-3 content_title">
                                    <h3 class="text-primary">Saturday</h3>
                                    <input type="hidden" name="day[]" value="saturday">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="timepicker1">From</label>
                                    <input class="form-control datetimepicker pick_from" id="timepicker1"
                                        name="time_from[]" type="text" placeholder="H:i"
                                        data-options='{"enableTime":true,"noCalendar":true,"dateFormat":"H:i","disableMobile":true}' />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="timepicker1">To</label>
                                    <input class="form-control datetimepicker pick_to" id="timepicker1" name="time_to[]"
                                        type="text" placeholder="H:i"
                                        data-options='{"enableTime":true,"noCalendar":true,"dateFormat":"H:i","disableMobile":true}' />
                                </div>
                                <div class="col-md-1">
                                    <label class="form-check-label" for="flexCheckChecked">Close</label>
                                    <input class="form-check-input min_close" id="flexCheckChecked" type="checkbox"
                                        name="is_close[]" />
                                </div>
                            </div>
                            <div class="row week_box">
                                <div class="col-md-3 content_title">
                                    <h3 class="text-primary">Sunday</h3>
                                    <input type="hidden" name="day[]" value="sunday">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="timepicker1">From</label>
                                    <input class="form-control datetimepicker pick_from" id="timepicker1"
                                        name="time_from[]" type="text" placeholder="H:i"
                                        data-options='{"enableTime":true,"noCalendar":true,"dateFormat":"H:i","disableMobile":true}' />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="timepicker1">To</label>
                                    <input class="form-control datetimepicker pick_to" id="timepicker1" name="time_to[]"
                                        type="text" placeholder="H:i"
                                        data-options='{"enableTime":true,"noCalendar":true,"dateFormat":"H:i","disableMobile":true}' />
                                </div>
                                <div class="col-md-1">
                                    <label class="form-check-label" for="flexCheckChecked">Close</label>
                                    <input class="form-check-input min_close" id="flexCheckChecked" type="checkbox"
                                        name="is_close[]" />
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-12 content_title text-end">
                        <input id="Previous" type="button" value="<" class="btn btn-primary"
                            onclick="doTab('Previous','3')" />
                        <input id="Next" type="button" value=">" class="btn btn-primary"
                            onclick="doTab('Next','3')" />
                    </div>
                </div>
            </div>

            <!-- OPTIONS TAB -->
            <div class="tab-pane fade" id="tab-table" role="tabpanel" aria-labelledby="table-tab">
                <div class="row">
                    @if (count($get_options) > 0)
                        @foreach ($get_options as $key => $value)
                            <input type="hidden" name="options_id[]" value="{{ $value['id'] }}">
                            <div class="col-md-12 content_title">
                                <table class="table2 bg-dark table-dark" width="100%" style="margin: 0 auto;">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <label class="form-label" for="tour_option">Tour Option<span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" placeholder="Tour Option"
                                                    name="tour_option[]" type="text"
                                                    value="{{ $value['tour_option'] }}" />
                                            </td>
                                            <td>
                                                <label class="form-label" for="addtional_info">Additional Info<span
                                                        class="text-danger">*</span></label>
                                                <textarea class="form-control" placeholder="Enter Additional info" name="addtional_info[]">{{ $value['addtional_info'] }}</textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="form-label" for="tour_option">Transfer Option<span
                                                        class="text-danger">*</span></label>
                                                <br>
                                                <select class="form-select single-select" name="transfer_option[]"
                                                    style="width: 100%;">
                                                    <option value="sharing">Sharing</option>
                                                    <option value="private">Private</option>
                                                </select>
                                            </td>
                                            <td>
                                                <label class="form-label" for="edult">Edult Price<span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" placeholder="Enter Child Price"
                                                    name="edult[]" type="number" value="{{ $value['edult'] }}" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="form-label" for="child_price">Child Price<span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" placeholder="Enter Child Price"
                                                    name="child_price[]" type="number"
                                                    value="{{ $value['child_price'] }}" />
                                            </td>
                                            <td>
                                                <label class="form-label" for="infant">Infant<span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" placeholder="Enter Infant" name="infant[]"
                                                    type="number" value="{{ $value['infant'] }}" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="form-label" for="room_price">Room Price<span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" placeholder="Tour Option" name="room_price[]"
                                                    type="number" value="{{ $value['room_price'] }}" />
                                            </td>
                                            <td>
                                                <label class="form-label" for="online_booking">Online Booking<span
                                                        class="text-danger">*</span></label>
                                                <input class="form-check-input" id="flexCheckDefault" type="checkbox"
                                                    name="online_booking[]" value="1" />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    @else
                        <div class="col-md-12 content_title">
                            <input type="hidden" name="options_id[]" value="">
                            <table class="table2 bg-dark table-dark" width="100%" style="margin: 0 auto;">
                                <tbody>
                                    <tr>
                                        <td>
                                            <label class="form-label" for="tour_option">Tour Option<span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" placeholder="Tour Option" name="tour_option[]"
                                                type="text" />
                                        </td>
                                        <td>
                                            <label class="form-label" for="addtional_info">Additional Info<span
                                                    class="text-danger">*</span></label>
                                            <textarea class="form-control" placeholder="Enter Additional info" name="addtional_info[]"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="form-label" for="tour_option">Transfer Option<span
                                                    class="text-danger">*</span></label>
                                            <br>
                                            <select class="form-select single-select" name="transfer_option[]"
                                                style="width: 100%;">
                                                <option value="sharing">Sharing</option>
                                                <option value="private">Private</option>
                                            </select>
                                        </td>
                                        <td>
                                            <label class="form-label" for="edult">Edult Price<span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" placeholder="Enter Child Price" name="edult[]"
                                                type="number" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="form-label" for="child_price">Child Price<span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" placeholder="Enter Child Price"
                                                name="child_price[]" type="number" />
                                        </td>
                                        <td>
                                            <label class="form-label" for="infant">Infant<span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" placeholder="Enter Infant" name="infant[]"
                                                type="number" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="form-label" for="room_price">Room Price<span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" placeholder="Tour Option" name="room_price[]"
                                                type="number" />
                                        </td>
                                        <td>
                                            <label class="form-label" for="online_booking">Online Booking<span
                                                    class="text-danger">*</span></label>
                                            <input class="form-check-input" id="flexCheckDefault" type="checkbox"
                                                name="online_booking[]" value="1" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="show_table">
                    </div>
                    <div class="col-md-12 add_more_button">
                        <button class="btn btn-success btn-sm" type="button" id="add_table" title='Add more' />Add
                        more</button>
                    </div>
                </div>
                <div class="col-md-12 content_title text-end">
                    <input id="Previous" type="button" value="<" class="btn btn-primary"
                        onclick="doTab('Previous','4')" />
                    <input id="Next" type="button" value=">" class="btn btn-primary"
                        onclick="doTab('Next','4')" />
                </div>
            </div>

            <!-- ADDTIONAL INFO TAB -->
            <div class="tab-pane fade" id="tab-info" role="tabpanel" aria-labelledby="info-tab">
                <div class="row">
                    @if (count($get_add_info) > 0)
                        @foreach ($get_add_info as $key => $value_add)
                            <input type="hidden" name="info_id[]" value="{{ $value_add['id'] }}">
                            <div class="col-md-12 content_title">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label" for="title">Additional Info Title<span
                                                class="text-danger">*</span></label>
                                        <input class="form-control" name="info_title[]" type="text"
                                            placeholder="Enter Additional Info Title"
                                            value="{{ $value_add['info_title'] }}" />
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label" for="title">Add url<span
                                                class="text-danger">*</span></label>
                                        <input class="form-control" name="info_url[]" type="text"
                                            placeholder="Enter url" value="{{ $value_add['info_url'] }}" />
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-md-12 content_title">
                            <input type="hidden" name="info_id[]" value="">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="title">Additional Info Title<span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" name="info_title[]" type="text"
                                        placeholder="Enter Additional Info Title" />
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label" for="title">Add url<span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" name="info_url[]" type="text"
                                        placeholder="Enter url" />
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="show_info">
                    </div>
                    <div class="col-md-12 add_more_button">
                        <button class="btn btn-success btn-sm" type="button" id="add_info" title='Add more' />Add
                        more</button>
                    </div>
                </div>
                <div class="col-md-12 content_title text-end">
                    <input id="Previous" type="button" value="<" class="btn btn-primary"
                        onclick="doTab('Previous','5')" />
                    <input id="Next" type="button" value=">" class="btn btn-primary"
                        onclick="doTab('Next','5')" />
                </div>
            </div>

            <!-- FAQ TAB -->
            <div class="tab-pane fade" id="tab-faqs" role="tabpanel" aria-labelledby="faqs-tab">
                <div class="row">
                    @if (count($get_faqs) > 0)
                        @foreach ($get_faqs as $key => $value_faq)
                            <input type="hidden" name="faq_id[]" value="{{ $value_faq['id'] }}">
                            <div class="col-md-12 content_title">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label" for="title">Faq Title<span
                                                class="text-danger">*</span></label>
                                        <input class="form-control" name="question[]" type="text"
                                            placeholder="Enter Faq Title" value="{{ $value_faq['question'] }}" />
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label" for="title">Faq Answer<span
                                                class="text-danger">*</span></label>
                                        <textarea name="answer[]" class="form-control" id="faq_text" placeholder="Enter Faq Answer">{{ $value_faq['answer'] }}</textarea>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-md-12 content_title">
                            <input type="hidden" name="faq_id[]" value="">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="title">Faq Title<span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" name="question[]" type="text"
                                        placeholder="Enter Faq Title" />
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label" for="title">Faq Answer<span
                                            class="text-danger">*</span></label>
                                    <textarea name="answer[]" class="form-control" id="faq_text" placeholder="Enter Faq Answer"></textarea>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="show_faqs">
                    </div>
                    <div class="col-md-12 add_more_button">
                        <button class="btn btn-success btn-sm" type="button" id="add_faqs" title='Add more' />Add
                        more</button>
                    </div>
                </div>
                <div class="col-md-12 content_title text-end">
                    <input id="Previous" type="button" value="<" class="btn btn-primary"
                        onclick="doTab('Previous','6')" />
                </div>
                <div class="col-12 d-flex justify-content-end mt-2">
                    <button class="btn btn-primary" type="submit"> <span class="fas fa-save"></span>
                        {{ $common['button'] }}</button>
                </div>
            </div>

        </div>
        </div>
    </form>


    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCpqoRKJ3CM7GGiFWTEY0qCKYYRh00ULF0&callback=initMap&sensor=true&libraries=places">
    </script>
    <script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>

    <!-- HIGHLIGHTS -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = 1;
            $('body').on('click', "#add_highlights", function(e) {

                var highlights_html = '';
                highlights_html += '<div class="highlights_div col-md-12">';
                highlights_html += '<input type="hidden" name="highlights_id[]" value="">';
                highlights_html += '<div class="col-md-6">';
                highlights_html +=
                    '<label class="form-label" for="title">Higlights Title<span class="text-danger">*</span></label>';
                highlights_html +=
                    '<input class="form-control" name="highlights_title[]" type="text" placeholder="Enter Higlights Title" />';
                highlights_html += '</div>';
                highlights_html += '<div class="col-md-12">';
                highlights_html +=
                    '<label class="form-label" for="title">Higlights Description<span class="text-danger">*</span></label>';
                highlights_html +=
                    '<textarea name="highlights_description[]" class="form-control footer_text" id="footer_text_' +
                    count + '" placeholder="Enter Higlights Description"></textarea>';
                highlights_html += '</div>';
                highlights_html +=
                    '<button type="button" class="btn btn-danger btn-sm" id="delete_high" title="Delete">Delete</button>';
                highlights_html += '</div>';
                highlights_html += '<hr>';

                $('.show_highlights').append(highlights_html);
                CKEDITOR.replace('footer_text_' + count);
                e.preventDefault();
                count++;
            });

            $('body').on('click', "#delete_high", function(e) {
                if (!confirm("Are you sure to delete ?"))
                    return false;
                $(this).closest('.highlights_div').remove();
                e.preventDefault();
            });
        });
    </script>

    <!-- OPTIONS -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('body').on('click', "#add_table", function(e) {

                var table_html = '';
                table_html += '<div class="table_div" style="margin-top: 15px;">';
                table_html += '<input type="hidden" name="options_id[]" value="">';
                table_html +=
                    '<table class="table2 bg-dark table-dark" width="100%" style="margin: 0 auto;">';
                table_html += '<tbody>';
                table_html += '<tr>';
                table_html += '<td>';
                table_html +=
                    '<label class="form-label" for="tour_option">Tour Option<span class="text-danger">*</span></label>';
                table_html +=
                    '<input class="form-control" placeholder="Tour Option" name="tour_option[]" type="text" />';
                table_html += '</td>';
                table_html += '<td>';
                table_html +=
                    '<label class="form-label" for="addtional_info">Additional Info<span class="text-danger">*</span></label>';
                table_html +=
                    '<textarea class="form-control" placeholder="Enter Additional info" name="addtional_info[]"></textarea>';
                table_html += '</td>';
                table_html += '</tr>';
                table_html += '<tr>';
                table_html += '<td>';
                table_html +=
                    '<label class="form-label" for="transfer_option">Transfer Option<span class="text-danger">*</span></label>';
                table_html += '<br>';
                table_html +=
                    '<select class="form-select single-select" name="transfer_option[]" style="width: 100%;">';
                table_html += '<option value="sharing">Sharing</option>';
                table_html += '<option value="private">Private</option>';
                table_html += '</select>';
                table_html += '</td>';
                table_html += '<td>';
                table_html +=
                    '<label class="form-label" for="edult">Edult Price<span class="text-danger">*</span></label>';
                table_html +=
                    '<input class="form-control" placeholder="Enter Child Price" name="edult[]" type="number" />';
                table_html += '</td>';

                table_html += '<tr>';
                table_html += '<td>';
                table_html +=
                    '<label class="form-label" for="child_price">Child Price<span class="text-danger">*</span></label>';
                table_html +=
                    '<input class="form-control" placeholder="Enter Child Price" name="child_price[]" type="number" />';
                table_html += '</td>';
                table_html += '<td>';
                table_html +=
                    '<label class="form-label" for="infant">Infant<span class="text-danger">*</span></label>';
                table_html +=
                    '<input class="form-control" placeholder="Enter Infant" name="infant[]" type="number"/>';
                table_html += ' </td>';
                table_html += '</tr>';
                table_html += '<tr>';
                table_html += '<td>';
                table_html +=
                    '<label class="form-label" for="room_price">Room Price<span class="text-danger">*</span></label>';
                table_html +=
                    '<input class="form-control" placeholder="Tour Option" name="room_price[]" type="number" />';
                table_html += '</td>';
                table_html += '<td>';
                table_html +=
                    '<label class="form-label" for="online_booking">Online Booking<span class="text-danger">*</span></label>';
                table_html +=
                    '<input class="form-check-input" id="flexCheckDefault" type="checkbox" name="online_booking[]" value="1"/>';
                table_html += '</td>';
                table_html += '</tr>';
                table_html += '</tbody>';
                table_html += '</table>';
                table_html +=
                    '<button type="button" class="btn btn-danger btn-sm" id="delete_table" title="Delete">Delete</button>';
                table_html += '</div>';


                $('.show_table').append(table_html);
                e.preventDefault();
            });

            $('body').on('click', "#delete_table", function(e) {
                if (!confirm("Are you sure to delete this table?"))
                    return false;
                $(this).closest('.table_div').remove();
                e.preventDefault();
            });
        });
    </script>

    <!-- ADDITIONAL INFO -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('body').on('click', "#add_info", function(e) {

                var add_info_html = '';
                add_info_html += '<div class="info_div col-md-12">';
                add_info_html += '<input type="hidden" name="info_id[]" value="">';
                add_info_html += '<div class="col-md-6">';
                add_info_html +=
                    '<label class="form-label" for="title">Additional Info Title<span class="text-danger">*</span></label>';
                add_info_html +=
                    '<input class="form-control" name="info_title[]" type="text" placeholder="Enter Additional Info Title" />';
                add_info_html += '</div>';
                add_info_html += '<div class="col-md-12">';
                add_info_html +=
                    '<label class="form-label" for="title">Add url<span class="text-danger">*</span></label>';
                add_info_html +=
                    '<input class="form-control" name="info_url[]" type="text" placeholder="Enter url" />';
                add_info_html += '</div>';
                add_info_html +=
                    '<button type="button" class="btn btn-danger btn-sm" id="delete_info" title="Delete">Delete</button>';
                add_info_html += '</div>';
                add_info_html += '<hr>';
                // $('.show_info').append(`@include('admin.product._info', ['some' => 'Check Data '])`);
                $('.show_info').append(add_info_html);
                e.preventDefault();

            });

            $('body').on('click', "#delete_info", function(e) {
                if (!confirm("Are you sure to delete ?"))
                    return false;
                $(this).closest('.info_div').remove();
                e.preventDefault();
            });
        });
    </script>

    <!-- FAQS -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = 1;
            $('body').on('click', "#add_faqs", function(e) {

                var faqs_html = '';
                faqs_html += '<div class="highlights_div col-md-12">';
                faqs_html += '<input type="hidden" name="faq_id[]" value="">';
                faqs_html += '<div class="col-md-6">';
                faqs_html +=
                    '<label class="form-label" for="title">Faq Title<span class="text-danger">*</span></label>';
                faqs_html +=
                    '<input class="form-control" name="question[]" type="text" placeholder="Enter Faq Title" />';
                faqs_html += '</div>';
                faqs_html += '<div class="col-md-12">';
                faqs_html +=
                    '<label class="form-label" for="title">Faq Answer<span class="text-danger">*</span></label>';
                faqs_html += '<textarea name="answer[]" class="form-control" id="faq_text_' + count +
                    '" placeholder="Enter Faq Answer"></textarea>';
                faqs_html += '</div>';
                faqs_html +=
                    '<button type="button" class="btn btn-danger btn-sm" id="delete_faqs" title="Delete">Delete</button>';
                faqs_html += '</div>';
                faqs_html += '<hr>';

                $('.show_faqs').append(faqs_html);
                CKEDITOR.replace('faq_text_' + count);
                e.preventDefault();
                count++;
            });

            $('body').on('click', "#delete_faqs", function(e) {
                if (!confirm("Are you sure to delete ?"))
                    return false;
                $(this).closest('.highlights_div').remove();
                e.preventDefault();
            });
        });
    </script>

    <script>
        CKEDITOR.replace('footer_text');
        CKEDITOR.replace('faq_text');
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('body').on('click', ".min_close", function(e) {
                $(this).closest('.week_box').find('.pick_from').val("");
                $(this).closest('.week_box').find('.pick_to').val("");
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('body').on('change', ".avl_item", function(e) {

                var avl_type = $(this).val();
                $('.show_timings').hide();
                if (avl_type == 'week_days') {
                    $('.show_timings').show();
                }
                // alert(ex_type);
            });

            $('body').on('change', "#excursion_type", function(e) {

                var ex_type = $(this).val();
                $('.cncl_duration').hide();
                if (ex_type == 'can_be_cancled') {
                    $('.cncl_duration').show();
                }
                // alert(ex_type);
            });
        });
    </script>

    <script type="text/javascript">
        function doTab(obj, obj2) {

            // var index = $(".test").attr("data_id");//get current active tab
            // alert(index);
            if (obj == "Previous") {
                obj2 = parseInt(obj2) - 1; //parseInt() convert index from string type to int type
            } else {
                obj2 = parseInt(obj2) + 1;
            }
            $('.nav-tabs a[data_id="' + obj2 + '"]').tab('show');
        }
    </script>
@endsection
