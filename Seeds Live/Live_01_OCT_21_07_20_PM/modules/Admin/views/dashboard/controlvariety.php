<div class="row">        
  	<div class="col-md-12">
	    <h3>Control variety</h3>
  		<div class="dash_inner_row">
	      	<div class="box-body table-responsive no-padding">
		        <table class="table table-hover">
		          <tr>
		            <th>S No.</th>
		            <th>Title</th>
		          </tr>
		          <?php if(count($SearchControlvariety) > 0) { ?>
		          <?php $cnt = 1; ?>
		          <?php foreach ($SearchControlvariety as $value) { ?>
		              <tr>
		                <td><?php echo $cnt; ?></td>
		                <td><?php echo $value['Title']; ?></td>
		              </tr>
		          <?php $cnt++; }  ?>
		          <?php }else{ ?>
				    <tr class="not_found">
				      <td colspan="2"> Record Not Found </td>
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