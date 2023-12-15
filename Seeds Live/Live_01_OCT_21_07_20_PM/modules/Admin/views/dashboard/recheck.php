<div class="row">        
  	<div class="col-md-12">
	    <h3>Re-check</h3>
  		<div class="dash_inner_row">
	      	<div class="box-body table-responsive no-padding">
		        <table class="table table-hover">
		          <tr>
		            <th>S No.</th>
		            <th>Crop</th>
                    <th>Variety</th>
                    <th>Supplier</th>
                    <th>Numebr of seeds requast</th>
                    <th>By when</th>
		          </tr>
		          <?php if(count($SearchRecheck) > 0) { ?>
		          <?php $cnt = 1; ?>
		          <?php foreach ($SearchRecheck as $value) { ?>
		              <tr>
		                <td><?php echo $cnt; ?></td>
		                <td><?php echo $value['Crop']; ?></td>
                        <td><?php echo $value['Variety']; ?></td>
                        <td><?php echo $value['Supplier']; ?></td>
                        <td><?php echo $value['Numebrofseedsrequast']; ?></td>
                        <td><?php echo $value['Bywhen']; ?></td>
		              </tr>
		          <?php $cnt++; }  ?>
		          <?php }else{ ?>
				    <tr class="not_found">
				      <td colspan="6"> Record Not Found </td>
				    </tr>
				  <?php } ?>   
		        </table>
	      	</div>
	      	<div class="row">
	        	<div class="col-md-6">
	          		<div class="total_rows"><?php echo $result_count; ?></div>
	        	</div>
		        <div class="col-md-6">
		          <div class="pagination_main"><?php echo $links; ?></div>
		        </div>
	      	</div>  	
      	</div>
 	</div>
</div>