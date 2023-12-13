@extends('admin.layout.master')
@section('content')
    <form class="row g-3 " method="POST" action="{{ route('admin.blog_page.add') }}" enctype="multipart/form-data">
        @csrf
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
            <a class="btn btn-falcon-primary  backButton float-end" href="javascript:void(0)" onclick="back()"
              type="button"><span class="fas fa-arrow-alt-circle-left text-primary "></span> {{ translate('Back') }}
           </a>        
            <button class="btn btn-success me-1 mb-1 backButton float-end"  type="submit"><span
                  class="fas fa-save"></span>
               {{ $common['button'] }}
            </button>        
        </div>
    </div>

        <div class="add_product add_product-effect-scale add_product-theme-1">
            <input type="radio" name="add_product" checked id="tab1" class="tab-content-first addProTab">
            <label for="tab1" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('General') }}"> <i
             class="icon-general"></i></label>
            <input type="radio" name="add_product" id="tab2" class="tab-content-2 addProTab">
            <label for="tab2" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('Featured Destinations') }}"><i
             class="icon-faq"></i></label>        
            <ul>
                {{-- General Tab  --}}
                <li class="tab-content tab-content-first typography">
                    <div class="col-lg-12">
                        <div class="card mb-3">

                            <div class="card-body ">
                                <div class="row">
                                     <div class="colcss">
                                        <h4 class="text-black mt-2 fw-semi-bold fs-0">{{ translate('Blog Banners') }}</h4>
                                        @php
                                            $data = 0;
                                        @endphp
                                        @foreach ($get_slider_images as $LSI)
                                            @include('admin.blog_page._slider_images')
                                            @php
                                                $data++;
                                            @endphp
                                        @endforeach
                                        @if (count($get_slider_images) == 0)
                                            @include('admin.blog_page._slider_images')
                                        @endif
                                        <div class="show_overview">
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


                {{-- Featured Destinations  --}}
                <li class="tab-content tab-content-2 typography">
                    <div class="col-lg-12">
                       <div class="card mb-3">
                          <div class="card-body ">
                             <div class="row">
                                <h4 class="text-dark">{{ translate('Featured Destinations') }}</h4>
                                <div class="colcss">
                                   @php
                                      $data = 0;
                                   @endphp
                                   @foreach ($get_blog_page_featured as $BPF)
                                      @include('admin.blog_page._features')
                                      @php
                                         $data++;
                                      @endphp
                                   @endforeach
                                   @if (empty($get_blog_page_featured))
                                      @include('admin.blog_page._features')
                                   @endif
                                   <div class="show_works">
                                   </div>
                                   <div class="row">
                                      <div class="col-md-12 add_more_button">
                                          <button class="btn btn-success btn-sm float-end" type="button" id="add_works"
                                            title='Add more'> <span class="fa fa-plus"></span> {{ translate('Add more') }}</button> 
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

    <!-- Banner Overview -->
    <script type="text/javascript">
        $(document).ready(function() {
            var count = 1;
            $('#add_slider').click(function(e) {
                var length = $(".over_view_row").length;
                
                    var ParamArr = {
                        'view': 'admin.blog_page._slider_images',
                        'data': count,
                    }
                    getAppendPage(ParamArr, '.show_overview');
                    e.preventDefault();
                    count++;
                
            });


            $(document).on('click', ".over_view_delete", function(e) {
                var length = $(".over_view_delete").length;
                if (length > 1) {
                    deleteMsg('Are you sure to delete ?').then((result) => {
                        if (result.isConfirmed) {
                            $(this).parent().closest('.over_view_row').remove();
                            e.preventDefault();
                        }
                    });
                }
            });


        });
    </script>


    <!-- How it Work -->
<script type="text/javascript">
   $(document).ready(function() {
       var count = 1;
       $('#add_works').click(function(e) {
   
           var ParamArr = {
               'view': 'admin.blog_page._features',
               'data': count
           }
           getAppendPage(ParamArr, '.show_works');
   
           e.preventDefault();
           count++;
       });
   
   
       $(document).on('click', ".delete_faq", function(e) {
           var length = $(".delete_faq").length;
           if (length > 1) {
               deleteMsg('Are you sure to delete ?').then((result) => {
                   if (result.isConfirmed) {
                       $(this).parent().closest('.faq_div').remove();
                       e.preventDefault();
                   }
               });
           }
       });
   
   
   });
</script>

<script type="text/javascript">
    $(document).ready(function() {

        $('input[name="add_product"]').each(function() {
            $(".typography").css("display", "none");

        })
        $("#tab1").addClass("addProTab");
        $("li.tab-content-first").css("display", "block")

        $(".addProTab").click(function() {
            var ClassName = $(this).removeClass("addProTab").attr("class");

            if ($(this).is(':checked') == true) {
                $('input[name="add_product"]').each(function() {
                    $(".typography").css("display", "none");
                    $(this).addClass("addProTab")
                })
                $("li." + ClassName).css("display", "block");
            }
        })
    });
</script>

@endsection
