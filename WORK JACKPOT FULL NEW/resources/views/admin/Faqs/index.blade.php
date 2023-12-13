@include('admin.layout.header')
@include('admin.layout.sidebar')
<div class="main_right">

    <div class="top_announce d-flex align-items-center justify-content-between mb_20">
        <div class="top_ann_left">
            <a href="{{Route('faqs')}}" class="site_btn f16 f_bold blue__btn post_ad_disabled">{{$common['heading_title']}}</a>
        </div>
        <div class="top_ann_right d-flex align-items-center ">
            <form class="topan_search w-100 justify-content-xl-end">
                <a href="{{Route('faq_add')}}" class="btn add_btn">{{__("admin.text_add_new")}}</a>
            </form>
        </div>
    </div>
  	<div class="main-section bg-white">
  		<table class="table table-responsive">
          <thead class="table-head">
             <tr>
                <th>{{__("admin.text_serial_no")}}</th>
                <th>{{__("admin.text_title")}}</th>
                <th>{{__("admin.text_status")}}</th>
                <th>{{__("admin.text_action")}}</th>
             </tr>
          </thead>
          <tbody>
             <?php $cnt = 1;  
              if (!empty($faqs)) { 
              foreach ($faqs as $key => $value) { ?>
                <tr>
                  <td>{{$cnt}}</td>
                  <td>{{$value['title']}}</td>
                  <td>
                    @if($value['status'] == '1')
                    <span>{{__("admin.text_active")}}</span>
                    @elseif($value['status'] == '0')
                    <span>{{__("admin.text_inactive")}}</span>
                    @endif
                  </td>
                  <td>
                    <a href="{{Route('faq_add')}}?id={{$value['id']}}"><span class="fas fa-edit"></span></a>
                    <a href="{{Route('faq_delete')}}?id={{$value['id']}}" onClick="return doconfirm()"><span class="fa fa-trash text-danger"></span></a>
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
        {{$Faqs->appends(request()->query())->links() }}
    </div> 
</div>
@include('admin.layout.footer')
