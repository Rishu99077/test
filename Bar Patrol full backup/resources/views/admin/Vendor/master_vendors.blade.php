@include('admin.Common.header')
@include('admin.Common.sidebar')
@include('admin.Common.topbar')
<style type="text/css">
  .all_inve_tab thead th:last-child {text-align: left;}
</style>
      <div class="d-flex align-items-center justify-content-between announce_ban bg_black mb_40">
         <div class="">
            <h3 class="f24 mb-0 text-white">Admin Vendors</h3>
         </div>
      </div>
      @foreach (['danger', 'warning', 'success', 'info', 'error'] as $key)
        @if(Session::has($key))
          <p id="success_msg" class="alert alert-{{ $key }}">{{ Session::get($key) }}</p>
        @endif
      @endforeach
      <div class="all_inve_main">
         <form action="">
          @csrf
            <div class="all_inve_tab">
               <table class="table_products">
                  <thead>
                     <tr>
                        <th>Vendor Name</th>
                        <th>Contact Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Restaurant name</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if (!empty($vendors)) { ?>
                     <?php foreach ($vendors as $key => $value) { ?>
                     <tr class="alert alert-dismissible fade show" role="alert">
                        <td class="vendorname">{{$value['vendor_name'];}}</td>
                        <td>{{$value['contact_name'];}}</td>
                        <td>{{$value['email'];}}</td>
                        <td>{{$value['phone_number'];}}</td>
                        <td>{{$value['restaurant_name']}}</td>
                        <td><a onClick="return addconfirm();" id="Add" data-id="{{$value['VendorID']}}" data-name="{{$value['vendor_name'];}}" class="btn btn-success"><i class="fa fa-plus"></i>Add</a></td>
                     </tr>
                     <?php } ?>
                     <?php }else{ ?>
                     <tr class="alert alert-dismissible fade show text-center" role="alert">
                        <td class="text-center" colspan="6">No Vendors</td>
                     </tr>
                     <?php } ?>	
                  </tbody>
               </table>
            </div>
         </form>
         <div class="text-end mt_25">
          <button class="btn btn-secondary" onclick="goBack()">Back</button>
        </div>
      </div>
   </div>
</div>
@include('admin.Common.footer')
<script type="text/javascript">
   function addconfirm(){
        job=confirm("Are you sure to add this Vendor?");
        if(job!=true){
            return false;
        }
    }
</script>

<!-- Location move to master -->
<script type="text/javascript">
  $('body').on("click",'#Add', function(){
      var VendorID = $(this).attr('data-id');
      var Vendor_name = $(this).attr('data-name');
      _token = $("input[name='_token']").val();
      $.ajax({
        url:"{{ url('add_from_master') }}",
        type: 'post',
        data: {'VendorID': VendorID , 'Vendor_name':Vendor_name , '_token':_token},
         success: function(response) {
            window.location.href = "master_vendors";  
         }
      });
      return false;
   
   });
</script>