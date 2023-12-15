<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>
<!--   <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css" rel="stylesheet"> -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.css" rel="stylesheet">
@include('admin.Common.header')
@include('admin.Common.sidebar')
@include('admin.Common.topbar')
<style type="text/css">
   .inventry_modal{max-width: 1200px; margin: 1.75rem auto;}
   .form-group input[type="text"],.form-group input[type="email"],.form-group input[type="number"] { width: 100%;
   padding: 10px;
   font-size: 13px;}
   .inventry_modal_header{background: #141414;
   color: #ffffff;}
   .products_modal_header{background: #F8D034;}
   .modal-dialog{overflow-y: initial !important}
.modal-body{height: 550px;overflow-y: auto;}
</style>
<body onload="myFunction()">
      <div class="d-flex align-items-center justify-content-between announce_ban bg_black mb_40">
         <div>
            <h3 class="f24 mb-0 text-white">Edit Inventry</h3>
         </div>
         <div class="">
            <a  class="rec_btn" data-bs-toggle="modal" data-bs-target="#addinventryModal">
               <span class="mr_10">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                     <path id="fi-rr-plus-small" d="M22.5,13.5h-6v-6A1.5,1.5,0,0,0,15,6h0a1.5,1.5,0,0,0-1.5,1.5v6h-6A1.5,1.5,0,0,0,6,15H6a1.5,1.5,0,0,0,1.5,1.5h6v6A1.5,1.5,0,0,0,15,24h0a1.5,1.5,0,0,0,1.5-1.5v-6h6A1.5,1.5,0,0,0,24,15h0A1.5,1.5,0,0,0,22.5,13.5Z" transform="translate(-6 -6)" fill="#fff"/>
                  </svg>
               </span>
               Edit 
            </a>
         </div>
      </div>
   </div>
</div>
<!------------------------------- Inventry  Modal ------------------------------->
<div class="modal fade" id="addinventryModal"  aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog inventry_modal">
      <div class="modal-content">
         <div class="modal-header inventry_modal_header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Inventries</h5>
         </div>
         <form method="post" id="validate_signup_form">
            <div class="modal-body">
               @csrf
               <div class="row">
                <?php $inventry_id = $_GET['InventryID']; ?>
                <input type="hidden" name="inventry_id" value="{{$inventry_id}}">
                  <div class="mb-3 col-lg-6 form-group" id="Inputlocation">
                     <label  class="form-label">Select Location</label>
                     <select class="form-control select2box" id="LocationName" name="location" style="width: 100%;">
                        <option value="">-- Select location --</option>
                        <?php foreach ($get_locations as $type_key => $val_loc) { ?>
                        <option value="<?php echo $val_loc['location_name']; ?>" <?php if ($inventries['location_name'] ==  $val_loc['location_name'] ) echo 'selected' ; ?>><?php echo $val_loc['location_name']; ?></option>
                        <?php } ?>
                     </select>
                     <span class="help-block location_name_req1"></span>
                  </div>
                  <div class="mb-3 col-lg-6 form-group" id="Inputdescription">
                     <label  class="form-label">Description</label>
                     <div class="response_des">
                      
                      <input type="text" name="description" value="{{$inventries['description']}}">
                     </div>
                     <span class="help-block"></span>
                  </div>
                  <div class="mb-3 col-lg-6 form-group" id="Inputdate">
                     <label  class="form-label">Date</label>
                     <input type="text" name="date" class="form-control" placeholder="Enter date" value="<?php echo date("Y-m-d H:i:s")  ?>">
                     <span class="help-block"></span>
                  </div>
                  <div class="mb-3 col-lg-6 form-group" id="Inputinventrie_notes">
                     <label  class="form-label">Inventry Notes</label>
                     <input type="text" name="inventrie_notes" value="{{$inventries['inventrie_notes']}}" placeholder="Enter inventrie notes" >
                  </div>
                  <div class="col-lg-4 col-sm-6 mb_30 form-group" id="Inputvendor_id">
                     <label class="form-label">Vendor</label>
                     <select class="form-control select2box" id="vendor_id" name="vendor_id" style="width: 100%;">
                        <option value="">-- Select vendor --</option>
                        <?php foreach ($get_vendors as $type_key => $val_vendor) { ?>
                        <option value="<?php echo $val_vendor['VendorID']; ?>" <?php if ($inventries['vendor_id'] ==  $val_vendor['VendorID'] ) echo 'selected' ; ?>><?php echo $val_vendor['vendor_name']; ?></option>
                        <?php } ?>
                     </select>
                     <span class="help-block"></span>
                  </div>
                  <div class="row" id="view_table">
                      <div class="table-responsive">
                        <table class="table table_products">
                           <thead>
                              <tr>
                                 <th>S.no.</th> 
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
                           <tbody id="view_pro" class="Pro_response sort_ajax">
                              <?php if ($get_inventryproducts!='') { $cnt = 1;
                                foreach ($get_inventryproducts as $key => $value) { ?>
                                  <tr id="{{$value['Inventries_productsID']}}" style="cursor: grab;">
                                    <input type="hidden" name="InventryID[]" class="form-control" value="{{$value['InventryID']}}" data-id/>
                                    <td>{{$cnt}}</td>
                                    <td><input type="text" name="product_name[]" class="form-control" value="{{$value['product_name']}}" readonly/></td>
                                    <td><input type="text" name="location_name[]" class="form-control" value="{{$value['location_name']}}" readonly/></td>
                                    <td><input type="text" name="quantity_type[]" class="form-control" value="{{$value['quantity_type']}}" readonly/></td>
                                    <td><input type="text" name="case_size[]" class="form-control" value="{{$value['case_size']}}" readonly/></td>
                                    <td><input type="number" name="quantity[]" class="form-control" value="{{$value['quantity']}}" readonly/></td>
                                    <td><input type="number" name="weight[]" class="form-control" value="{{$value['weight']}}" readonly/></td>
                                    <td><input type="number" name="whole_sale_value[]" class="form-control" value="{{$value['whole_sale_value']}}" readonly/></td>
                                    <td><input type="number" name="retail_value[]" class="form-control" value="{{$value['retail_value']}}" readonly/></td>
                                    <td><button type="button" name="remove" id="ajx_btn_remove" class="btn btn-danger btn_remove" data-id="{{$value['Inventries_productsID']}}">X</button></a></td>
                                  </tr>
                               <?php $cnt++; }
                            } ?>
                           </tbody>
                        </table>
                     </div>
                  </div>
                  <button type="button" id="add_more" class="btn btn-success mt-5" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-plus" aria-hidden="true">Add more products</i></button>
                  <div class="mb-3 col-lg-6 form-group" id="Inputproduct_name">
                     <span class="help-block"></span>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="goBack()">Close</button>
              <button type="submit" class="btn btn-primary">update</button>
            </div>
         </form>
      </div>
   </div>
</div>
<!--------------------------------- Products MODAL ----------------- -->
<div class="modal fade" id="exampleModal"  aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog products_modal">
      <div class="modal-content">
         <div class="modal-header products_modal_header">
            <h5 class="modal-title" id="exampleModalLabel">Add Products</h5>
         </div>
            <div class="modal-body">
               <div class="row">
                <input type="hidden" name="inventry_id" value="{{$inventry_id}}">
                  <div class="mb-3 col-lg-12 form-group" id="Inputproduct_name">
                     <label  class="form-label">Products</label>
                     <select class="form-control select2box" id="ProductName" required name="product_name" style="width: 100%;">
                        <option value="">-- Select Product --</option>
                        <?php foreach ($get_products as $type_key => $val_prod) { ?>
                        <option value="<?php echo $val_prod['product_name']; ?>"><?php echo $val_prod['product_name']; ?></option>
                        <?php } ?>
                     </select>
                     <span class="help-block product_name_req"></span>
                  </div>
                  <div class="mb-3 col-lg-12 form-group" id="Inputlocation_name">
                     <label  class="form-label">Location</label>
            
                       <div class="response_loc">
                        <input type="text" name="location_name" value="{{$inventries['location_name']}}">
                        </div>
                     <span class="help-block location_name_req"></span>
                  </div>
                  <div class="mb-3 col-lg-6 form-group" id="Inputquantity_type">
                     <label  class="form-label">Quantity Type</label>
                     <input type="text" name="quantity_type" readonly class="form-control"  id="get_container_type" placeholder="Enter Quantity">
                     <span class="help-block quantity_type_req"></span>
                  </div>
                  <div class="mb-3 col-lg-6 form-group" id="Inputcase_size">
                     <label  class="form-label">Case Size</label>
                     <input type="text" name="case_size" readonly class="form-control"  id="get_ajx_case_size" placeholder="Enter Case size">
                     <span class="help-block case_size_req"></span>
                  </div>
                  <div class="mb-3 col-lg-6 form-group" id="Inputquantity">
                     <label  class="form-label">Quantity</label>
                     <input type="number" name="quantity" class="form-control"  id="quantity" placeholder="Enter Quantity">
                     <span class="help-block quantity_req"></span>
                  </div>
                  <div class="mb-3 col-lg-6 form-group" id="Inputweight">
                     <label  class="form-label">Weight</label>
                     <input type="number" name="weight" readonly class="form-control"  id="get_full_weight" placeholder="Enter Weight">
                     <span class="help-block weight_req"></span>
                  </div>
                  <div class="mb-3 col-lg-6 form-group" id="Inputwhole_sale_value">
                     <label  class="form-label">Whole sale value</label>
                     <input type="number" name="whole_sale_value" readonly class="form-control"  id="get_whole_sale_value" placeholder="Enter Quantity">
                     <span class="help-block whole_sale_value_req"></span>
                  </div>
                  <div class="mb-3 col-lg-6 form-group" id="Inputretail_value">
                     <label  class="form-label">Retail value</label>
                     <input type="number" name="retail_value" readonly class="form-control"  id="get_retail_portion_price" placeholder="Enter Retail value">
                     <span class="help-block retail_value_req"></span>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary close_pro" data-bs-dismiss="modal">Close</button>
               <button  class="btn btn-primary single_inventry">Save product</button>
            </div>
         
      </div>
   </div>
</div>
</body>
<script>
   $('tbody').sortable();
</script>
@include('admin.Common.footer')
<script type="text/javascript">
  function myFunction(){ 
    $(document).ready(function(){
      $('#addinventryModal').modal('show');
    });
  }
</script>
<script>
     $("#add_more").click(function(e){
        // alert('test');
         var get_location_name = $('[name="location_name"]').val(); 
        // alert(get_location_name);

          if (get_location_name=='' || get_location_name==undefined) {
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
       // alert(TypeValue);
       var get_location = TypeValue;
         $('.response_des').html('<input type="text" readonly name="description" class="Description_val" placeholder="Enter description" value="'+get_location+'">');
         $('.response_loc').html('<input type="text" readonly name="location_name" value="'+get_location+'">'); 
      });

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
                    url:"{{ route('product.editPosition')}}",
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

   });
</script>
<script type="text/javascript">
   $('#ProductName').change(function(){
      var ProductName = $('#ProductName option:selected').val();
       // alert(TypeValue);
   
      _token = $("input[name='_token']").val();
      $.ajax({
        url:"{{ url('get_products') }}",
        type: 'post',
        dataType: "json",
        data: {'ProductName': ProductName,'_token':_token},
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
</script>

<!-- <script type="text/javascript">
  $('body').on("change",'#LocationName', function(){
      var LocationName = $('#LocationName option:selected').val();
       // alert(LocationName);
   
      _token = $("input[name='_token']").val();
      $.ajax({
        url:"{{ url('get_locations') }}",
        type: 'post',
        data: {'LocationName': LocationName,'_token':_token},
         success: function(response) {  
            // console.log(response);
            // return false;
            $("#view_table").html(response);
         }
      });
      return false;
   
   });
</script> -->

<script type="text/javascript">
       
  $('body').on("click",'.single_inventry', function(){
      // alert("etet");
      var get_inventry_id = $('[name="inventry_id"]').val();
      var get_product_name = $('[name="product_name"]').val();
      var get_location_name = $('[name="location_name"]').val();
      var get_quantity_type = $('[name="quantity_type"]').val();
      var get_case_size = $('[name="case_size"]').val();
      var get_quantity = $('[name="quantity"]').val();
      var get_weight = $('[name="weight"]').val();
      var get_whole_sale_value = $('[name="whole_sale_value"]').val();
      var get_retail_value = $('[name="retail_value"]').val();

      _token = $("input[name='_token']").val();

        if (get_product_name=='') {
          $(".product_name_req").html('Product name field is required');
          return false;
        }else{
          $(".product_name_req").html('');
        } 
   
         if (get_location_name=='' || get_location_name==undefined) {
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
        url:"{{ url('update_single_inventrie') }}",
        type: 'post',
        data: {'get_inventry_id':get_inventry_id,'get_product_name': get_product_name,'get_location_name': get_location_name,'get_quantity_type': get_quantity_type,'get_case_size': get_case_size,'get_quantity': get_quantity,'get_weight': get_weight,'get_whole_sale_value': get_whole_sale_value,'get_retail_value': get_retail_value,'_token':_token},
         success: function(response) {  
            $('.close_pro').trigger('click'); 
   
            $("#view_pro").append('<tr><input type="hidden" name="InventryID[]" class="form-control" value="'+get_inventry_id+'"/><td><input type="text" name="product_name[]" class="form-control" value="'+get_product_name+'" readonly/></td><td><input type="text" name="location_name[]" class="form-control" value="'+get_location_name+'" readonly/></td><td><input type="text" name="quantity_type[]" class="form-control" value="'+get_quantity_type+'" readonly/></td><td><input type="text" name="case_size[]" class="form-control" value="'+get_case_size+'" readonly/></td><td><input type="number" name="quantity[]" class="form-control" value="'+get_quantity+'" readonly/></td><td><input type="number" name="weight[]" class="form-control" value="'+get_weight+'" readonly/></td><td><input type="number" name="whole_sale_value[]" class="form-control" value="'+get_whole_sale_value+'" readonly/></td><td><input type="number" name="retail_value[]" class="form-control" value="'+get_retail_value+'" readonly/></td><td><button type="button" name="remove" id="ajx_btn_remove" class="btn btn-danger btn_remove">X</button></td></tr>');
         }
      });
      return false;

  });
</script>