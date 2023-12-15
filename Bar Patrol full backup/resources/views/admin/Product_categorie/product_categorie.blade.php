@include('admin.Common.header')
@include('admin.Common.sidebar')
@include('admin.Common.topbar')
      <?php $Current_user =  $data['user_details']['restaurant_name']; ?>
      <div class="d-flex align-items-center justify-content-between announce_ban bg_black mb_40">
          <div class="">
            <h3 class="f24 mb-0 text-white">All Products categorie</h3>
          </div>
          <div class="">
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

      <div class="row">
          <div class="col-md-6">
              <!-- Current user Categorie -->
              <h2>{{$Current_user}}</h2>
              <div class="all_inve_main">
                    <div class="all_inve_tab">
                       <table>
                          <thead>
                             <tr>
                                <th>#</th>
                                <th>Product type Name</th>
                                <th>Categorie Name</th>
                                <th>Action</th>
                             </tr>
                          </thead>
                          <tbody>
                             <?php if (!empty($user_products)) { $cnt = 1; ?>
                             <?php foreach ($user_products as $key => $value) { ?>
                             <tr class="alert alert-dismissible fade show" role="alert">
                                <td>{{$cnt}}</td>
                                <td>{{$value['product_type_name'];}}</td>
                                <td>{{$value['categorie_name'];}}</td>
                                <td>
                                   <div class="d-flex align-items-center inve_ed_del justify-content-center">
                                      <a href="{{('add_productcategorie')}}?Categorie_ID={{$value['Categorie_ID']}}"><i class="fa fa-pencil-square-o text-success fa-2x"></i></a>
                                      <a href="{{url('delete_categorie')}}?Categorie_ID={{$value['Categorie_ID']}}" onClick="return doconfirm();"><i class="fa fa-trash-o text-danger fa-2x"></i></a>
                                   </div>
                                </td>
                             </tr>
                             <?php $cnt++; } ?>
                             <?php }else{ ?>
                             <tr class="alert alert-dismissible fade show text-center" role="alert">
                                <td class="text-center" colspan="6">No Categories</td>
                             </tr>
                             <?php } ?>
                          </tbody>
                       </table>
                    </div>
              </div>
          </div>
          <div class="col-md-6">
              <?php if ($data['user_details']['user_role']=='1') {?>
                  <h2>All Restaurant categories</h2>
                  <div class="all_inve_main">
                      <div class="all_inve_tab">
                         <table>
                            <thead>
                               <tr>
                                  <th>#</th>
                                  <th>Product type Name</th>
                                  <th>Categorie Name</th>
                                  <th>Status</th>
                                  <th>Restaurant name</th>
                                  <th>Action</th>
                               </tr>
                            </thead>
                            <tbody>
                               <?php if (!empty($admin_products)) { $cnt = 1; ?>
                               <?php foreach ($admin_products as $key => $value) { ?>
                               <tr class="alert alert-dismissible fade show" role="alert">
                                  <td>{{$cnt}}</td>
                                  <td>{{$value['product_type_name'];}}</td>
                                  <td>{{$value['categorie_name'];}}</td>
                                  <td>
                                       <?php if ($value['status']==0) { ?>
                                          <a onClick="return moveconfirm();" id="Move_master" data-id="{{$value['Categorie_ID']}}" data-name="{{$value['categorie_name'];}}" class="btn btn-success">Move to master</a>
                                       <?php }elseif ($value['status']==1) { ?> 
                                         <a onClick="return remove_confirm();" id="Remove_master" data-id="{{$value['Categorie_ID']}}" data-name="{{$value['categorie_name'];}}" class="btn btn-danger">Remove from master</a>
                                       <?php } ?>
                                  </td>
                                  <td>{{$value['restaurant_name'];}}</td>
                                  <td>
                                     <div class="d-flex align-items-center inve_ed_del justify-content-center">
                                        <a href="{{('add_productcategorie')}}?Categorie_ID={{$value['Categorie_ID']}}"><i class="fa fa-pencil-square-o text-success fa-2x"></i></a>
                                        <a href="{{url('delete_categorie')}}?Categorie_ID={{$value['Categorie_ID']}}" onClick="return doconfirm();"><i class="fa fa-trash-o text-danger fa-2x"></i></a>
                                     </div>
                                  </td>
                               </tr>
                               <?php $cnt++; } ?>
                               <?php }else{ ?>
                               <tr class="alert alert-dismissible fade show text-center" role="alert">
                                  <td class="text-center" colspan="6">No Categories</td>
                               </tr>
                               <?php } ?>
                            </tbody>
                         </table>
                      </div>
                  </div>
              <?php }elseif ($data['user_details']['user_role']!='1') { ?>
                  <h2>Master categories</h2>
                  <div class="all_inve_main">
                      <div class="all_inve_tab">
                         <table>
                            <thead>
                               <tr>
                                  <th>#</th>
                                  <th>Product type Name</th>
                                  <th>Categorie Name</th>
                                  <th style="text-align: left;">Action</th>
                               </tr>
                            </thead>
                            <tbody>
                               <?php if (!empty($master_products)) { $cnt = 1; ?>
                               <?php foreach ($master_products as $key => $value) { ?>
                               <tr class="alert alert-dismissible fade show" role="alert">
                                  <td>{{$cnt}}</td>
                                  <td>{{$value['product_type_name'];}}</td>
                                  <td>{{$value['categorie_name'];}}</td>
                          
                                  <td><a onClick="return addconfirm();" id="Add" data-id="{{$value['Categorie_ID']}}" data-name="{{$value['categorie_name'];}}" class="btn btn-success"><i class="fa fa-plus"></i>Add</a></td>
                               </tr>
                               <?php $cnt++; } ?>
                               <?php }else{ ?>
                               <tr class="alert alert-dismissible fade show text-center" role="alert">
                                  <td class="text-center" colspan="6">No Categorie</td>
                               </tr>
                               <?php } ?>
                            </tbody>
                         </table>
                      </div>
                  </div>
              <?php } ?>
          </div>
      </div>
   </div>
