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
</style>


		<div class="d-flex align-items-center justify-content-between announce_ban bg_black mb_40">
		   <div class="">
		      <h3 class="f24 mb-0 text-white">Recieved orders history</h3>
		   </div>
		</div>

		@foreach (['danger', 'warning', 'success', 'info', 'error'] as $key)
	     @if(Session::has($key))
	         <p id="success_msg" class="alert alert-{{ $key }}">{{ Session::get($key) }}</p>
	     @endif
	    @endforeach

		<div class="all_inve_main">
		   <form action="">
		      <div class="all_inve_tab">
		         <?php foreach ($preorders as $key => $value_pre) { ?>
		         	<div class="table-responsive table_purchase">
	                    <div class="table-header mt-2">
	                      <span>{{$value_pre[0]['vendor_name']}}</span> 
	                    </div> 	
				         <table class="table table_products">
				            <thead>
				               <tr>
				                  <th>Product name</th>
				                  <th>Order by</th>
				                  <th>Quantity</th>
				                  <th>Wholesale value</th> 
				                  <th>Send to invoice</th>  
				                  <th>Added time</th>
				                  <th>Action</th>
				               </tr>
				            </thead>
				            <tbody>
					           	<?php foreach ($value_pre as $key => $value) { 
					           		$newdate = $value['updated_at'];
                          			  $transactionDate = date("F j, Y, g:i a",strtotime($newdate));?>	
					               <tr class="alert alert-dismissible fade show" role="alert">
					                  <td>{{$value['product_name'];}}</td>
					                  <td>{{$value['order_by'];}}</td>
					                  <td>{{$value['quantity'];}}</td>
					                  <td>{{$value['wholesale_value'];}}</td>
					                  <td><button class="btn btn-warning">
					                  	    <a href="{{('update_productstatus')}}?PurchaseID={{$value['PurchaseID']}}" onClick="return doupdate();">
					                           Select purchase order to receive
					                        </a>
					                    </button>
					                  </td>
					                  <td>{{$transactionDate}}</td>
					                  <td>
					                     <div class="d-flex align-items-center inve_ed_del justify-content-center">
					                         <a href="{{url('delete_order')}}?PurchaseID={{$value['PurchaseID']}}" onClick="return doconfirm();">
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
				            </tbody>
				         </table>
		      		</div>
		         <?php } ?>
		   </form>
		</div>
	</div>
</div>
@include('admin.Common.footer')
<script type="text/javascript">
	function doupdate(){
        job=confirm("Are you sure to update this product?");
        // alert(job);
        if(job!=true)
        {
            return false;
        }
    }
</script>
