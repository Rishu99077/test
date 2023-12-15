<?php include('common/header.php');?>

<style type="text/css">

  .select2-container{width: 100%!important;}

   table.table1 {

    border: 1px solid #ccc;

  }

  table.table1 td {

    padding: 10px;

    border: 1px solid #ccc;

  }

  table.table2 {

    border: 1px solid #ccc;

  }

  table.table2 td {

    padding: 10px;

    border: 1px solid #ccc;

  }

  ul.buttons_list { margin-top: 0;}

  ul.buttons_list li button {

    color: #fff;

    font-size: 20px;

    text-transform: uppercase;

    background: #12B13B;

    padding: 5px 15px;border: unset;

}
.buttons_list{
    color: #fff;

    font-size: 20px;

    text-transform: uppercase;

    color: #12B13B;

    padding: 0px 15px;border: unset;
}

ul.buttons_list li button i {

    color: #fff;

    padding-right: 5px;

    font-size: 15px;

}

</style>

<div class="wrapper">

    <?php include('common/topbar.php');?>

    <?php include('common/left_sidebar.php');?>  

    <div class="content-wrapper">

      <!-- Content Header (Page header) -->

      <section class="content-header">

        <div class="row">

          <div class="col-md-12">

            <div class="row">

              <div class="col-md-6">

                <h1><?php echo $heading_title; ?>
                  <?php $SeedID = $_GET['SeedID']; ?>
                </h1>

              </div>
              <div class="col-md-5">
              <?php if($userrole=='1' || $userrole=='4' || in_array("export", $userpermission)){ ?>
                <?php 
                    $exporturl = base_url()."admin/summaryexport?SeedID=".$SeedID; 
                ?>
                <a href="<?php echo $exporturl; ?>" style="float: right;"><button type="button" style="padding: 6px 20px;" class="btn btn-primary btn-export">Export Data</button></a>
              <?php } ?>
              </div>
                <div class="col-md-1 buttons_list"><button onclick="goBack()" style="background-color: #12B13B; color: #fff; width: 70px;" ><i class="fa fa fa-level-up" aria-hidden="true"></i>Back</button></div>

             <!--  <div class="col-md-2">

                <ul class="buttons_list">
                    <li><button onclick="goBack()"> 
                       <i class="fa fa fa-level-up" aria-hidden="true"></i>
                        Back
                        </button>
                    </li>
                  </ul>
              </div> -->

            </div>

          </div>

        </div>        

      </section>

      <!-- Main content -->

      <section class="content">



        <div class="row">

          <div class="col-md-12">

             <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                  <tr>
                    <th>S.No.</th>
                    <th>Crop</th>
                    <th>Variety</th>
                    <th>Location</th>
                    <th>Supplier Name</th>
                    <th>Sampling</th>
                    <th>Trial Count</th>
                    <th>Evaluations</th>
                    <th>Result</th>
                    <th>Close Status</th>
                  </tr>

                  <?php if(count($sampling) > 0) { ?>
                  <?php $cnt = 1; ?>
                  <?php foreach ($sampling as $value) { ?>
                      <tr>
                        <td><?php echo $cnt; ?></td>
                        <td><?php echo $value['CropTitle']; ?></td>
                        <td><?php echo $value['SeedVariety']; ?></td>
                        <td><?php echo @$value['Location']; ?></td>
                        <td><?php echo $value['SupplierName']; ?></td>
                        <td><?php echo $value['Internalsamplingcode']; ?></td>
                        <td><a href="<?php echo base_url(); ?>admin/trialsummary/?Internalsamplingcode=<?php echo $value['Internalsamplingcode']; ?>"><?php echo $value['trailcount']; ?> Trails</a></td>
                        <td><?php if($value['evaluationcount']==0){ 
                          echo "No";
                        }elseif($value['evaluationcount']>=1) {?>
                          <a href="<?php echo base_url(); ?>admin/evaluationview/?EvaluationID=<?php echo $value['EvaluationID']; ?>">Yes</a>
                       <?php }?></td>
                        
                       <!--  <td><?php if($value['Status']=='Pre-commercial' || $value['Status']=='Commercial or control variety'){
                          echo $value['Status'];
                        }elseif($value['evaluationcount']==0){
                          echo "No Status";
                        }elseif($value['Status']=='New Sample' || $value['Status']=='Re-check 1' || $value['Status']=='Re-check 2' || $value['Status']=='Re-check 3' ||$value['Status']=='Drop'){
                          echo $value['EvaluationStatus'];
                        } ?></td> -->

                        <td>
                          <?php
                          if ($value['evaluationcount']!=0) {
                            if($value['EvaluationStatus']=='')
                            {
                                if($value['Status']=='Pre-commercial' || $value['Status']=='Commercial or control variety'){
                                  echo $value['Status'];
                                }
                            }
                            else{
                              echo $value['EvaluationStatus'];  
                            }
                          }else{
                            echo "No Status";
                          }
                          ?>
                        </td>
                        
                        <td><?php if ($value['get_close']>=1) {
                          echo "Closed";
                        }else{
                          echo "Open";
                        } ?></td>
                      </tr>
                  <?php $cnt++; }  ?>
                  <?php }else{ ?>
                    <tr class="not_found">
                      <td colspan="9"> Record Not Found </td>
                    </tr>
                  <?php } ?>

                </table>
              </div>

              <!-- /.box -->

          </div>

          <!-- /.col -->

        </div>

        <!-- /.row -->

      </section>

      <!-- /.content -->

    </div>

    <?php include('common/footer_content.php');?>

    <?php include('common/sidebar_control.php');?> 

</div>

<!-- ./wrapper -->

<?php include('common/footer.php');?>

<!-- <script type="text/javascript">

  $(document).ready(function(){

      $('#lightgallery').lightGallery({

        share:false,

      });

  });

</script> -->

<script>

function goBack() {

  window.history.back();

}

</script>