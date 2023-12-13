@extends('admin.layout.master')
@section('content')
<style type="text/css">
  #add_airport{
    margin-right: 10px;
  }
</style>
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
            <a class="btn btn-falcon-primary me-1 mb-1 mt-1" href="javascript:void(0)" onclick="back()" type="button">
                <span class="fas fa-arrow-alt-circle-left text-primary "></span> Back </a>
        </div>
    </div>

    <form class="row g-3 " method="POST" action="{{ route('admin.zones.add') }}" enctype="multipart/form-data">
        @csrf

        <div class="col-lg-12">
            <div class="card mb-3">

                <div class="card-body ">
                    <div class="row">

                        <input id="" name="id" type="hidden" value="{{ $get_zones['id'] }}" />

                        <div class="col-md-12 content_title">
                            <div class="form-check form-switch pl-0">
                                <input class="form-check-input float-end status switch_button" {{ getChecked('Active', old('status', $get_zones['status'])) }} id="status" type="checkbox" value="Active" name="status">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label" for="zone_title">{{ translate('Zone Title') }}<span class="text-danger">*</span></label>
                                <input class="form-control {{ $errors->has('zone_title') ? 'is-invalid' : '' }}" placeholder="{{ translate('Zone Title') }}" id="zone_title" name="zone_title" type="text" value="{{ $get_zones['zone_title'] }}" />
                                @error('zone_title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 content_title ">
                                <label class="form-label" for="price">{{ translate('Country') }}<span class="text-danger">*</span>  </label>
                                <select class="form-select single-select country  {{ $errors->has('zone_country') ? 'is-invalid' : '' }}"
                                  name="zone_country" id="country" onchange="getStateCity('country'),getAirport('country')">
                                  <option value="">{{ translate('Select Country') }}</option>
                                  @foreach ($country as $C)
                                      <option value="{{ $C['id'] }}"
                                          {{ getSelected($C['id'], old('country', $get_zones['country'])) }}>
                                          {{ $C['name'] }}</option>
                                  @endforeach
                                </select>

                                @error('zone_country')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                              <label class="form-label" for="zone_state">{{ translate('State') }}<span class="text-danger">*</span> </label>
                              <select class="single-select form-control {{ $errors->has('zone_state') ? 'is-invalid' : '' }}" name="zone_state" id="state" onchange="getStateCity('state')">
                                  <option value="">{{ translate('Select State') }}</option>
                              </select>
                               @error('zone_state')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                              <label class="form-label" for="title">{{ translate('City') }}<span class="text-danger">*</span></label>
                              <select class="single-select form-control {{ $errors->has('zone_city') ? 'is-invalid' : '' }}" name="zone_city" id="city">
                                  <option value="">{{ translate('Select City') }}</option>

                              </select>
                              @error('zone_city')
                                  <div class="invalid-feedback">
                                      {{ $message }}
                                  </div>
                              @enderror
                            </div>


                            <?php  if ($get_zones['airport']!='') { 

                              $airport_id = json_decode($get_zones['airport']); 

                              foreach ($airport_id as $key => $value_air) { ?>

                                <input type="hidden" name="zone_airport[]" value="{{$value_air}}">

                                <div class="row airport_div">
                                  
                                  <div class="col-md-10">
                                     <label class="form-label" for="title">{{ translate('Airport') }}<span class="text-danger">*</span></label>

                                     <select class="form-select"  >
                                      <option value="">{{ translate('Select Airport') }}</option>
                                      @foreach ($airport as $C)
                                          <option value="{{ $C['id'] }}" <?php if ($C['id'] ==  $value_air ) echo 'selected' ; ?> disabled> {{ $C['name'] }}</option>
                                      @endforeach
                                    </select>
                                  </div>

                                  <div class="col-md-2">
                                      <button class="btn btn-danger mt-4 delete_airport" type="button"><span class="fa fa-trash"></span></button>
                                  </div>
                                </div>

                            <?php } ?> 
                            <?php }else{ ?>


                              <div class="col-md-4">
                                <label class="form-label" for="title">{{ translate('Airport') }}<span class="text-danger">*</span></label>
                                <select class="single-select form-control airport" name="zone_airport[]" id="airport" required>
                                    

                                </select>
                              </div>

                            <?php } ?>




                            <div class="get_ajax_airport">
                              <div class="row show_airport" > </div>

                              <div class="col-md-4">
                                <button class="btn btn-success mt-4" type="button" id="add_more_airport"><span class="fa fa-plus"></span> Add more airport</button>
                              </div>

                            </div>

                            
                        </div>


                        
                        <div class="col-12 d-flex justify-content-end mt-2">
                            <button class="btn btn-primary ml-4" type="submit"> <span class="fas fa-save"></span> {{ $common['button'] }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>

<script>      
    $(document).ready(function() {

            $(".single-select").select2();
            var state   = "{{ $get_zones['state'] }}";
            var city    = "{{ $get_zones['city'] }}";
            var airport = "{{ $get_zones['airport'] }}";

            if (state != "") {
                setTimeout(() => {
                    getStateCity("country", state);
                    setTimeout(() => {
                        getStateCity("state", city);
                        setTimeout(() => {
                            getAirport("city",airport);
                        }, 500);
                    }, 500);
                }, 500);
            }
          
            // Get Category By Country
            $(".country").change(function() {
                var country = $(this).val();
            })

    });
</script>
<script type="text/javascript">
  $(document).ready(function() {
      $('body').on('change', "#country", function(e) {
        $('.airport_log').val('');
        $('.airport_div').remove();
      });
  });
</script>
  
</script>

<script type="text/javascript">
        $(document).ready(function() {
            
            var count = 1;
            $('body').on('click', "#add_more_airport", function(e) {

                var html = '';
                html+='<div class="row airport_div" >';
                  html+='<div class="col-md-10">';
                    html+='<label class="form-label" for="title">{{ translate('Airport') }}<span class="text-danger">*</span></label>';  
                    html+='<select class="single-select form-control airport_log" name="zone_airport[]" required >';
                                    

                    html+='</select>';  
                  html+='</div>';

                  html+='<div class="col-md-2">';
                    html+='<button class="btn btn-danger mt-4 delete_airport" type="button"><span class="fa fa-trash"></span></button>';
                  html+='</div>';  

                html+='</div>';  
                
                $(".show_airport").append(html);

                $(".single-select").select2();


                var country = $("#country").val();
                selectedCat = '';
                $.ajax({
                    "type": "POST",
                    "data": {
                        country: country,
                        selectedCat: selectedCat,
                        _token: "{{ csrf_token() }}"
                    },
                    url: "{{ route('admin.get_airport') }}",
                    success: function(response) {
                        $(".airport_log").append(response);
                    }
                });

                
                
                count++;
                
                e.preventDefault();

            });

            $(document).on("click", ".delete_airport", function(e) {
                var length = $(".delete_airport").length;
               
                  deleteMsg('Are you sure to delete ?').then((result) => {
                      if (result.isConfirmed) {
                          $(this).parent().closest('.airport_div').remove();
                          e.preventDefault();
                      }
                  });
               
            });
        });
    </script>
  
    <script>
        function getAirport(type,selectedCat = "") {
            
            var country = $("#country").val();
            // alert(country);
            $.ajax({
                "type": "POST",
                "data": {
                    country: country,
                    selectedCat: selectedCat,
                    _token: "{{ csrf_token() }}"
                },
                url: "{{ route('admin.get_airport') }}",
                success: function(response) {
                    $("#airport").html(response);
                }
            })
        }
    </script>



@endsection
