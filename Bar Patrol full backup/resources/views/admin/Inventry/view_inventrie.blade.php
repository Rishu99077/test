@include('admin.Common.header')
@include('admin.Common.sidebar')
@include('admin.Common.topbar')
<style type="text/css">
   .all_inve_tab thead th:last-child {
   text-align: left;}
   .view_inventry{background: #d5d4d4;
    padding: 12px;
    margin-top: 15px;}
</style>
      <?php
        $newdate = $data['date'];
        $transactionDate = date("F j, Y, g:i a",strtotime($newdate)); 
      ?>
      <div class="d-flex align-items-center justify-content-between announce_ban bg_black mb_40">
         <div class="">
            <h3 class="f24 mb-0 text-white">View inventry by location</h3>
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
               &nbsp;<label>#</label>&nbsp; 
               <label>Location name</label>
               <?php $cnt = 1; ?>
               <?php foreach ($inventrie_products as $key => $value) { ?>
               <div class="row">
                  
                  <a href="{{('view_locationinventrie')}}?Location={{$value['location_name']}}">   <div class="col-md-12 bg_black">
                        <div class="view_inventry">
                        <span>{{$cnt}}</span>&nbsp;
                        <span>{{$value['location_name']}}</span>
                        </div>
                     </div>
                  </a>
               </div>
               <?php $cnt++; } ?>
            </div>
         </form>
      </div>
      <div class="d-flex justify-content-end">
         <button class="btn btn-secondary" onclick="goBack()">Back</button>
      </div>
   </div>
</div>
@include('admin.Common.footer')
