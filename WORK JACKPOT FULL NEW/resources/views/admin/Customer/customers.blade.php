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
                <th>{{__("admin.text_first_name")}}</th>
                <th>{{__("admin.text_family_name")}}</th>
                <th>{{__("admin.text_phone")}}</th>
                <th>{{__("admin.text_email")}}</th>
                <th class="text-center">{{__("admin.text_action")}}</th>
             </tr>
          </thead>
          <tbody>
             <?php $cnt = 1; ?>
             <?php if (!empty($get_customers)) { ?>
             <?php foreach ($get_customers as $key => $value) {  ?>
             <tr class="alert alert-dismissible fade show" role="alert">
                <td>{{$cnt}}</td>
                <td>{{$value['firstname'];}}</td>
                <td>{{$value['surname'];}}</td>
                <td>{{$value['phone_number'];}}</td>
                <td>{{$value['email'];}}</td>
               
                <td class="text-center">
                  <a href="{{ route('customer_edit',['id'=>$value['id']]) }}"><button class="btn add_btn">{{__("admin.text_edit")}}</button></a>
                  @if($value['status'] == '0')
                  <a href="{{Route('change_status')}}?CustID={{$value['id']}}&Status=1"><button class="btn add_btn">{{__("admin.text_active")}}</button></a>
                  @elseif($value['status'] == '1')
                  <a href="{{Route('change_status')}}?CustID={{$value['id']}}&Status=0"><button class="btn btn-danger">{{__("admin.text_inactive")}}</button></a>
                  @endif
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
        {{$get_customers->appends(request()->query())->links() }}
    </div> 

</div>
@include('admin.layout.footer')
