@include('admin.Common.header')
@include('admin.Common.sidebar')
@include('admin.Common.topbar')
      <div class="d-flex align-items-center justify-content-between announce_ban bg_black mb_40">
         <div class="">
            <h3 class="f24 mb-0 text-white">All Admin Products</h3>
         </div>
         <div class="">
            <button class="btn btn-primary" onclick="goBack()">Back</button>
         </div>
      </div>
      @foreach (['danger', 'warning', 'success', 'info', 'error'] as $key)
      @if(Session::has($key))
      <p id="success_msg" class="alert alert-{{ $key }}">{{ Session::get($key) }}</p>
      @endif
      @endforeach
      <?php
       @$ProductSearch = $_GET['ProductSearch'];
       @$Productcode = $_GET['Productcode'];
       @$Productcategory = $_GET['Productcategory'];
      ?>
      <form action="{{url('admin_products')}}" method="get">
        <div class="row">
            <div class="col-md-6">
              <div class="row">
                  <div class="add_inve_box col-md-4 ">
                    <label>Product name</label>
                    <input type="text" name="ProductSearch" class="form-control Search_items" placeholder="Search by product name" value="<?php if (@$ProductSearch != ''){
                      echo $ProductSearch ; } ?>">
                  </div>
                  <div class="add_inve_box col-md-4 ">
                      <label>Product code</label>
                      <input type="text" name="Productcode" class="form-control Search_items" placeholder="Search by product code" value="<?php if (@$Productcode != ''){
                        echo $Productcode ; } ?>">
                  </div> 
                  <div class="add_inve_box col-md-4 ">
                      <label>Product category</label>
                      <select class="form-control select2box Search_items"  name="Productcategory">
                        <option value="">-- Select categorie --</option>
                        <?php foreach ($get_productscategories as $type_key => $val_cat) { ?>
                        <option value="<?php echo $val_cat['Categorie_ID']; ?>" <?php if ($Productcategory ==  $val_cat['Categorie_ID'] ) echo 'selected' ; ?>><?php echo $val_cat['categorie_name']; ?></option>
                        <?php } ?>
                     </select>
                  </div> 
              </div>
            </div>
            <div class="col-md-2 mt-4">
              <div class="row">
                  <div class="add_inve_box col-md-12">
                      <label></label>
                      <button type="submit" class="btn btn-success">Search</button>
                      <a id="clear" href="{{('admin_products')}}" class="btn btn-danger clear">Clear</a>
                  </div>
              </div>
            </div>
        </div>
      </form>
      <div class="all_inve_main">
         <form action="">
            @csrf
            <div class="all_inve_tab">
               <table>
                  <thead>
                     <tr>
                        <th>#</th>
                        <th>Product Name</th>
                        <th>Product Code</th>
                        <th>Product type</th>
                        <th>Product Categorie</th>
                        <th>Container type</th>
                        <th>Container size</th>
                        <th>Units</th>
                        <th>Vendor</th>
                        <?php if ($data['user_details']['user_role']=='1') {?>
                        <th>Status</th>
                        <?php } ?>
                        <th>Restaurant name</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if (!empty($products)) { $cnt = 1;?>
                     <?php foreach ($products as $key => $value) { ?>
                     <tr class="alert alert-dismissible fade show" role="alert">
                        <td>{{$cnt;}}</td>
                        <td>{{$value['product_name'];}}</td>
                        <td>{{$value['product_code'];}}</td>
                        <td>{{$value['product_type_name']}}</td>
                        <td>{{$value['categorie_name'];}}</td>
                        <td>{{$value['container_type'];}}</td>
                        <td>{{$value['container_size'];}}</td>
                        <td>{{$value['units'];}}</td>
                        <td>{{$value['vendor_name'];}}</td>
                        <?php if ($data['user_details']['user_role']=='1') {?>
                          <td>
                             <?php if ($value['status']==0) { ?>
                                <a onClick="return moveconfirm();" id="Move_master" data-id="{{$value['ProductID']}}" data-name="{{$value['product_name'];}}" class="btn btn-success">Move to master</a>
                             <?php }elseif ($value['status']==1) { ?> 
                               <a onClick="return remove_confirm();" id="Remove_master" data-id="{{$value['ProductID']}}" data-name="{{$value['product_name'];}}" class="btn btn-danger">Remove from master</a>
                             <?php } ?>
                          </td>
                        <?php $cnt++; } ?>
                        <td>{{$value['restaurant_name']}}</td>
                        <td>
                           <div class="d-flex align-items-center inve_ed_del justify-content-center">
                              <a href="{{('add_product')}}?ProductID={{$value['ProductID']}}">
                                 <span class="inven_svg edit_inven">
                                    <svg id="fi-rr-edit" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                                       <path id="Path_566" data-name="Path 566" d="M15.242.709,6.1,9.853A3.725,3.725,0,0,0,5,12.5v1.007a.75.75,0,0,0,.75.75H6.757a3.724,3.724,0,0,0,2.651-1.1l9.144-9.144a2.344,2.344,0,0,0,0-3.31,2.4,2.4,0,0,0-3.31,0Zm2.25,2.25L8.348,12.1a2.265,2.265,0,0,1-1.591.658H6.5V12.5a2.265,2.265,0,0,1,.658-1.591L16.3,1.769a.861.861,0,0,1,1.19,0,.842.842,0,0,1,0,1.189Z" transform="translate(-1.25 -0.011)" fill="#009e10"/>
                                       <path id="Path_567" data-name="Path 567" d="M17.25,6.734a.75.75,0,0,0-.75.75V11.25h-3a2.25,2.25,0,0,0-2.25,2.25v3H3.75A2.25,2.25,0,0,1,1.5,14.25V3.75A2.25,2.25,0,0,1,3.75,1.5h6.781a.75.75,0,1,0,0-1.5H3.75A3.754,3.754,0,0,0,0,3.75v10.5A3.754,3.754,0,0,0,3.75,18h8.507a3.726,3.726,0,0,0,2.652-1.1L16.9,14.908A3.726,3.726,0,0,0,18,12.257V7.484A.75.75,0,0,0,17.25,6.734Zm-3.4,9.107a2.231,2.231,0,0,1-1.1.6V13.5a.75.75,0,0,1,.75-.75h2.944a2.262,2.262,0,0,1-.6,1.1Z" fill="#009e10"/>
                                    </svg>
                                 </span>
                              </a>
                              <a href="{{url('delete_product')}}?ProductID={{$value['ProductID']}}" onClick="return doconfirm();">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="15" height="18" viewBox="0 0 15 18">
                                    <g id="fi-rr-trash" transform="translate(-2)">
                                       <path id="Path_568" data-name="Path 568" d="M16.25,3H13.925A3.757,3.757,0,0,0,10.25,0H8.75A3.757,3.757,0,0,0,5.075,3H2.75a.75.75,0,0,0,0,1.5H3.5v9.75A3.755,3.755,0,0,0,7.25,18h4.5a3.755,3.755,0,0,0,3.75-3.75V4.5h.75a.75.75,0,0,0,0-1.5ZM8.75,1.5h1.5A2.254,2.254,0,0,1,12.372,3H6.628A2.254,2.254,0,0,1,8.75,1.5ZM14,14.25a2.25,2.25,0,0,1-2.25,2.25H7.25A2.25,2.25,0,0,1,5,14.25V4.5h9Z" fill="red"/>
                                       <path id="Path_569" data-name="Path 569" d="M9.75,16a.75.75,0,0,0,.75-.75v-4.5a.75.75,0,0,0-1.5,0v4.5A.75.75,0,0,0,9.75,16Z" transform="translate(-1.75 -2.5)" fill="red"/>
                                       <path id="Path_570" data-name="Path 570" d="M13.75,16a.75.75,0,0,0,.75-.75v-4.5a.75.75,0,0,0-1.5,0v4.5A.75.75,0,0,0,13.75,16Z" transform="translate(-2.75 -2.5)" fill="red"/>
                                    </g>
                                 </svg>
                              </a>
                           </div>
                        </td>
                     </tr>
                     <?php } ?>
                     <?php }else{ ?>
                     <tr class="alert alert-dismissible fade show text-center" role="alert">
                        <td class="text-center" colspan="10">No Products</td>
                     </tr>
                     <?php } ?>	
                  </tbody>
               </table>
            </div>
         </form>

      </div>
      <div class="row">
        <div class="col-md-12">
          {{$get_products->appends(request()->input())->links()}}
        </div>
      </div> 
   </div>
