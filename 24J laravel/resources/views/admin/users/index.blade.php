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
               <a href="{{route('admin.user.add')}}"><button class="btn btn-secondary">Add new</button></a>
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
                  <th>Name</th>
                  <th>Email</th>
                  <th>Company Name</th>
                  <th>Contact number</th>
                  <th>Designation</th>
                  <th>Action</th>
               <tr>
            </thead>
            <tbody>
               @if(!$get_users->isEmpty())
                  @foreach($get_users as $key => $value)
                     <tr>
                        <td>{{$value['first_name']}} {{$value['last_name']}}</td>
                        <td>{{$value['email']}}</td>
                        <td>{{$value['company_name']}}</td>
                        <td>{{$value['contact']}}</td>
                        <td>{{$value['designation']}}</td>
                        <td class="text-end">
                             <div>
                                 <a class="btn p-0" href="{{ route('admin.user.edit', $value['id']) }}" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><span class="text-500 fas fa-edit"></span>
                                 </a>

                                 <a class="btn p-0" onclick="return  doconfirm(this);" href="{{ route('admin.user.delete', $value['id']) }}" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><span class="text-500 fas fa-trash-alt"></span>
                                 </a>
                             </div>
                        </td>
                     <tr>
                  @endforeach
               @else
                  <tr>
                     <td colspan="10">No records Found</td>
                  </tr>
               @endif
            </tbody>
         </table>
      </div>
      <div>
           {{ $get_users->appends(request()->query())->links() }}
      </div>
      <!-- /.container-fluid -->
   </section>
   <!-- /.content -->
</div>
@include('admin.layout.footer')


         