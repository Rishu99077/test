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
         <table class="table" >
            <thead>
               <tr>
                  <th>Title</th>
                  <th>Image</th>
                  <th>Status</th>
                  <th>Action</th>
               <tr>
            </thead>
            <tbody>
               @if(!$get_slider->isEmpty())
                  @foreach($get_slider as $key => $value)
                     <tr>
                        <td>{{$value['title']}}</td>
                        <td><img src="{{ $value['image'] != '' ? asset('uploads/slider_images/' . $value['image']) : asset('uploads/placeholder/placeholder.png') }}"
                                               id="preview_image" width="100" alt="" /></td>
                        <td>{{ $value['status'] }}</td>

                        <td class="text-end">
                             <div>
                                 <a class="btn p-0" href="{{ route('admin.slider.edit', $value['id']) }}" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><span class="text-500 fas fa-edit"></span>
                                 </a>

                                 <a class="btn p-0" onclick="return  doconfirm(this);" href="{{ route('admin.slider.delete', $value['id']) }}" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><span class="text-500 fas fa-trash-alt"></span>
                                 </a>
                             </div>
                        </td>
                     <tr>
                  @endforeach
               @else
                  <tr class="text-end">
                     <td colspan="10" class="text-center">No records Found</td>
                  </tr>
               @endif
            </tbody>
         </table>
      </div>
      <div>
           {{ $get_slider->appends(request()->query())->links() }}
      </div>
      <!-- /.container-fluid -->
   </section>
   <!-- /.content -->
</div>
@include('admin.layout.footer')


         