@extends('admin.layout.master')
@section('content')
    <div class="d-flex justify-content-between">
        <ul class="breadcrumb mb-2 ">
            <li>
                <a href="#" style="width: auto;">
                    {{-- <span class="fas fa-list-alt"></span> --}}
                    <span class="text">{{ $common['title'] }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <span class="fa fa-home"></span>
                </a>
            </li>
        </ul>
        <div class="col-auto ms-auto">
            <a class="btn btn-falcon-primary me-1 mb-1 mt-1" href="javascript:void(0)" onclick="back()" type="button"><span
                    class="fas fa-arrow-alt-circle-left text-primary "></span> Back </a>
        </div>
    </div>

    <form class="row g-3 " method="POST" action="{{ route('admin.time_slot.add') }}" enctype="multipart/form-data">
        @csrf

        <div class="col-lg-12">
            <div class="card mb-3">

                <div class="card-body ">
                    <div class="row">

                        <input id="" name="id" type="hidden" value="{{ $get_option_time['id'] }}" />


                        <div class="col-md-12 content_title">
                            <div class="form-check form-switch pl-0">
                                <input class="form-check-input float-end status switch_button" {{ getChecked('Active', old('status', $get_option_time['status'])) }} id="status" type="checkbox" value="Active" name="status">
                            </div>
                        </div>


                        <div class="col-md-4 week_box">
                            <label class="form-label" for="timepicker1">{{ translate('Select Time Slot') }}</label>
                            <input class="form-control datetimepicker pick_from" id="timepicker1" name="title" type="text" placeholder="H:i" data-options='{"enableTime":true,"dateFormat":"H:i","disableMobile":true}' value="{{ $get_option_time['title'] }}" />
                        </div>


                       
                        <div class="col-12 d-flex justify-content-end mt-2">
                            <button class="btn btn-primary" type="submit"> <span class="fas fa-save"></span>
                                {{ $common['button'] }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>

 <script type="text/javascript">
        $(document).ready(function() {
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
            $(".pick_from").each(function() {
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

@endsection
