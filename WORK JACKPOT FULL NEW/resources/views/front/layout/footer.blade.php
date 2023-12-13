			</div>
    <!-- bootstrap js -->
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>

    <!-- FontAwesome -->
    <!-- <script src="https://kit.fontawesome.com/6a8b7e6905.js" crossorigin="anonymous"></script> -->

    <!-- slick slider -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.min.js"></script>


    <!-- Range Slider -->

    <script src="https://codepen.io/nosurprisethere/pen/rJzKOe"></script>
    <!-- Double Range Slider -->


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js"></script>
    <!-- custom js -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bower_components/toast-master/js/jquery.toast.js') }}"></script>
    <!-- <script src="https://cdn.ckeditor.com/ckeditor5/16.0.0/classic/ckeditor.js"></script> -->

</body>
</html>
<script type="text/javascript">
    $(document).ready(function() {
        $('.select2box').select2();
    });

    function doconfirm(String){
        if(String ==""){

        job=confirm('{{__("customer.text_sure_to_delete")}}');
    }else{}
        job=confirm(String);
        if(job!=true)
        {
            return false;
        }
    }

    function goBack() {
       window.history.back();
    }

</script>
<script type="text/javascript">
    function danger_msg(msg){
        $.toast({   
           heading: 'Error',  
           text: msg,  
           position: 'top-right',   
           loaderBg: '#fff',   
           icon: 'error',   
           hideAfter: 3500,   
           stack: 6   
       });
    }
    function success_msg(msg){
    $.toast({
       heading: 'Success',
       text: msg,
       position: 'top-right',
       loaderBg: '#fff',
       icon: 'success',
       hideAfter: 3500,
       stack: 6
   });
    }
</script>

@if($errors->has('error'))
    <script>
       $.toast({   
               heading: 'Error',  
               text: "{{ $errors->first('error') }}",  
               position: 'top-right',   
               loaderBg: '#fff',   
               icon: 'error',   
               hideAfter: 3500,   
               stack: 6   
           });
       
    </script>
    @endif
    @if($errors->has('success'))
    <script>
       $.toast({
           heading: 'Success',
           text: "{{ $errors->first('success') }}",
           position: 'top-right',
           loaderBg: '#fff',
           icon: 'success',
           hideAfter: 3500,
           stack: 6
       });
    </script>
@endif 


