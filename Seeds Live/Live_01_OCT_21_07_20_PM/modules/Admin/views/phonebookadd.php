<?php include('common/header.php');?>
<div class="wrapper">
    <?php include('common/topbar.php');?>
    <?php include('common/left_sidebar.php');?>  
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1><?php echo $heading_title; ?></h1>
         <!-- <h1><?php echo $UserID; ?></h1> -->
      </section>
      <!-- Main content -->
      <section class="content">
        <!-- Info boxes -->
        <div class="row">

            <div class="col-md-6">
              <div class="box box-primary">
                <!-- form start -->
                <form role="form" id="addphonebook" action="" method="post" enctype="multipart/form-data"  accept-charset="utf-8" name="formname">
                  <div class="box-body">
                    <div class="form-group" id="Inputuserid">
                      <input type="hidden" class="form-control" id="UserID" name="UserID" value="<?php echo $UserID; ?>">
                    </div>

                    <div class="form-group" id="Inputname">
                      <label for="name" class="required">Name</label>
                      <input type="text" class="form-control" id="name" name="name" placeholder="Enter Your Name">
                      <span class="help-block"></span>
                    </div>
                    
                    <div class="form-group" id="Inputfamily_name">
                      <label for="family_name" class="required">Family Name</label>
                      <input type="text" class="form-control" id="family_name" name="family_name" placeholder="Enter Your family name">
                      <span class="help-block"></span>
                    </div>

                    <div class="form-group" id="Inputtelephone1">
                      <label for="telephone1">Telephone 1</label>
                      <input type="number" class="form-control" id="telephone1" name="telephone1" placeholder="Enter Your Telephone Number">
                    </div>

                    <div class="form-group" id="Inputtelephone2">
                      <label for="telephone2">Telephone 2</label>
                      <input type="number" class="form-control" id="telephone2" name="telephone2" placeholder="Enter Your 2nd Telephone Number">
                    </div>

                    <div class="form-group" id="Inputtelephone3">
                      <label for="telephone3">Telephone 3</label>
                      <input type="number" class="form-control" id="telephone3" name="telephone3" placeholder="Enter Your 3rd Telephone Number">
                    </div>

                    <div class="form-group" id="Inputmobile1">
                      <label for="mobile1" class="required">Mobile 1</label>
                      <input type="number" class="form-control" id="mobile1" name="mobile1" placeholder="Enter Your Mobile Number">
                      <span class="help-block"></span>
                    </div>

                    <div class="form-group" id="Inputmobile2">
                      <label for="mobile2">Mobile 2</label>
                      <input type="number" class="form-control" id="mobile2" name="mobile2" placeholder="Enter Your 2nd Mobile Number">
                    </div>

                    <div class="form-group" id="Inputaddress">
                      <label for="address">Address</label>
                      <textarea class="form-control" name="address" id="address"></textarea>
                    </div>

                    <div class="form-group" id="Inputcity">
                      <label for="city" class="required">City</label>
                      <input type="text" class="form-control" id="city" name="city" placeholder="Enter Your City">
                      <span class="help-block"></span>
                    </div>

                    <div class="form-group" id="Inputpostcode">
                      <label for="postcode">Postcode</label>
                      <input type="number" class="form-control" id="postcode" name="postcode" placeholder="Enter Your Postcode">
                    </div>

                    <div class="form-group" id="Inputemail">
                      <label for="email" class="required">Email</label>
                      <input type="text" class="form-control" id="email" name="email" placeholder="Enter Your Email address">
                      <span class="help-block"></span>
                    </div>

                    <div class="form-group" id="Inputissue">
                      <label for="issue" class="required">Issue</label>
                      <textarea class="form-control" name="issue" id="issue"></textarea>
                      <span class="help-block"></span>
                    </div>

                  
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form>
              </div>
              <!-- /.box -->
              </div>
          <div class="col-md-6">
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
  /* Add Hired Script */
$(document).ready(function(){ 
  $("#addphonebook").submit(function(){
      $('#addphonebook .form-group').removeClass('has-error');
      $('#addphonebook .help-block').html('');

      $.ajax({
          url: 'addphonebookvalidation',
          type: 'post',
          dataType: 'json',
          data: new FormData(this),
          contentType:false,
            cache:false,
            processData:false,
          success: function(response) {
              var i = 1;
              if(response.error){
                jQuery.each( response.data, function( index, value ) {
              if(value!=''){
                $('#Input'+index).addClass('has-error');
                $('#Input'+index+' .help-block').html(value);
                if(i==1){ 
                  $('#'+index).focus();
                }
                i++;
              }
          });          
              }else{
                //$(this).submit();
                window.location.href = response.url;
              }
          }
      });
      return false; 
  }); 
});
</script>
