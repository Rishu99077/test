@include('admin.Common.header')
@include('admin.Common.sidebar')
@include('admin.Common.topbar')

		<div class="d-flex align-items-center justify-content-between announce_ban bg_black mb_40">
		   <div class="">
		      <h3 class="f24 mb-0 text-white">All approved invoice</h3>
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
		         <table>
		            <thead>
		               <tr>
		                  <th>Product name</th>
		                  <th>Order by</th>
		                  <th>Quantity</th>
		                  <th>Wholesale value</th> 
		                  <th>Added time</th> 
		                  <th>Action</th>
		               </tr>
		            </thead>
		            <tbody>
		            <?php if (!empty($orders)) { ?>
		            <?php foreach ($orders as $key => $value) { 
		            	
		            $newdate = $value['updated_at'];
                     $transactionDate = date("F j, Y, g:i a",strtotime($newdate)); ?>
		            		
		               <tr class="alert alert-dismissible fade show" role="alert">
		                  <td>{{$value['product_name'];}}</td>
		                  <td>{{$value['order_by'];}}</td>
		                  <td>{{$value['quantity'];}}</td>
		                  <td>{{$value['wholesale_value'];}}</td>
		                  <td>{{$transactionDate}}</td>
		                  <td>
		                     <div class="d-flex align-items-center inve_ed_del justify-content-center">
		                     	<a href="{{url('view_invoice')}}?PurchaseID={{$value['PurchaseID']}}" data-bs-toggle="modal" data-bs-target=".vieworder_<?php echo $value['PurchaseID'] ?>"><span><i class="fa fa-eye fa-2x"></i></span></a>&nbsp;	
		                        <a href="{{url('delete_invoice')}}?PurchaseID={{$value['PurchaseID']}}" onClick="return doconfirm();">
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
		            		<td class="text-center" colspan="6">No Invoice</td>
		            	</tr>
		            <?php } ?>	
		               
		            </tbody>
		         </table>
		      </div>
		   </form>
		</div>

		<!-- View Invoice Modal -->
		<?php foreach ($orders as $key => $value) {
		$newdate = $value['updated_at'];
        $AddedDate = date("F j, Y, g:i a",strtotime($newdate)); ?> 
		<div class="modal fade vieworder_<?php echo $value['PurchaseID'] ?>" id="addinventryModal"  aria-labelledby="exampleModalLabel" aria-hidden="true">
		   <div class="modal-dialog inventry_modal">
		      <div class="modal-content">
		         <div class="modal-header inventry_modal_header">
		            <h5 class="modal-title" id="exampleModalLabel">View invoice (<span class="text-primary">{{$AddedDate}}</span>)</h5>
		         </div>
		         <div class="modal-body">
		            <div class="row">
		               <input type="hidden" name="OrderID" value="<?php if(@$OrderID!=''){echo @$OrderID; } ?>">
		               <div class="mb-3 col-lg-6 form-group" id="Inputproduct_name">
		                  <label  class="form-label">Products</label>
		                  <br>
		                  <input type="text" readonly name="product_name" value="{{$value['product_name']}}">
		                  <span class="help-block product_name_req"></span>
		               </div>
		               <div class="mb-3 col-lg-6 form-group" id="Inputorder_by">
		                  <label  class="form-label">Order By</label>
		                  <input type="text" readonly name="order_by" value="{{$value['order_by']}}">
		                  
		                  <span class="help-block order_by_req"></span>
		               </div>
		               <div class="order_response row">
		               </div>
		               <div class="mb-3 col-lg-6 form-group" id="Inputquantity">
		                  <label  class="form-label">Quantity</label>
		                  <input type="number" readonly name="quantity" value="{{$value['quantity']}}" id="quantity" placeholder="Enter Quantity" >
		                  <span class="help-block quantity_req"></span>
		               </div>
		               <div class="mb-3 col-lg-6 form-group" id="Inputwholesale_value">
		                  <label  class="form-label">Whole sale value</label>
		                  <input type="text" readonly name="wholesale_value" id="wholesale_value" value="{{$value['wholesale_value']}}" placeholder="Enter wholesale value" >
		                  <span class="help-block wholesale_value_req"></span>
		               </div>
		            </div>
		         </div>
		         <div class="modal-footer">
		            <button type="button" class="btn btn-secondary close_pro" data-bs-dismiss="modal">Close</button>
		         </div>
		      </div>
		   </div>
		</div>
		<?php } ?>

	</div>
</div>
@include('admin.Common.footer')
