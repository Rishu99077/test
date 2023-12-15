<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.css" rel="stylesheet">
@include('admin.Common.header')
@include('admin.Common.sidebar')
@include('admin.Common.topbar')
<style type="text/css">
   .modal-dialog {overflow-y: initial !important}
   .modal-body {height: 550px;overflow-y: auto;}
   .table-sorti tr{cursor: grab;}
</style>
<div class="d-flex align-items-center justify-content-between announce_ban bg_black mb_40">
   <div>
      <h3 class="f24 mb-0 text-white">All Inventry</h3>
   </div>
   <div class="">
      <a class="rec_btn" data-bs-toggle="modal" data-bs-target="#addinventryModal">
         <span class="mr_10"><i class="fa fa-plus"></i></span>
         Create new Inventry
      </a>
   </div>
</div>
@foreach (['danger', 'warning', 'success', 'info', 'error'] as $key)
@if(Session::has($key))
<p id="success_msg" class="alert alert-{{ $key }}">{{ Session::get($key) }}</p>
@endif
@endforeach
<?php @$Date = $_GET['Date'] ?>
<form action="{{url('inventries')}}" method="get">
   <div class="row">
      <div class="col-md-4">
         <div class="add_inve_box ">
            <label>Date</label>
            <select class="form-control select2box" id="Date" required name="Date">
               <?php foreach ($get_inventries_date as $key => $value) { ?>
               <option value="<?php echo $value['date']; ?>" <?php if (@$Date==$value['date'] ) echo 'selected' ; ?>>
                  <?php echo $value['date']; ?>
               </option>
               <?php } ?>
            </select>
         </div>
      </div>
      <div class="col-md-2 mt-4">
         <button type="submit" class="btn btn-success">Search</button>
      </div>
   </div>
</form>

<div class="all_inve_main">
   <form action="">
      <div class="all_inve_tab">
         <table class="table">
            <thead>
               <tr>
                  <th>#</th>   
                  <th>Date</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tbody>
               <?php if (!empty($inventries)) { $cnt = 1; ?>
               <?php foreach ($inventries as $key => $value) { ?>
               <tr class="alert alert-dismissible fade show" role="alert">
                     <?php 
                        $newdate = $value['date']; 
                        $transactionDate = date("F j, Y, g:i a",strtotime($newdate)); 
                     ?>
                  <td>{{$cnt}}</td>
                  <td><a href="{{('view_inventrie')}}?InventryID={{$value['InventryID']}}">{{$transactionDate}}</a></td>

                  <td>
                     <div class="d-flex align-items-center inve_ed_del justify-content-center">
                        <a href="{{('edit_inventries')}}?InventryID={{$value['InventryID']}}">
                           <i class="fa fa-pencil-square-o text-success fa-2x"></i>
                        </a>
                        <a href="{{url('delete_inventrie')}}?InventryID={{$value['InventryID']}}"
                           onClick="return doconfirm();">
                           <i class="fa fa-trash-o text-danger fa-2x"></i>
                        </a>
                     </div>
                  </td>
               </tr>
               <?php $cnt++; } ?>
               <?php }else{ ?>
               <tr class="alert alert-dismissible fade show text-center" role="alert">
                  <td class="text-center" colspan="6">No Inventry done yet</td>
               </tr>
               <?php } ?>
            </tbody>
         </table>
      </div>
   </form>
