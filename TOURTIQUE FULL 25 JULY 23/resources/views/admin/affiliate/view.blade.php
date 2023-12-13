@extends('admin.layout.master')
@section('content')
<div class="d-flex">
   <ul class="breadcrumb">
      <li>
         <a href="#" style="width: auto;">
         <span class="text">{{ $common['title'] }}</span>
         </a>
      </li>
      <li>
         <a href="{{ route('admin.dashboard') }}">
         <span class="fa fa-home"></span>
         </a>
      </li>
   </ul>
   <div class="col-auto ms-auto">
      <a class="btn btn-falcon-primary me-1 mb-1" href="{{ route('admin.affiliate.add') }}" type="button"><span
         class="fas fa-plus-circle text-primary "></span> Add New </a>
   </div>
</div>
<div class="card mb-3">
   <div class="card-header position-relative min-vh-25 mb-7">
      <div class="bg-holder-2 rounded-3 rounded-bottom-0" style="background-image:url(../../assets/img/generic/4.jpg);"></div>
      <div class="avatar avatar-5xl avatar-profile"><img class="rounded-circle img-thumbnail shadow-sm" src="../../assets/img/team/2.jpg" width="200" alt="" /></div>
   </div>
   <div class="card-body">
      <div class="row">
         <div class="col-lg-6">
            <h4 class="mb-1"> {{$get_affiliate['name']}}<span data-bs-toggle="tooltip" data-bs-placement="right" title="Verified"><small class="fa fa-check-circle text-primary" data-fa-transform="shrink-4 down-2"></small></span></h4>
            <p class="text-500">{{$get_affiliate['email']}}</p>
            <p class="text-500">{{$get_affiliate['phone_number']}}</p>
            <p class="">223,New york 452006</p>
            <div class="border-dashed-bottom my-4 d-lg-none"></div>
         </div>
         <div class="col-lg-6">
           <div class="row g-3 mb-3">
         
               <div class="col-sm-6 col-md-6">
                  <div class="card overflow-hidden" style="min-width: 12rem">
                     <div class="bg-holder-2 bg-card" style="background-image:url(../../assets/img/icons/spot-illustrations/corner-2.png);"></div>
                     <!--/.bg-holder-->
                     <div class="card-body position-relative">
                        <h6>Orders <!-- <span class="badge badge-soft-info rounded-pill ms-2">0.0%</span> --></h6>
                        <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info" data-countup="{&quot;endValue&quot;:{{$get_affiliate_commission_count}} }">{{$get_affiliate_commission_count}}</div>
                        <a class="fw-semi-bold fs--1 text-nowrap" href="{{route('admin.orders')}}">
                           All orders
                           <svg class="svg-inline--fa fa-angle-right fa-w-8 ms-1" data-fa-transform="down-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg="" style="transform-origin: 0.25em 0.5625em;">
                              <g transform="translate(128 256)">
                                 <g transform="translate(0, 32)  scale(1, 1)  rotate(0 0 0)">
                                    <path fill="currentColor" d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z" transform="translate(-128 -256)"></path>
                                 </g>
                              </g>
                           </svg>
                           <!-- <span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span> Font Awesome fontawesome.com -->
                        </a>
                     </div>
                  </div>
               </div>

               <div class="col-sm-6 col-md-6">
                  <div class="card overflow-hidden" style="min-width: 12rem">
                     <div class="bg-holder-2 bg-card" style="background-image:url(../../assets/img/icons/spot-illustrations/corner-1.png);"></div>
                     <!--/.bg-holder-->
                     <div class="card-body position-relative">
                        <h6>Total commission amount<!-- <span class="badge badge-soft-warning rounded-pill ms-2">-0.23%</span> --></h6>
                        <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning" data-countup="{&quot;endValue&quot;:{{$total_affiliate_commission}},&quot;decimalPlaces&quot;:2,&quot;suffix&quot;:&quot;AED&quot;}">{{$total_affiliate_commission}}AED</div>
                        <a class="fw-semi-bold fs--1 text-nowrap" href="{{route('admin.orders')}}">
                           See all
                           <svg class="svg-inline--fa fa-angle-right fa-w-8 ms-1" data-fa-transform="down-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg="" style="transform-origin: 0.25em 0.5625em;">
                              <g transform="translate(128 256)">
                                 <g transform="translate(0, 32)  scale(1, 1)  rotate(0 0 0)">
                                    <path fill="currentColor" d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z" transform="translate(-128 -256)"></path>
                                 </g>
                              </g>
                           </svg>
                           <!-- <span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span> Font Awesome fontawesome.com -->
                        </a>
                     </div>
                  </div>
               </div>

            </div>
         </div>
      </div>
   </div>
