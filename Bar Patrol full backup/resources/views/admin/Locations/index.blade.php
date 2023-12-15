@include('admin.Common.header')
@include('admin.Common.sidebar')
@include('admin.Common.topbar')
      <?php $Current_restaurant =  $data['user_details']['restaurant_name']; ?>
      <div class="d-flex align-items-center justify-content-between announce_ban bg_black mb_40">
         <div class="">
            <h3 class="f24 mb-0 text-white">All Locations</h3>
         </div>
         <div class="">
            <a href="{{('add_location')}}" class="rec_btn">
              <span class="mr_10"><i class="fa fa-plus"></i> Add New</span>
            </a>
         </div>
      </div>
      @foreach (['danger', 'warning', 'success', 'info', 'error'] as $key)
        @if(Session::has($key))
          <p id="success_msg" class="alert alert-{{ $key }}">{{ Session::get($key) }}</p>
        @endif
      @endforeach
      <div class="row">
        <div class="col-md-6">
            <!-- Current user Product -->
            <h2>{{$Current_restaurant}}</h2>
            <div class="all_inve_main">
               <form action="">
                  @csrf
                  <div class="all_inve_tab">
                     <table>
                        <thead>
                           <tr>
                              <th>Location Name</th>
                              <th>Restaurant name</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                          <?php if (!empty($user_locations)) { ?>
                             <?php foreach ($user_locations as $key => $value) { ?>
                             <tr class="alert alert-dismissible fade show" role="alert">
                                <td>{{$value['location_name'];}}</td>
                              
                                <td>{{$value['restaurant_name'];}}</td>
                                <td>
                                   <div class="d-flex align-items-center inve_ed_del justify-content-center">
                                      <a href="{{url('add_location')}}?LocationID={{$value['LocationID']}}" ><i class="fa fa-pencil-square-o text-success fa-2x"></i></a>
                                      <a href="{{url('delete_location')}}?LocationID={{$value['LocationID']}}" onClick="return doconfirm();"><i class="fa fa-trash-o text-danger fa-2x"></i></a>
                                   </div>
                                </td>
                             </tr>
                             <?php } ?>
                          <?php }else{ ?>
                              <tr class="alert alert-dismissible fade show" role="alert">
                                  <td colspan="10" class="text-center">No locations</td>
                              </tr>
                          <?php } ?>   
                        </tbody>
                     </table>
                  </div>
               </form>
            </div>
        </div>
        <div class="col-md-6">
            <?php if ($data['user_details']['user_role']=='1') {?>

                <h2>All Restaurant location</h2>
                <div class="all_inve_main">
                   <form action="">
                      @csrf
                      <div class="all_inve_tab">
                         <table>
                            <thead>
                               <tr>
                                  <th>Location Name</th>
                                  <th>Status</th>
                                  <th>Restaurant name</th>
                                  <th>Action</th>
                               </tr>
                            </thead>
                            <tbody>
                              <?php if (!empty($admin_locations)) { ?>
                                 <?php foreach ($admin_locations as $key => $value) { ?>
                                 <tr class="alert alert-dismissible fade show" role="alert">
                                    <td>{{$value['location_name'];}}</td>
                                    <td>
                                       <?php if ($value['status']==0) { ?>
                                          <a onClick="return moveconfirm();" id="Move_master" data-id="{{$value['LocationID']}}" data-name="{{$value['location_name']}}" class="btn btn-success">Move to master</a>
                                       <?php }elseif ($value['status']==1) { ?> 
                                         <a onClick="return remove_confirm();" id="Remove_master" data-id="{{$value['LocationID']}}" data-name="{{$value['location_name']}}" class="btn btn-danger">Remove from master</a>
                                       <?php } ?>
                                    </td>
                                    <td>{{$value['restaurant_name'];}}</td>
                                    <td>
                                     <div class="d-flex align-items-center inve_ed_del justify-content-center">
                                        <a href="{{url('delete_location')}}?LocationID={{$value['LocationID']}}" onClick="return doconfirm();"><i class="fa fa-trash-o text-danger fa-2x" aria-hidden="true"></i></a>
                                     </div>
                                    </td>
                                 </tr>
                                 <?php } ?>
                              <?php }else{ ?>
                                  <tr class="alert alert-dismissible fade show" role="alert">
                                      <td colspan="10" class="text-center">No locations</td>
                                  </tr>
                              <?php } ?>   
                            </tbody>
                         </table>
                      </div>
                   </form>
                </div>
            <?php }elseif ($data['user_details']['user_role']!='1') { ?>

                <h2>Master Location</h2>
                <div class="all_inve_main">
                   <form action="">
                      @csrf
                      <div class="all_inve_tab">
                         <table>
                            <thead>
                               <tr>
                                  <th>Location Name</th>
                                  <th>Restaurant name</th>
                                  <th style="text-align: left;">Action</th>
                               </tr>
                            </thead>
                            <tbody>
                              <?php if (!empty($master_locations)) { ?>
                                 <?php foreach ($master_locations as $key => $value) { ?>
                                 <tr class="alert alert-dismissible fade show" role="alert">
                                    <td>{{$value['location_name'];}}</td>
                                    <td>{{$value['restaurant_name'];}}</td>
                                    <td><a onClick="return addconfirm();" id="Add" data-id="{{$value['LocationID']}}" data-name="{{$value['location_name'];}}" class="btn btn-success"><i class="fa fa-plus"></i>Add</a></td>
                                 </tr>
                                 <?php } ?>
                              <?php }else{ ?>
                                  <tr class="alert alert-dismissible fade show" role="alert">
                                      <td colspan="10" class="text-center">No locations</td>
                                  </tr>
                              <?php } ?>   
                            </tbody>
                         </table>
                      </div>
                   </form>
                </div>
            <?php } ?>  
        </div>
      </div>
   </div>
