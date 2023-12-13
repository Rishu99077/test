@include('admin.layout.header')
@include('admin.layout.sidebar')
<div class="main_right">

    <div class="top_announce d-flex align-items-center justify-content-between mb_20">
        <div class="top_ann_left">
            <a href="{{Route('notifications')}}" class="site_btn f16 f_bold blue__btn post_ad_disabled">{{$common['heading_title']}}</a>
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
                <th>{{__("admin.text_full_name")}}</th>
                <th>{{__("admin.text_phone")}}</th>
                <th>{{__("admin.text_email")}}</th>
                <th>Role</th>
                <th class="text-center">{{__("admin.text_action")}}</th>
             </tr>
          </thead>
          <tbody>
             <?php $cnt = 1; ?>
             <?php if (!empty($get_customers)) { ?>
             <?php foreach ($get_customers as $key => $value) {  ?>
             <tr class="alert alert-dismissible fade show" role="alert">
                <td>{{$cnt}}</td>
                <td>{{$value['firstname'];}} {{$value['surname'];}}</td>
                <td>{{$value['phone_number'];}}</td>
                <td>{{$value['email'];}}</td>
                <td>
                    @if($value['role'] == 'seeker')
                    <span>Seeker</span>
                    @elseif($value['role'] == 'provider')
                    <span>Provider</span>
                    @endif
                </td>
                <td class="text-center">
                  <button type="button" class="btn add_btn" data-bs-toggle="modal"
                    data-bs-target=".exampleModal_<?php echo $value['id'] ?>" style="width: 100%;">Send Notification</button>
                </td>
             </tr>
             <?php $cnt++;} ?>
             <?php }else{ ?>
              <tr class="alert alert-dismissible fade show" role="alert">
                <td colspan="10">No Records found</td>
              </tr>
             <?php } ?> 

          </tbody>
       </table>
  	</div>
    <div class="my_pagination">
        {{$get_customers->appends(request()->query())->links() }}
    </div> 


    <!--------------------------------- Notification MODAL ----------------- -->
    <?php foreach ($get_customers as $key => $value_cus) {  ?>
    <div class="modal fade exampleModal_<?php echo $value_cus['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
       <div class="modal-dialog products_modal">
          <div class="modal-content">
             <div class="modal-header products_modal_header">
                <h5 class="modal-title" id="exampleModalLabel">{{__("admin.text_add_noti_send")}}</h5>
             </div>
              <form action="{{url('admin/send_notification')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                  <div class="row">

                      <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                          <label for="" class="full-name">{{__("admin.text_customer_name")}}</label>
                          <input type="hidden" name="cust_id" value="{{$value_cus['id']}}"> 
                          <input type="text" readonly class="form-control full-name-control" name="customer_name" value="{{$value_cus['firstname']}}">
                        </div>
                      </div>  

                      <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                          <label for="" class="full-name">{{__("admin.text_phone")}}</label>
                          <input type="text" readonly class="form-control full-name-control" name="customer_phone" value="{{$value_cus['phone_number']}}">
                        </div> 
                      </div>

                      <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                          <label for="" class="full-name">{{__("admin.text_email")}}</label>
                          <input type="text" readonly class="form-control full-name-control" name="customer_email" value="{{$value_cus['email']}}">
                        </div>  
                      </div>

                      <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                          <label for="" class="full-name">{{__("admin.text_noti_msg")}}</label>
                          <textarea class="form-control full-name-control" name="message" ></textarea>
                        </div>  
                      </div>  
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{__("admin.text_close")}}</button>
                  <button class="btn add_btn" type="submit">{{__("admin.text_send")}}</button>
                </div>
              </form>
          </div>
       </div>
    </div>
    <?php } ?>

</div>
@include('admin.layout.footer')
