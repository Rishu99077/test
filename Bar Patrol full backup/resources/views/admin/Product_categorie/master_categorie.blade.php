@include('admin.Common.header')
@include('admin.Common.sidebar')
@include('admin.Common.topbar')
      <div class="d-flex align-items-center justify-content-between announce_ban bg_black mb_40">
         <div class="">
            <h3 class="f24 mb-0 text-white">All Products categorie Records</h3>
         </div>
      </div>
      @foreach (['danger', 'warning', 'success', 'info', 'error'] as $key)
	      @if(Session::has($key))
	    	  <p id="success_msg" class="alert alert-{{ $key }}">{{ Session::get($key) }}</p>
	      @endif
      @endforeach
      <div class="all_inve_main">
         <form action="">
            @csrf
            <div class="all_inve_tab">
               <table>
                  <thead>
                     <tr>
                     	  <th>Product type Name</th>
                        <th>Categorie Name</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                  	 <?php if (!empty($master_products)) { ?>
                     <?php foreach ($master_products as $key => $value) { ?>
                     <tr class="alert alert-dismissible fade show" role="alert">
                     	  <td>{{$value['product_type_name'];}}</td>
                        <td>{{$value['categorie_name'];}}</td>
                
                        <td><a onClick="return addconfirm();" id="Add" data-id="{{$value['Categorie_ID']}}" data-name="{{$value['categorie_name'];}}" class="btn btn-success"><i class="fa fa-plus"></i>Add</a></td>
                     </tr>
                     <?php } ?>
                     <?php }else{ ?>
                     <tr class="alert alert-dismissible fade show text-center" role="alert">
                        <td class="text-center" colspan="6">No Categorie</td>
                     </tr>
                     <?php } ?>
                  </tbody>
               </table>
            </div>
         </form>
      </div>
   </div>
</div>
@include('admin.Common.footer')
<script type="text/javascript">
   function addconfirm(){
        job=confirm("Are you sure to add this categorie?");
        if(job!=true){
            return false;
        }
    }
</script>

<!-- Location move to master -->
<script type="text/javascript">
  $('body').on("click",'#Add', function(){
      var Categorie_ID = $(this).attr('data-id');
      var categorie_name = $(this).attr('data-name');
      _token = $("input[name='_token']").val();
      $.ajax({
        url:"{{ url('addcategorie_from_master') }}",
        type: 'post',
        data: {'Categorie_ID': Categorie_ID , 'categorie_name':categorie_name , '_token':_token},
         success: function(response) {
            window.location.href = "master_categorie";  
         }
      });
      return false;
   
   });
</script>