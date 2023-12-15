@include('admin.Common.header')
@include('admin.Common.sidebar')
@include('admin.Common.topbar')
<style type="text/css">
  .all_inve_tab thead th:last-child {
    text-align: left;
}
</style>
      <div class="d-flex align-items-center justify-content-between announce_ban bg_black mb_40">
         <div class="">
            <h3 class="f24 mb-0 text-white">Master Products</h3>
         </div>
         <button class="btn btn-secondary" onclick="goBack()">Back</button>
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
      <form action="{{url('master_products')}}" method="get">
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
                      <a id="clear" href="{{('master_products')}}" class="btn btn-danger clear">Clear</a>
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
                        <td>{{$value['restaurant_name']}}</td>
                        <td><a onClick="return addconfirm();" id="Add" data-id="{{$value['ProductID']}}" data-name="{{$value['product_name'];}}" class="btn btn-success"><i class="fa fa-plus"></i>Add</a></td>
                     </tr>
                     <?php $cnt++; } ?>
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
   function addconfirm(){
        job=confirm("Are you sure to add this Product?");
        if(job!=true){
            return false;
        }
    }
</script>

<script type="text/javascript">
  $('body').on("click",'#Add', function(){
      var ProductID = $(this).attr('data-id');
      var product_name = $(this).attr('data-name');
      _token = $("input[name='_token']").val();
      $.ajax({
        url:"{{ url('addproduct_from_master') }}",
        type: 'post',
        data: {'ProductID': ProductID , 'product_name':product_name , '_token':_token},
         success: function(response) {
            window.location.href = "master_products";  
         }
      });
      return false;
   
   });
</script>