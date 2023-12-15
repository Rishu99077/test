<div class="row">        
  	<div class="col-md-12">
	    <h3>Evaluation</h3>
  		<div class="dash_inner_row">
	      	<div class="box-body table-responsive no-padding">
		        <table class="table table-hover">
		          <tr>
		            <th>S No.</th>
		            <th>Internal code</th>
                    <th>Date of visit</th>
                    <th>Plant vigur</th>
                    <th>Fruit shape</th>
                    <th>Yield</th>
                    <th>Maturity</th>
                    <th>Firmness</th>
                    <th>Uniformity</th>
                    <th>Overall rating</th>
                    <th>Action</th>
		          </tr>
		          <?php if(count($module_data) > 0) { ?>
		          <?php $cnt = 1; ?>
		          <?php foreach ($module_data as $value) { ?>
		              <tr>
		                <td><?php echo $cnt; ?></td>
		                <td><?php echo $value['Internalsamplecode']; ?></td>
                        <td><?php echo $value['Dateofvisit']; ?></td>
                        <td><?php echo $value['Fruitshape']; ?></td>
                        <td><?php echo $value['Plantvigur']; ?></td>
                        <td><?php echo $value['Yield']; ?></td>
                        <td><?php echo $value['Maturity']; ?></td>
                        <td><?php echo $value['Firmness']; ?></td>
                        <td><?php echo $value['Uniformity']; ?></td>
                        <td><?php echo $value['Overallrating']; ?></td>
                        <td>
                            <a href="<?php echo base_url(); ?>admin/restore/delete/evaluations/<?php echo $value['EvaluationID']; ?>"><button type="button" class="btn btn-danger" onClick="return doconfirm();">Permanently Delete</button>
                                </a>
                            <a href="<?php echo base_url(); ?>admin/restore/restore/evaluations/<?php echo $value['EvaluationID']; ?>"><button type="button" class="btn btn-success">Restore</button></a>
                        </td>
		              </tr>
		          <?php $cnt++; }  ?>
		          <?php }else{ ?>
				    <tr class="not_found">
				      <td colspan="10"> Record Not Found </td>
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