</div>
</div>
</div>
<!------------------------------- Inventry  Modal ------------------------------->
<div class="modal fade" id="addinventryModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog inventry_modal">
      <div class="modal-content">
         <div class="modal-header inventry_modal_header">
            <h5 class="modal-title" id="exampleModalLabel">Add Inventries</h5>
         </div>
         <form method="post" id="validate_signup_form">
            <div class="modal-body">
               @csrf
               <div class="row">
                  <div class="mb-3 col-lg-6 form-group" id="Inputlocation">
                     <label class="form-label">Select Location</label>
                     <br>
                     <select class="form-control select2box" id="LocationName" name="location" style="width: 100%;">
                        <option value="">-- Select location --</option>
                        <?php foreach ($get_locations as $type_key => $val_loc) { ?>
                        <option value="<?php echo $val_loc['LocationID']; ?>"><?php echo $val_loc['location_name']; ?></option>
                        <?php } ?>
                     </select>
                     <span class="help-block location_name_req1"></span>
                  </div>
                  <div class="mb-3 col-lg-6 form-group" id="Inputdescription">
                     <label class="form-label">Description</label>
                     <div class="response_des">
                     </div>
                     <span class="help-block"></span>
                  </div>
                  <div class="mb-3 col-lg-6 form-group" id="Inputdate">
                     <label class="form-label">Date</label>
                     <input type="text" name="date" class="form-control" placeholder="Enter date"
                        value="<?php echo date(" Y-m-d H:i:s") ?>">
                     <span class="help-block"></span>
                  </div>
                  <div class="mb-3 col-lg-6 form-group" id="Inputinventrie_notes">
                     <label class="form-label">Inventry Notes</label>
                     <input type="text" name="inventrie_notes" placeholder="Enter inventrie notes">
                  </div>
                  <div class="col-lg-4 col-sm-6 mb_30 form-group" id="Inputvendor_id">
                     <label class="form-label">Vendor</label>
                     <br>
                     <select class="form-control select2box" id="vendor_id" name="vendor_id" style="width: 100%;">
                        <option value="">-- Select vendor --</option>
                        <?php foreach ($get_vendors as $type_key => $val_vendor) { ?>
                        <option value="<?php echo $val_vendor['VendorID']; ?>">
                           <?php echo $val_vendor['vendor_name']; ?>
                        </option>
                        <?php } ?>
                     </select>
                     <span class="help-block"></span>
                  </div>
                  <button type="submit" class="btn btn-primary">Save</button>

                  <div class="row" id="view_table">


                     <script>
                        $('tbody').sortable();
                     </script>
                  </div>
                  <div class="row" id="view_pro_table">
                     <div class="table-responsive">
                        <?php if (count($get_draft_inventry)>0) { ?><h5>Draft products</h5> <?php } ?>
                        <table class="table table_products">
                           <thead>
                              <tr>
                                 <th>Products name</th>
                                 <th>Location name</th>
                                 <th>Quantity Type</th>
                                 <th>Case Size</th>
                                 <th>Quantity</th>
                                 <th>Weight</th>
                                 <th>Whole sale value</th>
                                 <th>Retail value</th>
                                 <th>Action</th>
                              </tr>
                           </thead>
                           <tbody id="view_pro" class="Pro_response sort">
                              <?php if ($get_draft_inventry!='') {
                                foreach ($get_draft_inventry as $key => $value) { ?>
                              <tr id="{{ $value['Inventries_productsID'] }}">
                                 <input type="hidden" name="InventryID[]" class="form-control"
                                    value="{{$value['InventryID']}}" />
                                 <td>
                                    <input type="hidden" name="product_id[]" class="form-control"
                                       value="{{$value['product_id']}}" readonly />
                                    <input type="text" name="product_name[]" class="form-control"
                                       value="{{$value['product_name']}}" readonly />
                                 </td>
                                 <td>
                                    <input type="hidden" name="location_id[]" class="form-control"
                                       value="{{$value['location_id']}}" readonly />
                                    <input type="text" name="location_name[]" class="form-control"
                                       value="{{$value['location_name']}}" readonly />
                                 </td>
                                 <td><input type="text" name="quantity_type[]" class="form-control"
                                       value="{{$value['quantity_type']}}" readonly /></td>
                                 <td><input type="text" name="case_size[]" class="form-control"
                                       value="{{$value['case_size']}}" readonly /></td>
                                 <td><input type="number" name="quantity[]" class="form-control quantity_focus"
                                       value="{{$value['quantity']}}" data-id="{{$value['Inventries_productsID']}}" />
                                 </td>
                                 <td><input type="number" name="weight[]" class="form-control weight_focus"
                                       value="{{$value['weight']}}" data-id="{{$value['Inventries_productsID']}}" />
                                 </td>
                                 <td><input type="number" name="whole_sale_value[]" class="form-control"
                                       value="{{$value['whole_sale_value']}}" readonly /></td>
                                 <td><input type="number" name="retail_value[]" class="form-control"
                                       value="{{$value['retail_value']}}" readonly /></td>
                                 <td><button type="button" name="remove" id="ajx_btn_remove"
                                       class="btn btn-danger btn_remove"
                                       data-id="{{$value['Inventries_productsID']}}">X</button></a></td>
                              </tr>
                              <?php }
                            } ?>
                           </tbody>
                        </table>
                     </div>
                  </div>
                  <button type="button" id="add_more" class="btn btn-success mt-5" data-bs-toggle="modal"
                     data-bs-target="#exampleModal"><i class="fa fa-plus" aria-hidden="true">Add more
                        products</i></button>
                  <div class="mb-3 col-lg-6 form-group" id="Inputproduct_name">
                     <span class="help-block"></span>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary">Save</button>
            </div>
         </form>
      </div>
   </div>
