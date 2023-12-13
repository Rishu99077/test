@extends('admin.layout.master')
@section('content')
    <div class="d-flex justify-content-between">
        <ul class="breadcrumb mb-2 ">
            <li>
              <a href="#" style="width: auto;">
                  <span class="text">{{ $common['language_title'] }} <img src="{{ url('uploads/language_flag', $common['language_flag']) }}" class="lang_img"></span>
              </a>
            </li>
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

    <form class="row g-3 " method="POST" action="{{ route('admin.override_banner.add') }}" enctype="multipart/form-data">
        @csrf

        <div class="col-lg-12">
            <div class="card mb-3">

                <div class="card-body ">
                    <div class="row">

                        <input id="" name="id" type="hidden" value="{{ $get_over_ride['id'] }}" />

                        <div class="col-md-12 content_title">
                            <div class="form-check form-switch pl-0">
                                <input class="form-check-input float-end status switch_button"
                                    {{ getChecked('Active', old('status', $get_over_ride['status'])) }} id="status"
                                    type="checkbox" value="Active" name="status">
                            </div>
                        </div>

                        <div class="row">
                            <div class="colcss">
                                @php
                                    $data = 0;
                                @endphp
                                @foreach ($get_over_ride_banner as $EXO)
                                    @include('admin.over_ride_banner._banners')
                                    @php
                                        $data++;
                                    @endphp
                                @endforeach
                                @if (empty($get_over_ride_banner))
                                    @include('admin.over_ride_banner._banners')
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

                        <div class="col-12 d-flex justify-content-end mt-2">
                            <button class="btn btn-primary" type="submit"> <span class="fas fa-save"></span>
                                {{ $common['button'] }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>
    <script>
        $(document).ready(function() {

            if (state != "") {
                setTimeout(() => {
                    getStateCity("country", state);
                    setTimeout(() => {
                        getStateCity("state", city);
                    }, 500);
                }, 500);
            }

            // Get Category By Country
            $(".country").change(function() {
                var country = $(this).val();
            })

        });
    </script>

    <!-- How it Work -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = 1;
            $('#add_works').click(function(e) {

                var ParamArr = {
                    'view': 'admin.over_ride_banner._banners',
                    'data': count
                }
                getAppendPage(ParamArr, '.show_locations');

                e.preventDefault();
                count++;
            });


            $(document).on('click', ".delete_banner", function(e) {
                var length = $(".delete_banner").length;

                var Banner_id = $(this).attr('data-id');

                _token = $("input[name='_token']").val();

                if (length > 1) {
                    deleteMsg('Are you sure to delete ?').then((result) => {
                        if (result.isConfirmed) {

                            $.ajax({
                                url: "{{ url('delete_single_banner') }}",
                                type: 'post',
                                data: {
                                    'Banner_id': Banner_id,
                                    '_token': _token
                                },
                                success: function(response) {
                                    success_msg("Banner deleted Successfully...")
                                }
                            });

                            $(this).parent().closest('.banner_div').remove();
                            e.preventDefault();
                        }
                    });
                }
            });


        });
    </script>
@endsection
