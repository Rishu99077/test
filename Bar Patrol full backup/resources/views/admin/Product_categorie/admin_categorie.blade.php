@include('admin.Common.header')
@include('admin.Common.sidebar')
@include('admin.Common.topbar')
      <div class="d-flex align-items-center justify-content-between announce_ban bg_black mb_40">
         <div class="">
            <h3 class="f24 mb-0 text-white">All Products categorie Records</h3>
         </div>
         <div class="">
            <?php if ($data['user_details']['user_role']=='1') {?>
            <a href="{{('admin_categorie')}}" class="rec_btn">
              <span class="mr_10"><i class="fa fa-plus"></i> All admin Categories</span>
            </a>
            <?php }elseif ($data['user_details']['user_role']!='1') { ?>
              <a href="{{('master_categorie')}}" class="rec_btn">
                <span class="mr_10"><i class="fa fa-plus"></i> Add from master</span>
              </a>
            <?php } ?>
            <a href="{{('add_productcategorie')}}" class="rec_btn">
              <span class="mr_10"><i class="fa fa-plus"></i> Add New</span>
            </a>
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
               <table>
                  <thead>
                     <tr>
                     	<th>Product type Name</th>
                        <th>Categorie Name</th>
                        <?php if ($data['user_details']['user_role']=='1') {?>
                        <th>Status</th>
                        <?php } ?>
                        <th>Restaurant name</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                  	 <?php if (!empty($admin_products)) { ?>
                     <?php foreach ($admin_products as $key => $value) { ?>
                     <tr class="alert alert-dismissible fade show" role="alert">
                     	  <td>{{$value['product_type_name'];}}</td>
                        <td>{{$value['categorie_name'];}}</td>
                        <?php if ($data['user_details']['user_role']=='1') {?>
                        <td>
                             <?php if ($value['status']==0) { ?>
                                <a onClick="return moveconfirm();" id="Move_master" data-id="{{$value['Categorie_ID']}}" class="btn btn-success">Move to master</a>
                             <?php }elseif ($value['status']==1) { ?> 
                               <a onClick="return remove_confirm();" id="Remove_master" data-id="{{$value['Categorie_ID']}}" class="btn btn-danger">Remove from master</a>
                             <?php } ?>
                        </td>
                        <?php } ?>
                        <td>{{$value['restaurant_name'];}}</td>
                        <td>
                           <div class="d-flex align-items-center inve_ed_del justify-content-center">
                              <a href="{{('add_productcategorie')}}?Categorie_ID={{$value['Categorie_ID']}}"><i class="fa fa-pencil-square-o text-success fa-2x"></i></a>
                              <a href="{{url('delete_categorie')}}?Categorie_ID={{$value['Categorie_ID']}}" onClick="return doconfirm();"><i class="fa fa-trash-o text-danger fa-2x"></i></a>
                           </div>
                        </td>
                     </tr>
                     <?php } ?>
                     <?php }else{ ?>
                     <tr class="alert alert-dismissible fade show text-center" role="alert">
                        <td class="text-center" colspan="6">No Products</td>
                     </tr>
                     <?php } ?>
                  </tbody>
               </table>
            </div>
         </form>
      </div>
   </div>
</div>
@include('admin.Common.footer')
<script type="text/javascript">
   function moveconfirm(){
        job=confirm("Are you sure to move this location into master?");
        if(job!=true){
            return false;
        }
    }

    function remove_confirm(){
        job=confirm("Are you sure to remove this location from master?");
        if(job!=true){
            return false;
        }
    }
</script>

<!-- Location move to master -->
<script type="text/javascript">
  $('body').on("click",'#Move_master', function(){
      var Categorie_ID = $(this).attr('data-id');
       // alert(LocationID);
   
      _token = $("input[name='_token']").val();
      $.ajax({
        url:"{{ url('categorie_movetomaster') }}",
        type: 'post',
        data: {'Categorie_ID': Categorie_ID,'_token':_token},
         success: function(response) {
            window.location.href = "productcategorie";  
         }
      });
      return false;
   
   });
</script>

<!-- location_remove_master -->
<script type="text/javascript">
  $('body').on("click",'#Remove_master', function(){
      var Categorie_ID = $(this).attr('data-id');
       // alert(Categorie_ID);
   
      _token = $("input[name='_token']").val();
      $.ajax({
        url:"{{ url('categorie_remove_master') }}",
        type: 'post',
        data: {'Categorie_ID': Categorie_ID,'_token':_token},
         success: function(response) {
            window.location.href = "productcategorie";  
         }
      });
      return false;
   
   });
</script>