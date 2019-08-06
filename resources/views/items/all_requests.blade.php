@extends('layouts.app')

@section('title', 'All Users')

@section('content')

<div class="container">
	<div class="row">
		<form action="/admin/filterByUser" method="post" class="form-group col-4" style="max-width: 12em;">
			@csrf {{method_field('POST')}}
			<select class="form-control" name="user_id" onchange="this.form.submit()">

				<option value="">Select User</option>
				
				@foreach (\App\User::all()->where('role_id', 1) as $value)			
				<option value="{{ $value->id }}">
					{{ $value->name }} 
				</option>
				@endforeach    

			</select>

			<noscript><input type="submit" value="Submit"></noscript>
		</form>

		<form action="/admin/filterByStatus" method="post" class="form-group col-4" style="max-width: 12em;">
			@csrf {{method_field('POST')}}
			<select class="form-control" name="status_id" onchange="this.form.submit()">

				<option value="">Sort By Status</option>
				
				@foreach (\App\Status::all() as $value)			
				<option value="{{ $value->id }}">
					{{ $value->name }} 
				</option>
				@endforeach    

			</select>

			<noscript><input type="submit" value="Submit"></noscript>
		</form>

		<button id="showBtn" class="btn btn-md col-2 ml-3"><a href="/admin/showAllOrders"><strong>All Requests</strong></a></button>
	</div>
	<div class="row">
		<table class="table table-striped table-dark table-hover table-bordered text-center">
			<thead>
				<tr>
					<th scope="col">ID</th>
					<th scope="col">TV Show</th>
					@auth
					@if(Auth::user()->role_id == 2)
					<th scope="col">Requested By</th>
					@endif
					@endauth
					<th scope="col">Time of Request</th>
					<th scope="col">Status</th>
					<th scope="col">Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($orders as $request)
				<tr>
					<th>{{$request->id}}</th>
					<th>{{$request->item->name}}</th>
					@auth
					@if(Auth::user()->role_id == 2)
					<th>{{$request->user->name}}</th>
					@endif
					@endauth
					<th>{{$request->created_at->diffForHumans()}}</th>
					<th>{{$request->status->name}}</th>
					<th>
						@auth
						@if(Auth::user()->role_id == 2)

						@if($request->status_id == 1)
						<div class="row mx-auto">
							<form action="/admin/approveOrderStatus/{{$request->id}}" method="post" class="col-6">
								@csrf
								{{method_field('PATCH')}}
								<button class="btn btn-md btn-success">Approve</button>
							</form>
							<form action="/admin/rejectOrderStatus/{{$request->id}}" method="post" class="col-6">
								@csrf
								{{method_field('PATCH')}}
								<button class="btn btn-md btn-warning">Reject</button>
							</form>
						</div>
						@endif

						@if($request->status_id == 4 || $request->status_id == 3 || $request->status_id == 5)
						<form action="/admin/deleteOrder/{{$request->id}}" method="post">
							@csrf
							{{method_field('DELETE')}}
							<button class="btn btn-md btn-danger">Delete</button>
						</form>
						@endif

						@elseif(Auth::user()->role_id == 1)

						@if($request->status_id == 1)
						<form action="/cancelOrderStatus/{{$request->id}}" method="post">
							@csrf
							{{method_field('PATCH')}}
							<button class="btn btn-md btn-danger">Cancel Request</button>
						</form>
						@endif
						@else
						@endif
						@endauth
					</th>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

@endsection