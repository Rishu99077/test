
<div class="row">        
  	<div class="col-md-12">
	    <h3>Crops</h3>
  		<div class="dash_inner_row">
	      	<div class="box-body table-responsive no-padding">
		        <table class="table table-hover">
		          <tr>
		            <th>S No.</th>
		            <th>Title</th>
		            <th>Action</th>
		          </tr>

		          <?php if(count($module_data) > 0) { ?>
		          <?php $cnt = 1; ?>
		          <?php foreach ($module_data as $value) { ?>
		              <tr>
		                <td><?php echo $cnt; ?></td>
		                <td><?php echo $value['Title']; ?></td>
		                <td>
		                	<a href="<?php echo base_url(); ?>admin/restore/delete/crops/<?php echo $value['CropID']; ?>"><button type="button" class="btn btn-danger" onClick="return doconfirm();">Permanently Delete</button>
                         	</a>
                         	<a href="<?php echo base_url(); ?>admin/restore/restore/crops/<?php echo $value['CropID']; ?>"><button type="button" class="btn btn-success">Restore</button></a>
		                </td>	
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