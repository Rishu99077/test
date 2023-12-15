@include('front.layout.header')
@include('front.layout.top_bar')
<style type="text/css">
    .help-block{
        display: block!important;
    }
</style>
{{--<div class="row container-fluid">
    <div class="col-sm-12 text-end">
        <i class="fa fa-arrow-left" aria-hidden="true"></i>
    </div>
</div>--}}
<div class="container-fluid mt-3 staff_main" style="min-height: 440px; padding: 30px;">
    <div class="row">

        <div class="col-sm-8 col-xl-8 col-lg-8">
            <div class="main_signup">
                <form id="StaffFormID" enctype="multipart/form-data" class="signup_form_section2" style="margin-top: 0px;">
                    @csrf
                    <input type="hidden" value="{{ isset($get_staff['id']) ? $get_staff['id'] : ''  }}" name="id"  />
                    <?php  if($get_staff['id'] != ''){ ?>
                        <input type="hidden" value="1" name="is_update"  />
                    <?php } ?>
                    <input type="hidden" name="get_status_type" id="get_status_type">
                    <input type="hidden" id="get_company_logo_url" name="company_logo_url" value="{{ $get_staff['company_logo'] != '' ? $get_staff['company_logo'] : '' }}">

                    <div class="row">
                        <div class="form-group col-md-6"  id="Input-first_name">
                            <label>First Name</label>
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <input  id="first_name" class="form-control {{ $errors->has('first_name') ? 'is-invalid' : ''}}" type="text" name="first_name" value="{{ isset($get_staff['first_name']) ? $get_staff['first_name'] : ''  }}" 
                            onkeyup="vcard_design()" />
                            <span class="help-block"></span>
                        </div>

                        <div class="form-group col-md-6" id="Input-last_name">
                            <label>Last Name</label>
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <input class="form-control {{ $errors->has('last_name') ? 'is-invalid' : ''}}" type="text" name="last_name" 
                            value="{{ isset($get_staff['last_name']) ? $get_staff['last_name'] : ''  }}" onkeyup="vcard_design()" />
                            <span class="help-block"></span>
                        </div>

                        <div class="form-group col-md-6" id="Input-company_name">
                            <label>Company name</label>
                            <i class="fa fa-building" aria-hidden="true"></i>
                            <input class="form-control {{ $errors->has('company_name') ? 'is-invalid' : ''}}" type="text" name="company_name"
                            value="{{ isset($get_staff['company_name']) ? $get_staff['company_name'] : ''  }}" onkeyup="vcard_design()" />
                            <span class="help-block"></span>
                        </div>

                        <div class="form-group col-md-6" id="Input-designation">
                            <label>Designation</label>
                            <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                            <input class="form-control {{ $errors->has('designation') ? 'is-invalid' : ''}}" type="text" name="designation"
                            value="{{ isset($get_staff['designation']) ? $get_staff['designation'] : ''  }}"  onkeyup="vcard_design()" />
                            <span class="help-block"></span>
                        </div>


                        <div class="form-group col-md-6" id="Input-email">
                            <label>Email</label>
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                            <div class="tags_add" style=" width: 100%;"  onkeyup="vcard_design()" >
                                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : ''}}" type="email" name="email"
                                value="{{ isset($get_staff['email']) ? $get_staff['email'] : ''  }}"   data-role="tagsinput" />
                            </div>
                            <span class="help-block"></span>
                        </div>

                        <?php  if($get_staff['id'] == ''){ ?>
                            <div class="form-group col-md-6" id="Input-password">
                                <label>Password</label>
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                                <div class="tags_add" style=" width: 100%;">
                                    <input class="form-control {{ $errors->has('password') ? 'is-invalid' : ''}}" type="password" name="password" 
                                    data-role="tagsinput" />
                                </div>
                                <span class="help-block"></span>
                            </div>
                        <?php } ?>

                        <div class="form-group col-md-6" id="Input-contact">
                            <label>Mobile</label>
                            <i class="fa fa-mobile" aria-hidden="true"></i>
                            <div class="tags_add" style=" width: 100%;" onkeyup="vcard_design()">
                                <input type="text" class="form-control {{ $errors->has('contact') ? 'is-invalid' : ''}}" value="{{ isset($get_staff['contact']) ? $get_staff['contact'] : ''  }}" data-role="tagsinput" name="contact"
                                value=""  />
                            </div>
                            <span class="help-block"></span>
                        </div>

                        <div class="form-group col-md-6" id="Input-address">
                            <label>Address</label>
                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                            <input class="form-control {{ $errors->has('address') ? 'is-invalid' : ''}}" type="text" name="address"
                            value="{{ isset($get_staff['address']) ? $get_staff['address'] : ''  }}" onkeyup="vcard_design()" />
                            <span class="help-block"></span>
                        </div>

                        <div class="form-group col-md-6" id="Input-town">
                            <label>City</label>
                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                            <input class="form-control {{ $errors->has('town') ? 'is-invalid' : ''}}" type="text" name="town"
                            value="{{ isset($get_staff['town']) ? $get_staff['town'] : ''  }}" onkeyup="vcard_design()" />
                            <span class="help-block"></span>
                        </div>

                        <div class="form-group col-md-6" id="Input-country">
                            <label>Country</label>
                            <i class="fa fa-globe" aria-hidden="true"></i>

                            <select class="form-control {{ $errors->has('country') ? 'is-invalid' : ''}}" name="country" id="country" onkeyup="vcard_design()">
                                <option value="">Select country</option>
                                @foreach($get_country as $row)
                                    <option value="{{ $row['id'] }}" <?php if($get_staff['country'] == $row['id']){ echo 'selected="selected"'; } ?>>{{ $row['name'] }}</option>
                                @endforeach
                            </select>

                            <span class="help-block"></span>
                        </div>
                        
                        <div class="form-group col-md-6" id="Input-company_logo">
                            <label>Company Logo</label>
                            <i class="fa fa-linode" aria-hidden="true"></i>
                            <input class="form-control {{ $errors->has('company_logo') ? 'is-invalid' : ''}}" type="file" name="company_logo" id="company_logo_id" accept="image/png, image/gif, image/jpeg"  />
                            <span class="help-block"></span>
                        </div>

                        <?php
                            if(isset($get_staff['company_logo'])){
                                if($get_staff['company_logo'] != ''){
                                    ?>
                                    <div class="form-group" style="display: none;">
                                        <img src="{{ $get_staff['company_logo'] != '' ? asset('uploads/staff/' . $get_staff['company_logo']) : asset('frontassets/image/placeholder.jpg') }}" width="100"  />
                                    </div>
                                    <?php
                                }
                            }
                        ?>

                        <div class="form-group col-md-6" id="Input-facebook">
                            <label>Facebook URL</label>
                            <i class="fa fa-facebook-official" aria-hidden="true"></i>
                            <input class="form-control {{ $errors->has('facebook') ? 'is-invalid' : ''}}" type="text" name="facebook"
                            value="{{ isset($get_staff['facebook']) ? $get_staff['facebook'] : 'facebook.com'  }}" onkeyup="vcard_design()" />
                            <span class="help-block"></span>
                        </div>

                        <div class="form-group col-md-6" id="Input-twitter">
                            <label>Twitter URL</label>
                            <i class="fa fa-twitter" aria-hidden="true"></i>
                            <input class="form-control {{ $errors->has('twitter') ? 'is-invalid' : ''}}" type="text" name="twitter"
                            value="{{ isset($get_staff['twitter']) ? $get_staff['twitter'] : 'twitter.com'  }}" onkeyup="vcard_design()" />
                            <span class="help-block"></span>
                        </div>


                        <div class="form-group col-md-6" id="Input-instagram">
                            <label>Instagram URL</label>
                            <i class="fa fa-instagram" aria-hidden="true"></i>
                            <input class="form-control {{ $errors->has('instagram') ? 'is-invalid' : ''}}" type="text" name="instagram"
                            value="{{ isset($get_staff['instagram']) ? $get_staff['instagram'] : 'instagram.com'  }}" onkeyup="vcard_design()"  />
                            <span class="help-block"></span>
                        </div>

                        <div class="form-group col-md-6" id="Input-linkedin">
                            <label>Linkedin URL</label>
                            <i class="fa fa-linkedin-square" aria-hidden="true"></i>
                            <input class="form-control {{ $errors->has('linkedin') ? 'is-invalid' : ''}}" type="text" name="linkedin"
                            value="{{ isset($get_staff['linkedin']) ? $get_staff['linkedin'] : ''  }}" onkeyup="vcard_design()" />
                            <span class="help-block"></span>
                        </div>

                        <div class="form-group col-md-6" id="Input-whatsapp_url">
                            <label>Whatsapp</label>
                            <i class="fa fa-whatsapp" aria-hidden="true"></i>
                            <input class="form-control {{ $errors->has('whatsapp_url') ? 'is-invalid' : ''}}" type="text" name="whatsapp_url"
                            value="{{ isset($get_staff['whatsapp_url']) ? $get_staff['whatsapp_url'] : ''  }}" onkeyup="vcard_design()" />
                            <span class="help-block"></span>
                        </div>

                        <div class="form-group col-md-6" id="Input-google_plus_url">
                            <label>Google+ URL</label>
                            <i class="fa fa-google-plus" aria-hidden="true"></i>
                            <input class="form-control {{ $errors->has('google_plus_url') ? 'is-invalid' : ''}}" type="text" name="google_plus_url"
                            value="{{ isset($get_staff['google_plus_url']) ? $get_staff['google_plus_url'] : ''  }}" onkeyup="vcard_design()" />
                            <span class="help-block"></span>
                        </div>

                        <div class="form-group col-md-6" id="Input-avatar_file">
                            <label>Avatar File</label>
                            <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                            <input class="form-control {{ $errors->has('avatar_file') ? 'is-invalid' : ''}}" type="file" name="avatar_file" id="avatar_file_id" accept="image/png, image/gif, image/jpeg"  />
                            <span class="help-block"></span>
                        </div>
                    
                        <?php
                            if(isset($get_staff['avatar_file'])){
                                ?>
                                <div class="form-group col-md-6" style="display: none;">
                                    <img src="{{ $get_staff['avatar_file'] != '' ? asset('uploads/staff/' . $get_staff['avatar_file']) : asset('frontassets/image/placeholder.jpg') }}" width="100" alt="" />
                                </div>
                                <?php
                            }
                        ?>

                        <input type="hidden" id="get_avatar_img_url" name="avatar_img_url"  value="{{ $get_staff['avatar_file'] != '' ? $get_staff['avatar_file'] : '' }}">

                        <?php
                            if(isset($get_staff['qr_code'])){
                                ?>
                                <div class="form-group col-md-6" style="display: none;">
                                    <img src="{{ $get_staff['qr_code'] != '' ? asset('uploads/staff/qrcode-images/' . $get_staff['qr_code']) : asset('frontassets/image/placeholder.jpg') }}" width="100" alt="" />
                                </div>
                                <?php
                            }
                        ?>
                        
                        <div class="form-group col-md-6" >
                            <label>Qr Color</label>
                            <i class="fa fa-qrcode" aria-hidden="true"></i>
                            <input class="form-control" type="color" name="qr_color" value="{{$get_staff['qr_color'] != '' ? $get_staff['qr_color'] : '#ffffff'}}"  />
                        </div>

                        <?php
                            $google_map_check = '';
                            if(isset($get_staff['google_map'])){
                                if($get_staff['google_map'] != ''){
                                    $google_map_check = 'checked';
                                }
                            }
                        ?>
                        
                        <div class="form-group col-md-12" id="">
                            <label>Google map</label>
                            <input type="checkbox" {{$google_map_check}} name="google_map" id="google_map_id"  onclick="vcard_design()"> Include Google Map    
                        </div>

                    </div>

                    <a id="download_qr_code_id" href="" download=""  target="_blank" style="display: none;">
                        Downlad QR Code
                    </a>

                    <div class="btn_list">
                        <ul>
                          <!--   <li>
                                <button type="button" class="btn btn-warning save_btn draft_btn" data-status="draft" >Draft</button>
                            </li> -->
                            <li>
                                <button type="button" class="btn save_btn download_btn" data-status="download" >Save</button>
                            </li>
                        </ul>
                        
                    </div>
                    

                </form>
            </div>
        </div>

        <div class="col-sm-4 col-xl-4 col-lg-4">
            <div id="get_card_resp"> 
                @include('front.staff.card_design')    
            </div>
        </div>
    </div>   
</div>
@include('front.layout.footer')
