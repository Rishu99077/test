<?php include('common/header.php');?>

<style type="text/css">

  .select2-container{width: 100%!important;}

  .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {

      background-color: #fefefe;border: unset;}

  textarea {border: 1px solid #fefefe;}

  .viewonlyclass {

      padding: 6px 12px;

      background: #fefefe;

  }

  ul.buttons_list {margin-top: 30px;padding: 0;list-style: none;text-align: right;}

  ul.buttons_list li {display: inline-block;}

  ul.buttons_list li a {color: #fff;font-size: 20px;text-transform: uppercase;background: #12B13B;padding: 5px 15px;}

  ul.buttons_list li a i {color: #fff;padding-right: 5px;font-size: 15px;}

  ul.buttons_list { margin-top: 0;}

  ul.buttons_list li button {

    color: #fff;

    font-size: 20px;

    text-transform: uppercase;

    background: #12B13B;

    padding: 5px 15px;border: unset;

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

              <div class="col-md-9">

                <h1><?php echo $heading_title; ?></h1>

              </div>

              <div class="col-md-3">

                <ul class="buttons_list">

                    <li><button onclick="goBack()">

                        <i class="fa fa fa-level-up" aria-hidden="true"></i>

                        Back

                        </button>

                    </li>

                </ul>

              </div>

            </div>

          </div>

        </div>           

      </section>

      <!-- Main content -->

      <section class="content">

        <!-- Info boxes -->



        <div class="row">

          <div class="col-md-12">
           <!--  <?php echo $get_single_trial['latitude']; ?>
            <?php echo $get_single_trial['longitude']; ?> -->
              <div class="box box-primary">
                  <div id="map-container-google-4" class="z-depth-1-half map-container-4">
                    <iframe src="https://maps.google.com/maps?q=<?php echo $get_single_evaluation['latitude'].','.$get_single_evaluation['longitude']; ?>&t=&z=13&ie=UTF8&iwloc=&output=embed"  frameborder="0"
                      style="border:0; height: 700px; width: 100%;"></iframe>
                  </div>
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

<script type="text/javascript">

  $(document).ready(function(){

      $('#lightgallery').lightGallery({

      	share:false,

      });

  });

</script>

<script>

function goBack() {

  window.history.back();

}

</script>