</div>
<div class="row g-0">
   <div class="col-lg-8 pe-lg-2">
      <div class="card mb-3">
         <div class="card-header bg-light d-flex justify-content-between">
            <h5 class="mb-0">Commission History</h5>
            <a class="font-sans-serif" href="#">All logs</a>
         </div>
         <div class="card-body fs--1 p-0">
            <a class="border-bottom-0 notification rounded-0 border-x-0 border border-300" href="#!">
               <div class="notification-avatar">
                  <div class="avatar avatar-xl me-3">
                     <div class="avatar-emoji rounded-circle "><span role="img" aria-label="Emoji">🎁</span></div>
                  </div>
               </div>
               <div class="notification-body">
                  <p class="mb-1"><strong>Jennifer Kent</strong> Congratulated <strong>Anthony Hopkins</strong></p>
                  <span class="notification-time">November 13, 5:00 Am</span>
               </div>
            </a>
            <a class="border-bottom-0 notification rounded-0 border-x-0 border border-300" href="#!">
               <div class="notification-avatar">
                  <div class="avatar avatar-xl me-3">
                     <div class="avatar-emoji rounded-circle "><span role="img" aria-label="Emoji">🏷️</span></div>
                  </div>
               </div>
               <div class="notification-body">
                  <p class="mb-1"><strong>California Institute of Technology</strong> tagged <strong>Anthony Hopkins</strong> in a post.</p>
                  <span class="notification-time">November 8, 5:00 PM</span>
               </div>
            </a>
            <a class="border-bottom-0 notification rounded-0 border-x-0 border border-300" href="#!">
               <div class="notification-avatar">
                  <div class="avatar avatar-xl me-3">
                     <div class="avatar-emoji rounded-circle "><span role="img" aria-label="Emoji">📋️</span></div>
                  </div>
               </div>
               <div class="notification-body">
                  <p class="mb-1"><strong>Anthony Hopkins</strong> joined <strong>Victory day cultural Program</strong> with <strong>Tony Stark</strong></p>
                  <span class="notification-time">November 01, 11:30 AM</span>
               </div>
            </a>
            <a class="notification border-x-0 border-bottom-0 border-300 rounded-top-0" href="#!">
               <div class="notification-avatar">
                  <div class="avatar avatar-xl me-3">
                     <div class="avatar-emoji rounded-circle "><span role="img" aria-label="Emoji">📅️</span></div>
                  </div>
               </div>
               <div class="notification-body">
                  <p class="mb-1"><strong>Massachusetts Institute of Technology</strong> invited <strong>Anthony Hopkin</strong> to an event</p>
                  <span class="notification-time">October 28, 12:00 PM</span>
               </div>
            </a>
         </div>
      </div>
   </div>
   <div class="col-lg-4 ps-lg-2">
      <div class="sticky-sidebar">
         <div class="card mb-3 mb-lg-0">
            <div class="card-header bg-light">
               <h5 class="mb-0">Latest Order</h5>
            </div>
            <div class="card-body fs--1">
              @isset($affiliate_comission)
                @foreach ($affiliate_comission as $key => $value)
                 <div class="d-flex btn-reveal-trigger">
                     <?php $newDate = $value['created_at']->format('d-m-Y'); ?>
                    <div class="calendar"><span class="calendar-month">{{$value['created_at']->format('M');}}</span><span class="calendar-day">{{$value['created_at']->format('d');}}</span></div>
                    <div class="flex-1 position-relative ps-3">
                       <h6 class="fs-0 mb-0"><a href="#">{{$value['product_order_id']}}</a></h6>
                       <p class="mb-1">Total <a href="#!" class="text-700">{{$value['total']}}</a></p>
                       <p class="text-1000 mb-0">Date: {{$newDate}}</p>
                       <p class="text-1000 mb-0">Code: {{$value['affilliate_code']}}</p>
                       Total Commission: {{$value['total_commission_amount']}}
                       <div class="border-dashed-bottom my-3"></div>
                    </div>
                 </div>
                @endforeach
              @endisset 
            </div>
            <div class="card-footer bg-light p-0 border-top"><a class="btn btn-link d-block w-100" href="{{route('admin.orders')}}">All Orders<span class="fas fa-chevron-right ms-1 fs--2"></span></a></div>
         </div>
      </div>
   </div>
</div>
@endsection