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
                    <li class="breadcrumb-item"><a href="{{ route('admin.reviews') }}">{{ $common['title'] }}</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ translate('Reviews') }}</h5>
                        </div>
                        <div class="card-block">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="example-2">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ translate('Title') }}</th>
                                            <th>{{ translate('Rating') }}</th>
                                            <th>{{ translate('Status') }}</th>
                                            <th>{{ translate('Action') }}</th>
                                        </tr>
                                    </thead>
                                    </tbody>
                                    @if (count($Reviews) > 0)
                                        @foreach ($Reviews as $key => $value)
                                            <?php $encryptID = encrypt($value['id']); ?>

                                            <tr>
                                                <th scope="row">{{ $key + $get_review->firstItem() }}</th>
                                                <td>{{ $value['title'] }}
                                                    <a href="#" class="text-dark" data-toggle="modal"
                                                        data-target="#exampleModalCenter{{ $key }}">
                                                        <i class="fa fa-eye"></i>
                                                    </a>

                                                    <!-- Modal -->
                                                    <div class="modal fade review_modal"
                                                        id="exampleModalCenter{{ $key }}" tabindex="-1"
                                                        role="dialog" aria-labelledby="exampleModalCenterTitle"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">

                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLongTitle">
                                                                        {{ translate('View Review') }}</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="form-group mb-1">
                                                                                <label for=""
                                                                                    class="mb-0 d-block f-14">
                                                                                    {{ translate('Product name') }}</label>
                                                                                <span class=" font-weight-bold f-18">
                                                                                    {{ $value['product_name'] }}</span>

                                                                                <span class="float-right">
                                                                                    @php
                                                                                        $rating = $value['rating'];
                                                                                    @endphp
                                                                                    @for ($i = 0; $i < 5; $i++)
                                                                                        @if (floor($rating) - $i >= 1)
                                                                                            {{-- Full Start --}}
                                                                                            <i
                                                                                                class="fa fa-star text-warning">
                                                                                            </i>
                                                                                        @elseif($rating - $i > 0)
                                                                                            {{-- Half Start --}}

                                                                                            <i
                                                                                                class="fa fa-star-half-o text-warning">
                                                                                            </i>
                                                                                        @else
                                                                                            {{-- Empty Start --}}
                                                                                            <i
                                                                                                class="fa fa-star-o text-warning"></i>
                                                                                        @endif
                                                                                    @endfor
                                                                                </span>
                                                                            </div>

                                                                            <div class="form-group mb-1">
                                                                                <label for=""
                                                                                    class="mb-0 d-block f-14">{{ translate('Title') }}</label>
                                                                                <span class=" font-weight-bold f-16">
                                                                                    {{ $value['title'] }}</span>

                                                                            </div>
                                                                            <div class="form-group mb-0">
                                                                                <label for=""
                                                                                    class="mb-0 d-block f-14">{{ translate('Description') }}</label>
                                                                                <span class=" font-weight-bold f-16">
                                                                                    {{ $value['description'] }}</span>

                                                                            </div>
                                                                            <div class="form-group mb-0">
                                                                                <label for=""
                                                                                    class="mb-0 d-block f-14">{{ translate('User Details') }}</label>
                                                                                <span class=" font-weight-bold f-16">
                                                                                    {{ $value['user_name'] }}</span>
                                                                                <span
                                                                                    class=" font-weight-bold f-16 d-block">
                                                                                    {{ $value['email'] }}</span>
                                                                            </div>

                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">{{ translate('Close') }}</button>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $value['rating'] }}</td>
                                                <td>
                                                    {!! checkStatus($value['status']) !!}
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="" id="aa{{ $value['id'] }}"
                                                        onchange="ChangeStatus(this,{{ $value['id'] }})"
                                                        class="add-page-check"
                                                        {{ $value['status'] == 'Active' ? 'checked' : '' }}>
                                                    <label for="aa{{ $value['id'] }}"><span></span></label>

                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="8" class="text-center">
                                                <h3>{{ config('adminconfig.record_not_found') }}</h3>
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                                <div class="dataTables_paginate paging_simple_numbers">
                                    {{ $get_review->appends(request()->query())->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // $(document).ready(function() {
        function ChangeStatus(e, id) {

            var is_approved = 'Deactive';
            if ($(e).prop('checked') == true) {
                is_approved = 'Active';
            }


            $.ajax({
                "type": "POST",
                "data": {
                    is_approved: is_approved,
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                url: "{{ route('admin.reviews.change_status') }}",
                success: function(response) {
                    window.location.reload();

                }
            })
        }
        // })
    </script>

@endsection
