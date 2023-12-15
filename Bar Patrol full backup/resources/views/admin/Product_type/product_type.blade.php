@include('admin.Common.header')
@include('admin.Common.sidebar')
@include('admin.Common.topbar')
<style type="text/css">
   .icon_img{height: 50px;width: 50px;}
</style>
      <?php $Current_user =  $data['user_details']['restaurant_name']?>
      <div class="d-flex align-items-center justify-content-between announce_ban bg_black mb_40">
          <div class="">
              <h3 class="f24 mb-0 text-white">Product Type</h3>
          </div>
          <div class="">
            <a href="{{('add_Producttype')}}" class="rec_btn">
              <span class="mr_10"><i class="fa fa-plus"></i> Add New</span>
            </a>
         </div>
      </div>
      @foreach (['danger', 'warning', 'success', 'info', 'error'] as $key)
        @if(Session::has($key))
          <p id="success_msg" class="alert alert-{{ $key }}">{{ Session::get($key) }}</p>
        @endif
      @endforeach
       <?php
       @$ProductName = $_GET['ProductName'];
       @$MasterProductName = $_GET['MasterProductName'];
      ?>
      <div class="row">
        <div class="col-md-6">
            <!-- Current user Product -->
            <form action="{{url('Product_type')}}" method="get">
              <div class="row">
                  <div class="col-md-6">
                    <div class="row">
                        <div class="add_inve_box col-md-6">
                          <label>Product name</label>
                          <input type="text" name="ProductName" class="form-control Search_items" placeholder=" product name" value="<?php if (@$ProductName != ''){
                            echo $ProductName ; } ?>">
                        </div>
                    </div>
                  </div>
                  <div class="col-md-6 mt-4">
                    <div class="row">
                        <div class="add_inve_box col-md-12">
                            <label></label>
                            <button type="submit" class="btn btn-success">Search</button>
                            <a id="clear" href="{{('Product_type')}}" class="btn btn-danger clear">Clear</a>
                        </div>
                    </div>
                  </div>
              </div>
            </form>  
            <h2>{{$Current_user}}</h2>
            <div class="all_inve_main">
               <form action="">
                  @csrf
                  <div class="all_inve_tab">
                     <table>
                        <thead>
                           <tr>
                              <th>Name</th>
                              <th>Icon</th>
                              <th>Restaurant name</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                          <?php if (!empty($user_products)) { ?>
                           <?php foreach ($user_products as $key => $value) { 
                              $IconImage = $value["icon_name"]; ?>
                           <tr class="alert alert-dismissible fade show" role="alert">
                              <td>{{$value['name'];}}</td>
                              <td>
                                <?php if ($IconImage!='') { ?>
                                  <img src="{{asset('App/IconsImages').'/'.$IconImage}}" class="icon_img">
                                <?php }else{ echo "No icon"; } ?>
                              </td>
                              <td>{{$value['restaurant_name'];}}</td>
                              <td>
                                 <div class="d-flex align-items-center inve_ed_del justify-content-center">
                                    <a href="{{('add_Producttype')}}?Product_type_Id={{$value['id']}}">
                                      <i class="fa fa-pencil-square-o text-success fa-2x"></i>
                                    </a>
                                    <a href="{{url('delete_Producttype')}}?Product_type_Id={{$value['id']}}" onClick="return doconfirm();"><i class="fa fa-trash-o text-danger fa-2x"></i></a>
                                 </div>
                              </td>
                           </tr>
                           <?php } ?>
                           <?php }else{ ?>
                           <tr class="alert alert-dismissible fade show text-center" role="alert">
                              <td class="text-center" colspan="6">No Products type</td>
                           </tr>
                           <?php } ?> 
                        </tbody>
                     </table>
                  </div>
               </form>
                <div class="row">
                  <div class="col-md-12">
                    {{$get_user_producttype->appends(request()->input())->links()}}
                  </div>
                </div> 
            </div>
        </div>
        <div class="col-md-6">
            <?php if ($data['user_details']['user_role']=='1') {?>
                <form action="{{url('Product_type')}}" method="get">
                  <div class="row">
                      <div class="col-md-6">
                        <div class="row">
                            <div class="add_inve_box col-md-6">
                              <label>Product name</label>
                              <input type="text" name="ProductName" class="form-control Search_items" placeholder=" product name" value="<?php if (@$ProductName != ''){
                                echo $ProductName ; } ?>">
                            </div>
                        </div>
                      </div>
                      <div class="col-md-6 mt-4">
                        <div class="row">
                            <div class="add_inve_box col-md-12">
                                <label></label>
                                <button type="submit" class="btn btn-success">Search</button>
                                <a id="clear" href="{{('Product_type')}}" class="btn btn-danger clear">Clear</a>
                            </div>
                        </div>
                      </div>
                  </div>
                </form>  
                <h2>All Restaurant products</h2>
                <div class="all_inve_main">
                   <form action="">
                      @csrf
                      <div class="all_inve_tab">
                         <table>
                            <thead>
                               <tr>
                                  <th>Name</th>
                                  <th>Icon</th>
                                  <th>Status</th>
                                  <th>Restaurant name</th>
                                  <th>Action</th>
                               </tr>
                            </thead>
                            <tbody>
                              <?php foreach ($admin_products as $key => $value) { 
                                $IconImage = $value["icon_name"]; ?>
                                <tr class="alert alert-dismissible fade show" role="alert">
                                    <td>{{$value['name'];}}</td>
                                    <td>
                                      <?php if ($IconImage!='') { ?>
                                        <img src="{{asset('App/IconsImages').'/'.$IconImage}}" class="icon_img">
                                      <?php }else{ echo "No icon"; } ?>
                                    </td>
                                    <td>
                                       <?php if ($value['status']==0) { ?>
                                          <a onClick="return moveconfirm();" id="Move_master" data-id="{{$value['id']}}" data-name="{{$value['name']}}" class="btn btn-success">Move to master</a>
                                       <?php }elseif ($value['status']==1) { ?> 
                                         <a onClick="return remove_confirm();" id="Remove_master" data-id="{{$value['id']}}" data-name="{{$value['name']}}" class="btn btn-danger">Remove from master</a>
                                       <?php } ?>
                                    </td>
                                    <td>{{$value['restaurant_name'];}}</td>
                                    <td>
                                       <div class="d-flex align-items-center inve_ed_del justify-content-center">
                                         <a href="{{('add_Producttype')}}?Product_type_Id={{$value['id']}}">
                                            <i class="fa fa-pencil-square-o text-success fa-2x" aria-hidden="true"></i>
                                          </a>
                                          <a href="{{url('delete_Producttype')}}?Product_type_Id={{$value['id']}}" onClick="return doconfirm();"><i class="fa fa-trash-o text-danger fa-2x" aria-hidden="true"></i></a>
                                       </div>
                                    </td>
                                </tr>
                              <?php } ?>
                            </tbody>
                         </table>
                      </div>
                   </form>
                    <div class="row">
                      <div class="col-md-12">
                        {{$get_admin_producttype->appends(request()->input())->links()}}
                      </div>
                    </div> 
                </div>
            <?php }elseif ($data['user_details']['user_role']!='1') { ?>
                <form action="{{url('Product_type')}}" method="get">
                  <div class="row">
                      <div class="col-md-6">
                        <div class="row">
                            <div class="add_inve_box col-md-6">
                              <label>Product name</label>
                              <input type="text" name="MasterProductName" class="form-control Search_items" placeholder=" product name" value="<?php if (@$MasterProductName != ''){
                                echo $MasterProductName ; } ?>">
                            </div>
                        </div>
                      </div>
                      <div class="col-md-6 mt-4">
                        <div class="row">
                            <div class="add_inve_box col-md-12">
                                <label></label>
                                <button type="submit" class="btn btn-success">Search</button>
                                <a id="clear" href="{{('Product_type')}}" class="btn btn-danger clear">Clear</a>
                            </div>
                        </div>
                      </div>
                  </div>
                </form>
                <h2>Master products</h2>
                <div class="all_inve_main">
                  <form action="">
                    @csrf
                    <div class="all_inve_tab">
                       <table>
                          <thead>
                             <tr>
                                <th>Name</th>
                                <th>Icon</th>
                                <th style="text-align: left;">Action</th>
                             </tr>
                          </thead>
                          <tbody>
                             <?php foreach ($master_products as $key => $value) { 
                                $IconImage = $value["icon_name"]; ?>
                                 <tr class="alert alert-dismissible fade show" role="alert">
                                    <td>{{$value['name'];}}</td>
                                    <td>
                                      <?php if ($IconImage!='') { ?>
                                        <img src="{{asset('App/IconsImages').'/'.$IconImage}}" class="icon_img">
                                      <?php }else{ echo "No icon"; } ?>
                                    </td>
                                    <td><a onClick="return addconfirm();" id="Add" data-id="{{$value['id']}}" data-name="{{$value['name']}}" class="btn btn-success"><i class="fa fa-plus"></i>Add</a></td>  
                                 </tr>
                             <?php } ?> 
                          </tbody>
                       </table>
                    </div>
                  </form>
                  <div class="row">
                    <div class="col-md-12">
                      {{$get_superadmin_producttype->appends(request()->input())->links()}}
                    </div>
                  </div> 
                </div>
            <?php } ?>  
        </div>
      </div>
   </div>
