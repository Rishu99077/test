@include('admin.layout.master')
@include('admin.layout.sidebar')
@include('admin.layout.header')
<div class="jobs_main">
    <div class="row">
    	<div class="col-md-6 text-start">	
        	<h3 class="f28 mb_15">{{$common['heading_title']}}</h3>
        </div>
	    <div class="col-md-6 text-end">
	    	<a href="{{Route('customers_add')}}" class="btn btn-primary add_btn"> Add new </a>
	    </div>
    </div>
</div>
@include('admin.layout.footer')