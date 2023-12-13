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
            <a class="btn btn-falcon-primary  backButton float-end" href="javascript:void(0)" onclick="back()"
            type="button"><span class="fas fa-arrow-alt-circle-left text-primary "></span> {{ translate('Back') }}
        </a>
        </div>
    </div>
       
    <div class="card mb-3" id="ordersTable" data-list='{"valueNames":["order","date","address","status","amount"],"page":10,"pagination":true}'>
       <div class="card-header">
          <div class="row flex-between-center">
             <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Orders</h5>
             </div>
          </div>
       </div>
       <div class="card-body p-0">
          <div class="table-responsive scrollbar">
             <table class="table table-sm table-striped fs--1 mb-0 overflow-hidden">
                <thead class="bg-200 text-900">
                   <tr>
                      
                      <th class="sort pe-1 align-middle white-space-nowrap" data-sort="order">OrderID</th>
                      <th class="sort pe-1 align-middle white-space-nowrap pe-7" data-sort="date">Date</th>
                      <th class="sort pe-1 align-middle white-space-nowrap" data-sort="address" style="min-width: 12.5rem;">Ship To</th>
                      <th class="sort pe-1 align-middle white-space-nowrap text-center" data-sort="status">Status</th>
                      <th class="sort pe-1 align-middle white-space-nowrap text-end" data-sort="amount">Amount</th>
                      <th class="no-sort"></th>
                   </tr>
                </thead>
                <tbody class="list" id="table-orders-body">
                	@if(!$get_request->isEmpty())
	                	@foreach ($get_request as $key => $value)
                      @php
                        $get_user_details = App\Models\User::select('*')
                                                    ->where('id', $value['user_id'])
                                                    ->first(); 
                      @endphp

		                   <tr class="btn-reveal-trigger">
		                      
		                      <td class="order py-2 align-middle white-space-nowrap"><a href="#"> <strong>#{{$value['id']}}</strong></a> by 
                                @if($get_user_details)
                                <strong>{{$get_user_details['name']}}</strong><br /><a href="mailto:ricky@example.com">{{$get_user_details['email']}}</a>
                                @endif
                            </td>

		                      <td class="date py-2 align-middle">{{$value['created_at']->format('d-m-Y')}}</td>

		                      <td class="address py-2 align-middle white-space-nowrap">
                                    @if($get_user_details)
		                              {{$get_user_details['address']}}
                                    @endif

		                      </td>

		                      <td class="status py-2 align-middle text-center fs-0 white-space-nowrap">
			                      	<span class="badge badge rounded-pill d-block badge-soft-success">{{$value['status']}}
			                      		<span class="ms-1 fas fa-check" data-fa-transform="shrink-2"></span>
			                      	</span>
		                      </td>

		                      <td class="amount py-2 align-middle text-end fs-0 fw-medium">
                          AED @if($value['total'])
                                {{$value['total']}}
                              @else
                                0
                              @endif
                          </td>

		                      <td class="py-2 align-middle white-space-nowrap text-end">
		                         <a class="btn p-0" href="{{ route('admin.product_request.view', encrypt($value['id'])) }}" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="View"><span class="text-500 fas fa-eye"></span>
                                  </a>
		                      </td>
		                   </tr>
	                  @endforeach
                  @else
	                    <tr>
	                        <td colspan="6" align="center">
	                            <p>No Record found</p>
	                        </td>
	                    </tr>
                  @endif
                </tbody>
             </table>
          </div>
       </div>
       <div class="card-footer">
          <div class="d-flex align-items-center justify-content-center">
             {{ $get_request->appends(request()->query())->links() }}
          </div>
       </div>
    </div>
     
@endsection