</div>
@include('admin.Common.footer')

<script type="text/javascript">
    function addconfirm(){
        job=confirm("Are you sure to add this product type?");
        if(job!=true){
            return false;
        }
    }
    function moveconfirm(){
        job=confirm("Are you sure to move this Product type into master?");
        if(job!=true){
            return false;
        }
    }

    function remove_confirm(){
        job=confirm("Are you sure to remove this Product type from master?");
        if(job!=true){
            return false;
        }
    }  

</script>

<!-- Add  type from master -->
<script type="text/javascript">
    $('body').on("click",'#Add', function(){
      var Type_ID = $(this).attr('data-id'); 
      var type_name = $(this).attr('data-name');
      _token = $("input[name='_token']").val();

      $.ajax({
        url:"{{ url('addtype_from_master') }}",
        type: 'post',
        data: {'Type_ID': Type_ID,'type_name':type_name, '_token':_token},
         success: function(response) {
            window.location.href = "Product_type";  
         }
      });
      return false;
    });

    $('body').on("click",'#Move_master', function(){
      var Type_ID = $(this).attr('data-id');
      var type_name = $(this).attr('data-name');
   
      _token = $("input[name='_token']").val();
      $.ajax({
        url:"{{ url('product_type_movetomaster') }}",
        type: 'post',
        data: {'Type_ID': Type_ID,'type_name':type_name,'_token':_token},
         success: function(response) {
            window.location.href = "Product_type";  
         }
      });
      return false;
    });

    $('body').on("click",'#Remove_master', function(){
      var Type_ID = $(this).attr('data-id');
      var type_name = $(this).attr('data-name');
   
      _token = $("input[name='_token']").val();
      $.ajax({
        url:"{{ url('product_type_remove_master') }}",
        type: 'post',
        data: {'Type_ID': Type_ID,'type_name':type_name,'_token':_token},
         success: function(response) {
            window.location.href = "Product_type";  
         }
      });
      return false;
    });
</script>