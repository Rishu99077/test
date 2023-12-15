@include('admin.Common.header')
@include('admin.Common.sidebar')
@include('admin.Common.topbar')
<style type="text/css">
   .inventry_modal{max-width: 1200px; margin: 1.75rem auto;}
   .form-group input[type="text"],.form-group input[type="email"],.form-group input[type="number"] { width: 100%;padding: 10px;font-size: 13px;}
   .inventry_modal_header{background: #141414;color: #ffffff;}
   .products_modal_header{background: #F8D034;}
   .table-responsive{background: #ffffff; margin-top: 30px;}
   .table-footer{text-align: right; margin-right: 5px;}
   .all_inve_tab table {width: 100%;padding: 10px;}
   .table_pur_body{background-color: white;opacity: 1;border: none;}
    .span_number span{color: #0A58CA;}

    .table_products thead tr{
      background-color: #0082BA;
      color: white;
    }
    .table_products thead th{
      padding: 10px;
    }
    .place_btn{background-color: #0082BA;color: white;margin: 10px;}
    .place_btn:hover{color: #0082BA;background: #fff;border-color: #0082BA;}
    .table-header span{margin-left: 15px; color: #48465B;}
    .ajax-loader {
      visibility: hidden;
      background-color: rgba(255,255,255,0.7);
      position: absolute;
      z-index: +100 !important;
      width: 100%;
      height:100%;
    }

    .ajax-loader img {
      position: relative;
      top:50%;
      left:50%;
    }
    .select2-container{width: 100%;}
    .all_inve_tab thead th:last-child {
     text-align: left; 
    }
</style>
<script type="text/javascript">
$.fn.modal.Constructor.prototype.enforceFocus = function() {};
</script>
      <div class="d-flex align-items-center justify-content-between announce_ban bg_black mb_40">
         <div>
            <h3 class="f24 mb-0 text-white">All Purchase order</h3>
         </div>
         <div class="form-group" id="Inputproduct_name">
          <div>
            <a  class="rec_btn" data-bs-toggle="modal" data-bs-target="#addpurcahseorderModal">
               <span class="mr_10">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                     <path id="fi-rr-plus-small" d="M22.5,13.5h-6v-6A1.5,1.5,0,0,0,15,6h0a1.5,1.5,0,0,0-1.5,1.5v6h-6A1.5,1.5,0,0,0,6,15H6a1.5,1.5,0,0,0,1.5,1.5h6v6A1.5,1.5,0,0,0,15,24h0a1.5,1.5,0,0,0,1.5-1.5v-6h6A1.5,1.5,0,0,0,24,15h0A1.5,1.5,0,0,0,22.5,13.5Z" transform="translate(-6 -6)" fill="#fff"/>
                  </svg>
               </span>
               Add product manually
            </a>
          </div>
             <span class="help-block product_name_req"></span>
         </div>        
      </div>
      @foreach (['danger', 'warning', 'success', 'info', 'error'] as $key)
        @if(Session::has($key))
          <p id="success_msg" class="alert alert-{{ $key }}">{{ Session::get($key) }}</p>
        @endif
      @endforeach
      <div class="all_inve_main">
        <?php if ($total_count > 0) { ?>     
           <form method="post" id="modal_signup_form">
              @csrf
              <div class="all_inve_tab">
                <div id="view_pro">
                  <?php foreach ($main_data as $key => $value_pre) { ?>
                    <?php if (count($value_pre)>0) { ?>
                    <div class="table-responsive table_purchase">
                      <div class="table-header mt-2">
                        <span>{{$value_pre[0]['vendor_name']}}</span> 
                      </div>  
                      <table class="table table_products">
                          <thead>
                             <tr>
                                <th>Products name</th>
                                <th>Order By</th>
                                <th>Case size</th>
                                <th>Actual Order</th>
                                <th>WS value</th>
                                <th>Added time</th>
                                <th>Action</th>
                             </tr>
                          </thead>
                          <tbody>
                            <?php foreach ($value_pre as $key => $value) {
                            $newdate = $value['updated_at'];
                            $transactionDate = date("F j, Y, g:i a",strtotime($newdate)); 
                           ?>
                               <tr>
                                  <td><input type="hidden" readonly name="PurchaseID[]" class="table_pur_body" value="{{$value['PurchaseID']}}" >
                                    <input type="text" readonly name="product_name[]" class="table_pur_body" value="{{$value['product_name']}}" ></td>
                                  <td><input type="text" readonly name="order_by[]" class="table_pur_body" value="{{$value['order_by']}}" ></td>
                                  <td><input type="text" readonly name="case_size[]" id="case_size" class="table_pur_body" value="{{$value['case_size']}}" ></td>
                                  <td><input type="number" readonly name="quantity[]" class="table_pur_body" value="{{$value['quantity']}}"></td>
                                  <td><input type="text" readonly name="wholesale_value[]" class="table_pur_body" value="{{$value['wholesale_value']}}"></td>
                                  <td>{{$transactionDate}}</td>
                                  <td>
                                    <a href="{{url('save_order')}}?PurchaseID={{$value['PurchaseID']}}" onClick="return order_confirm();">Place</a>
                                    <a href="{{url('delete_purchase_order')}}?PurchaseID={{$value['PurchaseID']}}" onClick="return doconfirm();"><button type="button" name="remove" id="btn_remove" class="btn btn-danger btn_remove">X</button></a></td>
                               </tr>
                            <?php } ?>
                          </tbody>
                      </table>
                      <div class="table-footer">
                          <span class="span_number">Total Order: Items - <span>20</span></span><span>,</span><span class="span_number">Cases - <span>{{$value['quantity']}}</span></span><span>|</span><span class="span_number">Total Order Cost: <span>${{$value['wholesale_value']}}</span></span>
                        <div class="mt_25">
                            <button class="btn place_btn single_place_order">Place order</button>
                        </div>
                      </div>
                    </div>
                    <?php } ?>
                  <?php } ?>
                      
                </div>
              </div>
                <div>
                   <div class="text-end mt_75" id="place_order">
                     <button type="submit" class="btn place_btn" onClick="return sconfirm();">Place all order <span class="count_order">{{$total_count}}</span></button>
                   </div>
                </div>
           </form>
        <?php }else{ ?>
            <div class="text-center">
                <h3>No data available</h3>
            </div>
        <?php } ?>   
      </div>
   </div>
</div>
<!------------------------------- Inventry  Modal ------------------------------->
<div class="modal fade" id="addpurcahseorderModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog inventry_modal">
      <div class="modal-content">
         <div class="modal-header inventry_modal_header">
            <h5 class="modal-title" id="exampleModalLabel"> Add Product To Order</h5>
         </div>
          <form method="post" id="draft_form">
            @csrf
            <div class="modal-body">
               <div class="row">
                  <input type="hidden" name="OrderID" value="<?php if(@$OrderID!=''){echo @$OrderID; } ?>">
                  <div class="mb-3 col-lg-6 form-group" id="Inputproduct_name">
                     <label  class="form-label">Products</label>
                     <br>
                     <select class="form-control select2box" id="product_name mySelect2"  name="product_name" style="width: 100%;">
                        <option value="">-- Select Product --</option>
                        <?php foreach ($get_products as $type_key => $val_prod) { ?>
                        <option value="<?php echo $val_prod['product_name']; ?>"><?php echo $val_prod['product_name']; ?></option>
                        <?php } ?>
                     </select>
                     <span class="help-block product_name_req"></span>
                  </div>
                  <div class="mb-3 col-lg-6 form-group" id="Inputorder_by">
                     <label  class="form-label">Order By</label>
                     <select class="form-control" name="order_by"  id="order_by">
                        <option value="">--Select--</option>
                        <option value="Bottle">Bottle</option>
                        <option value="Keg">Keg</option>
                        <option value="Case">Case</option>
                     </select>
                     <span class="help-block order_by_req"></span>
                  </div>
                  <div class="order_response row">

                  </div>
                  <div class="mb-3 col-lg-6 form-group" id="Inputquantity">
                     <label  class="form-label">Quantity</label>
                     <input type="number" name="quantity"  id="quantity" placeholder="Enter Quantity" >
                     <span class="help-block quantity_req"></span>
                  </div> 
                  <div class="mb-3 col-lg-6 form-group" id="Inputwholesale_value">
                     <label  class="form-label">Whole sale value</label>
                     <input type="text" name="wholesale_value" id="wholesale_value"  placeholder="Enter wholesale value" >
                     <span class="help-block wholesale_value_req"></span>
                  </div>                  
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary close_pro" data-bs-dismiss="modal">Close</button>
               <button class="btn btn-primary save_pro">Save</button>
            </div>
          </form>  
      </div>
   </div>
</div>

<!-- Ajax loader -->
<div class="ajax-loader">
  <img src="{{ asset('admin/images/bottle.png') }}" class="img-responsive" />
</div>
@include('admin.Common.footer')
<script>
    $('#mySelect2').select2({
        dropdownParent: $('#addpurcahseorderModal');
    });
</script>
<script type="text/javascript">
   jQuery(document).ready(function() {
     jQuery("#draft_form").submit(function(){
       var datastatus =jQuery(this).attr('data-status');
       jQuery('#draft_form .form-group').removeClass('has-error');
       jQuery('#draft_form .help-block').html('');
       jQuery('#signup_form_success').html('');  
       data= jQuery("#draft_form").serialize()+ "&datastatus="+datastatus;  
       var formData = new FormData(this);  
       jQuery('#wait').show();
   
       jQuery.ajax({   
         type:"POST",   
         url:"{{ url('save_draft_order') }}",   
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
             window.location.href = "purchase_order";
           }
         }
       });
       return false;
     });
   });
</script>

<script>
   $(document).ready(function(){
  
     $(".save_pro").click(function(e){  
            if (get_product_name=='') {
                $(".product_name_req").html('Product name field is required');
                return false;
            }else{
                $(".product_name_req").html('');
            } 
            if (get_order_by=='') {
                $(".order_by_req").html('Order by field is required');
                return false;
            }else{
              $(".order_by_req").html('');
            }  
            if (get_quantity=='') {
                $(".quantity_req").html('Quantity field is required');
                return false;
            }else{
              $(".quantity_req").html('');
            } 
            if (get_wholesale_value=='') {
                $(".wholesale_value_req").html('Whole sale value field is required');
                return false;
            }else{
              $(".wholesale_value_req").html('');
            }  
           
     });
    
   
   });
</script>

<script type="text/javascript">
   jQuery(document).ready(function() {
     jQuery("#modal_signup_form").submit(function(){
       var datastatus =jQuery(this).attr('data-status');
       jQuery('#modal_signup_form .form-group').removeClass('has-error');
       jQuery('#modal_signup_form .help-block').html('');
       jQuery('#signup_form_success').html('');  
       data= jQuery("#modal_signup_form").serialize()+ "&datastatus="+datastatus;  
       var formData = new FormData(this);  
       jQuery('#wait').show();
   
       jQuery.ajax({   
         type:"POST",   
         url:"{{ url('save_purchase_order') }}",   
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
             window.location.href = "purchase_order";
           }
         }
       });
       return false;
     });
   });
</script>

<script type="text/javascript">
   $(document).ready(function(){

      $('#Inputorder_by').change(function() { 
       var TypeValue = $('#Inputorder_by option:selected').val();
         if(TypeValue == 'Case'){
               var html ='';
               html+='<div class="col-lg-12 col-sm-12 mb_30 form-group" id="Inputcase_size">';
               html+='<label class="form-label">Case size</label><input type="number" name="case_size"  placeholder="Enter Case size">';
               html+='</div>';          
           $('.order_response').html(html);
         }
         if(TypeValue == 'Bottle'){
           $('.order_response').html('');
         }
         if(TypeValue == 'Keg'){
           $('.order_response').html('');
         }
      });
   });
</script>

<script type="text/javascript">
       
  $('body').on("click",'.single_place_order', function(){
      var this_div = $(this);
      var PurchaseID = $(this).closest('.table_purchase').find('.table_products tbody tr td').find("input[name='PurchaseID[]']").map(function(){ 
                    return this.value; 
                }).get();
      /*console.log(PurchaseID);
      return false;*/
      _token = $("input[name='_token']").val();
     
      $.ajax({
        url:"{{ url('save_single_order') }}",
        beforeSend: function(){
          $('.ajax-loader').css("visibility", "visible");
        },
        type: 'post',
        data: {'PurchaseID': PurchaseID,'_token':_token},
         success: function(response) {  
          this_div.closest('.table_purchase').remove();
          $('.ajax-loader').css("visibility", "hidden");
          window.location.href = "purchase_order";
         }
      });
      return false;

  });
</script>
<script type="text/javascript">
  function sconfirm(){
        job=confirm("Are you sure to place all order?");
        // alert(job);
        if(job!=true)
        {
            return false;
        }
    }

    function order_confirm(){
        job=confirm("Are you sure to place these order?");
        // alert(job);
        if(job!=true)
        {
            return false;
        }
    }
</script>





