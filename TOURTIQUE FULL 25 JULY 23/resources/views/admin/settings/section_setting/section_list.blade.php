@extends('admin.layout.master')
@section('content')
    <div class="card mb-3">
        <div class="bg-holder d-none d-lg-block bg-card"
            style="background: linear-gradient(90deg, rgba(38,42,73,1) 0%, rgba(61,65,100,1) 71%, rgba(9,193,45,0.44019614681810226) 100%);">
        </div>
        <!--/.bg-holder-->
        <div class="card-body position-relative">
            <div class="row">
                <div class="col-lg-8">
                    <h3>{{ $common['title'] }}</h3>
                </div>
            </div>
        </div>
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
                                            <th scope="col">Section Name</th>
                                            <th class="text-end" scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($get_setting_list as $key => $value)
                                            <tr>
                                                <td>{{ $key + $get_setting_list->firstItem() }}</td>
                                                <td>{{ $value['title'] }}</td>
                                                <td class="text-end">
                                                    <div>
                                                        <a class="btn p-0"
                                                            href="{{ route('admin.page_setting', $value['meta_title']) }}"
                                                            type="button" data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Edit"><span class="text-500 fas fa-edit"></span>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <div>
                                {{ $get_setting_list->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
