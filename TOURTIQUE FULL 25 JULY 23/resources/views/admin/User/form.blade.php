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

    <form class="row g-3 " method="POST" action="{{ route('admin.user.add') }}" enctype="multipart/form-data">
        @csrf

        <div class="col-lg-12">
            <div class="card mb-3">

                <div class="card-body ">
                    <div class="row">

                        <input id="" name="id" type="hidden" value="{{ $get_user['id'] }}" />
                        
                        <div class="col-md-6">
                            <label class="form-label" for="title">{{ translate('Name') }}<span
                                    class="text-danger">*</span>
                            </label>
                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                placeholder="{{ translate('Name') }}" id="name" name="name"
                                type="text" value="{{ $get_user['name'] }}" />
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="title">{{ translate('Email') }}<span class="text-danger">*</span>
                                </label>
                            </label>
                            <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" @if($get_user['email']!='') readonly @endif
                                placeholder="{{ translate('Email') }}" id="email" name="email"
                                type="text" value="{{ $get_user['email'] }}" />
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        @if($get_user['email']=='')
                            <div class="col-md-6">
                                <label class="form-label" for="title">{{ translate('Password') }}<span class="text-danger">*</span>
                                </label>
                                <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                    placeholder="{{ translate('Password') }}" id="password" name="password"
                                    type="text" value="{{ $get_user['password'] }}" />
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        @endif    

                        <div class="col-md-6">
                            <label class="form-label" for="title">{{ translate('Number') }}<span class="text-danger">*</span>
                                </label>
                            </label>
                            <input class="form-control {{ $errors->has('phone_number') ? 'is-invalid' : '' }}" @if($get_user['phone_number']!='') readonly @endif
                                placeholder="{{ translate('Number') }}" id="phone_number" name="phone_number"
                                type="text" value="{{ $get_user['phone_number'] }}" />
                            @error('phone_number')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6 content_title ">
                            <label class="form-label" for="price">{{ translate('Country') }}
                                <span class="text-danger">*</span>
                            </label>
                            <select
                                class="form-select single-select country  {{ $errors->has('country') ? 'is-invalid' : '' }}"
                                name="country" id="country" onchange="getStateCity('country')">
                                <option value="">{{ translate('Select Country') }}</option>
                                @foreach ($country as $C)
                                    <option value="{{ $C['id'] }}"
                                        {{ getSelected($C['id'], old('country', $get_user['country'])) }}>
                                        {{ $C['name'] }}</option>
                                @endforeach
                            </select>

                            @error('country')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="title">{{ translate('State') }}<span
                                    class="text-danger">*</span>
                            </label>
                            <select
                                class="single-select form-control {{ $errors->has('state') ? 'is-invalid' : '' }}" name="state" id="state" onchange="getStateCity('state')">
                                <option value="">{{ translate('Select State') }}</option>

                            </select>
                            @error('state')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="title">{{ translate('City') }}<span
                                    class="text-danger">*</span>
                            </label>
                            <select
                                class="single-select form-control {{ $errors->has('city') ? 'is-invalid' : '' }}"
                                name="city" id="city" onchange="getStateCity('city')">
                                <option value="">{{ translate('Select City') }}</option>

                            </select>
                            @error('city')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="title">{{ translate('Wallet Top up amount') }} </label>
                            <input class="form-control"  placeholder="{{ translate('Wallet Top up amount') }}" id="giftcard_wallet" name="giftcard_wallet"
                                type="text" value="{{ $get_user['giftcard_wallet'] }}" />
                           
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="price">{{ translate('Status') }} </label>
                            <select class="form-select single-select" name="status">
                                <option value="Active">{{ translate('Active') }} </option>
                                <option value="Deactive"{{ $get_user['status'] == 'Deactive' ? 'selected' : '' }}>
                                    {{ translate('Deactive') }}
                                </option>
                            </select>
                        </div>


                        <div class="col-md-12">
                            <label class="form-label" for="address">{{ translate('Address') }}
                            </label>
                            <textarea class="form-control" id="address" name="address">{{ $get_user['address'] }}</textarea>
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

        var state = "{{ old('state', $get_user['state']) }}";
        var city = "{{ old('city', $get_user['city']) }}";
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
