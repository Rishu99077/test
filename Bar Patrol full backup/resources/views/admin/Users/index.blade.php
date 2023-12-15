@include('admin.Common.header')
@include('admin.Common.sidebar')
@include('admin.Common.topbar')
      <div class="d-flex align-items-center justify-content-between announce_ban bg_black mb_40">
         <div class="">
            <h3 class="f24 mb-0 text-white">All Users</h3>
         </div>
         <div class="">
            <a href="{{('add_user')}}" class="rec_btn">
              <span class="mr_10"><i class="fa fa-plus"></i> Add New user</span>
            </a>
         </div>
      </div>
      @foreach (['danger', 'warning', 'success', 'info', 'error'] as $key)
         @if(Session::has($key))
          <p id="success_msg" class="alert alert-{{ $key }}">{{ Session::get($key) }}</p>
         @endif
      @endforeach
      <div class="all_inve_main">
         <form action="">
            <div class="all_inve_tab">
               <table>
                  <thead>
                     <tr>
                        <th>Restaurant Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if (!empty($users)) { ?>
                     <?php foreach ($users as $key => $value) { ?>
                     <tr class="alert alert-dismissible fade show" role="alert">
                        <td>{{$value['restaurant_name'];}}</td>
                        <td>{{$value['email'];}}</td>
                        <td>{{$value['phone_no'];}}</td>
                        <td>
                           <div class="d-flex align-items-center inve_ed_del justify-content-center">
                              <a href="{{('add_user')}}?UserID={{$value['id']}}">
                                 <span class="inven_svg edit_inven">
                                    <svg id="fi-rr-edit" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                                       <path id="Path_566" data-name="Path 566" d="M15.242.709,6.1,9.853A3.725,3.725,0,0,0,5,12.5v1.007a.75.75,0,0,0,.75.75H6.757a3.724,3.724,0,0,0,2.651-1.1l9.144-9.144a2.344,2.344,0,0,0,0-3.31,2.4,2.4,0,0,0-3.31,0Zm2.25,2.25L8.348,12.1a2.265,2.265,0,0,1-1.591.658H6.5V12.5a2.265,2.265,0,0,1,.658-1.591L16.3,1.769a.861.861,0,0,1,1.19,0,.842.842,0,0,1,0,1.189Z" transform="translate(-1.25 -0.011)" fill="#009e10"/>
                                       <path id="Path_567" data-name="Path 567" d="M17.25,6.734a.75.75,0,0,0-.75.75V11.25h-3a2.25,2.25,0,0,0-2.25,2.25v3H3.75A2.25,2.25,0,0,1,1.5,14.25V3.75A2.25,2.25,0,0,1,3.75,1.5h6.781a.75.75,0,1,0,0-1.5H3.75A3.754,3.754,0,0,0,0,3.75v10.5A3.754,3.754,0,0,0,3.75,18h8.507a3.726,3.726,0,0,0,2.652-1.1L16.9,14.908A3.726,3.726,0,0,0,18,12.257V7.484A.75.75,0,0,0,17.25,6.734Zm-3.4,9.107a2.231,2.231,0,0,1-1.1.6V13.5a.75.75,0,0,1,.75-.75h2.944a2.262,2.262,0,0,1-.6,1.1Z" fill="#009e10"/>
                                    </svg>
                                 </span>
                              </a>
                              <a href="{{url('delete_user')}}?UserID={{$value['id']}}" onClick="return doconfirm();">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="15" height="18" viewBox="0 0 15 18">
                                    <g id="fi-rr-trash" transform="translate(-2)">
                                       <path id="Path_568" data-name="Path 568" d="M16.25,3H13.925A3.757,3.757,0,0,0,10.25,0H8.75A3.757,3.757,0,0,0,5.075,3H2.75a.75.75,0,0,0,0,1.5H3.5v9.75A3.755,3.755,0,0,0,7.25,18h4.5a3.755,3.755,0,0,0,3.75-3.75V4.5h.75a.75.75,0,0,0,0-1.5ZM8.75,1.5h1.5A2.254,2.254,0,0,1,12.372,3H6.628A2.254,2.254,0,0,1,8.75,1.5ZM14,14.25a2.25,2.25,0,0,1-2.25,2.25H7.25A2.25,2.25,0,0,1,5,14.25V4.5h9Z" fill="red"/>
                                       <path id="Path_569" data-name="Path 569" d="M9.75,16a.75.75,0,0,0,.75-.75v-4.5a.75.75,0,0,0-1.5,0v4.5A.75.75,0,0,0,9.75,16Z" transform="translate(-1.75 -2.5)" fill="red"/>
                                       <path id="Path_570" data-name="Path 570" d="M13.75,16a.75.75,0,0,0,.75-.75v-4.5a.75.75,0,0,0-1.5,0v4.5A.75.75,0,0,0,13.75,16Z" transform="translate(-2.75 -2.5)" fill="red"/>
                                    </g>
                                 </svg>
                              </a>
                           </div>
                        </td>
                     </tr>
                     <?php } ?>
                     <?php }else{ ?>
                     <tr class="alert alert-dismissible fade show text-center" role="alert">
                        <td class="text-center" colspan="6">No Users</td>
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