</div>
<!--------------------------------- Products MODAL ----------------- -->
<div class="modal fade" id="exampleModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog products_modal">
      <div class="modal-content">
         <div class="modal-header products_modal_header">
            <h5 class="modal-title" id="exampleModalLabel">Add Products</h5>
            <button class="btn btn-success" id="add_master_products">Add master product</button>
            <button class="btn btn-primary" id="add_normal_products" style="display: none;">Add res. product</button>
         </div>
         <div class="modal-body">
            <div class="row">
               <div class="mb-3 col-lg-12 form-group res_products" id="Inputproduct_name">
                  <label class="form-label">Products</label>
                  <br>
                  <select class="form-control select2box" id="ProductName" required name="product_name"
                     style="width: 100%;">
                     <option value="">-- Select Product --</option>
                     <?php foreach ($get_products as $type_key => $val_prod) { ?>
                     <option value="<?php echo $val_prod['ProductID']; ?>"><?php echo $val_prod['product_name']; ?>
                     </option>
                     <?php } ?>
                  </select>
                  <span class="help-block product_name_req"></span>
               </div>
               <div class="mb-3 col-lg-12 form-group mast_products" id="Inputproduct_name" style="display: none;">
                  <label class="form-label">Master Products</label>
                  <br>
                  <select class="form-control select2box" id="MasterProductName" required name="master_product_name"
                     style="width: 100%;">
                     <option value="">-- Select master product --</option>
                     <?php foreach ($get_master_products as $type_key => $val_prod) { ?>
                     <option value="<?php echo $val_prod['ProductID']; ?>"><?php echo $val_prod['product_name']; ?>
                     </option>
                     <?php } ?>
                  </select>
                  <span class="help-block product_name_req"></span>
               </div>
               <div class="mb-3 col-lg-12 form-group" id="Inputlocation_name">
                  <label class="form-label">Location </label>
                  <div class="response_loc_value">
                  </div>
                  <div class="response_loc_name">
                  </div>
                  <span class="help-block location_name_req"></span>
               </div>
               <div class="mb-3 col-lg-6 form-group" id="Inputquantity_type">
                  <label class="form-label">Quantity Type</label>
                  <input type="text" name="quantity_type" readonly class="form-control" id="get_container_type"
                     placeholder="Enter Quantity">
                  <span class="help-block quantity_type_req"></span>
               </div>
               <div class="mb-3 col-lg-6 form-group" id="Inputcase_size">
                  <label class="form-label">Case Size</label>
                  <input type="text" name="case_size" readonly class="form-control" id="get_ajx_case_size"
                     placeholder="Enter Case size">
                  <span class="help-block case_size_req"></span>
               </div>
               <div class="mb-3 col-lg-6 form-group" id="Inputquantity">
                  <label class="form-label">Quantity</label>
                  <input type="number" name="quantity" class="form-control" id="quantity" placeholder="Enter Quantity">
                  <span class="help-block quantity_req"></span>
               </div>
               <div class="mb-3 col-lg-6 form-group" id="Inputweight">
                  <label class="form-label">Weight</label>
                  <input type="number" name="weight" readonly class="form-control" id="get_full_weight"
                     placeholder="Enter Weight">
                  <span class="help-block weight_req"></span>
               </div>
               <div class="mb-3 col-lg-6 form-group" id="Inputwhole_sale_value">
                  <label class="form-label">Whole sale value</label>
                  <input type="number" name="whole_sale_value" readonly class="form-control" id="get_whole_sale_value"
                     placeholder="Enter Quantity">
                  <span class="help-block whole_sale_value_req"></span>
               </div>
               <div class="mb-3 col-lg-6 form-group" id="Inputretail_value">
                  <label class="form-label">Retail value</label>
                  <input type="number" name="retail_value" readonly class="form-control" id="get_retail_portion_price"
                     placeholder="Enter Retail value">
                  <span class="help-block retail_value_req"></span>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary close_pro" data-bs-dismiss="modal">Close</button>
            <button class="btn btn-primary single_inventry">Save product</button>
         </div>

      </div>
   </div>
