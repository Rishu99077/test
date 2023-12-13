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

    <form class="row g-3 " method="POST" action="{{ route('admin.transportation_vehicle.add') }}"
        enctype="multipart/form-data">
        @csrf

        <div class="col-lg-12">
            <div class="card mb-3">

                <div class="card-body ">
                    <div class="row">

                        <input id="" name="id" type="hidden"
                            value="{{ $get_transportation_vehicle['id'] }}" />

                        <div class="col-md-12 content_title">
                            <div class="form-check form-switch pl-0">
                                <input class="form-check-input float-end status switch_button"
                                    {{ getChecked('Active', old('status', $get_transportation_vehicle['status'])) }}
                                    id="status" type="checkbox" value="Active" name="status">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="title">{{ translate('Title') }}<span
                                    class="text-danger">*</span>
                            </label>
                            <input class="form-control {{ $errors->has('title.' . $lang_id) ? 'is-invalid' : '' }}"
                                placeholder="{{ translate('Title') }}" id="title" name="title[{{ $lang_id }}]"
                                type="text"
                                value="{{ getLanguageTranslate($get_transportation_vehicle_language, $lang_id, $get_transportation_vehicle['id'], 'title', 'transportation_vehicle_id') }}" />
                            @error('title.' . $lang_id)
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="quantity">{{ translate('Quantity') }}<span
                                    class="text-danger">*</span>
                            </label>
                            <input class="form-control numberonly {{ $errors->has('quantity') ? 'is-invalid' : '' }}"
                                placeholder="{{ translate('Quantity') }}" id="quantity" name="quantity" type="text"
                                value="{{ old('quantity', $get_transportation_vehicle['quantity']) }}" />
                            @error('quantity')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="price">{{ translate('One Way Price') }}<span
                                    class="text-danger">*</span>
                            </label>
                            <input class="form-control numberonly {{ $errors->has('one_way_price') ? 'is-invalid' : '' }}"
                                placeholder="{{ translate('One Way Price') }}" id="one_way_price" name="one_way_price"
                                type="text"
                                value="{{ old('one_way_price', $get_transportation_vehicle['one_way_price']) }}" />
                            @error('one_way_price')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="price">{{ translate('Two Way Price') }}<span
                                    class="text-danger">*</span>
                            </label>
                            <input class="form-control numberonly {{ $errors->has('two_way_price') ? 'is-invalid' : '' }}"
                                placeholder="{{ translate('Two Way Price') }}" id="two_way_price" name="two_way_price"
                                type="text"
                                value="{{ old('two_way_price', $get_transportation_vehicle['two_way_price']) }}" />
                            @error('two_way_price')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
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
