<div class="row">        
  	<div class="col-md-12">
	    <h3>Seeds</h3>
  		<div class="dash_inner_row">
	      	<div class="box-body table-responsive no-padding">
		        <table class="table table-hover">
		          <tr>
		            <th>S No.</th>
		            <th>Crop</th>
                    <th>Supplier</th>
                    <th>Variety</th>
                    <th>Date of recived sampel</th>
                    <th>Status</th>
                    <th>Action</th>
		          </tr>
		          <?php if(count($module_data) > 0) { ?>
		          <?php $cnt = 1; ?>
		          <?php foreach ($module_data as $value) { ?>
		              <tr>
		                <td><?php echo $cnt; ?></td>
		                <td><?php echo $value['Crop']; ?></td>
                        <td><?php echo $value['Supplier']; ?></td>
                        <td><?php echo $value['Variety']; ?></td>
                        <td><?php echo $value['Dateofrecivedsampel']; ?></td>
                        <td><?php echo $value['Status']; ?></td>
                        <td>
                            <a href="<?php echo base_url(); ?>admin/restore/delete/seeds/<?php echo $value['SeedID']; ?>"><button type="button" class="btn btn-danger" onClick="return doconfirm();">Permanently Delete</button>
                                </a>
                            <a href="<?php echo base_url(); ?>admin/restore/restore/seeds/<?php echo $value['SeedID']; ?>"><button type="button" class="btn btn-success">Restore</button></a>
                        </td>
		              </tr>
		          <?php $cnt++; }  ?>
		          <?php }else{ ?>
				    <tr class="not_found">
				      <td colspan="8"> Record Not Found </td>
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