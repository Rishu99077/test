@extends('admin.layout.master')

@section('content')
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
                    <form class="row g-3" method="post" action="{{ route('admin.profile') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="col-lg-12 text-center">
                            <div class="avatar avatar-5xl  shadow-sm img-thumbnail rounded-circle position-relative">
                                <div class="h-100 w-100 rounded-circle overflow-hidden position-relative">
                                    <img src="{{ $get_admin['image'] != '' ? url('uploads/admin_image', $get_admin['image']) : asset('uploads/placeholder/user.png') }}"
                                        id="preview" width="200" alt="" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label" for="first-name">Profile Image</label>
                            <input class="form-control   {{ $errors->has('image') ? 'is-invalid' : '' }}" id="customFile"
                                name="image" onchange="loadFile(event,'preview')" type="file">
                            @error('image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label" for="first-name">First Name</label>
                            <input class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}" id="first-name"
                                name="first_name" type="text" value="{{ old('first_name', $get_admin['first_name']) }}"
                                placeholder="First Name" />
                            @error('first_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label" for="last-name">Last Name</label>
                            <input class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}"
                                placeholder="Last Name" id="last-name" type="text" name="last_name"
                                value="{{ old('first_name', $get_admin['last_name']) }}" />

                            @error('last_name')
                                <div class="invalid-feedback">

                                    {{ $message }}

                                </div>
                            @enderror

                        </div>

                        <div class="col-lg-6">

                            <label class="form-label" for="email1">Email</label>

                            <input class="form-control" id="email1" placeholder="Email" readonly type="text"
                                value="{{ $get_admin['email'] }}" />

                        </div>



                        <div class="col-12 d-flex justify-content-end">

                            <button class="btn btn-primary" type="submit"> <span class="fa fa-save"></span> Update

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>
@endsection
