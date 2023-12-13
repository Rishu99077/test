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
    <form class="row g-3 " method="POST" action="{{ route('admin.legal_stuff.add') }}" enctype="multipart/form-data">
        @csrf

        <div class="col-lg-12">
            <div class="card mb-3">

                <div class="card-body ">
                    <div class="row">
                        <input id="" name="id" type="hidden" value="{{ $get_legal_stuff['id'] }}" />

                        <div class="col-md-6">
                            <label class="form-label" for="title">{{ translate('Name') }}<span
                                    class="text-danger">*</span>
                            </label>
                            <input class="form-control {{ $errors->has('name.' . $lang_id) ? 'is-invalid' : '' }}"
                                placeholder="{{ translate('Name') }}" id="name" name="name[{{ $lang_id }}]"
                                type="text"
                                value="{{ getLanguageTranslate($get_legal_stuff_language, $lang_id, $get_legal_stuff['id'], 'name', 'legal_stuff_id') }}" />
                            @error('name.' . $lang_id)
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    
                        <div class="col-md-6">
                            <label class="form-label" for="price">{{ translate('Description') }} </label>

                             <textarea class="form-control description{{ $errors->has('description.' . $lang_id) ? 'is-invalid' : '' }}" rows="8" id="description" name="description[{{ $lang_id }}]" placeholder="Enter Description">{{ getLanguageTranslate($get_legal_stuff_language, $lang_id, $get_legal_stuff['id'], 'description', 'legal_stuff_id') }}</textarea>
                            @error('description.' . $lang_id)
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="price">Status </label>
                            <select class="form-select single-select" name="status">
                                <option value="Active">Active</option>
                                <option value="Deactive"{{ $get_legal_stuff['status'] == 'Deactive' ? 'selected' : '' }}> Deactive </option>
                            </select>
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
    <script src="{{ asset('assets/plugins/ckeditor/ckeditor.js') }}"></script>

<script>
    $(document).ready(function() {
        CKEDITOR.replaceAll('description');
    });
</script>
@endsection