</div>
<script>
   $('tbody').sortable();
</script>
@include('admin.Common.footer')
<script>
   $("#add_more").click(function(e){
        // alert('test');
         var get_location_name = $('[name="location_name"]').text(); 
         var get_location_id = $('[name="location_id"]').val(); 

        // alert(get_location_name);

          if (get_location_name=='' || get_location_name==undefined || get_location_id=='') {
            $(".location_name_req1").html('Please fill location first');
            return false;
          }else{
            $(".location_name_req1").html('');
          } 
          $("#ProductName").val('');  
          $("#quantity_type").val('');
          $("#get_ajx_case_size").val('');
          $("#quantity").val('');
          $("#get_full_weight").val('');
          $("#get_whole_sale_value").val('');
          $("#get_retail_portion_price").val('');
          
      }); 
   
    $('body').on('click', "#ajx_btn_remove", function(e) {
           if (!confirm("Are you sure to delete this row?"))
           return false;
           $(this).closest('tr').remove();
           e.preventDefault();
    });

    // delete inventry products
    $('body').on("click",'#ajx_btn_remove', function(){
      var Inventries_productsID = $(this).attr('data-id');
    
      _token = $("input[name='_token']").val();
      $.ajax({
        url:"{{ url('delete_inventrie_products') }}",
        type: 'post',
        data: {'Inventries_productsID': Inventries_productsID,'_token':_token},
         success: function(response) {  
            
         }
      });
      return false;
   
     });
    
</script>
<script type="text/javascript">
   jQuery(document).ready(function() {
     jQuery("#validate_signup_form").submit(function(){
       var datastatus =jQuery(this).attr('data-status');
       jQuery('#validate_signup_form .form-group').removeClass('has-error');
       jQuery('#validate_signup_form .help-block').html('');
   
       jQuery('#signup_form_success').html('');
   
       data= jQuery("#validate_signup_form").serialize()+ "&datastatus="+datastatus;
   
       var formData = new FormData(this);
   
       jQuery('#wait').show();
   
       jQuery.ajax({
         type:"POST",
         url:"{{ url('save_inventrie') }}",
         datatype: 'JSON',
         data:formData,
         cache: false,
         contentType: false,
         processData: false,
         success: function(response) {
           jQuery('#wait').hide();
           if(response.error){
             jQuery.each( response.error, function( index, value ) {
                 if(value!=''){
                   jQuery('#Input'+index).addClass('has-error');
                   jQuery('#Input'+index+' .help-block').html(value);
                   if(i==1){ 
                     jQuery('#'+index).focus();
                   }
                   i++;
                 }
             });
           }else{
             window.location.href = "inventries";
           }
         }
       });
       return false;
     });
   });
   
</script>
<script type="text/javascript">
   $(document).ready(function(){
   
      $('#LocationName').change(function() { 
       var TypeValue = $('#LocationName option:selected').val();
       var TypeName = $('#LocationName option:selected').text();
       //alert(TypeValue);
       // var get_location = TypeValue;
         $('.response_des').html('<input type="text" readonly name="description" class="Description_val" placeholder="Enter description" value="'+TypeName+'" data-name="'+TypeName+'" >');
         $('.response_loc_value').html('<input type="hidden" readonly name="location_id" value="'+TypeValue+'">'); 
         $('.response_loc_name').html('<input type="text" readonly name="location_name" value="'+TypeName+'">'); 
      });
   });
</script>
<!-- master products -->
<script type="text/javascript">
   $('#add_master_products').click(function(){
    $('.res_products').hide();
    $('.mast_products').show();
    $('#add_normal_products').show();
    $('#add_master_products').hide();
  });
  $('#add_normal_products').click(function(){
    $('.res_products').show();
    $('.mast_products').hide();
    $('#add_normal_products').hide();
    $('#add_master_products').show();
  });
