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

              <div class="col-md-11">

                <h1><?php echo $heading_title; ?>
                  <?php $SeedID = $_GET['SeedID']; ?>
                </h1>

              </div>
              <!-- <div class="col-md-5">
              <?php if($userrole=='1' || $userrole=='4' || in_array("export", $userpermission)){ ?>
                <?php 
                    $exporturl = base_url()."admin/summaryexport?SeedID=".$SeedID; 
                ?>
                <a href="<?php echo $exporturl; ?>" style="float: right;"><button type="button" style="padding: 6px 20px;" class="btn btn-primary btn-export">Export Data</button></a>
              <?php } ?>
              </div> -->
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
                    <th>Sampling</th>
                    <th>Location</th>
                    <th>Supplier</th>
                    <th>Number of seeds request</th>
                    <th>By when</th>
                    <th>Evaluation Added Date</th>
                    <th>Added By</th>
                    <th>Status</th>
                   
                  </tr>

                  <?php if(count($sampling) > 0) { ?>
                  <?php $cnt = 1; ?>
                  <?php foreach ($sampling as $value) { 
                        if($value['AddedDate']!=''){
                         $newAddDate = $value['AddedDate'];
                         $newAddDate1 = date("d-F-Y",strtotime($newAddDate));
                         }
                    
                    ?>

                      <tr>
                        <td><?php echo $cnt; ?></td>
                        <td><?php echo @$value['Internalsamplingcode']; ?></td>

                        <td><?php echo @$value['Location']; ?></td>
                        <td><?php echo @$value['SupplierName']; ?></td>

                        <td><?php echo @$value['Numberofseeds']; ?></td>
                        <td><?php echo @$value['ByWhen']; ?></td>

                        <td><?php echo @$newAddDate1; ?></td>
                        <td><?php echo @$value['Fullname']; ?></td>
                        <td><?php echo @$value['Status']; ?></td>  
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