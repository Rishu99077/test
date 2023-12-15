@include('front.layout.header')
@include('front.layout.top_bar')
<div class="container-fluid mt-3" style="min-height: 440px; padding: 30px;">
    <div class="row">
        <div class="col-sm-12 text-end">
            <a href="{{route('my_staff.add')}}"><button class="btn btn-info">Add Staff</button></a>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-block table-border-style">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>QrCode</th>
                                    <th>View Count</th>
                                    <th>Download Count</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    if($get_staffs->isNotEmpty()){
                                        foreach ($get_staffs as $key => $value) {
                                            ?>
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{$value['first_name']}}</td>
                                                    <td>{{$value['email']}}</td>
                                                    <td>
                                                        <img src="{{ $value['qr_code'] != '' ? asset('uploads/staff/qrcode-images/' . $value['qr_code']) : asset('frontassets/image/placeholder.png') }}" width="100" alt="" />
                                                    </td>
                                                    <td>{{ $value['view_count'] != '' ? $value['view_count'] : '0' }}</td>
                                                    <td>{{ $value['download_count'] != '' ? $value['download_count'] : '0' }}</td>
                                                    <td>
                                                        <ul class="action_btns">
                                                            <li>
                                                                <a class="edit btn btn-info btn-square" href="{{ route('staff.edit', encrypt($value['id'])) }}">Edit</a>
                                                            </li>
                                                            <li>
                                                                <a class="btn btn-danger btn-square " onclick="return doconfirm();" href="{{ route('staff.delete', encrypt($value['id'])) }}">Delete</a>
                                                            </li>
                                                            <?php 
                                                                if(isset($value['qr_code'])){
                                                                    if($value['qr_code'] != ''){
                                                                        ?>
                                                                        <li>
                                                                            <a class="btn btn-inverse btn-square" href="{{ $value['qr_code'] != '' ? asset('uploads/staff/qrcode-images/' . $value['qr_code']) : asset('frontassets/image/placeholder.png') }}" download="">Download</a>
                                                                        </li>

                                                                        <li>
                                                                           <button type="button" 
                                                                           class="view_qr_link btn btn-success" 
                                                                           data-toggle="modal" data-qrcode="{{route('staff', encrypt($value['id']))}}" >NFC URL</button>
                                                                        </li>
                                                                        <?php
                                                                    }
                                                                }
                                                            ?>
                                                        </ul>
                                                    </td>
                                                </tr>
                                            <?php
                                        }
                                    }else{  ?>
                                        <tr>
                                            <td colspan="10" class="text-center">No Records found</td>
                                        </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="custom_pagination">
                        {{ $get_staffs->appends(request()->query())->links() }}
                    </div>

                </div>
            </div>   
        </div>
    </div>
</div>
<div class="modal fade" id="qr-code-modal" tabindex="-1">
    <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">NFC URL</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-b-0">
                <div class="qr_code_area">
                    <div class="my_qrcode">
                        <input type="text" value="" id="get_qrcode_input" class="form-control">
                    </div>
                    <div class="copy_btn">
                        <button class="btn btn-square btn-primary" onclick="qr_code_copy()">Copy link</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@include('front.layout.footer')

