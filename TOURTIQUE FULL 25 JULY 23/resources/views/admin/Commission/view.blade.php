@extends('admin.layout.master')
@section('content')
    <form method="post" id="add_transfer" enctype="multipart/form-data" action="">
        <ul class="breadcrumb">
            <li>
                <a href="#" style="width: auto;">
                    <span class="text">{{ $common['title'] }}</span>
                </a>
            </li>
            <li>
                <a href="javascript:void(0)">
                    {{ Session::get('TopMenu') }}
                </a>
            </li>
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <span class="fa fa-home"></span>
                </a>
            </li>
        </ul>
        <a class="btn btn-falcon-primary  backButton float-end" href="javascript:void(0)" onclick="back()"
            type="button"><span class="fas fa-arrow-alt-circle-left text-primary "></span> {{ translate('Back') }}
        </a>
    </form>
    <div class="col-lg-12">
        <div class="card mb-3">
            <div class="card-body ">
                <div class="row mt-3">
                    <div class="col-md-3">
                        <h4 class="text-dark">Affiliate : {{$get_data['affiliate_name']}}</h4>
                    </div>
                    <div class="col-md-2">
                        <h4 class="text-dark">Code : {{$get_data['affilliate_code']}}</h4>
                    </div>
                    <div class="col-md-2">
                        <h4 class="text-dark">Total : {{$get_data['total']}}</h4>
                    </div>
                    <div class="col-md-2">
                        <h4 class="text-dark">Remain : {{$get_data['remaining_amount']}}</h4>
                    </div>
                    <div class="col-md-2">
                        <h4 class="text-dark">Paid : {{$get_data['total_paid_amount']}}</h4>
                    </div>
                    @if($get_data['remaining_amount']!=0)
                        <div class="col-md-1">
                            <button class="btn btn-secondary" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">Pay</button>
                        </div>
                    @endif    
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @isset($get_data['extra'])
            @foreach ($get_data['extra'] as $key2 => $VAL)
                <div class="col-lg-4">
                    <div class="card mb-3">
                        <div class="card-body ">
                            <div class="row mt-3">
                                <div class="col-md-9">
                                    <p>Product name : <b>{{$VAL->product_name}}</b></p>
                                    <p>Product Amount : <b>{{$VAL->product_amount}}</b></p>
                                    <p>commission : <b>{{$VAL->commission}} %</b></p>
                                    <p>commission Amount : <b>{{$VAL->commission_amount}}</b></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endisset
    </div>
    <!-- Modal -->
    <form action="{{route('admin.add_comission_history')}}" method="post" id="add_amount">
        @csrf
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title text-dark" id="exampleModalLabel">Add Amount</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                    <div class="row">
                         <div class="col-md-12">
                             <input type="hidden" name="afilliate_comission_id" value="{{$get_data['id']}}" class="form-control">
                             <input type="hidden" name="user_id" value="{{$get_data['user_id']}}" class="form-control">
                             <input type="hidden" name="order_id" value="{{$get_data['order_id']}}" class="form-control">
                             <input type="hidden" name="total_val" id="remain_amount" value="{{$get_data['remaining_amount']}}" class="form-control">
                         </div>   
                         <div class="col-md-12">
                             <label>Amount</label>
                             <br>
                             <input type="text" required name="paid_amount" id="innneraddinput" class="form-control {{ $errors->has('paid_amount') ? 'is-invalid' : '' }}">
                             <p class="text-danger view_msg"></p>
                             @error('paid_amount')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                         </div>  
                    </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" >Pay now</button>
              </div>
            </div>
          </div>
        </div>
    </form>


<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('keyup', "#innneraddinput", function(e) {    
            var paid_amount = $(this).val();
            var remain  = $('#remain_amount').val();

            if (parseInt(paid_amount) > parseInt(remain) ) {
                $('.view_msg').html('Paid amount should less than total amount');
                return false;
            }else{
                $('.view_msg').html('');
            }
           
        });
    });
</script>

@endsection
