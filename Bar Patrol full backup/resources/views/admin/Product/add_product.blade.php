@include('admin.Common.header')
@include('admin.Common.sidebar')
@include('admin.Common.topbar')
      <div class="d-flex align-items-center justify-content-between announce_ban mb_40">
         <div class="">
            <h3 class="f24 mb-0 text-white">{{$data['heading']}}</h3>
         </div>
         <div class="">
            <a href="{{('products')}}" class="rec_btn">All Products </a>
         </div>
      </div>
      <div class="add_inve_main">
         <form method="post" id="validate_signup_form">
            @csrf 
            <div class="text-end mt_25">
               <?php 
               if ($data['heading']=='Add product') { ?>
                  <button class="btn btn-warning" type="submit">Save</button>
               <?php }elseif($data['heading']=='Edit product'){ ?>
                  <button class="btn btn-warning" type="submit">Update</button>
               <?php } ?>
            </div>
            <div class="row">
               <div class="col-lg-6 col-sm-6 mb_30 form-group" id="Inputproduct_name">
                  <div class="add_inve_box ">
                     <label for="inve_lab">Products Name <span class="text-danger">*</span></label>
                     <input type="hidden" name="ProductID" value="<?php if(@$products['ProductID']!=''){echo @$products['ProductID']; } ?>">
                     <input type="text" name="product_name"  placeholder="Enter product name" value="{{$products['product_name']}}">
                  </div>
                  <span class="help-block"></span>
               </div>
               <div class="col-lg-3 col-sm-6 mb_30 form-group" id="Inputproduct_code">
                  <div class="add_inve_box ">
                     <label for="inve_lab">Product code <span class="text-danger">*</span></label>
                     <input type="text" name="product_code" readonly  placeholder="Enter Product code" value="{{rand(100000,1000000)}}">
                  </div>
                  <span class="help-block"></span>
               </div>
               <div class="col-lg-3 col-sm-6 mb_30 form-group" id="Inputvendor_code">
                  <div class="add_inve_box ">
                     <label for="inve_lab">Vendor code<span class="text-danger">*</span></label>
                     <input type="text" name="vendor_code" placeholder="Enter Vendor code" value="{{$products['vendor_code']}}">
                  </div>
                  <span class="help-block"></span>
               </div>
               <div class="col-lg-4 col-sm-6 mb_30 form-group" id="Inputproduct_type_id">
                  <div class="add_inve_box ">
                     <label for="inve_lab">Product type <span class="text-danger">*</span></label>
                     <select class="form-control select2box" id="product_type_id" name="product_type_id">
                        <option value="">-- Select Product --</option>
                        <?php foreach ($get_productstype as $type_key => $val_type) { ?>
                        <option value="<?php echo $val_type['id']; ?>" <?php if ($products['product_type_id'] ==  $val_type['id'] ) echo 'selected' ; ?>><?php echo $val_type['name']; ?></option>
                        <?php } ?>
                     </select>
                  </div>
                  <span class="help-block"></span>
               </div>
               <div class="col-lg-4 col-sm-6 mb_30 form-group" id="Inputproduct_categorie_id">
                  <div class="add_inve_box ">
                     <label for="inve_lab">Product Categorie <span class="text-danger">*</span></label>
                     <select class="form-control select2box" id="product_categorie_id" name="product_categorie_id">
                        <option value="">-- Select categorie --</option>
                        <?php foreach ($get_productscategories as $type_key => $val_cat) { ?>
                        <option value="<?php echo $val_cat['Categorie_ID']; ?>" <?php if ($products['product_categorie_id'] ==  $val_cat['Categorie_ID'] ) echo 'selected' ; ?>><?php echo $val_cat['categorie_name']; ?></option>
                        <?php } ?>
                     </select>
                  </div>
                  <span class="help-block"></span>
               </div>
               <div class="col-lg-4 col-sm-6 mb_30 form-group" id="Inputcontainer_type">
                  <div class="add_inve_box">
                     <label for="inve_lab">Container type <span class="text-danger">*</span></label>
                     <div class="position-relative sel">
                        <select id="container_type" class="form-control select2box" name="container_type">
                           <option value="">--Select container type--</option>
                           <option value="Bottle" <?php if($products['container_type'] == 'Bottle'){ echo 'selected="selected"'; } ?>>Bottle</option>
                           <option value="Keg" <?php if($products['container_type'] == 'Keg'){ echo 'selected="selected"'; } ?>>Keg</option>
                           <option value="Can" <?php if($products['container_type'] == 'Can'){ echo 'selected="selected"'; } ?>>Can</option>
                           <option value="Bag" <?php if($products['container_type'] == 'Bag'){ echo 'selected="selected"'; } ?>>Bag</option>
                           <option value="Box" <?php if($products['container_type'] == 'Box'){ echo 'selected="selected"'; } ?>>Box</option>
                           <option value="Carton" <?php if($products['container_type'] == 'Carton'){ echo 'selected="selected"'; } ?>>Carton</option>
                           <option value="Each" <?php if($products['container_type'] == 'Each'){ echo 'selected="selected"'; } ?>>Each</option>
                        </select>
                   <!--      <span class="sel_drop" for="sel2">
                           <svg xmlns="http://www.w3.org/2000/svg" width="16" height="8" viewBox="0 0 16 8">
                              <path id="fi-rr-angle-small-down" d="M20.665,8.241a1.163,1.163,0,0,0-1.616,0l-5.241,5.116a1.188,1.188,0,0,1-1.616,0L6.951,8.241a1.163,1.163,0,0,0-1.616,0,1.1,1.1,0,0,0,0,1.578l5.24,5.115a3.488,3.488,0,0,0,4.849,0l5.241-5.116a1.1,1.1,0,0,0,0-1.577Z" transform="translate(-5 -7.914)" fill="#474747"/>
                           </svg>
                        </span> -->
                     </div>
                  </div>
                  <span class="help-block"></span>
               </div>
               <div class="col-lg-4 col-sm-6 mb_30 form-group" id="Inputcontainer_size">
                  <div class="add_inve_box ">
                     <label for="inve_lab">Container Size <span class="text-danger">*</span></label>
                     <input type="number" name="container_size"  placeholder="Enter container_size" value="{{$products['container_size']}}">
                  </div>
                  <span class="help-block"></span>
               </div>
               <div class="col-lg-8 col-sm-6 mb_30 form-group" id="Inputpresentation">
                  <div class="add_inve_box ">
                     <label for="inve_lab">Presentation (How many) <span class="text-danger">*</span></label>
                     <textarea name="presentation" class="form-control">{{$products['presentation']}}</textarea>
                  </div>
                  <span class="help-block"></span>
               </div>
               <div class="col-lg-4 col-sm-6 mb_30 form-group" id="Inputunits">
                  <div class="add_inve_box">
                     <label for="inve_lab">Units<span class="text-danger">*</span></label>
                     <div class="position-relative sel">
                        <select id="units" class="form-control select2box" name="units">
                           <option value="">--Select unit--</option>
                           <option value="ml" <?php if($products['units'] == 'ml'){ echo 'selected="selected"'; } ?>>ml</option>
                           <option value="liter" <?php if($products['units'] == 'liter'){ echo 'selected="selected"'; } ?>>liter</option>
                           <option value="gallon" <?php if($products['units'] == 'gallon'){ echo 'selected="selected"'; } ?>>gallon</option>
                           <option value="oz(ounce)" <?php if($products['units'] == 'oz(ounce)'){ echo 'selected="selected"'; } ?>>oz(ounce)</option>
                           <option value="lbs(pound)" <?php if($products['units'] == 'lbs(pound)'){ echo 'selected="selected"'; } ?>>lbs(pound)</option>
                           <option value="Each" <?php if($products['units'] == 'Each'){ echo 'selected="selected"'; } ?>>Each</option>
                        </select>
                        <!-- <span class="sel_drop" for="sel2">
                           <svg xmlns="http://www.w3.org/2000/svg" width="16" height="8" viewBox="0 0 16 8">
                              <path id="fi-rr-angle-small-down" d="M20.665,8.241a1.163,1.163,0,0,0-1.616,0l-5.241,5.116a1.188,1.188,0,0,1-1.616,0L6.951,8.241a1.163,1.163,0,0,0-1.616,0,1.1,1.1,0,0,0,0,1.578l5.24,5.115a3.488,3.488,0,0,0,4.849,0l5.241-5.116a1.1,1.1,0,0,0,0-1.577Z" transform="translate(-5 -7.914)" fill="#474747"/>
                           </svg>
                        </span> -->
                     </div>
                  </div>
                  <span class="help-block"></span>
               </div>
               <div class="col-lg-4 col-sm-6 mb_30 form-group" id="Inputwholesale_container_price">
                  <div class="add_inve_box ">
                     <label for="inve_lab">Wholesale container price</label>
                     <input type="number" name="wholesale_container_price"  placeholder="Enter wholesale_container_price" value="{{$products['wholesale_container_price']}}">
                  </div>
               </div>
               <div class="col-lg-4 col-sm-6 mb_30 form-group" id="Inputsingle_portion_size">
                  <div class="add_inve_box ">
                     <label for="inve_lab">Single portion size</label>
                     <input type="text" name="single_portion_size"  placeholder="Enter single portion size" value="{{$products['single_portion_size']}}">
                  </div>
               </div>
               <div class="col-lg-4 col-sm-6 mb_30 form-group" id="Inputsingle_portion_unit">
                  <div class="add_inve_box ">
                     <label for="inve_lab">single_portion_unit</label>
                     <input type="number" name="single_portion_unit"  placeholder="Enter single portion unit" value="{{$products['single_portion_unit']}}">
                  </div>
               </div>
               <div class="col-lg-4 col-sm-6 mb_30 form-group" id="Inputretail_portion_price">
                  <div class="add_inve_box ">
                     <label for="inve_lab">Retail portion price</label>
                     <input type="number" name="retail_portion_price"  placeholder="Enter Retail portion price" value="{{$products['retail_portion_price']}}">
                  </div>
               </div>
               <div class="col-lg-4 col-sm-6 mb_30 form-group" id="Inputfull_weight">
                  <div class="add_inve_box ">
                     <label for="inve_lab">Full weight</label>
                     <input type="number" name="full_weight"  placeholder="Enter Full weight" value="{{$products['full_weight']}}">
                  </div>
               </div>
               <div class="col-lg-4 col-sm-6 mb_30 form-group" id="Inputempty_weight">
                  <div class="add_inve_box ">
                     <label for="inve_lab">Empty weight</label>
                     <input type="number" name="empty_weight"  placeholder="Enter Empty weight" value="{{$products['empty_weight']}}">
                  </div>
               </div>
               <div class="col-lg-4 col-sm-6 mb_30 form-group" id="Inputcase_size">
                  <div class="add_inve_box ">
                     <label for="inve_lab">Case size</label>
                     <input type="number" name="case_size"  placeholder="Enter Case size" value="{{$products['case_size']}}">
                  </div>
               </div>
               <div class="col-lg-12 col-sm-6 mb_30 form-group" id="Inputvendor_id">
                  <div class="add_inve_box ">
                     <label for="inve_lab">Vendor <span class="text-danger">*</span></label>
                     <select class="form-control select2box" id="vendor_id" name="vendor_id">
                        <option value="">-- Select vendor --</option>
                        <?php foreach ($get_vendors as $type_key => $val_vendor) { ?>
                        <option value="<?php echo $val_vendor['VendorID']; ?>" <?php if ($products['vendor_id'] ==  $val_vendor['VendorID'] ) echo 'selected' ; ?>><?php echo $val_vendor['vendor_name']; ?></option>
                        <?php } ?>
                     </select>
                  </div>
                  <span class="help-block"></span>
               </div>
               <div class="col-lg-4 col-sm-6 mb_30 form-group" id="Inputpar">
                  <div class="add_inve_box ">
                     <label for="inve_lab">Par</label>
                     <input type="number" name="par"  placeholder="Enter par" value="{{$products['par']}}">
                  </div>
               </div>
               <div class="col-lg-4 col-sm-6 mb_30 form-group" id="Inputreorder_point">
                  <div class="add_inve_box ">
                     <label for="inve_lab">Reorder Point</label>
                     <input type="number" name="reorder_point"  placeholder="Enter reorder point" value="{{$products['reorder_point']}}">
                  </div>
               </div>
               <div class="col-lg-4 col-sm-6 mb_30 form-group" id="Inputorder_by_the">
                  <div class="add_inve_box ">
                     <label for="inve_lab">Order by the</label>
                     <input type="number" name="order_by_the"  placeholder="Enter Order by the" value="{{$products['order_by_the']}}">
                  </div>
               </div>
               <div class="col-lg-12 col-sm-6 mb_30 form-group" id="Inputideal_pour_cost">
                  <div class="add_inve_box ">
                     <label for="inve_lab">Ideal pour cost (%)</label>
                     <input type="number" name="ideal_pour_cost"  placeholder="Enter Ideal pour cost" value="{{$products['ideal_pour_cost']}}">
                  </div>
               </div>
               <input type="hidden" name="status" value="{{$products['status']}}">
               <input type="hidden" name="User_ID" value="{{$products['User_ID']}}">
              
            </div>
            <div class="text-end mt_25">
               <?php if ($data['heading']=='Add product') { ?>
                  <button class="btn btn-warning" type="submit">Save</button>
               <?php }elseif($data['heading']=='Edit product'){ ?>
                  <button class="btn btn-warning" type="submit">Update</button>
               <?php } ?>
               <button class="btn btn-secondary" onclick="goBack()">Back</button>
            </div>
         </form>
      </div>
   </div>
</div>
@include('admin.Common.footer')
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
         url:"{{ url('save_product') }}",
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
             window.location.href = "products";
           }
         }
       });
       return false;
     });
   });
</script>
<script type="text/javascript">
   $('#product_type_id').change(function(){
      var Product_type_id = $('#product_type_id option:selected').val();
      _token = $("input[name='_token']").val();

      $.ajax({
        url:"{{ url('get_categories') }}",
        type: 'post',
        data: {'Product_type_id': Product_type_id,'_token':_token},
         success: function(response) {  
            // $test = json.parse(response);
            // var res = JSON.parse(response);
            // console.log(response);
            // return false;
            $(".view_category").html(response);
         }
      });
      return false;
   
   });
</script>