@include('admin.layout.header')
@include('admin.layout.top_bar')
@include('admin.layout.sidebar')
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1 class="m-0 text-dark">{{$common['heading_title']}}</h1>
            </div>
            <div class="col-sm-6 text-right">
               <a href="{{route('admin.slider.add')}}"><button class="btn btn-secondary">Add new</button></a>
            </div>
            <!-- /.col -->
         </div>
         <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
   </div>
   <!-- /.content-header -->
   <!-- Main content -->
   <section class="content">
      <div class="container-fluid">
         <form class="row g-3 " method="POST" action="{{ route('admin.slider.add') }}" enctype="multipart/form-data">
           @csrf
           <div class="col-lg-12">
               <div class="card mb-3">

                   <div class="card-body ">
                       <div class="row">
                           <input id="" name="id" type="hidden" value="{{ $get_slider['id'] }}" />
                           <div class="col-md-4">
                               <label class="form-label" for="title">Full Name<span
                                       class="text-danger">*</span>
                               </label>
                               <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                                   placeholder="Full Name" id="title" name="title" type="text"
                                   value="{{ old('title', $get_slider['title']) }}" />
                               @error('title')
                                   <div class="invalid-feedback">
                                       {{ $message }}
                                   </div>
                               @enderror
                           </div>

                         
                        
                           <div class="col-md-4">
                               <label class="form-label" for="image">Slider Image<span
                                       class="text-danger">*</span>
                               </label>
                               <input type="file"  name="image" onchange="loadFile(event,'preview_image')"
                                   class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}">
                               @error('image')
                                   <div class="invalid-feedback">
                                       {{ $message }}
                                   </div>
                               @enderror
                               <div class="col-lg-12 mt-2">
                                   <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                                       <div class="h-100 w-100  overflow-hidden position-relative">
                                           <img src="{{ $get_slider['image'] != '' ? asset('uploads/slider_images/' . $get_slider['image']) : asset('uploads/placeholder/placeholder.png') }}"
                                               id="preview_image" width="200" alt="" />
                                       </div>
                                   </div>
                               </div>
                           </div>


                           <div class="col-md-4">
                               <label class="form-label" for="price">Status </label>
                               <br>
                               <select class="form-control form-select single-select" name="status">
                                   <option value="Active">Active</option>
                                   <option value="Deactive"> Deactive </option>
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
      </div>
      <!-- /.container-fluid -->
   </section>
   <!-- /.content -->
</div>
@include('admin.layout.footer')
 <script type="text/javascript">
        var loadFile = function(event, id) {
            var image = document.getElementById(id);
            image.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>