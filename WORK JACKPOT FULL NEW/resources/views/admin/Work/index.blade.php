@include('admin.layout.header')
@include('admin.layout.sidebar')
<div class="main_right">
    <?php
       $Title = @$_GET['title'];
    ?>
    <div class="top_announce d-flex align-items-center justify-content-between mb_20">
        <div class="top_ann_left">
            <a href="{{Route('work_seeker')}}?title={{$Title}}" class="site_btn f16 f_bold blue__btn post_ad_disabled">{{$common['heading_title']}}</a>
        </div>
        <div class="top_ann_right d-flex align-items-center ">
            <form class="topan_search w-100 justify-content-xl-end">
                <a href="{{Route('work_seeker_add')}}?title={{$Title}}" class="btn add_btn"> {{__("admin.text_add_new")}} </a>
            </form>
        </div>
    </div>
  	<div class="main-section bg-white">
  		<table class="table table-responsive">
          <thead class="table-head">
             <tr>
                <th>{{__("admin.text_serial_no")}}</th>
                <th>{{__("admin.text_title")}}</th>
                <th>{{__("admin.text_role")}}</th>
                <th>{{__("admin.text_status")}}</th>
                <th>{{__("admin.text_action")}}</th>
             </tr>
          </thead>
          <tbody>
              <?php $cnt = 1;  
               if (!empty($works)) { 
               foreach ($works as $key => $value) { ?>
                <tr>
                  <td>{{$cnt}}</td>
                  <td>{{$value['title']}}</td>
                  <td>
                    @if($value['role'] == 'seeker')
                    <span >SEEKER</span>
                    @elseif($value['role'] == 'provider')
                    <span >PROVIDER</span>
                    @endif
                  </td>
                  <td>
                    @if($value['status'] == '1')
                    <span >{{__("admin.text_active")}}</span>
                    @elseif($value['status'] == '0')
                    <span >{{__("admin.text_inactive")}}</span>
                    @endif
                  </td>
                  <td>
                    <a href="{{Route('work_seeker_add')}}?title={{$Title}}&id={{$value['id']}}"><span class="fas fa-edit"></span></a>
                    <a href="{{Route('work_seeker_delete')}}?title={{$Title}}&id={{$value['id']}}" onClick="return doconfirm()"><span class="fa fa-trash text-danger"></span></a>
                  </td>
                </tr>
              <?php $cnt++; } }else{ ?>
                <tr>
                  <td colspan="10">{{__("admin.text_no_record")}}</td>
                </tr>
              <?php } ?> 
          </tbody>
       </table>
  	</div>
    <div class="my_pagination">
        {{$WorkDetail->appends(request()->query())->links() }}
    </div> 
</div>
@include('admin.layout.footer')
