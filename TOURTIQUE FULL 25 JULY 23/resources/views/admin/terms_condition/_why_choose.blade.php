@php
    $languages = getLanguage();
    if (isset($append)) {
        $get_advertise_choose_language = [];
        $CHO = getTableColumn('advertise_choose_us');
    }
@endphp
<div class="row choose_div">
    <div>
        <button class="delete_choose bg-card btn btn-danger btn-sm float-end" type="button"><span
                class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="choose_id[]" value="{{ $CHO['id'] }}">


    @foreach ($languages as $key => $L)
        <div class="col-md-6 mb-3">

            <label class="form-label" for="title">{{ translate('Why Choose Description') }}({{ $L['title'] }})
            </label>
            <textarea
                class="form-control  {{ $errors->has('choose_description.' . $L['id']) ? 'is-invalid' : '' }} footer_text footer_text_{{ $CHO['id'] }}_{{ $data }}"
                placeholder="{{ translate('Enter Why Choose Description') }}" id="title"
                name="choose_description[{{ $L['id'] }}][]"> {{ getLanguageTranslate($get_advertise_choose_language, $L['id'], $CHO['id'], 'description', 'advertise_choose_id') }}
            </textarea>
            @error('choose_description.' . $L['id'])
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    @endforeach


    <div class="mb-2 mt-3">
        <hr>
    </div>
</div>

<script>
    CKEDITOR.replaceAll('footer_text_{{ $CHO['id'] }}_{{ $data }}', {
        extraPlugins: 'colorbutton,colordialog',
        removeButtons: 'PasteFromWord'
    });
</script>
