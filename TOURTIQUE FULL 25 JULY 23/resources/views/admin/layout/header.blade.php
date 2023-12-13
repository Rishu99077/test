<nav class="navbar navbar-light navbar-glass navbar-top navbar-expand">
    <button class="btn navbar-toggler-humburger-icon navbar-toggler me-1 me-sm-3" type="button" data-bs-toggle="collapse"
        data-bs-target="#navbarVerticalCollapse" aria-controls="navbarVerticalCollapse" aria-expanded="false"
        aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
    <a class="navbar-brand me-1 me-sm-3" href="{{ route('admin.dashboard') }}">
        <div class="d-flex align-items-center"><img style="width: 200px;" class="me-2"
                src="{{ get_setting_data('header_logo') != '' ? url('uploads/setting', get_setting_data('header_logo')) : asset('front_assets/images/logo.png') }}"
                alt="" width="40" />
        </div>
    </a>

    <ul class="navbar-nav navbar-nav-icons ms-auto flex-row align-items-center">

        <li class="nav-item dropdown">
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-card dropdown-menu-notification"
                aria-labelledby="navbarDropdownNotification">
                <div class="card card-notification shadow-none">
                    <div class="card-header">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-auto">
                                <h6 class="card-header-title mb-0">Notifications</h6>
                            </div>
                            <div class="col-auto ps-0 ps-sm-3"><a class="card-link fw-normal" href="#">Mark all
                                    as read</a></div>
                        </div>
                    </div>

                </div>
            </div>
        </li>

        @php
            $get_languages = App\Models\Language::where('status', 'Active')->get();
            $Session_lang_id =  Session::get('Lang');
        @endphp

        <li class="nav-item dropdown">
            <div>
                <select class="form-select single-select lang_chng" name="language">
                    @foreach ($get_languages as $Lang)
                        <option value="{{ $Lang['id'] }}" {{ getSelected($Session_lang_id, $Lang['id']) }}> {{ $Lang['title'] }} </option>
                    @endforeach
                </select>
            </div>
        </li>

        <li class="nav-item dropdown"><a class="nav-link pe-0" id="navbarDropdownUser" href="#navbarDropdownUser"
                role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="avatar avatar-xl">
                    <img class="rounded-circle"
                        src="{{ get_admin_data('', 'image') != '' ? url('uploads/admin_image', get_admin_data('', 'image')) : asset('uploads/placeholder/user.png') }}"
                        alt="" />
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end py-0" aria-labelledby="navbarDropdownUser">
                <div class="bg-white dark__bg-1000 rounded-2 py-2">
                    <a class="dropdown-item" href="{{ route('admin.profile') }}">Profile</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('admin.change_password') }}">Change Passwrod</a>
                    <a class="dropdown-item" href="{{ route('admin.logout') }}">Logout</a>
                </div>
            </div>
        </li>
    </ul>
</nav>


<script type="text/javascript">
    $('body').on("change",'.lang_chng', function(){
        
        var lang_id =$(this).val();

        $.ajax({
          url:"{{route('admin.language_change')}}",
          type: 'post',
          data: {'lang_id': lang_id,"_token": "{{ csrf_token() }}"},
           success: function(response) {
               success_msg("Language changed successfully");
               setTimeout(function(){ 
                  window.location.reload();     
               }, 1500);
           }
        });
    });
</script>
