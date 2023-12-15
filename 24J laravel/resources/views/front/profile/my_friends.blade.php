@include('front.layout.header')
@include('front.layout.top_bar')
<div class="container mt-3" style="min-height: 440px; padding: 20px 0 20px 0;">
	<div class="row">
		<div class="col-md-12">
			<h2>Friends List</h2>
			<table class="table table-bordered table-striped table-striped table-hover">
			   <thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Name</th>
						<th scope="col">Email</th>
						<th scope="col">Company</th>
					</tr>
			   </thead>
			   <tbody>
			   	@if(count($data)>0)
			   		@foreach($data as $key => $value)
						<tr>
							<td>{{$key+1}}</td>
							<td>{{$value['full_name']}}</td>
							<td>{{$value['email']}}</td>
							<td>{{$value['company_name']}}</td>
						</tr>
					@endforeach
				@else
					<tr>
						<td colspan="10" class="text-center">No friends Found</td>
					</tr>
                @endif
			   </tbody>
			</table>
		</div>
	</div>
</div>
@include('front.layout.footer')
