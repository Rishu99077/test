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

    <form class="row g-3 " method="POST" action="{{ route('admin.boat_types.add') }}" enctype="multipart/form-data">
       
        @csrf

        <div class="col-lg-12">
            <div class="card mb-3">

                <div class="card-body ">
                    <div class="row">

                        <input id="" name="id" type="hidden" value="{{ $get_boat_types['id'] }}" />

                        <div class="col-md-12 content_title">
                            <div class="form-check form-switch pl-0">
                                <input class="form-check-input float-end status switch_button" {{ getChecked('Active', old('status', $get_boat_types['status'])) }} id="status" type="checkbox" value="Active" name="status">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="boat_type">{{ translate('Boat type') }}<span class="text-danger">*</span></label>
                            <input class="form-control {{ $errors->has('boat_type') ? 'is-invalid' : '' }}" placeholder="{{ translate('Boat type') }}" id="boat_type" name="boat_type" type="text" value="{{ $get_boat_types['boat_type'] }}" />
                            
                            @error('boat_type')
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
