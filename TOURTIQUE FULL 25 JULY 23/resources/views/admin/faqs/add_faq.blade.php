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

    <form class="row g-3 " method="POST" action="{{ route('admin.faqs.add') }}" enctype="multipart/form-data">
        @csrf

        <div class="col-lg-12">
            <div class="card mb-3">

                <div class="card-body ">
                    <div class="row">

                        <input id="" name="id" type="hidden" value="{{ $get_faqs['id'] }}" />

                        <div class="col-md-12 content_title">
                            <div class="form-check form-switch pl-0">
                                <input class="form-check-input float-end status switch_button"
                                    {{ getChecked('Active', old('status', $get_faqs['status'])) }} id="status"
                                    type="checkbox" value="Active" name="status">
                                <label class="form-check-label form-label" for="status">{{ translate('Status') }}
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 col-lg-3  content_title box">
                                <label class="form-label" for="price">{{ translate('Faq Category') }} </label>

                                <select class="form-select {{ $errors->has('category') ? 'is-invalid' : '' }}"
                                    name="category" id="category">
                                    <option value="">-- Select category--</option>
                                    @foreach ($get_faq_category as $val)
                                        <option value="{{ $val->id }}"
                                            {{ isset($get_faqs['category']) ? getSelectedInArray($val->id, $get_faqs['category']) : '' }}>
                                            {{ $val->category_name }}</option>
                                    @endforeach
                                </select>

                                @error('category')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>


                       
                        <div class="col-md-6 mt-2">
                            <label class="form-label" for="price">{{ translate('Question') }}
                            </label>

                            <textarea class="form-control footer_text {{ $errors->has('question.' . $lang_id) ? 'is-invalid' : '' }}" rows="8"
                                id="question" name="question[{{ $lang_id }}]" placeholder="Enter Question">{{ getLanguageTranslate($get_faqs_language, $lang_id, $get_faqs['id'], 'question', 'faq_id') }}</textarea>
                            @error('question.' . $lang_id)
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>
                   
                        <div class="col-md-6 mt-2">
                            <label class="form-label" for="price">{{ translate('Answer') }}
                            </label>

                            <textarea class="form-control footer_text {{ $errors->has('answer.' . $lang_id) ? 'is-invalid' : '' }}" rows="8"
                                id="answer" name="answer[{{ $lang_id }}]" placeholder="Enter Answer">{{ getLanguageTranslate($get_faqs_language, $lang_id, $get_faqs['id'], 'answer', 'faq_id') }}</textarea>
                            @error('answer.' . $lang_id)
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>
                        

                        <div class="col-12 d-flex justify-content-end mt-2">
                            <button class="btn btn-primary" type="submit"> <span class="fas fa-save"></span>
                                {{ $common['button'] }}</button>
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
