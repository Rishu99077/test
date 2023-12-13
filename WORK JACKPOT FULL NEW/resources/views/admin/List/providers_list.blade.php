@include('admin.layout.header')
@include('admin.layout.sidebar')
<div class="main_right">

    <div class="top_announce d-flex align-items-center justify-content-between mb_20">
        <div class="top_ann_left">
            <a href="{{Route('providers_list')}}" class="site_btn f16 f_bold blue__btn post_ad_disabled">{{$common['heading_title']}}</a>
        </div>
        <div class="top_ann_right d-flex align-items-center ">
            <form class="topan_search w-100 justify-content-xl-end">
                <!-- <a href="#" class="btn add_btn" onclick="goBack()"> Back </a> -->
            </form>
        </div>
    </div>
   <div class="main-section bg-white">
      <table class="table table-responsive">
          <thead class="table-head">
             <tr>
                <th>{{__("admin.text_serial_no")}}</th>
                <th>{{__("admin.text_first_name")}}</th>
                <th>{{__("admin.text_phone_number")}}</th>
                <th>{{__("admin.text_email")}}</th>
                <th>{{__("admin.text_action")}}</th>
             </tr>
          </thead>
          <tbody>
             <?php $cnt = 1; ?>
             <?php if (!empty($get_providers)) { ?> 
             <?php foreach ($get_providers as $key => $value) {  ?>
             <tr class="alert alert-dismissible fade show" role="alert">
                <td>{{$cnt}}</td>
                <td>{{$value['firstname'];}}</td>
                <td>{{$value['phone_number'];}}</td>
                <td>{{$value['email'];}}</td>
                <td>
                  <a href="{{ route('providers_jobs',['id'=>$value['id']]) }}"><button class="btn add_btn">{{__("admin.text_job_posted")}}</button></a>
                </td>
             </tr>
             <?php $cnt++;} ?>
             <?php }else{ ?>
              <tr class="alert alert-dismissible fade show" role="alert">
                <td colspan="10">{{__("admin.text_no_record")}}</td>
              </tr>
             <?php } ?> 
          </tbody>
       </table>
   </div>
    <div class="my_pagination">
        {{$get_providers->appends(request()->query())->links() }}
    </div> 
</div>
@include('admin.layout.footer')