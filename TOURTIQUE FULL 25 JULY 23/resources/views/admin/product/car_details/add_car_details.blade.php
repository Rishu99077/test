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

    <form class="row g-3 " method="POST" action="{{ route('admin.car_details.add') }}" enctype="multipart/form-data">
        @csrf

        <div class="col-lg-12">
            <div class="card mb-3">

                <div class="card-body ">
                    <div class="row">

                        <input id="" name="id" type="hidden" value="{{ $get_car_details['id'] }}" />
                       
                        <div class="col-md-6">
                            <label class="form-label" for="title">{{ translate('Title') }}<span class="text-danger">*</span> </label>
                            <input class="form-control {{ $errors->has('title.' . $lang_id) ? 'is-invalid' : '' }}"
                                placeholder="{{ translate('Title') }}" id="title" name="title[{{ $lang_id }}]"
                                type="text"
                                value="{{ getLanguageTranslate($get_car_details_language, $lang_id, $get_car_details['id'], 'title', 'car_details_id') }}" />
                            @error('title.' . $lang_id)
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="price">{{ translate('Title Information') }} </label>

                            <textarea class="form-control {{ $errors->has('title_information.' . $lang_id) ? 'is-invalid' : '' }}" rows="8" id="title_information" name="title_information[{{ $lang_id }}]" placeholder="Enter Title Information">{{ getLanguageTranslate($get_car_details_language, $lang_id, $get_car_details['id'], 'title_information', 'car_details_id') }}</textarea>

                            @error('title_information.' . $lang_id)
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="title">{{ translate('Car name') }}<span class="text-danger">*</span> </label>
                            <input class="form-control {{ $errors->has('car_name.' . $lang_id) ? 'is-invalid' : '' }}"
                                placeholder="{{ translate('Title') }}" id="car_name" name="car_name[{{ $lang_id }}]"
                                type="text"
                                value="{{ getLanguageTranslate($get_car_details_language, $lang_id, $get_car_details['id'], 'car_name', 'car_details_id') }}" />
                            @error('car_name.' . $lang_id)
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        <div class="col-md-6">
                            <label class="form-label" for="price">{{ translate('Additional Information') }} </label>

                             <textarea class="form-control {{ $errors->has('additional_info.' . $lang_id) ? 'is-invalid' : '' }}" rows="8" id="additional_info" name="additional_info[{{ $lang_id }}]" placeholder="Enter Additional Information">{{ getLanguageTranslate($get_car_details_language, $lang_id, $get_car_details['id'], 'additional_info', 'car_details_id') }}</textarea>
                            @error('additional_info.' . $lang_id)
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror 
                        </div>

                        <div class="col-md-6 mt-3">
                            <label class="form-label" for="number_of_passengers">Number of passengers</label>
                            <input class="form-control" placeholder="Number of passengers" id="number_of_passengers" name="number_of_passengers" type="number" value="{{ $get_car_details['number_of_passengers'] }}" />
                            
                        </div>

                        <div class="col-md-6 mt-3">
                            <label class="form-label" for="price">Price</label>
                            <input class="form-control" placeholder="Price" id="price" name="price" type="number" value="{{ $get_car_details['price'] }}" />
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="price">{{ translate('Status') }} </label>
                            <select class="form-select single-select" name="status">
                                <option value="Active">{{ translate('Active') }} </option>
                                <option value="Deactive"{{ $get_car_details['status'] == 'Deactive' ? 'selected' : '' }}>
                                    {{ translate('Deactive') }}
                                </option>
                            </select>
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
@endsection
