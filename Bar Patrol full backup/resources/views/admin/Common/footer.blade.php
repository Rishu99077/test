<!-- bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous">
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('admin/js/custom.js') }}"></script>
<script src="{{ asset('admin/js/select2.min.js') }}"></script>
</body>

</html>
<script type="text/javascript">
    $(document).ready(function() {
        $('.select2box').select2();
    }); 
    $(document).ready(function(){
        $('#success_msg').show();
        $('#success_msg').fadeOut(3000);
        $('html, body').animate({ scrollTop: $("#success_msg").offset().top-90 }, 2500);
         setTimeout(explode, 2000);
    });


    function doconfirm(){
        job=confirm("Are you sure to delete permanently?");
        // alert(job);
        if(job!=true)
        {
            return false;
        }
    }

    function goBack() {
       window.history.back();
    }

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script>
    $(document).ready(function(){
       $('.sort').sortable({
            stop:function(event, ui){
                var parameter = new Array();
                var position = new Array();
                $('.sort>tr').each(function(){
                    $(this).removeAttr("style");
                    parameter.push($(this).attr("id"));
                });
                $(this).children().each(function(index) {
                    position.push(index + 1);
                });
                _token = $("input[name='_token']").val();
                $.ajax({
                    url:"{{ route('product.savePosition')}}",
                    method:"POST",
                    data:{"id":parameter,"position":position,'_token':_token},
                    success:function(response){
                        console.log(response);
                    },
                    error:function(xhr,response){
                        console.log(xhr.status);
                    }
                });
            },

        })
});
</script>