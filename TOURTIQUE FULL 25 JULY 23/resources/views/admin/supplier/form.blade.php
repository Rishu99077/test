@extends('admin.layout.master')
@section('content')
    <div class="d-flex">
        <ul class="breadcrumb">
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
            <a class="btn btn-falcon-primary me-1 mb-1" href="{{ route('admin.supplier.add') }}" type="button"><span
                    class="fas fa-plus-circle text-primary "></span> {{ translate('Add New') }} </a>
        </div>
    </div>

    <form class="row g-3 " method="POST" action="{{ route('admin.supplier.add') }}" enctype="multipart/form-data">
        @csrf
        <div class="col-lg-12">
            <div class="card mb-3">

                <div class="card-body ">
                    <div class="row">
                        <input id="" name="id" type="hidden" value="{{ $get_supplier['id'] }}" />
                        <div class="col-md-4">
                            <label class="form-label" for="title">{{ translate('Full Name') }}<span
                                    class="text-danger">*</span>
                            </label>
                            <input class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}"
                                placeholder="{{ translate('Full Name') }}" id="username" name="username" type="text"
                                value="{{ old('username', $get_supplier['username']) }}" />
                            @error('username')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="title">{{ translate('Phone') }}<span
                                    class="text-danger">*</span>
                            </label>
                            <input class="form-control numberonly {{ $errors->has('contact') ? 'is-invalid' : '' }}"
                                placeholder="{{ translate('Phone') }}" id="contact" name="contact" type="text"
                                value="{{ old('contact', $get_supplier['contact']) }}" />
                            @error('contact')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="title">{{ translate('Email') }}<span
                                    class="text-danger">*</span>
                            </label>
                            <input class="form-control  {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                placeholder="{{ translate('Email') }}" id="email" name="email" type="text"
                                value="{{ old('email', $get_supplier['email']) }}" />
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="title">{{ translate('Company Name') }}<span
                                    class="text-danger">*</span>
                            </label>
                            <input class="form-control  {{ $errors->has('company_name') ? 'is-invalid' : '' }}"
                                placeholder="{{ translate('Company Name') }}" id="company_name" name="company_name"
                                type="text" value="{{ old('company_name', $get_supplier['company_name']) }}" />
                            @error('company_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="title">{{ translate('Booking Email') }}<span
                                    class="text-danger">*</span>
                            </label>
                            <input class="form-control  {{ $errors->has('booking_email') ? 'is-invalid' : '' }}"
                                placeholder="{{ translate('Booking Email') }}" id="booking_email" name="booking_email"
                                type="text" value="{{ old('booking_email', $get_supplier['booking_email']) }}" />
                            @error('booking_email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="title">{{ translate('Booking Contact') }}<span
                                    class="text-danger">*</span>
                            </label>
                            <input class="form-control  {{ $errors->has('booking_contact') ? 'is-invalid' : '' }}"
                                placeholder="{{ translate('Booking Contact') }}" id="booking_contact"
                                name="booking_contact" type="text"
                                value="{{ old('booking_contact', $get_supplier['booking_contact']) }}" />
                            @error('booking_contact')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="title">{{ translate('Country') }}<span
                                    class="text-danger">*</span>
                            </label>
                            <select class="single-select form-control {{ $errors->has('country') ? 'is-invalid' : '' }}"
                                name="country" id="country" onchange="getStateCity('country')">
                                <option value="">{{ translate('Select Country') }}</option>
                                @foreach ($country as $C)
                                    <option value="{{ $C['id'] }}"
                                        {{ getSelected($C['id'], old('country', $get_supplier['country'])) }}>
                                        {{ $C['name'] }}</option>
                                @endforeach
                            </select>
                            @error('country')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>



                        <div class="col-md-4">
                            <label class="form-label" for="title">{{ translate('State') }}<span
                                    class="text-danger">*</span>
                            </label>
                            <select class="single-select form-control {{ $errors->has('state') ? 'is-invalid' : '' }}"
                                name="state" id="state" onchange="getStateCity('state')">
                                <option value="">{{ translate('Select State') }}</option>

                            </select>
                            @error('state')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="title">{{ translate('City') }}<span
                                    class="text-danger">*</span>
                            </label>
                            <select class="single-select form-control {{ $errors->has('city') ? 'is-invalid' : '' }}"
                                name="city" id="city">
                                <option value="">{{ translate('Select City') }}</option>

                            </select>
                            @error('city')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="title">{{ translate('Company Logo') }}<span
                                    class="text-danger">*</span>
                            </label>
                            <input type="file" name="logo" onchange="loadFile(event,'preview_image')"
                                class="form-control">
                            <div class="col-lg-12 mt-2">
                                <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                                    <div class="h-100 w-100  overflow-hidden position-relative">
                                        <img src="{{ $get_supplier['logo'] != '' ? asset('uploads/supplier/' . $get_supplier['logo']) : asset('uploads/placeholder/placeholder.png') }}"
                                            id="preview_image" width="200" alt="" />
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <label class="form-label" for="price">{{ translate('Status') }} </label>
                            <select class="form-select single-select" name="status">
                                <option value="Active">{{ translate('Active') }}</option>
                                <option value="Deactive" {{ getSelected('Deactive', $get_supplier['status']) }}>
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
    <script>
        var state = "{{ old('state', $get_supplier['state']) }}";
        var city = "{{ old('city', $get_supplier['city']) }}";
        if (state != "") {
            setTimeout(() => {
                getStateCity("country", state);
                setTimeout(() => {
                    getStateCity("state", city);
                }, 500);
            }, 500);

        }
    </script>
@endsection
