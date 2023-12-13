@php
    $languages = getLanguage();
    if (isset($append)) {
        $get_advertise_with_us_language = [];
        $MPS = getTableColumn('meta_page_settings');
    }
@endphp
<div class="row advertise_div">
    <div>
        <button class="delete_advertise bg-card btn btn-danger btn-sm float-end" type="button"><span
                class="fa fa-trash"></span></button>
    </div>
    <input type="hidden" name="facility_id[]" value="{{ $MPS['id'] }}">


    @foreach ($languages as $key => $L)
                    @php
                        $MetaPageSettingLanguage =  App\Models\MetaGlobalLanguage::where(['product_id'=>$MPS['id'],'meta_parent'=>'pages','language_id'=>$L['id']])->first();
                        // dd($L['id'],$MetaPageSettingLanguage,$MPS['id'])

                    @endphp
  
            <div class="col-md-6 mb-3">
                <label class="form-label" for="heading">{{ translate('Heading') }}({{ $L['title'] }})
                </label>
                <input class="form-control {{ $errors->has('heading.' . $L['id']) ? 'is-invalid' : '' }}"
                    placeholder="{{ translate('Enter Heading') }}" id="heading"
                    name="heading[{{ $L['id'] }}][]" type="text"
                    value="{{ $MetaPageSettingLanguage->title ?? "" }}" />
                @error('heading.' . $L['id'])
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

                <label class="form-label" for="title">{{ translate('Description') }}({{ $L['title'] }})
                </label>
                <textarea
                    class="form-control  {{ $errors->has('description.' . $L['id']) ? 'is-invalid' : '' }} footer_text footer_text_{{ $MPS['id'] }}_{{ $data }}"
                    placeholder="{{ translate('Enter Description') }}" id="footer_text_{{ $MPS['id'] }}_{{ $data }}_{{$L['title']}}"
                    name="description[{{ $L['id'] }}][]">  {!! $MetaPageSettingLanguage->content ?? "" !!}
                </textarea>
                @error('description.' . $L['id'])
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

<script type="text/javascript">
    $(function() {
        $('.footer_text').each(function(e) {
            CKEDITOR.replace(this.id, {
                format_tags: 'p;h1;h2;h3;h4;h5;h6;pre;address;div',
                extraPlugins: 'colorbutton,colordialog',
                removeButtons: 'PasteFromWord'
            });
        });
    });
</script>
