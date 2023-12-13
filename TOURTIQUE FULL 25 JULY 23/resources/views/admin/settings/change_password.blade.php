@extends('admin.layout.master')

@section('content')
    <style>



    </style>

    <div class="card mb-3">
        <div class="bg-holder d-none d-lg-block bg-card"
            style="background: linear-gradient(90deg, rgba(38,42,73,1) 0%, rgba(61,65,100,1) 71%, rgba(9,193,45,0.44019614681810226) 100%);">
        </div>
        <!--/.bg-holder-->
        <div class="card-body position-relative">
            <div class="row">
                <div class="col-lg-8">
                    <h3>{{ $common['title'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-0">

        <div class="col-lg-12 pe-lg-2">

            <div class="card mb-3">



                <div class="card-body bg-light">

                    <form class="row g-3" method="post" action="{{ route('admin.change_password') }}"
                        enctype="multipart/form-data">

                        @csrf

                        <div class="col-lg-6">

                            <label class="form-label" autocomplete="off" for="old-password">Current Password</label>

                            <input class="form-control {{ $errors->has('current_password') ? 'is-invalid' : '' }}"
                                id="current-password" value="{{ old('current_password') }}" placeholder="Current Password"
                                name="current_password" type="password">

                            @error('current_password')
                                <div class="invalid-feedback">

                                    {{ $message }}

                                </div>
                            @enderror

                        </div>

                        <div class="col-lg-6">

                            <label class="form-label" autocomplete="off" for="new-password">New Password</label>

                            <input class="form-control {{ $errors->has('new_password') ? 'is-invalid' : '' }}"
                                id="new-password" value="{{ old('new_password') }}" placeholder="New Password"
                                name="new_password" type="password">

                            @error('new_password')
                                <div class="invalid-feedback">

                                    {{ $message }}

                                </div>
                            @enderror

                        </div>

                        <div class="col-lg-6">

                            <label class="form-label" autocomplete="off" for="confirm-password">Confirm Password</label>

                            <input class="form-control {{ $errors->has('confirm_password') ? 'is-invalid' : '' }}"
                                id="confirm-password" name="confirm_password" value="{{ old('confirm_password') }}"
                                placeholder="Confirm Password" type="password">

                            @error('confirm_password')
                                <div class="invalid-feedback">

                                    {{ $message }}

                                </div>
                            @enderror

                        </div>



                        <div class="col-12 d-flex justify-content-end">

                            <button class="btn btn-primary" type="submit">Update

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>
@endsection
