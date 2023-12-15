<div class="row">        
  	<div class="col-md-12">
	    <h3>Trial</h3>
  		<div class="dash_inner_row">
	      	<div class="box-body table-responsive no-padding">
		        <table class="table table-hover">
		          <tr>
		            <th>S No.</th>
		            <th>Internal code</th>
                    <th>Date</th>
		          </tr>
		          <?php if(count($SearchTrial) > 0) { ?>
		          <?php $cnt = 1; ?>
		          <?php foreach ($SearchTrial as $value) { ?>
		              <tr>
		                <td><?php echo $cnt; ?></td>
		                <td><?php echo $value['Internalcode']; ?></td>
                        <td><?php echo $value['Date']; ?></td>
		              </tr>
		          <?php $cnt++; }  ?>
		          <?php }else{ ?>
				    <tr class="not_found">
				      <td colspan="3"> Record Not Found </td>
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