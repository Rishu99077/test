@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_advertise_choose_language = [];
        $CHO = getTableColumn('advertise_choose_us');
    }
@endphp
<div class="row choose_div">
    <div>
        <button class="delete_choose bg-card btn btn-danger btn-sm float-end" type="button"><span class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="choose_id[]" value="{{$CHO['id']}}">


    <div class="col-md-6 mb-3">
        
        <label class="form-label" for="title">{{ translate('Why Choose Description') }} </label>
        <textarea class="form-control  {{ $errors->has('choose_description.' . $lang_id) ? 'is-invalid' : '' }} footer_text footer_text_{{$CHO['id']}}_{{$data}}" placeholder="{{ translate('Enter Why Choose Description') }}" id="title" name="choose_description[{{ $lang_id }}][]"> {{ getLanguageTranslate($get_advertise_choose_language, $lang_id, $CHO['id'], 'description', 'advertise_choose_id') }}
        </textarea>
        @error('choose_description.' . $lang_id)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-6 content_title">
        <div class="form-check form-switch pl-0">
            <label class="form-check-label form-label" for="choose_sort_order">Sort Order </label>
            <input class="form-control numberonly  choose_sort_order" id="choose_sort_order" type="text" value="{{ $CHO['choose_sort_order'] }}" name="choose_sort_order[]">
            
        </div>   
    </div>
    

    <div class="mb-2 mt-3">
        <hr>
    </div>
</div>

<script>
    CKEDITOR.replaceAll('footer_text_{{$CHO["id"]}}_{{$data}}');
</script>
