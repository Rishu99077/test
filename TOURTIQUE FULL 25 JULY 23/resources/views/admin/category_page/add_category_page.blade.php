@extends('admin.layout.master')
@section('content')
<form  method="POST" action="{{ route('admin.category_page.add') }}" enctype="multipart/form-data">
   @csrf
   <ul class="breadcrumb">
            <li>
              <a href="#" style="width: auto;">
                  <span class="text">{{ $common['language_title'] }} <img src="{{ url('uploads/language_flag', $common['language_flag']) }}" class="lang_img"></span>
              </a>
            </li>  
      <li>
         <a href="#" style="width: auto;">
         <span class="text">{{ $common['title'] }}</span>
         </a>
      </li>
      <li>
         <a href="javascript:void(0)">
         {{ Session::get('TopMenu') }}
         </a>
      </li>
      <li>
         <a href="{{ route('admin.dashboard') }}">
         <span class="fa fa-home"></span>
         </a>
      </li>
   </ul>

   <a class="btn btn-falcon-primary  backButton float-end" href="javascript:void(0)" onclick="back()"
      type="button"><span class="fas fa-arrow-alt-circle-left text-primary "></span> {{ translate('Back') }}
   </a>
   <button class="btn btn-success me-1 mb-1 backButton float-end"  type="submit"><span class="fas fa-save"></span> 
      {{ $common['button'] }}
   </button>

   <div class="add_product add_product-effect-scale add_product-theme-1">
    
      <input type="radio" name="add_product" checked id="tab1" class="tab-content-first addProTab">
      <label for="tab1" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('Category Slider Images') }}"> <i
         class="icon-images"></i></label>

      
      <ul>
         {{-- General Tab  --}}
         <li class="tab-content tab-content-first typography">
            <div class="col-lg-12">
               <div class="card mb-3">
                  <div class="card-body ">
                     <div class="row">
                        <h4 class="text-dark">{{ translate('Category Page Slider details') }}</h4>
                        <div class="colcss">
                            @php
                                $data = 0;
                            @endphp
                            @foreach ($get_slider_images as $LSI)
                                @include('admin.category_page._slider_images')
                                @php
                                    $data++;
                                @endphp
                            @endforeach
                            @if (count($get_slider_images) == 0)
                                @include('admin.category_page._slider_images')
                            @endif
                            <div class="show_sliders">
                            </div>
                            <div class="row">
                                <div class="col-md-12 add_more_button">
                                    <button class="btn btn-success btn-sm float-end" type="button"
                                        id="add_slider" title='Add more'>
                                        <span class="fa fa-plus"></span> {{ translate('Add more') }}</button>
                                </div>
                            </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </li>

         
         
      </ul>
   </div>
   
</form>

<script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replaceAll('footer_text');
</script>






<!-- Slider Overview -->
  <script type="text/javascript">
      $(document).ready(function() {
          var count = 1;
          $('#add_slider').click(function(e) {
              var length = $(".category_slider_row").length;
              
                  var ParamArr = {
                      'view': 'admin.category_page._slider_images',
                      'data': count,
                  }
                  getAppendPage(ParamArr, '.show_sliders');
                  e.preventDefault();
                  count++;
              
          });


          $(document).on('click', ".category_slider_delete", function(e) {
              var length = $(".category_slider_row").length;
              if (length > 1) {
                  deleteMsg('Are you sure to delete ?').then((result) => {
                      if (result.isConfirmed) {
                          $(this).parent().closest('.category_slider_row').remove();
                          e.preventDefault();
                      }
                  });
              }
          });


      });
  </script>
<!-- End Slider Overview -->

@endsection