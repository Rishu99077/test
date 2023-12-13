@extends('admin.layout.master')
@section('content')
    <div class="d-flex justify-content-between">
        <ul class="breadcrumb mb-2 ">
            <li>
              <a href="#" style="width: auto;">
                  <span class="text">{{ $common['language_title'] }} <img src="{{ url('uploads/language_flag', $common['language_flag']) }}" class="lang_img"></span>
              </a>
            </li>
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

    <form class="row g-3 " method="POST" action="{{ route('admin.contact_setting.add') }}" enctype="multipart/form-data">
        @csrf

        <div class="col-lg-12">
            <div class="card mb-3">

                <div class="card-body ">
                    <div class="row">

                        <input id="" name="id" type="hidden" value="{{ $get_contact_setting['id'] }}" />

                        <div class="col-md-12 content_title">
                            <div class="form-check form-switch pl-0">
                                <input class="form-check-input float-end status switch_button" {{ getChecked('Active', old('status', $get_contact_setting['status'])) }} id="status" type="checkbox" value="Active" name="status">
                            </div>
                        </div>

                        
                        <h4 class="text-dark mt-3">{{ translate('Need Help Contacts') }}</h4>
                        
                        <div class="col-md-6">
                            <label class="form-label"
                                for="need_help_contact_heading">{{ translate('Need Help Contacts Heading') }}<span
                                    class="text-danger">*</span>
                            </label>
                            <input
                                class="form-control {{ $errors->has('need_help_contact_heading.' . $lang_id) ? 'is-invalid' : '' }}"
                                placeholder="{{ translate('Title') }}" id="need_help_contact_heading{{ $lang_id }}"
                                name="need_help_contact_heading[{{ $lang_id }}]" type="text"
                                value="{{ old('need_help_contact_heading.' . $lang_id ,getLanguageTranslate($need_help_contact_heading, $lang_id, 'heading_title', 'title', 'meta_title'))}}" />
                                {{-- getLanguageTranslate($get_contact_setting_language, $lang_id, 'heading_title', 'title', 'meta_title'))     --}}
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                              <label class="form-label" for="contact_number_1">{{ translate('Contact Number 1') }}</label>
                              <input class="form-control numberonly" placeholder="{{ translate('Contact Number 1') }}" id="contact_number_1" name="contact_number_1" type="text" value="{{ $get_contact_setting['contact_number_1'] }}" />
                        </div>

                        <div class="col-md-6">
                              <label class="form-label" for="contact_number_2">{{ translate('Contact Number 2') }}</label>
                              <input class="form-control numberonly" placeholder="{{ translate('Contact Number 2') }}" id="contact_number_2" name="contact_number_2" type="text" value="{{ $get_contact_setting['contact_number_2'] }}" />
                        </div>

                        <div class="col-md-6">
                              <label class="form-label" for="whatsapp_number_1">{{ translate('Whats App Number 1') }}</label>
                              <input class="form-control numberonly" placeholder="{{ translate('Whats App Number 1') }}" id="whatsapp_number_1" name="whatsapp_number_1" type="text" value="{{ $get_contact_setting['whatsapp_number_1'] }}" />
                        </div>

                        <div class="col-md-6">
                              <label class="form-label" for="whatsapp_number_2">{{ translate('Whats App Number 2') }}</label>
                              <input class="form-control numberonly" placeholder="{{ translate('Whats App Number 2') }}" id="whatsapp_number_2" name="whatsapp_number_2" type="text" value="{{ $get_contact_setting['whatsapp_number_2'] }}" />
                        </div>

                        <div class="col-md-6">
                              <label class="form-label" for="email_address_1">{{ translate('Email Address 1') }}</label>
                              <input class="form-control" placeholder="{{ translate('Email Address 1') }}" id="email_address_1" name="email_address_1" type="text" value="{{ $get_contact_setting['email_address_1'] }}" />
                        </div>

                        <div class="col-md-6">
                              <label class="form-label" for="email_address_2">{{ translate('Email Address 2') }}</label>
                              <input class="form-control" placeholder="{{ translate('Email Address 2') }}" id="email_address_2" name="email_address_2" type="text" value="{{ $get_contact_setting['email_address_2'] }}" />
                        </div>

                       
                        <div class="col-md-6">
                            <label class="form-label" for="title">{{ translate('Address') }}<span class="text-danger">*</span> </label>
                            <textarea class="form-control footer_text  {{ $errors->has('address.' . $lang_id) ? 'is-invalid' : '' }}" placeholder="{{ translate('Enter Address') }}" id="footer_voucher" name="address[{{ $lang_id }}]">{{ getLanguageTranslate($get_contact_setting_language, $lang_id, $get_contact_setting['id'], 'address', 'contact_setting_id') }}</textarea>    
                          
                        </div>
                        

                        <h4 class="text-dark mt-3">{{ translate('Why Book With Us') }}</h4>

                        <div class="col-md-6">
                            <label class="form-label"
                                for="why_book_with_us">{{ translate('Why Book With Us Heading') }}<span
                                    class="text-danger">*</span>
                            </label>
                            <input
                                class="form-control {{ $errors->has('why_book_with_us.' . $lang_id) ? 'is-invalid' : '' }}"
                                placeholder="{{ translate('Title') }}" id="why_book_with_us{{ $lang_id }}"
                                name="why_book_with_us[{{ $lang_id }}]" type="text"
                                value="{{ old('why_book_with_us.' . $lang_id,getLanguageTranslate($why_book_with_us_heading, $lang_id, 'heading_title', 'title', 'meta_title'))}}" />
                                {{-- getLanguageTranslate($opening_time_heading, $lang_id, 'heading_title', 'title', 'meta_title'))     --}}
                            <div class="invalid-feedback">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="title">{{ translate('Description') }}<span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control footer_text  {{ $errors->has('description.' . $lang_id) ? 'is-invalid' : '' }}" placeholder="{{ translate('Enter Description') }}" id="footer_voucher" name="description[{{ $lang_id }}]">{{ getLanguageTranslate($get_contact_setting_language, $lang_id, $get_contact_setting['id'], 'description', 'contact_setting_id') }}</textarea>    
                          
                        </div>
                    
            
                        <div class="col-12 d-flex justify-content-end mt-2">
                            <button class="btn btn-primary" type="submit"> <span class="fas fa-save"></span> {{ $common['button'] }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>
<script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replaceAll('footer_text');
</script>

@endsection
