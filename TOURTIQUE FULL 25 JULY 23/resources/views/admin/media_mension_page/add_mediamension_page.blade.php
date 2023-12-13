@extends('admin.layout.master')
@section('content')
<form  method="POST" action="{{ route('admin.media_mension_page.add') }}" enctype="multipart/form-data">
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
      type="button"><span class="fas fa-arrow-alt-circle-left text-primary "></span> {{ translate('Back')}}
   </a>
   <button class="btn btn-success me-1 mb-1 backButton float-end"  type="submit"><span
      class="fas fa-save"></span>
   {{ $common['button'] }}
   </button>

   <div class="add_product add_product-effect-scale add_product-theme-1">
      <input type="radio" name="add_product" checked id="tab1" class="tab-content-first addProTab">
      <label for="tab1" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('Media Mensions Slider Images') }}"> <i
         class="icon-general"></i></label>

      <input type="radio" name="add_product" id="tab3" class="tab-content-3 addProTab">
      <label for="tab3" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('Media Mensions Articles') }}"><i
         class="icon-highlight"></i></label>

      <input type="radio" name="add_product" id="tab5" class="tab-content-5 addProTab">
      <label for="tab5" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('Media Blog') }}"><i
         class="icon-faq"></i></label>    
      
      <input type="radio" name="add_product" id="tab4" class="tab-content-4 addProTab">
      <label for="tab4" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ translate('Media Mensions Social') }}"><i
         class="fa-sharp fa-solid fa-comments"></i></label>   
      <ul>

         {{-- Media Mensions silder  --}}           
         <li class="tab-content tab-content-first typography">
           <div class="col-lg-12">
               <div class="card mb-3">
                  <div class="card-body ">
                     <div class="row">
                        <h4 class="text-dark">{{ translate('Media Page Slider details') }}</h4>
                        <input id="" name="id" type="hidden" value="{{ $get_media_mension_page['id'] }}" />
                        <div class="colcss">
                            @php
                                $data = 0;
                            @endphp
                            @foreach ($get_slider_images as $LSI)
                                @include('admin.media_mension_page._slider_images')
                                @php
                                    $data++;
                                @endphp
                            @endforeach
                            @if (count($get_slider_images) == 0)
                                @include('admin.media_mension_page._slider_images')
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
         {{-- Media Mensions silder  --}}   


         {{-- Media Mensions Articles  --}}
         <li class="tab-content tab-content-3 typography">
            <div class="col-lg-12">
               <div class="card mb-3">
                  <div class="card-body ">
                     <div class="row">
                        <h4 class="text-dark">{{ translate('Articles') }}</h4>

                        
                        <div class="col-md-6">
                           <label class="form-label" for="article_heading_title">{{ translate('Article Title') }}</label>
                           <input class="form-control"
                              placeholder="{{ translate('Article Title') }}" id="article_heading_title" name="article_heading_title[{{ $lang_id }}]"
                              type="text"
                              value="{{ getLanguageTranslate($get_media_mension_page_language, $lang_id, $get_media_mension_page['id'], 'article_heading_title', 'media_mension_id') }}" />
                        </div>
                        

                        <div class="colcss">
                          @php
                             $data = 0;
                          @endphp
                             @foreach ($get_media_page_article as $GPF)
                               @include('admin.media_mension_page._articles')
                               @php
                                 $data++;
                               @endphp
                             @endforeach
                           @if (empty($get_media_page_article))
                             @include('admin.media_mension_page._articles')
                           @endif
                           <div class="show_works">
                           </div>
                           <div class="row">
                              <div class="col-md-12 add_more_button">
                                 <button class="btn btn-success btn-sm float-end" type="button" id="add_works"
                                    title='Add more'>
                                 <span class="fa fa-plus"></span> {{ translate('Add more') }}</button>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </li>

         {{-- Media Mensions Social  --}}
         <li class="tab-content tab-content-4 typography">
            <div class="col-lg-12">
               <div class="card mb-3">
                  <div class="card-body ">
                     <div class="row">
                        <h4 class="text-dark">{{ translate('Media Mensions Social') }}</h4>
                        <div class="colcss">
                          @php
                             $data = 0;
                          @endphp
                             @foreach ($get_medial_social as $media_mension_social)
                               @include('admin.media_mension_page._social_link')
                               @php
                                 $data++;
                               @endphp
                             @endforeach
                           @if ($get_medial_social->isEmpty())
                             @include('admin.media_mension_page._social_link')
                           @endif
                           <div class="show_media">
                           </div>
                           <div class="row">
                              <div class="col-md-12 add_more_button">
                                 <button class="btn btn-success btn-sm float-end" type="button" id="add_more_icons"
                                    title='Add more'>
                                 <span class="fa fa-plus"></span> {{ translate('Add more') }}</button>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </li>

         {{-- Media Blog  --}}
         <li class="tab-content tab-content-5 typography">
            <div class="col-lg-12">
               <div class="card mb-3">
                  <div class="card-body ">
                     <div class="row">
                        <h4 class="text-dark">{{ translate('Media Blogs') }}</h4>

                        <div class="col-md-6">
                           <label class="form-label" for="blog_heading_title">{{ translate('Media Blog heading Title') }}</label>
                           <input class="form-control"
                              placeholder="{{ translate('Media Blog heading Title') }}" id="blog_heading_title" name="blog_heading_title[{{ $lang_id }}]"
                              type="text"
                              value="{{ getLanguageTranslate($get_media_mension_page_language, $lang_id, $get_media_mension_page['id'], 'blog_heading_title', 'media_mension_id') }}" />
                        </div>
                        
                        <div class="colcss">
                          @php
                             $data = 0;
                          @endphp
                             @foreach ($get_media_blog as $MBD)
                               @include('admin.media_mension_page._media_blog')
                               @php
                                 $data++;
                               @endphp
                             @endforeach
                           @if ($get_media_blog->isEmpty())
                             @include('admin.media_mension_page._media_blog')
                           @endif
                           <div class="show_media_blogs">
                           </div>
                           <div class="row">
                              <div class="col-md-12 add_more_button">
                                 <button class="btn btn-success btn-sm float-end" type="button" id="add_more_blogs"
                                    title='Add more'>
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