</div>
@include('admin.Common.footer')
<script type="text/javascript">
    function addconfirm(){
        job=confirm("Are you sure to add this categorie?");
        if(job!=true){
            return false;
        }
    }

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

<!-- Product categories move to master -->
<script type="text/javascript">

   $('body').on("click",'#Add', function(){
      var Categorie_ID = $(this).attr('data-id');
      var categorie_name = $(this).attr('data-name');
      _token = $("input[name='_token']").val();
      $.ajax({
        url:"{{ url('addcategorie_from_master') }}",
        type: 'post',
        data: {'Categorie_ID': Categorie_ID , 'categorie_name':categorie_name , '_token':_token},
         success: function(response) {
            window.location.href = "productcategorie";  
         }
      });
      return false;
   
   });

   $('body').on("click",'#Move_master', function(){
      var Categorie_ID = $(this).attr('data-id');
      var categorie_name = $(this).attr('data-name');
   
      _token = $("input[name='_token']").val();
      $.ajax({
        url:"{{ url('categorie_movetomaster') }}",
        type: 'post',
        data: {'Categorie_ID': Categorie_ID , 'categorie_name':categorie_name , '_token':_token},
         success: function(response) {
            window.location.href = "productcategorie";  
         }
      });
      return false;
   
   });

   $('body').on("click",'#Remove_master', function(){
      var Categorie_ID = $(this).attr('data-id');
      var categorie_name = $(this).attr('data-name');
   
      _token = $("input[name='_token']").val();
      $.ajax({
        url:"{{ url('categorie_remove_master') }}",
        type: 'post',
        data: {'Categorie_ID': Categorie_ID , 'categorie_name':categorie_name , '_token':_token},
         success: function(response) {
            window.location.href = "productcategorie";  
         }
      });
      return false;
   
   });
</script>