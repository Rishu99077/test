@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_testimonial_language = [];
        $GT                       = getTableColumn('testimonials');
        $count                    = $params_arr['count'];
    } else {
        $get_testimonial_language   = App\Models\TestimonialsLanguage::where("testimonials_id", $GT['id'])->get();
    }
@endphp
<div class="card mb-3 partner_div">
    <div class="card-body position-relative">
        <div class="row">
            <div class="col-auto align-self-center">
                <h3 class="blck_clr">Testimonial</h3>
            </div>
            <div class="col-auto ms-auto">
                <button class="delete_testimonial bg-card btn btn-danger btn-sm float-end" type="button"><span
                        class="fas fa-trash-alt"></span></button>
            </div>
        </div>
        <div class="row">

            <input id="" name="id[]" type="hidden" value="{{ $GT['id'] }}" />
            <div class="col-md-6 content_title">
                <label class="form-label" for="duration_from">{{ translate('Upload Image') }}
                    <small>(792X450)</small> </label>
                <div class="input-group mb-3">
                    <input class="form-control " type="file" name="image[]" aria-describedby="basic-addon2"
                        onchange="loadFile(event,'upload_logo_<?php echo $count; ?>')" id="image" />

                    <div class="invalid-feedback">
                    </div>
                </div>
                <div class="col-lg-3 mt-2">
                    <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                        <div class="h-100 w-100  overflow-hidden position-relative">
                            <img src="{{ $GT['image'] != '' ? asset('uploads/Testimonials/' . $GT['image']) : asset('uploads/placeholder/placeholder.png') }}"
                                id="upload_logo_<?php echo $count; ?>" width="100" alt="" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <label class="form-label" for="price">{{ translate('Status') }} </label>
                <select class="form-select single-select" name="status[]">
                    <option value="Active">{{ translate('Active') }} </option>
                    <option value="Deactive"{{ $GT['status'] == 'Deactive' ? 'selected' : '' }}>
                        {{ translate('Deactive') }}
                    </option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label" for="name">{{ translate('Name') }}<span class="text-danger">*</span>
                </label>
                <input class="form-control {{ $errors->has('name.*') ? 'is-invalid' : '' }}"
                    placeholder="{{ translate('Enter Name') }}" id="name" name="name[]" type="text"
                    value="{{ old('name', $GT['name']) }}" />
                @error('name.*')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label" for="designation">{{ translate('Designation') }}<span
                        class="text-danger">*</span>
                </label>
                <input class="form-control {{ $errors->has('designation.*') ? 'is-invalid' : '' }}"
                    placeholder="{{ translate('Enter Designation') }}" id="designation" name="designation[]"
                    type="text" value="{{ old('designation.*', $GT['designation']) }}" />
                @error('designation.*')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label" for="price">{{ translate('Description') }}
                </label>

                <textarea
                    class="form-control {{ $errors->has('description.' . $lang_id) ? 'is-invalid' : '' }} footer_text footer_text_{{ $count }}"
                    rows="8" id="description" name="description[{{ $lang_id }}][]" placeholder="Enter Description">{{ getLanguageTranslate($get_testimonial_language, $lang_id, $GT['id'], 'description', 'testimonials_id') }}</textarea>
                @error('description.' . $lang_id)
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </div>
</div>
<script>
    CKEDITOR.replaceAll('footer_text_{{ $count }}');
</script>
