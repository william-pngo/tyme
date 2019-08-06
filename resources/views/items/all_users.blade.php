@extends('layouts.app')

@section('title', 'All Users')

@section('content')

<div class="container">
	<div class="row text-center">
		<table class="table table-striped table-dark table-hover table-bordered">
			<thead>
				<tr>
					<th scope="col">Name</th>
					<th scope="col">Email</th>
					<th scope="col">Joined</th>
					<th scope="col">User Type</th>
					<th scope="col">Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($users as $user)
				<tr>
					<th>{{$user->name}} {{$user->lastname}}</th>
					<td>{{$user->email}}</td>
					<td>{{$user->created_at->diffForHumans()}}</td>
					<td>{{$user->role->name}}</td>
					<td class="row m-1 justify-content-center">
						@if($user->role_id==1)
						<form action="/admin/promoteUserRole/{{$user->id}}" method="post" class="col-4">
							@csrf
							{{method_field('PATCH')}}
							<button class="btn btn-md btn-success">Promote</button>
						</form>
						@elseif($user->role_id==2 && $user->name!=="Admin")
						<form action="/admin/demoteUserRole/{{$user->id}}" method="post" class="col-4">
							@csrf
							{{method_field('PATCH')}}
							<button class="btn btn-md btn-warning">Demote</button>
						</form>
						@else
						@endif
						<form action="/admin/userDetails/{{$user->id}}" method="post" class="col-4">
							@csrf
							{{method_field('PATCH')}}
							<button class="btn btn-md btn-info">View Details</button>
						</form>
						@php ($filter = DB::table('orders')
							->where('user_id', '=', $user->id)
							->first()
							)

							@if(empty($filter) && $user->role_id==1)

							<button type="button" class="btn btn-danger col-3" data-toggle="modal" data-target="#deleteModal{{$user->id}}">
								Delete User
							</button>
							<div class="modal fade" id="deleteModal{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModalTitle" aria-hidden="true">
								<div class="modal-dialog modal-dialog-centered" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLongTitle">Warning: Delete Profile</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body p-4">
											Are You Sure You Want To Permanently Remove This Profile From The Database?
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
											<form action="/admin/removeUser/{{$user->id}}" method="post">
												@csrf
												{{method_field('DELETE')}}
												<button class="btn btn-md btn-danger">Remove</button>
											</form>
										</div>
									</div>
								</div>
							</div>

							@endif
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>

	@endsection
