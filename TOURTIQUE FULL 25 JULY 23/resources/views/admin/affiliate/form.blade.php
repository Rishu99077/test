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

    <form class="row g-3 " method="POST" action="{{ route('admin.affiliate.add') }}" enctype="multipart/form-data">
        @csrf
        <div class="col-lg-12">
            <div class="card mb-3">

                <div class="card-body ">
                    <div class="row">
                        <input id="" name="id" type="hidden" value="{{ $get_affiliate['id'] }}" />
                        <div class="col-md-4">
                            <label class="form-label" for="title">{{ translate('Full Name') }}<span
                                    class="text-danger">*</span>
                            </label>
                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                placeholder="{{ translate('Full Name') }}" id="name" name="name" type="text"
                                value="{{ old('name', $get_affiliate['name']) }}" />
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="title">{{ translate('Phone') }}<span
                                    class="text-danger">*</span>
                            </label>
                            <input class="form-control numberonly {{ $errors->has('phone_number') ? 'is-invalid' : '' }}"
                                placeholder="{{ translate('Phone') }}" id="phone_number" name="phone_number" type="text"
                                value="{{ old('phone_number', $get_affiliate['phone_number']) }}" />
                            @error('phone_number')
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
                                value="{{ old('email', $get_affiliate['email']) }}" />
                            @error('email')
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
                                        {{ getSelected($C['id'], old('country', $get_affiliate['country'])) }}>
                                        {{ $C['name'] }}
                                    </option>
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
                            <label class="form-label" for="title">{{ translate('Image') }}<span
                                    class="text-danger">*</span>
                            </label>
                            <input type="file" name="image" onchange="loadFile(event,'preview_image')"
                                class="form-control">
                            <div class="col-lg-12 mt-2">
                                <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                                    <div class="h-100 w-100  overflow-hidden position-relative">
                                        <img src="{{ $get_affiliate['image'] != '' ? asset('uploads/affiliate/' . $get_affiliate['image']) : asset('uploads/placeholder/placeholder.png') }}"
                                            id="preview_image" width="200" alt="" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="title">{{ translate('Commision percentage') }}<span
                                   class="text-danger">*</span>
                            </label>
                            <input class="form-control numberonly {{ $errors->has('commission_percentage') ? 'is-invalid' : '' }}"
                               placeholder="{{ translate('Commision percentage') }}" id="commission_percentage" name="commission_percentage" type="text"
                               value="{{ old('commission_percentage', $get_affiliate['commission_percentage']) }}" />
                            @error('commission_percentage')
                               <div class="invalid-feedback">
                                   {{ $message }}
                               </div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="price">{{ translate('Status') }} </label>
                            <select class="form-select single-select" name="status">
                                <option value="Active">{{ translate('Active') }}</option>
                                <option value="Deactive" {{ getSelected('Deactive', $get_affiliate['status']) }}>
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
        var state = "{{ old('state', $get_affiliate['state']) }}";
        var city = "{{ old('city', $get_affiliate['city']) }}";
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