</script>
<script type="text/javascript">
   $('#ProductName').change(function(){
      var Product_ID = $('#ProductName option:selected').val();
      
   
      _token = $("input[name='_token']").val();
      $.ajax({
        url:"{{ url('get_products') }}",
        type: 'post',
        dataType: "json",
        data: {'Product_ID': Product_ID,'_token':_token},
         success: function(response) {  
            // $test = json.parse(response);
            // console.log(response);
            // return false;
            $("#get_ajx_case_size").val(response.get_ajx_case_size);
            $("#get_full_weight").val(response.get_full_weight);
            $("#get_whole_sale_value").val(response.get_whole_sale_value);  
            $("#get_retail_portion_price").val(response.get_retail_portion_price);
            $("#get_container_type").val(response.get_container_type);
         }
      });
      return false;
   
   });

   // master
   $('#MasterProductName').change(function(){
      var MasterProduct_ID = $('#MasterProductName option:selected').val();
      
   
      _token = $("input[name='_token']").val();
      $.ajax({
        url:"{{ url('get_products') }}",
        type: 'post',
        dataType: "json",
        data: {'Product_ID': MasterProduct_ID,'_token':_token},
         success: function(response) { 
            $("#get_ajx_case_size").val(response.get_ajx_case_size);
            $("#get_full_weight").val(response.get_full_weight);
            $("#get_whole_sale_value").val(response.get_whole_sale_value);  
            $("#get_retail_portion_price").val(response.get_retail_portion_price);
            $("#get_container_type").val(response.get_container_type);
         }
      });
      return false;
   
   });
</script>

<script type="text/javascript">
   $('body').on("change",'#LocationName', function(){
      var Location_ID = $('#LocationName option:selected').val();
       // alert(LocationName);
   
      _token = $("input[name='_token']").val();
      $.ajax({
        url:"{{ url('get_locations') }}",
        type: 'post',
        data: {'Location_ID': Location_ID,'_token':_token},
         success: function(response) {  
            // console.log(response);
            // return false;
            $("#view_table").html(response);
             $('.sort_ajax').sortable({
            stop:function(event, ui){
                var parameter = new Array();
                var position = new Array();
                $('.sort_ajax>tr').each(function(){
                    $(this).removeAttr("style");
                    parameter.push($(this).attr("id"));
                });
                $(this).children().each(function(index) {
                    position.push(index + 1);
                });
                _token = $("input[name='_token']").val();
                $.ajax({
                    url:"{{ route('product.savePosition')}}",
                    method:"POST",
                    data:{"id":parameter,"position":position,'_token':_token},
                    success:function(response){
                        console.log(response);
                    },
                    error:function(xhr,response){
                        console.log(xhr.status);
                    }
                });
            },

        })
         }
      });
      return false;
   
   });
</script>

