<div class="row">        
  	<div class="col-md-12">
	    <h3>Receivers</h3>
  		<div class="dash_inner_row">
	      	<div class="box-body table-responsive no-padding">
		        <table class="table table-hover">
		          <tr>
                <th>S No.</th>
                <th>Name</th>
                <th>Activity</th>
                <th>Province</th>
                <th>Telphone 1</th>
                <th>Telphone 2</th>
                <th>Mobile 1</th>
                <th>Mobile 2</th>
                <th>Address</th>
		          </tr>
              <?php if(count($SearchReceivers) > 0) { ?>
		          <?php $cnt = 1; ?>
		          <?php foreach ($SearchReceivers as $value) { ?>
		              <tr>
		                <td><?php echo $cnt; ?></td>
		                <td><?php echo $value['Name']; ?></td>
                        <td><?php echo $value['Activity']; ?></td>
                        <td><?php echo $value['Province']; ?></td>
                        <td><?php echo $value['Telphone1']; ?></td>
                        <td><?php echo $value['Telphone2']; ?></td>
                        <td><?php echo $value['Mobile1']; ?></td>
                        <td><?php echo $value['Mobile2']; ?></td>
                        <td>
                          <?php
                            if($value['Address']!=''){
                                $get_Address = json_decode($value['Address']);
                              }else{
                                $get_Address = array();
                              }  
                          ?>  
                          <?php 
                          foreach($get_Address as $Location){ ?>
                            <b>Adddress</b><br>
                            <?php echo $Location; ?><br><br>
                          <?php } ?>  
                        </td>
		              </tr>
		          <?php $cnt++; }  ?>
              <?php }else{ ?>
              <tr class="not_found">
                <td colspan="9"> Record Not Found </td>
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