</div>
@include('admin.Common.footer')

<script type="text/javascript">
    function addconfirm(){
        job=confirm("Are you sure to add this location?");
        if(job!=true){
            return false;
        }
    }
    
    function moveconfirm(){
        job=confirm("Are you sure to move this location into master?");
        if(job!=true){
            return false;
        }
    }

    function remove_confirm(){
        job=confirm("Are you sure to remove this location from master?");
        if(job!=true){
            return false;
        }
    }
</script>

<!-- Location move to master -->
<script type="text/javascript">
    $('body').on("click",'#Add', function(){
      var LocationID = $(this).attr('data-id');
      var location_name = $(this).attr('data-name');
      _token = $("input[name='_token']").val();
      $.ajax({
        url:"{{ url('add_location_from_master') }}",
        type: 'post',
        data: {'LocationID': LocationID , 'location_name':location_name , '_token':_token},
         success: function(response) {
            window.location.href = "locations";  
         }
      });
      return false;
   
    });

    $('body').on("click",'#Move_master', function(){
      var LocationID = $(this).attr('data-id');
      var location_name = $(this).attr('data-name');
   
      _token = $("input[name='_token']").val();
      $.ajax({
        url:"{{ url('location_movetomaster') }}",
        type: 'post',
        data: {'LocationID': LocationID,'location_name':location_name,'_token':_token},
         success: function(response) {
            window.location.href = "locations";  
         }
      });
      return false;
   
    });


    $('body').on("click",'#Remove_master', function(){
      var LocationID = $(this).attr('data-id');
      var location_name = $(this).attr('data-name');
   
      _token = $("input[name='_token']").val();
      $.ajax({
        url:"{{ url('location_remove_master') }}",
        type: 'post',
        data: {'LocationID': LocationID,'location_name':location_name,'_token':_token},
         success: function(response) {
            window.location.href = "locations";  
         }
      });
      return false;
   
    });
</script>

