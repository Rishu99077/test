@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_partner_language = [];
        $GP = getTableColumn('partners');
        $count = $params_arr['count'];
    }else{
        $get_partner_language   = App\Models\PartnerLanguage::where("partner_id", $GP['id'])->get();
    }
@endphp
<div class="card mb-3 partner_div">
    <div class="card-body position-relative">
        <div class="row">
            <div class="col-auto align-self-center">
                <h3 class="blck_clr">Partners</h3>
            </div>
            <div class="col-auto ms-auto">
                <button class="delete_partners bg-card btn btn-danger btn-sm float-end" type="button"><span
                        class="fas fa-trash-alt"></span></button>
            </div>
        </div>
        <div class="row ">
            <input id="" name="id[]" type="hidden" value="{{ $GP['id'] }}" />
          
            <div class="col-md-6">
                <label class="form-label" for="title">{{ translate('Title') }}<span
                        class="text-danger">*</span>
                </label>
                <input class="form-control {{ $errors->has('name.' . $lang_id) ? 'is-invalid' : '' }}"
                    placeholder="{{ translate('Enter Title') }}" id="name" name="name[{{ $lang_id }}][]"
                    type="text"
                    value="{{ getLanguageTranslate($get_partner_language, $lang_id, $GP['id'], 'title', 'partner_id') }}" />
                @error('name.' . $lang_id)
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>


            <div class="col-md-6 mt-2">
                <label class="form-label" for="price">{{ translate('Link') }} </label>
                <input class="form-control {{ $errors->has('link') ? 'is-invalid' : '' }}"
                        placeholder="{{ translate('Enter Link') }}" id="link" name="link[]"
                        type="text"
                        value="{{$GP['link']}}" />
                    @error('link')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
            </div>

            <div class="col-md-6 content_title mt-2">
                <label class="form-label" for="duration_from">{{ translate('Banner Image') }}
                    <small>(792X450)</small> </label>
                <div class="input-group mb-3">
                    <input class="form-control " type="file" name="image[]" aria-describedby="basic-addon2"
                        onchange="loadFile(event,'upload_work_logo_<?php echo $count; ?>')" id="image" />

                    <div class="invalid-feedback">
                    </div>
                </div>
                <div class="col-lg-3 mt-2">
                    <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                        <div class="h-100 w-100  overflow-hidden position-relative">
                            <img src="{{ $GP['image'] != '' ? asset('uploads/partner_images/' . $GP['image']) : asset('uploads/placeholder/placeholder.png') }}"
                                id="upload_work_logo_<?php echo $count; ?>" width="100" alt="" />
                        </div>
                    </div>
                </div>
            </div>


            

            <div class="col-md-3 mt-2">
                <label class="form-label" for="price">{{ translate('Status') }} </label>
                <select class="form-select single-select" name="status[]">
                    <option value="Active">{{ translate('Active') }} </option>
                    <option value="Deactive"{{ $GP['status'] == 'Deactive' ? 'selected' : '' }}>
                        {{ translate('Deactive') }}
                    </option>
                </select>
            </div>
            


            <div class="mb-2 mt-3">
                <hr>
            </div>
        </div>
    </div>
</div>
