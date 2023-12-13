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

    <form class="row g-3 " method="POST" action="{{ route('admin.category.add') }}" enctype="multipart/form-data">
        @csrf

        <div class="col-lg-12">
            <div class="card mb-3">

                <div class="card-body ">
                    <div class="row">

                        <input id="" name="id" type="hidden" value="{{ $get_category['id'] }}" />
                        
                        <div class="col-md-6">
                            <label class="form-label" for="title">{{ translate('Name') }}<span
                                    class="text-danger">*</span>
                            </label>
                            <input class="form-control {{ $errors->has('name.' . $lang_id) ? 'is-invalid' : '' }}"
                                placeholder="{{ translate('Name') }}" id="name" name="name[{{ $lang_id }}]"
                                type="text"
                                value="{{ getLanguageTranslate($get_category_language, $lang_id, $get_category['id'], 'description', 'category_id') }}" />
                            @error('name.' . $lang_id)
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        @php
                            $countryArr = explode(',', $get_category['country']);
                        @endphp

                        <div class="col-md-3">
                            <label class="form-label" for="price">{{ translate('Icon') }} </label>
                            <input type="file" name="icon" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label" for="price">{{ translate('Parent') }} </label>



                            <select class="form-select single-select" name="parent">
                                <option value="0">{{ translate('Select Parent') }}</option>

                                @foreach ($parent as $P)
                                    @php
                                        $getCategory = getDataFromDB('category_language', ['category_id' => $P['id']], 'row');
                                        
                                    @endphp
                                    @isset($getCategory->description)
                                        <option value="{{ $P['id'] }}"
                                            {{ getSelected($get_category['parent'], $P['id']) }}>
                                            {{ isset($getCategory->description) ? $getCategory->description : '' }}</option>
                                    @endisset
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="price">{{ translate('Country') }} </label>
                            <select class="form-select multi-select" name="country[]" multiple>
                                <option value="">{{ translate('Select Country') }}</option>

                                @foreach ($country as $C)
                                    <option value="{{ $C['id'] }}" @if (in_array($C['id'], $countryArr)) selected @endif>
                                        {{ $C['name'] }}</option>
                                @endforeach

                            </select>
                            <small
                                class="text-danger">{{ translate('If any country is not select that means available for all country') }}</small>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="price">{{ translate('Status') }} </label>
                            <select class="form-select single-select" name="status">
                                <option value="Active">{{ translate('Active') }} </option>
                                <option value="Deactive"{{ $get_category['status'] == 'Deactive' ? 'selected' : '' }}>
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
