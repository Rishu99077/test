@extends('admin.layout.master')
@section('content')

    <div class="d-flex justify-content-between">
        <ul class="breadcrumb mb-2 ">
            <li>
                <a href="#" style="width: auto;">

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
            <a class="btn btn-falcon-primary me-1 mb-1 mt-1" href="{{ route('admin.cities.add') }}" type="button"> 
                <span class="fas fa-plus-circle text-primary "></span> {{ translate('Add New') }}
            </a>
        </div>
    </div>

    <form action="" method="get" class="mb-3">
        <div class="row">
            <div class="col-lg-3">
                <label>Country</label>
                <select class="form-select single-select country" name="country" id="country" onchange="getStateCity('country')">
                      <option value="">{{ translate('Select Country') }}</option>
                      @foreach ($country as $C)
                          <option value="{{ $C['id'] }}"
                          {{ getSelected($C['id'], old('country', @$_GET['country'])) }}
                          > {{ $C['name'] }}</option>
                      @endforeach
                </select>
            </div>
            <div class="col-lg-3">
                  <label>{{ translate('State') }} </label>
                  <select class="single-select form-control" name="state" id="state" onchange="getStateCity('state')">
                      <option value="">{{ translate('Select State') }}</option>
                  </select>
            </div>

            <div class="col-lg-3">
                  <label>{{ translate('City') }}</label>
                  <select class="single-select form-control" name="city" id="city">
                      <option value="">{{ translate('Select City') }}</option>

                  </select>
            </div>

            <div class="col-lg-2">
                <button class="btn btn-success mt-4" type="submit">Filter</button>
            </div>
        </div>
    </form>

    <div class="row g-3 mb-3">
        <div class="col-lg-12">
            <div class="card">

                <div class="card-body pt-0">
                    <div class="tab-content">
                        <div class="tab-pane preview-tab-pane active" role="tabpanel" aria-labelledby="tab-dom-fc2cf754-9fbc-4450-a5fc-ec75c99f83bc" id="dom-fc2cf754-9fbc-4450-a5fc-ec75c99f83bc">
                            <div class="table-responsive scrollbar">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">{{ translate('Country Name') }}</th>
                                            <th scope="col">{{ translate('State Name') }}</th>
                                            <th scope="col">{{ translate('City Name') }}</th>
                                            <th class="text-end" scope="col">{{ translate('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @if (!$get_city->isEmpty())
                                            @foreach ($get_city as $key => $value)
                                                <tr>
                                                    <td>{{ $key + $get_city->firstItem() }}</td>
                                                    <td>{{ $value['country_name'] }}</td>
                                                    <td>{{ $value['state_name'] }}</td>
                                                    <td>{{ $value['name'] }}</td>
                                                    
                                                    <td class="text-end">
                                                        <div>
                                                            <a class="btn p-0"
                                                                href="{{ route('admin.cities.edit', encrypt($value['id'])) }}"
                                                                type="button" data-bs-toggle="tooltip"
                                                                data-bs-placement="top" title="Edit"><span
                                                                    class="text-500 fas fa-edit"></span>
                                                            </a>

                                                            <a class="btn p-0" onclick="return doconfirm();"
                                                                href="{{ route('admin.cities.delete_cities', encrypt($value['id'])) }}"
                                                                type="button" data-bs-toggle="tooltip"
                                                                data-bs-placement="top" title="Delete"><span
                                                                    class="text-500 fas fa-trash-alt"></span>
                                                            </a>

                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="4" align="center">
                                                    <img src="{{ asset('public/assets/img/no_record.png') }}"
                                                        alt="">
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                {{ $get_city->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>      
    $(document).ready(function() {

            var country = "{{ @$_GET['country'] }}";
            var state   = "{{ @$_GET['state'] }}";
            var city    = "{{ @$_GET['city'] }}";

            getStateCity("country");

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


@endsection