<!-- Slider Images -->
<script>
   $(document).ready(function() {
       if (window.File && window.FileList && window.FileReader) {
           $("#files").on("change", function(e) {
               var files = e.target.files,
                   filesLength = files.length;
               for (var i = 0; i < filesLength; i++) {
                   var f = files[i]
                   var fileReader = new FileReader();
                   fileReader.onload = (function(e) {
                       var file = e.target;
                       var html =
                           "<div class='col-md-2'><div class='image-item upload_img_list'>" +
                           "<img src=' " +
                           e.target.result + "' alt='' width='20' title='" + file.name +
                           "'>" + "<div class='image-item__btn-wrapper'>" +
                           "<button type='button' class='btn btn-default remove btn-sm'>" +
                           "<i class='fa fa-times' aria-hidden='true'></i>" +
                           "</button>" +
                           "</div>" +
                           "</div>" +
                           "</div>";
                       // $(html).insertAfter(".appenImage");
                       $(".appenImage").append(html);
                   });
                   fileReader.readAsDataURL(f);
               }
   
           });
       } else {
           alert("Your browser doesn't support to File API")
       }
       $(document).on("click", ".remove", function() {
           $(this).closest(".col-md-2").remove();
       });
   });
</script>

<!-- How it Work -->
<script type="text/javascript">
   $(document).ready(function() {
       var count = 1;
       $('#add_works').click(function(e) {   
           var ParamArr = {
               'view': 'admin.media_mension_page._articles',
               'data': count
           }
           getAppendPage(ParamArr, '.show_works');   
           e.preventDefault();
           count++;
       });

       $('#add_more_icons').click(function(e) {   
           var ParamArr = {
               'view': 'admin.media_mension_page._social_link',
               'data': count
           }
           getAppendPage(ParamArr, '.show_media');   
           e.preventDefault();
           count++;
       });
   
   
       $(document).on('click', ".delete_media", function(e) {
           var length = $(".delete_media").length;
           console.log('length',length);
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

<!-- BLOGS -->
<script type="text/javascript">
   $(document).ready(function() {
       var count = 1;
       $('#add_more_blogs').click(function(e) {   
           var ParamArr = {
               'view': 'admin.media_mension_page._media_blog',
               'data': count
           }
           getAppendPage(ParamArr, '.show_media_blogs');   
           e.preventDefault();
           count++;
       });
   
       $(document).on('click', ".delete_media_blog", function(e) {
           var length = $(".delete_media_blog").length;
           console.log('length',length);
           if (length > 1) {
               deleteMsg('Are you sure to delete ?').then((result) => {
                   if (result.isConfirmed) {
                       $(this).parent().closest('.media_blog_div').remove();
                       e.preventDefault();
                   }
               });
           }
       });
   
   
   });
</script>


<!-- Slider Overview -->
<script type="text/javascript">
    $(document).ready(function() {
        var count = 1;
        $('#add_slider').click(function(e) {
            var length = $(".over_view_row").length;
            
                var ParamArr = {
                    'view': 'admin.media_mension_page._slider_images',
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

@endsection