<script type="text/javascript">
   $('body').on("click",'.single_inventry', function(){
      
      var get_product_id = $('#ProductName option:selected').val();
      var get_product_name = $('#ProductName option:selected').text();

      // var get_product_id = $('[name="product_name"]').val();
      // var get_product_name = $('[name="product_name"]').val();
      if (get_product_id=='' || get_product_name=='') {
         var get_product_id = $('#MasterProductName option:selected').val();
         var get_product_name = $('#MasterProductName option:selected').text();
      }
     
      var get_location_id = $('[name="location_id"]').val();
      var get_location_name = $('[name="location_name"]').val();
      var get_quantity_type = $('[name="quantity_type"]').val();
      var get_case_size = $('[name="case_size"]').val();
      var get_quantity = $('[name="quantity"]').val();
      var get_weight = $('[name="weight"]').val();
      var get_whole_sale_value = $('[name="whole_sale_value"]').val();
      var get_retail_value = $('[name="retail_value"]').val();

      // alert(get_product_id);
      // alert(get_product_name);
      // return false;


      _token = $("input[name='_token']").val();

        if (get_product_name=='' || get_product_id=='') {
          $(".product_name_req").html('Product name field is required');
          return false;
        }else{
          $(".product_name_req").html('');
        } 
   
         if (get_location_name=='' || get_location_name==undefined || get_location_id=='') {
           $(".location_name_req").html('location name field is required');
           return false;
         }else{
           $(".location_name_req").html('');
         }  
          if (get_quantity_type=='') {
           $(".quantity_type_req").html('Quantity type field is required');
           return false;
          }else{
            $(".quantity_type_req").html('');
          }  
          if (get_case_size=='') {
           $(".case_size_req").html('Case size field is required');
           return false;
         }else{
           $(".case_size_req").html('');
         }  
          if (get_quantity=='') {
           $(".quantity_req").html('Quantity field is required');
           return false;
         }else{
           $(".quantity_req").html('');
         }  
          if (get_weight=='') {
           $(".weight_req").html('Weight field is required');
           return false;
         }else{
           $(".weight_req").html('');
         }  
          if (get_whole_sale_value=='') {
           $(".whole_sale_value_req").html('Whole sale value field is required');
           return false;
         }else{
           $(".whole_sale_value_req").html('');
         }  
         if (get_retail_value=='') {
           $(".retail_value_req").html('Retail value field is required');
           return false;
         }else{
           $(".retail_value_req").html('');
         }  
     
      $.ajax({
        url:"{{ url('save_single_inventrie') }}",
        type: 'post',
        data: {'get_product_id': get_product_id,'get_product_name': get_product_name,'get_location_id': get_location_id,'get_location_name': get_location_name,'get_quantity_type': get_quantity_type,'get_case_size': get_case_size,'get_quantity': get_quantity,'get_weight': get_weight,'get_whole_sale_value': get_whole_sale_value,'get_retail_value': get_retail_value,'_token':_token},
         success: function(response) {  
            $('.close_pro').trigger('click'); 
   
            $("#view_pro").append('<tr><input type="hidden" name="InventryID[]" class="form-control" value="0"/><td><input type="hidden" name="product_id[]" class="form-control" value="'+get_product_id+'" readonly/><input type="text" name="product_name[]" class="form-control" value="'+get_product_name+'" readonly/></td><td><input type="hidden" name="location_id[]" class="form-control" value="'+get_location_id+'" readonly/><input type="text" name="location_name[]" class="form-control" value="'+get_location_name+'" readonly/></td><td><input type="text" name="quantity_type[]" class="form-control" value="'+get_quantity_type+'" readonly/></td><td><input type="text" name="case_size[]" class="form-control" value="'+get_case_size+'" readonly/></td><td><input type="number" name="quantity[]" class="form-control" readonly value="'+get_quantity+'" /></td><td><input type="number" name="weight[]" class="form-control" readonly value="'+get_weight+'"/></td><td><input type="number" name="whole_sale_value[]" class="form-control" value="'+get_whole_sale_value+'" readonly/></td><td><input type="number" name="retail_value[]" class="form-control" value="'+get_retail_value+'" readonly/></td><td><button type="button" name="remove" id="ajx_btn_remove" class="btn btn-danger btn_remove">X</button></td></tr>');
         }
      });
      return false;

  });
</script>

<script type="text/javascript">
   $('body').on("focusout",'.quantity_focus', function(){
      var Inventries_productsID = $(this).attr('data-id');
      var Quantity = $(this).val();
       // alert(Inventries_productsID);
       // alert(Quantity);

      _token = $("input[name='_token']").val();
      $.ajax({
        url:"{{ url('update_quantity') }}",
        type: 'post',
        data: {'Inventries_productsID': Inventries_productsID,'Quantity':Quantity,'_token':_token},
         // success: function(response) {  
         //  // $("#view_table").html(response);
         //    alert('quantity updated successfully');
         // }
      });
      // return false;
   });


   $('body').on("focusout",'.weight_focus', function(){
      var Inventries_productsID = $(this).attr('data-id');
      var Weight = $(this).val();
       // alert(Inventries_productsID);
       // alert(Quantity);

      _token = $("input[name='_token']").val();
      $.ajax({
        url:"{{ url('update_weight') }}",
        type: 'post',
        data: {'Inventries_productsID': Inventries_productsID,'Weight':Weight,'_token':_token},
         // success: function(response) {  
         //  // $("#view_table").html(response);
         //    alert('weight updated successfully');
         // }
      });
      // return false;
   });
</script>

{{-- Sortable script --}}