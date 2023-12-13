@include('admin.layout.header')
@include('admin.layout.sidebar')
<div class="main_right">

    <div class="top_announce d-flex align-items-center justify-content-between mb_20">
        <div class="top_ann_left">
            <a href="{{Route('all_customers')}}" class="site_btn f16 f_bold blue__btn post_ad_disabled">{{$common['heading_title']}}</a>
        </div>
        <div class="top_ann_right d-flex align-items-center ">
            <form class="topan_search w-100 justify-content-xl-end">
                <a href="{{Route('assistant_add')}}" class="btn add_btn"> {{__("admin.text_add_assistant")}} </a>
            </form>
        </div>
    </div>
    <div class="main-section bg-white">
      <table class="table table-responsive">
          <thead class="table-head">
             <tr>
                <th>{{__("admin.text_serial_no")}}</th>
                <th>{{__("admin.text_first_name")}}</th>
                <th>{{__("admin.text_family_name")}}</th>
                <th>{{__("admin.text_phone")}}</th>
                <th>{{__("admin.text_email")}}</th>
                <th class="text-center">{{__("admin.text_action")}}</th>
             </tr>
          </thead>
          <tbody>
             <?php $cnt = 1; ?>
             <?php if ($get_assistant!='') { ?>
             <?php foreach ($get_assistant as $key => $value) {  ?>
             <tr class="alert alert-dismissible fade show" role="alert">
                <td>{{$cnt}}</td>
                <td>{{$value['first_name'];}}</td>
                <td>{{$value['last_name'];}}</td>
                <td>{{$value['phone_no'];}}</td>
                <td>{{$value['email'];}}</td>
               
                <td class="text-center">
                  <a href="{{ route('assistant_add') }}?ID={{$value['id']}}"><button class="btn add_btn">{{__("admin.text_edit")}}</button></a>
                  <a href="{{ route('delete_assistant') }}?ID={{$value['id']}}"><button class="btn add_btn">{{__("admin.text_delete")}}</button></a>
                  
                   <!-- <a href="{{Route('customer_edit',$value['id'])}}"><button class="btn add_btn"><i class="fa fa-edit"></i></button></a> -->
                </td>
             </tr>
             <?php $cnt++;} ?>
             <?php }else{ ?>
              <tr class="alert alert-dismissible fade show" role="alert">
                <td colspan="10" class="text-center"><b>{{__("admin.text_no_records")}}</b></td>
              </tr>
             <?php } ?> 

          </tbody>
       </table>
    </div>
    <div class="my_pagination">
        {{$get_assistant->appends(request()->query())->links() }}
    </div> 

</div>
@include('admin.layout.footer')
