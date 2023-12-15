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
         <form class="row g-3 " method="POST" action="{{ route('admin.user.add') }}" enctype="multipart/form-data">
           @csrf
           <div class="col-lg-12">
               <div class="card mb-3">
                    <div class="card-body ">
                        <div class="row">
                            <input id="" name="id" type="hidden" value="{{ $get_user['id'] }}" />


                            <div class="col-md-9">
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
                               <div class="col-lg-4 mt-2">
                                   <div class="avatar shadow-sm img-thumbnail position-relative blog-image-cls">
                                       <div class="h-100 w-100  overflow-hidden position-relative">
                                           <img src="{{ $get_user['image'] != '' ? asset('uploads/users/' . $get_user['image']) : asset('uploads/placeholder/placeholder.png') }}"
                                               id="preview_image" width="200" alt="" />
                                       </div>
                                   </div>
                               </div>
                            </div>


                            <div class="col-md-4">
                               <label class="form-label" for="prefix">Prefix<span class="text-danger">*</span></label>
                               <input class="form-control" placeholder="Prefix" id="prefix" name="prefix" type="text" value="{{ old('prefix', $get_user['prefix']) }}" />
                            </div>

                            <div class="col-md-4">
                               <label class="form-label" for="first_name">First Name<span class="text-danger">*</span> </label>
                               <input class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}"
                                   placeholder="first_name" id="first_name" name="first_name" type="text"
                                   value="{{ old('first_name', $get_user['first_name']) }}" />
                               @error('first_name')
                                   <div class="invalid-feedback">
                                       {{ $message }}
                                   </div>
                               @enderror
                            </div>

                            <div class="col-md-4">
                               <label class="form-label" for="last_name">Last name<span class="text-danger">*</span> </label>
                               <input class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}"
                                   placeholder="Last name" id="last_name" name="last_name" type="text"
                                   value="{{ old('last_name', $get_user['last_name']) }}" />
                               @error('last_name')
                                   <div class="invalid-feedback">
                                       {{ $message }}
                                   </div>
                               @enderror
                            </div>

                            <div class="col-md-6">
                               <label class="form-label" for="email">Email<span class="text-danger">*</span> </label>
                               <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                   placeholder="Email" id="email" name="email" type="email"
                                   value="{{ old('email', $get_user['email']) }}" />
                               @error('email')
                                   <div class="invalid-feedback">
                                       {{ $message }}
                                   </div>
                               @enderror
                            </div>

                            @if($get_user['id']=='')
                                <div class="col-md-6">
                                   <label class="form-label" for="password">Password<span class="text-danger">*</span> </label>
                                   <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                       placeholder="Password" id="password" name="email" type="password"
                                       value="{{ old('password', $get_user['password']) }}" />
                                   @error('password')
                                       <div class="invalid-feedback">
                                           {{ $message }}
                                       </div>
                                   @enderror
                                </div>
                            @endif    


                            <div class="col-md-6">
                               <label class="form-label" for="company_name">Company </label>
                               <input class="form-control"
                                   placeholder="Company" id="company_name" name="company_name" type="company_name"
                                   value="{{ old('company_name', $get_user['company_name']) }}" />
                              
                            </div>

                            <div class="col-md-6">
                               <label class="form-label" for="designation">Designation </label>
                               <input class="form-control"
                                   placeholder="Designation" id="designation" name="designation" type="designation"
                                   value="{{ old('designation', $get_user['designation']) }}" />
                              
                            </div>

                            <div class="col-md-6">
                               <label class="form-label" for="contact">Contact </label>
                               <input class="form-control"
                                   placeholder="Contact" id="contact" name="contact" type="contact"
                                   value="{{ old('contact', $get_user['contact']) }}" />
                              
                            </div>

                            <div class="col-md-6">
                               <label class="form-label" for="price">Status</label>
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