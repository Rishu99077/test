@include('admin.layout.header')
@include('admin.layout.sidebar')
<div class="main_right">

    <div class="top_announce d-flex align-items-center justify-content-between mb_20">
        <div class="top_ann_left">
            <a href="{{Route('all_customers')}}" class="site_btn f16 f_bold blue__btn post_ad_disabled">{{$common['heading_title']}}</a>
        </div>
        <div class="top_ann_right d-flex align-items-center ">
            <form class="topan_search w-100 justify-content-xl-end">
                <!-- <a href="{{Route('customers_add')}}" class="btn add_btn"> Add new </a> -->
            </form>
        </div>
    </div>
  	<div class="main-section bg-white">
  		<table class="table table-responsive">
          <thead class="table-head">
             <tr>
                <th>{{__("admin.text_serial_no")}}</th>
                <th>{{__("admin.text_doc_title")}}</th>
                <th>{{__("admin.text_send_from")}}</th>
                <th>{{__("admin.text_send_to")}}</th>
                <th>{{__("admin.text_date")}}</th>
             </tr>
          </thead>
          <tbody>
             <?php $cnt = 1; ?>
             <?php if (!empty($Documents)) { ?>
             <?php foreach ($Documents as $key => $value) {  ?>
             <tr class="alert alert-dismissible fade show" role="alert">
                <td>{{$cnt}}</td>
                <td>{{$value['title'];}}</td>
                <td>{{$value['from_name'];}}</td>
                <td>{{$value['to_name'];}}</td>
                <td>{{$value['date'];}}</td>
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
        {{$get_otherdocuments->appends(request()->query())->links() }}
    </div> 

</div>
@include('admin.layout.footer')
