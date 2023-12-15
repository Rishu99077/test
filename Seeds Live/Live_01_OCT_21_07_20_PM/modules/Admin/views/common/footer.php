<!-- jQuery 3 -->
<script src="<?php echo base_url(); ?>adminasset/js/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url(); ?>adminasset/bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url(); ?>adminasset/fastclick/js/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>adminasset/js/adminlte.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>adminasset/js/jquery-ui.js"></script>
<script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script src="<?php echo base_url(); ?>adminasset/js/custom.js"></script>
<script src="<?php echo base_url(); ?>adminasset/js/select2.min.js"></script>
<script src="<?php echo base_url(); ?>adminasset/js/picturefill.min.js"></script>
<script src="<?php echo base_url(); ?>adminasset/js/lightgallery-all.min.js"></script>
<script src="<?php echo base_url(); ?>adminasset/js/jquery.mousewheel.min.js"></script>

<script>
$(document).ready(function() {
    $('.select2box').select2();
});    
function doconfirm()
{
    job=confirm("Are you sure to delete permanently?");
    if(job!=true)
    {
        return false;
    }
}
</script>
<!-- <script src="https://cdn.ckeditor.com/ckeditor5/16.0.0/classic/ckeditor.js"></script>
<script>
        ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .then( editor => {
                console.log( editor );
        } )
        .catch( error => {
                console.error( error );
        } );
</script> -->
</body>
</html>
