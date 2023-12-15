@include('admin.Common.header')
@include('admin.Common.sidebar')
@include('admin.Common.topbar')
<style type="text/css">
   .all_inve_tab thead th:last-child {text-align: left;}
   .modal-dialog{overflow-y: initial !important}
   .modal-body{height: 550px;overflow-y: auto;}
</style>
<div class="d-flex align-items-center justify-content-between announce_ban bg_black mb_40">
      <?php
        $newdate = @$data['date'];
        $transactionDate = date("F j, Y, g:i a",strtotime($newdate)); 
      ?>
   <div class="">
      <?php if (@$data['location']) { ?>
         <h3 class="f24 mb-0 text-white">{{ @$data['location'] }}</h3>
      <?php }else{ ?>
        <h3 class="f24 mb-0 text-white">{{@$_GET['LocationSearch']}}</h3>
      <?php } ?>
   </div>
   <?php if (@$data['InventryID']!='') { ?>
   <div class="">
      <a  class="rec_btn" href="{{('edit_inventries')}}?InventryID={{@$data['InventryID']}}">
         <span class="mr_10"><i class="fa fa-plus"></i></span>
         Add Inventry
      </a>
   </div>
   <?php } ?>
</div>
@foreach (['danger', 'warning', 'success', 'info', 'error'] as $key)
@if(Session::has($key))
<p id="success_msg" class="alert alert-{{ $key }}">{{ Session::get($key) }}</p>
@endif
@endforeach

<?php
 @$ProductSearch = $_GET['ProductSearch'];
?>
<form action="{{url('view_locationinventrie')}}" method="get">
  <div class="row">
      <div class="col-md-4">
            <div class="add_inve_box">
              <label>Product name</label>
              <input type="hidden" name="LocationSearch" value="<?php echo @$data['location']; ?>">
              <input type="text" name="ProductSearch" class="form-control Search_items" placeholder="Search by product name" value="<?php if (@$ProductSearch != ''){
                echo $ProductSearch ; } ?>">
            </div>
      </div>
      <div class="col-md-3 mt-4">
         <div class="add_inve_box">
             <label></label>
             <button type="submit" class="btn btn-success">Search</button>
             <a id="clear" class="btn btn-danger clear">Clear</a>
         </div>
      </div>
  </div>
</form>

<div class="all_inve_main">
   <form action="">
      <div class="all_inve_tab">
         <table>
            <thead>
               <tr>
                  <th>#</th>
                  <th>Product Name</th>
                  <th>Location Name</th>
                  <th>Quantity ype</th>
                  <th>Case_size</th>
                  <th>Quantity</th>
                  <th>weight</th>
                  <th>WS value</th>
                  <th>Retail value</th>
               </tr>
            </thead>
            <tbody>
               <?php if (!empty($inventrie_products)) { $cnt = 1;  ?>
               <?php foreach ($inventrie_products as $key => $value) { ?>
               <tr class="alert alert-dismissible fade show" role="alert">
                  <td>{{$cnt;}}</td>
                  <td>{{$value['product_name'];}}</td>
                  <td>{{$value['location_name'];}}</td>
                  <td>{{$value['quantity_type'];}}</td>
                  <td>{{$value['case_size'];}}</td>
                  <td>{{$value['quantity'];}}</td>
                  <td>{{$value['weight'];}}</td>
                  <td>{{$value['whole_sale_value'];}}</td>
                  <td>{{$value['retail_value'];}}</td>
               </tr>
               <?php $cnt++; } ?>
               <?php }else{ ?>
               <tr class="alert alert-dismissible fade show text-center" role="alert">
                  <td class="text-center" colspan="10">No Inventry</td>
               </tr>
               <?php } ?>  
            </tbody>
         </table>
      </div>
   </form>
   <div class="d-flex justify-content-end">
      <button class="btn btn-secondary" onclick="goBack()">Back</button>
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