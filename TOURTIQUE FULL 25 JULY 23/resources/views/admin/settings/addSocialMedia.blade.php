@extends('admin.layout.master')
@section('content')
    <div class="d-flex justify-content-between">
        <ul class="breadcrumb mb-2 ">
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

    <form class="row g-3 " method="POST" action="{{ route('admin.social_media.add') }}" enctype="multipart/form-data">
        @csrf

        <div class="col-lg-12">
            <div class="card mb-3">

                <div class="card-body ">
                    <div class="row">

                        <input id="" name="id" type="hidden" value="{{ $get_social_media['id'] }}" />

                        <div class="col-md-12 content_title ">
                            <label class="form-label" for="price">{{ translate('Copyright Title') }} </label>
                            <div class="input-group mb-3">
                                <input class="form-control " type="text" name="copyright_title" aria-describedby="basic-addon2"
                                    value="{{ $get_social_media['copyright_title'] }}" id="copyright_title" />

                                <div class="invalid-feedback">
                                </div>
                            </div>

                        </div>


                        <div class="row">
                            <div class="colcss">
                              @php
                                 $data = 0;
                              @endphp
                                 @foreach ($get_social_media_links as $SML)
                                   @include('admin.settings._media')
                                   @php
                                     $data++;
                                   @endphp
                                 @endforeach
                               @if (empty($get_social_media_links))
                                 @include('admin.settings._media')
                               @endif
                               <div class="show_media">
                               </div>
                               <div class="row">
                                  <div class="col-md-12 add_more_button">
                                     <button class="btn btn-success btn-sm float-end" type="button" id="add_media"
                                        title='Add more'>
                                     <span class="fa fa-plus"></span> {{ translate('Add more') }}</button>
                                  </div>
                               </div>
                            </div>
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

<!-- How it Work -->
<script type="text/javascript">
   $(document).ready(function() {
       var count = 1;
       $('#add_media').click(function(e) {
   
           var ParamArr = {
               'view': 'admin.settings._media',
               'data': count
           }
           getAppendPage(ParamArr, '.show_media');
   
           e.preventDefault();
           count++;
       });
   
   
       $(document).on('click', ".delete_media", function(e) {
            var length = $(".delete_media").length;

           if (length > 1) {
               deleteMsg('Are you sure to delete ?').then((result) => {
                   if (result.isConfirmed) {
                       $(this).parent().closest('.media_div').remove();
                       e.preventDefault();
                   }
               });
           }
       });
   
   
   });
</script>
@endsection
