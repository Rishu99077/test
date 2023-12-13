@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_transfer_extras_language = [];
        $TXX = getTableColumn('transfer_extras');
        $extras_data_count = $data;
    }
@endphp
<div class="row extras_div">
    <div>
        <button class="delete_extras bg-card btn btn-danger btn-sm float-end" type="button"><span
                class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="extra_id[]" value="{{ $TXX['id'] }}">

    <div class="col-md-6 mb-3">
        <label class="form-label" for="title">{{ translate('Tour option') }}
        </label>
        <input class="form-control {{ $errors->has('extra_title.' . $lang_id) ? 'is-invalid' : '' }}"
            placeholder="{{ translate('Enter Tour option') }}" id="title"
            name="extra_title[{{ $lang_id }}][]" type="text"
            value="{{ getLanguageTranslate($get_transfer_extras_language, $lang_id, $TXX['id'], 'extra_title', 'extras_id') }}" />
        @error('extra_title.' . $lang_id)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    
    <div class="col-md-6">    
        <label class="form-label" for="title">{{ translate('Addtional Information') }}
        </label>
        <textarea
            class="form-control {{ $errors->has('extra_information.' . $lang_id) ? 'is-invalid' : '' }} footer_extra_{{ $extras_data_count }}"
            placeholder="{{ translate('Enter Addtional Information') }}" id="footer_extra_{{ $extras_data_count }}"
            name="extra_information[{{ $lang_id }}][]">{{ getLanguageTranslate($get_transfer_extras_language, $lang_id, $TXX['id'], 'extra_information', 'extras_id') }}</textarea>
        @error('extra_information.' . $lang_id)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-12 content_title ">
        <h5 class="text-black mt-2 fw-semi-bold fs-0">{{ translate('Tour Price') }}</h5>
        <table class="table table-responsive">
            <thead>
                <tr>
                    <th>{{ translate('Adult Price') }}</th>
                    <th>{{ translate('Child Allowed') }}</th>
                    <th>{{ translate('Child Price') }}</th>
                </tr>
            <tbody>

                <tr>

                    <td>
                        <input class="form-control numberonly {{ $errors->has('adult_price') ? 'is-invalid' : '' }}"
                            type="text" name="adult_price[{{ $extras_data_count }}]"
                            placeholder="{{ translate('Adult Price') }}" value="{{ $TXX['adult_price'] }}" />
                        @error('adult_price')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </td>
                    <td>
                        <input class="form-check-input mt-2 child_allowed" id="flexCheckDefault" id="option_status"
                            type="checkbox" name="child_allowed[{{ $extras_data_count }}]" value="1"
                            @php if($TXX['transfer_id'] != ""){
                                    if($TXX['child_allowed'] == 1){
                                        echo " checked";
                                    }
                                }else{
                                    echo " checked";
                                } @endphp />
                    </td>
                    <td>

                        <input class="form-control numberonly {{ $errors->has('child_price') ? 'is-invalid' : '' }}"
                            type="text" name="child_price[{{ $extras_data_count }}]"
                            placeholder="{{ translate('Child Price') }}"
                            @php if($TXX['child_allowed'] != 1 && !isset($append) && $get_transfer['id'] != "")
                                    {
                                        echo "value=' N/A' readonly";
                                    }else{
                                        echo "value=".$TXX['child_price']."";
                                    } @endphp>
                        @error('child_price')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </td>
                </tr>
            </tbody>
            </thead>

            <tbody>
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        <hr>
    </div>
</div>
<script>
    CKEDITOR.replaceAll('footer_extra_{{ $extras_data_count }}');
</script>
