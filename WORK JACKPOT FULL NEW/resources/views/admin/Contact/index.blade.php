@include('admin.layout.header')
@include('admin.layout.sidebar')
<div class="main_right">

    <div class="top_announce d-flex align-items-center justify-content-between mb_20">
        <div class="top_ann_left">
            <a href="{{Route('contacts')}}" class="site_btn f16 f_bold blue__btn post_ad_disabled">{{$common['heading_title']}}</a>
        </div>
    </div>
  	<div class="main-section bg-white">
  		<table class="table table-responsive">
          <thead class="table-head">
             <tr>
                <th>{{__("admin.text_serial_no")}}</th>
                <th>{{__("admin.text_first_name")}}</th>
                <th>{{__("admin.text_family_name")}}</th>
                <th>{{__("admin.text_email")}}</th>
                <th>{{__("admin.text_phone")}}</th>
                <th>{{__("admin.text_topic")}}</th>
                <th>{{__("admin.text_status")}}</th>
             </tr>
          </thead>
          <tbody>
             <?php $cnt = 1;  
              if (!empty($contacts)) { 
              foreach ($contacts as $key => $value) { ?>
                <tr>
                  <td>{{$cnt}}</td>
                  <td>{{$value['first_name']}}</td>
                  <td>{{$value['family_name']}}</td>
                  <td>{{$value['email']}}</td>
                  <td>{{$value['phone']}}</td>
                  <td>{{$value['topic']}}</td>
                  <td>
                    @if($value['status'] == '1')
                    <span>ACTIVE</span>
                    @elseif($value['status'] == '0')
                    <span>INACTIVE</span>
                    @endif
                  </td>
                </tr>
             <?php $cnt++; } }else{ ?>
                <tr>
                  <td colspan="10" class="text-center"><b>{{__("admin.text_no_records")}}</b></td>
                </tr>
             <?php } ?> 
          </tbody>
       </table>
  	</div>
    <div class="my_pagination">
        {{$Contacts->appends(request()->query())->links() }}
    </div> 
</div>
@include('admin.layout.footer')
