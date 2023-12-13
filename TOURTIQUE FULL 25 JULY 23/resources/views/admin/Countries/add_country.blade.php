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
            <a class="btn btn-falcon-primary me-1 mb-1 mt-1" href="javascript:void(0)" onclick="back()" type="button">
                <span class="fas fa-arrow-alt-circle-left text-primary "></span> Back </a>
        </div>
    </div>

    <form class="row g-3 " method="POST" action="{{ route('admin.countries.add') }}" enctype="multipart/form-data">
       
        @csrf

        <div class="col-lg-12">
            <div class="card mb-3">

                <div class="card-body ">
                    <div class="row">

                        <input id="" name="id" type="hidden" value="{{ $get_country['id'] }}" />

        
                        <div class="col-md-4">
                            <label class="form-label" for="name">{{ translate('Country name') }}<span class="text-danger">*</span></label>
                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" placeholder="{{ translate('Country name') }}" id="name" name="name" type="text" value="{{ $get_country['name'] }}" />
                            
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            
                        </div>


                        <div class="col-md-4">
                            <label class="form-label" for="sortname">{{ translate('Short name') }}<span class="text-danger">*</span></label>
                            <input class="form-control {{ $errors->has('sortname') ? 'is-invalid' : '' }}" placeholder="{{ translate('Short name') }}" id="sortname" name="sortname" type="text" value="{{ $get_country['sortname'] }}" />
                            
                            @error('sortname')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            
                        </div>


                        <div class="col-md-4">
                            <label class="form-label" for="phonecode">{{ translate('Phone code') }}<span class="text-danger">*</span></label>
                            <input class="form-control {{ $errors->has('phonecode') ? 'is-invalid' : '' }}" placeholder="{{ translate('Phone code') }}" id="phonecode" name="phonecode" type="text" value="{{ $get_country['phonecode'] }}" />
                            
                            @error('phonecode')
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
