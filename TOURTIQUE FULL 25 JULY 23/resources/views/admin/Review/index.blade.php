@extends('admin.layout.master')
@section('content')

    <div class="d-flex justify-content-between">
        <ul class="breadcrumb mb-2 ">
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
    </div>

    <div class="row g-3 mb-3">
        <div class="col-lg-12">
            <div class="card">
                
                <div class="card-body pt-0">
                    <div class="tab-content">
                        <div class="tab-pane preview-tab-pane active" role="tabpanel"
                            aria-labelledby="tab-dom-fc2cf754-9fbc-4450-a5fc-ec75c99f83bc"
                            id="dom-fc2cf754-9fbc-4450-a5fc-ec75c99f83bc">
                            <div class="table-responsive scrollbar">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">{{ translate('Title') }}</th>
                                            <th scope="col">{{ translate('Rating') }}</th>
                                            <th scope="col">{{ translate('Status') }}</th>
                                            <th class="text-end" scope="col">{{ translate('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @if (!$get_reviews->isEmpty())
                                            @foreach ($get_reviews as $key => $value)
                                                <?php $encryptID = encrypt($value['id']); ?>
                                                <tr>
                                                    <td>{{ $key + $get_reviews->firstItem() }}</td>
                                                    <td>{{ $value['title'] }}</td>
                                                    <td>{{ $value['rating'] }}</td>
                                                    <td>
                                                        {!! checkStatus($value['status']) !!}
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="form-check form-switch pl-0">
                                                            <input class="form-check-input float-end status switch_button"                                  {{ getChecked('Active', $value['status']) }} id="status" type="checkbox" 
                                                            @if ($value['status']=='Active') value="Deactive" @else value="Active" @endif
                                                              name="status" onchange='statuschange("review","{{$encryptID}}",this.value);'>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="4" align="center">
                                                    <img src="{{ asset('public/assets/img/no_record.png') }}"
                                                        alt="">
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                {{ $get_reviews->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
@endsection
<script type="text/javascript">
    function statuschange(type,id,value) {
        
        // alert(value);
        // return false;
        $.ajax({
            "type": "POST",
            "url": "{{ route('admin.reviewstatus') }}",
            "data": {
                _token: "{{ csrf_token() }}",
                id: id,
                value: value,
            },

            success:function(response){
                res = JSON.parse(response);
                if (res.status) {
                    success_msg(res.message);
                }else{
                    danger_msg(res.message);
                }
                setTimeout(function(){
                   window.location.reload();
                }, 1500);
            }
        });
    }    

</script>
