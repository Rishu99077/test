@extends('admin.layout.master')
@section('content')
    <div class="page-wrapper">
        <div class="page-header">
            <div class="page-header-title">
                <h4>{{ $common['title'] }}</h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href = "{{ route('admin.dashboard') }}">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.transaction_history') }}">{{ $common['title'] }}</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="page-body">

            <div class="row">

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <h2> {{ translate('Total Earning') }}</h2>
                            @if (isset($get_user['total_commission']))
                                <h4><?php echo get_price_front('', '', '', '', $get_user['total_commission']); ?></h4>
                            @else
                                <h4>0</h4>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <h2>{{ translate('Total Paid') }}</h2>
                            @if (isset($get_user['total_paid']))
                                <h4><?php echo get_price_front('', '', '', '', $get_user['total_paid']); ?></h4>
                            @else
                                <h4>0</h4>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <h2>{{ translate('Due Amount') }}</h2>
                            <?php
                            $total_commission = '0';
                            $total_paid = '0';
                            if ($get_user['total_commission']) {
                                $total_commission = $get_user['total_commission'];
                            }
                            if ($get_user['total_paid']) {
                                $total_paid = $get_user['total_paid'];
                            }
                            $total_due = $total_commission - $total_paid;
                            ?>
                            <input type="hidden" class="total_due_amount" value="{{ $total_due }}">
                            <h4><?php echo get_price_front('', '', '', '', $total_due); ?></h4>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ translate('Transaction History') }}</h5>
                            <a href="{{ url(goPreviousUrl()) }}"
                                class="btn bg-dark cursor-pointer  f-right d-inline-block back_button ml-1"
                                data-modal="modal-13"> <i class="fa fa-angle-double-left m-r-5"></i>{{ translate('Back') }}
                            </a>

                            @if ($total_due != 0)
                                <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                                    data-target="#exampleModalCenter">
                                    {{ translate('Make payment') }}
                                </button>
                            @endif
                            <small class="d-block text-danger">{{ $tax_text }}</small>
                        </div>
                        <div class="card-block">

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="example-2">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th> {{ translate('User Name') }} </th>
                                            <th> {{ translate('User Type') }} </th>
                                            <th> {{ translate('Amount') }} </th>
                                            <th> {{ translate('Tax') }} </th>
                                            <th> {{ translate('Paid Amount') }} </th>
                                            <th> {{ translate('Payment Mode') }} </th>
                                            <th> {{ translate('Amount Type') }} </th>
                                            <th> {{ translate('Payment Date') }}</th>
                                            <th> {{ translate('Payment Proof') }} </th>
                                            <th> {{ translate('Invoice') }}</th>
                                        </tr>
                                    </thead>
                                    </tbody>

                                    @if (count($get_transaction_history) > 0)
                                        @foreach ($get_transaction_history as $key => $value)
                                            <tr
                                                class="{{ $value['trans_type'] == 'Credited' ? 'transport_success' : 'transport_danger' }}">
                                                <th scope="row">{{ $key + 1 }}</th>
                                                <td>{{ $get_user['first_name'] }} {{ $get_user['last_name'] }}
                                                    <span class="d-block f-12"> {{ $value['description'] }}</span>
                                                </td>
                                                <td>{{ $value['user_type'] }}</td>
                                                <td><?php echo get_price_front('', '', '', '', $value['paid_amount']); ?></td>
                                                <td><?php echo get_price_front('', '', '', '', $value['tax']); ?></td>
                                                <td><?php echo get_price_front('', '', '', '', $value['paid_amount'] - $value['tax']); ?></td>
                                                <td>
                                                    @if ($value['amount_type'] == 'bank_transfer')
                                                        {{ translate('Bank Transfer') }}
                                                    @elseif($value['amount_type'] == 'paypal')
                                                        {{ translate('Paypal') }}
                                                    @elseif($value['amount_type'] == 'other')
                                                        {{ translate('Other') }}
                                                    @else
                                                        {{ translate('Other') }}
                                                    @endif
                                                </td>
                                                <td>{!! checkStatus($value['trans_type']) !!}</td>
                                                <td>{{ date('Y, M d', strtotime($value['created_at'])) }}</td>

                                                <td>
                                                    <?php
                                                    $payment_proof_link = $value['payment_proof'] != '' ? url('uploads/transaction_history', $value['payment_proof']) : asset('uploads/placeholder/placeholder.png');
                                                    
                                                    @$img_explode = explode('.', $value['payment_proof']);
                                                    @$img_extension = $img_explode[1];
                                                    ?>
                                                    <?php if (@$img_extension=='pdf') { ?>
                                                    <a href="{{ $payment_proof_link }}" target="_blank">
                                                        <img class ="tbl-img-css"
                                                            src="{{ asset('uploads/placeholder/pdf.png') }}" />
                                                    </a>
                                                    <?php }else{ ?>
                                                    <a href="{{ $value['payment_proof'] != '' ? url('uploads/transaction_history', $value['payment_proof']) : asset('uploads/placeholder/placeholder.png') }}"
                                                        data-lightbox="example-set">
                                                        <img class ="tbl-img-css example-image"
                                                            src="{{ $value['payment_proof'] != '' ? url('uploads/transaction_history', $value['payment_proof']) : asset('uploads/placeholder/placeholder.png') }}">
                                                    </a>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $invoice_link = $value['invoice'] != '' ? url('uploads/transaction_history', $value['invoice']) : asset('uploads/placeholder/placeholder.png');
                                                    
                                                    @$img_explode = explode('.', $value['invoice']);
                                                    @$img_extension = $img_explode[1];
                                                    ?>
                                                    <?php if (@$img_extension=='pdf') { ?>
                                                    <a href="{{ $invoice_link }}" target="_blank">
                                                        <img class ="tbl-img-css"
                                                            src="{{ asset('uploads/placeholder/pdf.png') }}" />
                                                    </a>
                                                    <?php }else{ ?>
                                                    <a href="{{ $value['invoice'] != '' ? url('uploads/transaction_history', $value['invoice']) : asset('uploads/placeholder/placeholder.png') }}"
                                                        data-lightbox="example-set">
                                                        <img class ="tbl-img-css example-image"
                                                            src="{{ $value['invoice'] != '' ? url('uploads/transaction_history', $value['invoice']) : asset('uploads/placeholder/placeholder.png') }}">
                                                    </a>
                                                    <?php } ?>
                                                </td>

                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="11" class="text-center">
                                                <h3>{{ config('adminconfig.record_not_found') }}</h3>
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <?php
                    $UserID = '';
                    if ($get_user['id'] != '') {
                        $UserID = encrypt($get_user['id']);
                    }
                    ?>
                    <form id="main" method="post" action="{{ route('admin.transaction_history.view', $UserID) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">{{ translate('Add Transaction') }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <input type="hidden" name="user_id" value="{{ $get_user['id'] }}">
                                    <input type="hidden" name="user_type" value="{{ $get_user['user_type'] }}">
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label class="col-form-label">{{ translate('Amount to be paid') }}</label>
                                            <input type="hidden" class="total_commission"
                                                value="{{ $get_user['total_commission'] }}">
                                            <input class="form-control paid_amount numberonly" name="paid_amount"
                                                type="text" placeholder="Enter Amount" required="">
                                            <span class="valid_msg"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="col-form-label">{{ translate('Amount Type') }}</label>
                                        <div class="form-check">
                                            <input id="flexRadioDefault1" type="radio" name="amount_type"
                                                value="bank_transfer" checked="" />
                                            <label class="form-check-label"
                                                for="flexRadioDefault1">{{ translate('Bank Transfer') }}</label>
                                        </div>
                                        <div class="form-check">
                                            <input id="flexRadioDefault2" type="radio" name="amount_type"
                                                value="paypal" />
                                            <label class="form-check-label"
                                                for="flexRadioDefault2">{{ translate('Paypal') }}</label>
                                        </div>
                                        <div class="form-check">
                                            <input id="flexRadioDefault3" type="radio" name="amount_type"
                                                value="other" />
                                            <label class="form-check-label"
                                                for="flexRadioDefault3">{{ translate('Other') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="col-form-label">{{ translate('Payment Proof') }}</label>
                                            <input type="file" name="payment_proof" class="form-control"
                                                required="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="col-form-label">{{ translate('Invoice') }}</label>
                                            <input type="file" name="invoice" class="form-control" required="">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label class="col-form-label">{{ translate('Description') }}</label>
                                            <textarea rows="3" class="form-control" required="" name="description" placeholder="Enter Description"></textarea>
                                        </div>
                                    </div>
                                    @if ($get_user['user_type'] == 'Partner')
                                        <div class="col-md-12">
                                            <h3>{{ translate('Supplier Account Details') }}</h3>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label class="col-form-label">{{ translate('Bank Name') }}</label>
                                                <input class="form-control" name="bank_name" type="text"
                                                    placeholder="Enter Bank Name">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="col-form-label">{{ translate('IBAN') }}</label>
                                                <input class="form-control numberonly" name="iban" type="text"
                                                    placeholder="Enter IBAN">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="col-form-label">{{ translate('SWIFT') }}</label>
                                                <input class="form-control numberonly" name="swift" type="text"
                                                    placeholder="Enter SWIFT">
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">{{ translate('Close') }}</button>
                                <button type="submit" class="btn btn-primary">{{ translate('Save changes') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@section('script')
    <script>
        $(document).ready(function() {
            $(document).on('focusout', '.paid_amount', function(e) {
                var amount = $(this).val();
                var total_due = $('.total_due_amount').val();

                if (parseFloat(amount) > parseFloat(total_due)) {
                    $(".valid_msg").html('Amount is greater than total due Amount');
                    $(".paid_amount").val('');
                    return false;
                } else {
                    $(".valid_msg").html('');
                }

            });
        });
    </script>
@endsection
@endsection
