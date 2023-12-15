<?php include('common/header.php');?>
<div class="wrapper">
    <?php include('common/topbar.php');?>
    <?php include('common/left_sidebar.php');?>  
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1><?php echo $heading_title; ?></h1>
      </section>
      <!-- Main content -->
      <section class="content">

        <?php include('dashboard/dashboard_filter.php');?>
        <!-- Info boxes -->
        <div class="row" style="display: none;">
          <div class="col-md-12">
            <?php if($userrole=='1' || $userrole=='4' ){ ?>
              <h3>Latest Crops</h3>
              <div class="dash_inner_row">
                 <table class="table table-hover">
                    <tr>
                      <th>S No.</th>
                      <th>Title</th>
                    </tr>

                    <?php if(count($crops) > 0) { ?>
                    <?php $cnt = 1; ?>
                    <?php foreach ($crops as $value) { ?>
                        <tr>
                          <td><?php echo $cnt; ?></td>
                          <td><?php echo $value['Title']; ?></td>
                        </tr>
                    <?php $cnt++; }  ?>
                    <?php }else{ ?>
                      <tr class="not_found">
                        <td colspan="4"> Record Not Found </td>
                      </tr>
                    <?php } ?>

                  </table>
              </div>
            <?php } ?>
          </div>
        </div>
        <div class="row">
          <?php if($userrole=='1' || $userrole=='4' || in_array("sampling", $userpermission)){ ?>
          <div class="col-md-6">
            <h3>Latest Samplings</h3>
            <div class="dash_inner_row">
               <table class="table table-hover">
                  <tr>
                    <th>S No.</th>
                    <th>Crop</th>
                    <th>Location</th>
                    <th>Description</th>
                  </tr>

                  <?php if(count($samplings) > 0) { ?>
                  <?php $cnt = 1; ?>
                  <?php foreach ($samplings as $value) { ?>
                      <tr>
                        <td><?php echo $cnt; ?></td>
                        <td><?php echo $value['get_crop']['Title']; ?></td>
                        <td><?php echo $value['Location']; ?></td>
                        <td><?php echo $value['Description']; ?></td>
                      </tr>
                  <?php $cnt++; }  ?>
                  <?php }else{ ?>
                    <tr class="not_found">
                      <td colspan="4"> Record Not Found </td>
                    </tr>
                  <?php } ?>

                </table>
            </div>
          </div><!-- /.col --> 
          <?php } ?>
          <?php if($userrole=='1' || $userrole=='4' || $userrole=='7' || in_array("trial", $userpermission)){ ?>
          <div class="col-md-6" >
            <h3>Latest Trial</h3>
            <div class="dash_inner_row">
               <table class="table table-hover">
                  <tr>
                    <th>S No.</th>
                    <th>Internal code</th>
                    <th>Date</th>
                  </tr>

                  <?php if(count($trial) > 0) { ?>
                  <?php $cnt = 1; ?>
                  <?php foreach ($trial as $value) { ?>
                      <tr>
                       <?php 
                       if($value['Date'] != ''){
                          $date = $value['Date'];
                          $exdate = explode("/",$date); 
                          $newDate       =   $exdate[2].'-'.$exdate[1].'-'.$exdate[0];
                          $newDate1   =   date("d-F-Y", strtotime($newDate));
                       }else{
                          $newDate1 = '';
                       }
                        
                      ?>
                      <td><?php echo $cnt; ?></td>
                      <td><?php echo $value['Internalcode']; ?></td>
                      <td><?php echo $newDate1; ?></td>
                      </tr>
                  <?php $cnt++; }  ?>
                  <?php }else{ ?>
                    <tr class="not_found">
                      <td colspan="3"> Record Not Found </td>
                    </tr>
                  <?php } ?>

                </table>
            </div>
          </div><!-- /.col --> 
          <?php } ?>
        </div>
        <?php if($userrole=='1' || $userrole=='4' || $userrole=='7' || in_array("evaluation", $userpermission)){ ?>
        <div class="row">  
          <div class="col-md-12">
            <h3>Latest Evaluations</h3>
            <div class="dash_inner_row">
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
                  </tr>

                  <?php if(count($evaluation) > 0) { ?>
                  <?php $cnt = 1; ?>
                  <?php foreach ($evaluation as $value) { ?>
                      <?php 
                        if($value['Dateofvisit'] != ''){
                          $Dateofvisit = $value['Dateofvisit'];
                          $exdate = explode("/",$Dateofvisit); 
                          @$newDate =   $exdate[2].'-'.$exdate[1].'-'.$exdate[0];
                          $NewDateofvisit =   date("d-F-Y", strtotime($newDate));
                        }else{
                          @$NewDateofvisit == '';
                        }
                      ?>
                      <tr>
                        <td><?php echo $cnt; ?></td>
                        <td><?php echo $value['Internalsamplecode']; ?></td>
                        <td><?php echo @$NewDateofvisit; ?></td>
                        <td><?php echo $value['Fruitshape']; ?></td>
                        <td><?php echo $value['Plantvigur']; ?></td>
                        <td><?php echo $value['Yield']; ?></td>
                        <td><?php echo $value['Maturity']; ?></td>
                        <td><?php echo $value['Firmness']; ?></td>
                        <td><?php echo $value['Uniformity']; ?></td>
                        <td><?php echo $value['Overallrating']; ?></td>
                      </tr>
                  <?php $cnt++; }  ?>
                  <?php }else{ ?>
                    <tr class="not_found">
                      <td colspan="10"> Record Not Found </td>
                    </tr>
                  <?php } ?>   

                </table>
            </div>
          </div><!-- /.col -->  
        </div><!-- /.row -->
        <?php } ?>
        
      </section>
      <!-- /.content -->
    </div>
    <?php include('common/footer_content.php');?>
    <?php include('common/sidebar_control.php');?> 
</div>
<!-- ./wrapper -->
<?php include('common/footer.php');?>