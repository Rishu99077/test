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
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.testimonials') }}">{{ $common['title'] }}</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ translate('Testimonial') }}</h5>
                            <a href="{{ url(goPreviousUrl()) }}"
                                class="btn bg-dark cursor-pointer  f-right d-inline-block back_button ml-1"
                                data-modal="modal-13"> <i class="fa fa-angle-double-left m-r-5"></i>{{ translate('Back') }}
                            </a>
                            <a href="{{ route('admin.testimonials.add') }}"
                                class="btn btn-primary waves-effect waves-light f-right d-inline-block md-trigger"
                                data-modal="modal-13"> <i
                                    class="icofont icofont-plus m-r-5"></i>{{ translate('Add Testimonial') }}
                            </a>
                        </div>
                        <div class="card-block">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="example-2">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ translate('Image') }}</th>
                                            <th>{{ translate('Title') }}</th>
                                            <th>{{ translate('Status') }}</th>
                                            <th>{{ translate('Action') }}</th>
                                        </tr>
                                    </thead>
                                    </tbody>
                                    @if (count($Testomonials) > 0)
                                        @foreach ($Testomonials as $key => $value)
                                            <tr>
                                                <th scope="row">{{ $key + $get_testimonial->firstItem() }}</th>

                                                <td><img class="custom_img"
                                                        src="{{ url('uploads/testimonials', $value['image']) }}"></td>
                                                <td>{{ $value['title'] }}</td>

                                                <td>
                                                    {!! checkStatus($value['status']) !!}
                                                </td>
                                                <td>
                                                    <div class="action_cls mt-2">
                                                        <a href="{{ route('admin.testimonials.edit', encrypt($value['id'])) }}"
                                                            class="btn btn-success btn-icon">
                                                            <i class="icofont icofont-ui-edit"></i></a>
                                                        <a data-href="{{ route('admin.testimonials.delete', encrypt($value['id'])) }}"
                                                            class="btn btn-danger btn-icon text-white confirm-delete">
                                                            <i class="icofont icofont-ui-delete"></i></a>
                                                    </div>
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
                                    {{ $get_testimonial->appends(request()->query())->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