</div>
@include('admin.Common.footer')
<script type="text/javascript">
   $(document).ready(function(){
      $('#clear').click(function(){
         $('.Search_items').val('');
      });
   });
</script>
<script type="text/javascript">
   function moveconfirm(){
        job=confirm("Are you sure to move this product into master?");
        if(job!=true){
            return false;
        }
    }

    function remove_confirm(){
        job=confirm("Are you sure to remove this product from master?");
        if(job!=true){
            return false;
        }
    }
</script>

<!-- Product move to master -->
<script type="text/javascript">
  $('body').on("click",'#Move_master', function(){
      var ProductID = $(this).attr('data-id');
      var product_name = $(this).attr('data-name');
   
      _token = $("input[name='_token']").val();
      $.ajax({
        url:"{{ url('product_movetomaster') }}",
        type: 'post',
        data: {'ProductID': ProductID,'product_name':product_name,'_token':_token},
         success: function(response) {
            window.location.href = "products";  
         }
      });
      return false;
   
   });
</script>

<!-- Product_remove_master -->
<script type="text/javascript">
  $('body').on("click",'#Remove_master', function(){
      var ProductID = $(this).attr('data-id');
      var product_name = $(this).attr('data-name');

      _token = $("input[name='_token']").val();
      $.ajax({
        url:"{{ url('product_remove_master') }}",
        type: 'post',
        data: {'ProductID': ProductID,'product_name':product_name,'_token':_token},
         success: function(response) {
            window.location.href = "products";  
         }
      });
      return false;
   
   });
</script>
