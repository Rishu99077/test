@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_transfer_why_book_language = [];
        $WBT = getTableColumn('transfer_why_book');
    }
    $get_supplier = getDataFromDB('supplier', ['added_by' => 'admin']);                

@endphp
<div class="row why_book_div">
    <div> <button class="delete_book bg-card btn btn-danger btn-sm float-end" type="button"><span class="fa fa-trash"></span></button> </div>
    <input type="hidden" name="book_id[]" value="">

    <div class="row">
        
        <div class="col-md-6 mb-3">
            <label class="form-label" for="book_title">{{ translate('Why book Us Title') }}
            </label>
            <input class="form-control {{ $errors->has('book_title.' . $lang_id) ? 'is-invalid' : '' }}" placeholder="{{ translate('Enter Why book Us Title') }}" id="book_title"
                name="book_title[{{ $lang_id }}][]" type="text" value="{{ getLanguageTranslate($get_transfer_why_book_language, $lang_id, $WBT['id'], 'book_title', 'why_book_id') }}" />
            @error('book_title.' . $lang_id)
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="col-md-6">
            <label class="form-label" for="title">{{ translate('Why book Us Description') }} </label>
            <textarea class="form-control footer_text footer_book_{{ $data }} {{ $errors->has('book_description.' . $lang_id) ? 'is-invalid' : '' }}"
                placeholder="{{ translate('Enter Why book Us Description') }}" id="footer_book_{{ $data }}" name="book_description[{{ $lang_id }}][]">{{ getLanguageTranslate($get_transfer_why_book_language, $lang_id, $WBT['id'], 'book_description', 'why_book_id') }}
            </textarea>
            @error('book_description.' . $lang_id)
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label" for="reward_point">{{ translate('Clients Rewards point') }}</label>
            <input class="form-control numberonly"  placeholder="{{ translate('Enter Clients Rewards point') }}" id="reward_point" name="reward_point[]" type="text"
                    value="{{ $WBT['reward_point'] }}" />
        </div> 

        <div class="col-md-4 mb-3">
            <label class="form-label" for="points_to_purchase">{{ translate('How many points to purchase') }}</label>
            <input class="form-control numberonly"  placeholder="{{ translate('Enter How many points to purchase') }}" id="points_to_purchase" name="points_to_purchase[]" type="text" value="{{ $WBT['points_to_purchase'] }}" />
        </div>   

        <div class="col-md-4 col-lg-4  content_title box">
            <label class="form-label" for="price">{{ translate('Supplier') }}</label>
            <select class="form-select multi-select" name="suppliers[]" id="suppliers_{{ $data }}_{{$WBT['id']}}">

                @foreach ($get_supplier as $GS)
                    <option value="{{ $GS->id }}"
                        {{ getSelectedInArray($GS->id, $WBT['suppliers']) }}>
                        {{ $GS->username }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="mt-3">
        <hr>
    </div>
</div>
<script>
    CKEDITOR.replaceAll('footer_book_{{ $data }}');
</script>
