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
                <div class="col-auto ms-auto">
                    <a class="btn btn-falcon-primary me-1 mb-1" href="javascript:void(0)" onclick="back()" type="button"><span
                            class="fas fa-arrow-alt-circle-left text-primary "></span> Back </a>
                </div>
            </div>
        </div>
    </div>
    <form class="row g-3 " method="POST" action="{{ route('admin.staff.add') }}" enctype="multipart/form-data">
        @csrf
        <input id="" name="id" type="hidden" value="{{ $get_staff['id'] }}" />
        <div class="col-lg-12">
            <div class="card mb-3">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label" for="title">First Name<span class="text-danger">*</span>
                            </label>
                            <input class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}" placeholder="First Name" id="first_name" name="first_name" type="text" value="{{ old('first_name', $get_staff['first_name']) }}" />
                                @error('first_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="title">Last Name<span class="text-danger">*</span></label>
                            <input class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}" placeholder="Last Name" id="last_name" name="last_name" type="text" value="{{ old('last_name', $get_staff['last_name']) }}" />
                            @error('last_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label" for="title">Email<span class="text-danger">*</span></label>
                            <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" placeholder="Email" id="email" name="email" type="text" value="{{ old('email', $get_staff['email']) }}" />
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <?php if ($get_staff['id']!=''){ ?> 
                        <div class="row">
                            <div class="col-md-4">
                                <input class="formcontrol" id="chk_password" name="chk_password" type="checkbox" value="1" /> <label class="form-label" for="chk_password">If You want to change Password?</label>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="row chk_password_div" <?php if ($get_staff['id']!=''){ ?> style="display: none;" <?php }else{ ?> style="display: block;" <?php } ?> >
                        <div class="col-md-4">
                            <label class="form-label" for="title">Password<span class="text-danger">*</span></label>
                            <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" placeholder="Password" id="password" name="password" type="text" value="{{ old('password', '') }}" />
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label" for="price">Status </label>
                            <select class="form-select" name="status">
                                <option value="Active">{{ translate('Active') }} </option>
                                <option value="Deactive"{{ $get_staff['status'] == 'Deactive' ? 'selected' : '' }}>
                                    {{ translate('Deactive') }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 d-flex justify-content-end mt-2">
                            <button class="btn btn-primary" type="submit"> <span class="fas fa-save"></span>
                                {{ $common['button'] }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
<script type="text/javascript">
    $(document).ready(function() {
        $('#chk_password').click(function() {
            if($(this).is(':checked')){
                $('.chk_password_div').show();
            }else{
                $('.chk_password_div').hide();
            }
        });
    });
</script>
@endsection