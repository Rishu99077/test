@php
    $languages = getLanguage();
    $get_session_language  = getSessionLang();
    $lang_id = $get_session_language['id'];
    if (isset($append)) {
        $get_golf_rooms_language = [];
        $GGR        = getTableColumn('golf_rooms');
        $room_count = $data;
    }
@endphp
<div class="row rooms_div">
    <div>
        <button class="delete_rooms bg-card btn btn-danger btn-sm float-end" type="button"><span
                class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="room_id[]" value="{{ $GGR['id'] }}" Alt="{{$GGR['id']}}">

    
        <div class="col-md-6 mb-3">
            <label class="form-label" for="title">{{ translate('Room Name') }}
            </label>
            <input class="form-control {{ $errors->has('room_name.' . $lang_id) ? 'is-invalid' : '' }}"
                placeholder="{{ translate('Enter Higlights Title') }}" id="title"
                name="room_name[{{ $lang_id }}][]" type="text"
                value="{{ getLanguageTranslate($get_golf_rooms_language, $lang_id, $GGR['id'], 'title', 'golf_room_id') }}" />
            @error('room_name.' . $lang_id)
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

            <label class="form-label mt-2" for="title">{{ translate('Room Description') }}
            </label>
            <textarea
                class="form-control  footer_text footer_text_{{ $room_count }} {{ $errors->has('room_description.' . $lang_id) ? 'is-invalid' : '' }}"
                placeholder="{{ translate('Enter Room Description') }}" id="footer_text_{{ $room_count }}"
                name="room_description[{{ $lang_id }}][]">{{ getLanguageTranslate($get_golf_rooms_language, $lang_id, $GGR['id'], 'description', 'golf_room_id') }}</textarea>
            @error('room_description.' . $lang_id)
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    
    <div class="mt-3">
        <hr>
    </div>
</div>


<script>
    CKEDITOR.replaceAll('footer_text_{{ $room_count }}');
</script>
