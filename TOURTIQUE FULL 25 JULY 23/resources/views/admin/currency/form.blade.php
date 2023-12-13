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
                    class="fas fa-arrow-alt-circle-left text-primary "></span> {{ translate('Back') }} </a>
        </div>
    </div>

    <form class="row g-3 " method="POST" action="{{ route('admin.currency.add') }}" enctype="multipart/form-data">
        @csrf

        <div class="col-lg-12">
            <div class="card mb-3">

                <div class="card-body ">
                    <div class="row">
                        <input id="" name="id" type="hidden" value="{{ $get_currency['id'] }}" />
                        <div class="col-md-4">
                            <label class="form-label" for="title">{{ translate('Title') }}<span
                                    class="text-danger">*</span>
                            </label>
                            <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                                placeholder="{{ translate('Title') }}" id="title" name="title" type="text"
                                value="{{ old('title', $get_currency['title']) }}" />
                            @error('title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="title">{{ translate('Short Code') }}<span
                                    class="text-danger">*</span>
                            </label>
                            <input class="form-control {{ $errors->has('sort_code') ? 'is-invalid' : '' }}"
                                placeholder="{{ translate('Short Code') }}" id="sort_code" name="sort_code" type="text"
                                value="{{ old('sort_code', $get_currency['sort_code']) }}" />
                            @error('sort_code')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label" for="price">{{ translate('Status') }} </label>
                            <select class="form-select single-select" name="status">
                                <option value="Active">{{ translate('Active') }}</option>
                                <option value="Deactive"{{ $get_currency['status'] == 'Deactive' ? 'selected' : '' }}>
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
