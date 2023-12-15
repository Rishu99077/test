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
               <a href="{{route('admin.plans.add')}}"><button class="btn btn-secondary">Add new</button></a>
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
         <form class="row g-3 " method="POST" action="{{ route('admin.plans.add') }}" enctype="multipart/form-data">
           @csrf
           <div class="col-lg-12">
               <div class="card mb-3">

                   <div class="card-body ">
                       <div class="row">
                           <input id="" name="id" type="hidden" value="{{ $get_plan['id'] }}" />

                           <div class="col-md-6">
                               <label class="form-label" for="title">Title<span
                                       class="text-danger">*</span>
                               </label>
                               <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                                   placeholder="Title" id="title" name="title" type="text"
                                   value="{{ old('title', $get_plan['title']) }}" />
                               @error('title')
                                   <div class="invalid-feedback">
                                       {{ $message }}
                                   </div>
                               @enderror
                           </div>

                           <div class="col-md-6">
                               <label class="form-label" for="image">Image<span
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
                                           <img src="{{ $get_plan['image'] != '' ? asset('uploads/plan_images/' . $get_plan['image']) : asset('uploads/placeholder/placeholder.png') }}"
                                               id="preview_image" width="200" alt="" />
                                       </div>
                                   </div>
                               </div>
                           </div>


                         
                            <div class="col-md-6">
                               <label class="form-label" for="price">Price<span
                                       class="text-danger">*</span>
                               </label>
                               <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}"
                                   placeholder="Price" id="price" name="price" type="text"
                                   value="{{ old('price', $get_plan['price']) }}" />
                               @error('price')
                                   <div class="invalid-feedback">
                                       {{ $message }}
                                   </div>
                               @enderror
                           </div>

                           <div class="col-md-6">
                               <label class="form-label" for="duration">Duration<span
                                       class="text-danger">*</span>
                               </label>
                               <input class="form-control {{ $errors->has('duration') ? 'is-invalid' : '' }}"
                                   placeholder="Duration" id="duration" name="duration" type="text"
                                   value="{{ old('duration', $get_plan['duration']) }}" />
                               @error('duration')
                                   <div class="invalid-feedback">
                                       {{ $message }}
                                   </div>
                               @enderror
                           </div>

                           <div class="col-md-6">
                               <label class="form-label" for="description">Description<span class="text-danger">*</span> </label>

                               <textarea class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" placeholder="Description" id="description" name="description">{{ old('description', $get_plan['description']) }}</textarea>
                              
                           </div>


                           <div class="col-md-6">
                               <label class="form-label" for="price">Status</label>
                               <br>
                               <select class="form-control form-select single-select" name="status">
                                   <option value="Active">Active</option>
                                   <option value="Deactive"> Deactive </option>
                               </select>
                           </div>
                       </div>
                   </div>
                            <hr>

                    <div class="card-body ">
                        <div class="colcss">
                            <h2>Features</h2>
                            @php
                                $data = 0;
                            @endphp
                            @foreach ($get_plan_features as $PFV)
                                @include('admin.Plans._plan_features')
                                @php
                                    $data++;
                                @endphp
                            @endforeach
                            @if (empty($get_plan_features))
                                @include('admin.Plans._plan_features')
                            @endif
                            <div class="show_features">
                            </div>
                            <div class="row">
                                <div class="col-md-12 add_more_button">
                                    <button class="btn btn-success btn-sm float-end" type="button"
                                        id="add_features" title='Add more'>
                                        <span class="fa fa-plus"></span> Add more</button>
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
<!-- Plam Feature -->
<script type="text/javascript">
    $(document).ready(function() {
        var count = 1;
        $('#add_features').click(function(e) {

            var ParamArr = {
                'view': 'admin.Plans._plan_features',
                'data': count
            }
            getAppendPage(ParamArr, '.show_features');

            e.preventDefault();
            count++;
        });


        $(document).on('click', ".delete_features", function(e) {
            var length = $(".delete_features").length;
            if (length > 1) {
                deleteMsg('Are you sure to delete ?').then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent().closest('.features_div').remove();
                        e.preventDefault();
                    }
                });
            }
        });


    });
</script>    

 <script>
    function getAppendPage(params, appendDiv) {
        $.post("{{ route('admin.get_append_view') }}", {
            params: params,
            _token: "{{ csrf_token() }}"
        }, function(data) {
            console.log(appendDiv);
            $(appendDiv).append(data);
        });
    }
</script>