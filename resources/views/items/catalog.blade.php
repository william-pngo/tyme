@extends('layouts.app')

@section('title', 'Catalog')

@section('content')


<div class="container">
	<div class="row">
		@guest
		<div class="alert alert-danger col-12" role="alert">
			<p class="text-center my-0"><strong>You Must Have An Account To Start Reserving These Titles.</strong> <a href="/login" class="alert-link">Login Here!</a></p>
		</div>
		@endguest
		@if(count($errors)>0)
		@foreach($errors->all() as $error)
		<div class="alert alert-danger col-12" role="alert">
			<p class="text-center my-0"><strong>{{$error}}</strong></p>
		</div>
		@endforeach
		@elseif(Session::has("message"))
		<div class="alert alert-success col-12" role="alert">
			<p class="text-center my-0"><strong>{{Session::get("message")}}</strong></p>
		</div>
		@else
		@endif
		<div class="row col-12 ml-3 mb-2">
			<form action="/catalog" method="post" class="form-group col-4" style="max-width: 12em;">
				@csrf {{method_field('POST')}}
				<select class="form-control" name="genre_id" onchange="this.form.submit()">

					<option value="">Select Genre</option>

					@foreach (\App\Genre::all() as $id => $value)			
					<option value="{{ $id }}" {{-- {{old('genre_id') == $id ? 'selected' : ''}} --}}>
						{{ $value->name }} 
					</option>
					@endforeach    

				</select>

				<noscript><input type="submit" value="Submit"></noscript>

			</form>

			<form action="/catalog-country" method="post" class="form-group col-4" style="max-width: 12em;">
				@csrf {{method_field('POST')}}
				<select class="form-control" name="country_id" onchange="this.form.submit()">

					<option value="">Select Country</option>

					@foreach (\App\Country::all() as $id => $value)			
					<option value="{{ $id }}" {{-- {{old('genre_id') == $id ? 'selected' : ''}} --}}>
						{{ $value->name }} 
					</option>
					@endforeach    

				</select>

				<noscript><input type="submit" value="Submit"></noscript>
			</form>

			<button id="showBtn" class="btn btn-md col-2 ml-3"><a href="/catalog"><strong>All Shows</strong></a></button>

		</div>
		@foreach($items as $item)
		<div class="card bg-dark mb-5 ml-5" style="max-width: 22em;">
			<img class="card-img-top" src="{{$item->img_path}}">
			<div class="card-body text-secondary text-light">
				<h5 class="card-title">{{$item->name}}</h5>
				{{-- <p class="card-text">Genre: {{$item->genre->name}}</p>
				<p class="card-text">Country: {{$item->country->name}}</p> --}}
				<p class="card-text">{{$item->description}}</p>

				@auth
				@if(Auth::user()->role_id == 1)
				@php ($filter = DB::table('orders')
					->where('item_id', '=', $item->id)
					->where('user_id', '=', Auth::user()->id)
					->where('status_id', '=', 2)
					->first()
					)
				@php ($filters = DB::table('orders')
					->where('item_id', '=', $item->id)
					->where('user_id', '=', Auth::user()->id)
					->where('status_id', '=', 1)
					->first()
					)
				@php ($filter1 = DB::table('orders')
					->where('item_id', '=', $item->id)
					->where('user_id', '=', Auth::user()->id)
					->where('status_id', '=', 3)
					->first()
					)
				@php ($filter2 = DB::table('orders')
					->where('item_id', '=', $item->id)
					->where('user_id', '=', Auth::user()->id)
					->where('status_id', '=', 5)
					->first()
					)
					@if(!empty($filter))
					<div class="row">
						<!-- Button trigger modal -->
						<button type="button" class="btn btn-success mx-3 video-btn" data-toggle="modal" data-src="{{$item->url}}" data-target="#myModal">
							Watch Now
						</button>
						<!-- Modal -->
						<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog" id="modal-dialog" role="document">
								<div class="modal-content">

									<button type="button" class="close" id="closeBtn" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>        
									<!-- 16:9 aspect ratio -->
									<div class="embed-responsive embed-responsive-16by9">
										<iframe class="embed-responsive-item" src="" id="video"  allowscriptaccess="always" allow="autoplay"></iframe>
									</div>

								</div>
							</div>
						</div>
						<form action="/return/{{$item->id}}" method="post">
							@csrf
							<button class="btn btn-warning btn-md">Return</button>
						</form>
					</div>
					@elseif(!empty($filters))
					<div class="alert alert-primary" role="alert">
						<strong>Pending Request</strong>
						<div class="progress">
							<div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: 70%"></div>
						</div>
					</div>
					@elseif(!empty($filter1))
					<div class="alert alert-danger text-center p-2" role="alert">
						<p>Your Request Has Been <strong>Rejected</strong>. Wait <strong>24 Hours</strong> To Reserve This Item Again.</p>
					</div>
					@elseif(!empty($filter2))
					<div class="alert alert-warning text-center p-2" role="alert">
						<p>Item Has Been Recently Returned.</p>
					</div>
					@else
					<form action="/reserve/{{$item->id}}" method="post">
						@csrf
						<button class="btn btn-info btn-md">Reserve</button>
					</form>
					@endif
					@elseif(Auth::user()->role_id == 2)
					<button type="button" class="btn btn-success btn-md col-4" data-toggle="modal" data-target="#editModal{{$item->id}}">
						Edit
					</button>
					<div class="modal fade" id="editModal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLongTitle">Edit Item</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<p>Fill Up the Form Below To Edit The Item: <strong>{{$item->name}}</strong></p>
									<form action="/admin/editItem/{{$item->id}}" method="post">
										@csrf {{method_field('POST')}}
										<div class="form-group">
											<input type="text" name="name" id="name" value="{{$item->name}}" class="form-control">
										</div>


										<div class="form-group">
											<textarea name="description" id="description" rows="3" class="form-control">{{$item->description}}</textarea>
										</div>

										<div class="form-group">
											<input type="file" name="image" id="image" class="form-control" placeholder="Image">
										</div>

										<div class="form-group">
											<input type="url" name="url" id="url" class="form-control" value="{{$item->url}}">
										</div>

										<div class="form-group">
											<select name="genre_id" id="genre_id" class="form-control">
												<option class="placeholder" selected value="">Genre (required)</option>
												@foreach(\App\Genre::all() as $indiv_genre)
												<option value="{{$indiv_genre->id}}" {{$indiv_genre->id == $item->genre_id ? "selected" : ""}}>{{$indiv_genre->name}}</option>
												@endforeach
											</select>
										</div>

										<div class="form-group">
											<select name="country_id" id="country_id" class="form-control">
												<option class="placeholder" selected value="">Country (required)</option>
												@foreach(\App\Country::all() as $indiv_country)
												<option value="{{$indiv_country->id}}" {{$indiv_country->id == $item->country_id ? "selected" : ""}}>{{$indiv_country->name}}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
										<button class="btn btn-success btn-md col-3">Edit</button>
									</form>
								</div>
							</div>
						</div>
					</div>

					<button type="button" class="btn btn-danger btn-md col-4" data-toggle="modal" data-target="#deleteModal{{$item->id}}">
						Delete
					</button>
					<div class="modal fade" id="deleteModal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModalTitle" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLongTitle">Delete Item</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									Are You Sure You Want To Remove <strong>{{$item->name}}</strong> From Your Database?
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									<form action="/admin/deleteItem/{{$item->id}}" method="post">
										@csrf {{method_field('DELETE')}}
										<button class="btn btn-danger btn-md">Delete</button>
									</form>
								</div>
							</div>
						</div>
					</div>
					@else
					@endif
					@endauth
				</div>
			</div>
			@endforeach
		</div>
		<button onclick="topFunction()" id="myBtn" title="Go to top"><i class="fas fa-arrow-up"></i></button>
	</div>
	<script>
	// When the user scrolls down 20px from the top of the document, show the button
	window.onscroll = function() {scrollFunction()};

	function scrollFunction() {
		if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
			document.getElementById("myBtn").style.display = "block";
		} else {
			document.getElementById("myBtn").style.display = "none";
		}
	}

	// When the user clicks on the button, scroll to the top of the document
	function topFunction() {
	  document.body.scrollTop = 0; // For Safari
	  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
	}

	$(document).ready(function() {

	// Gets the video src from the data-src on each button

	var $videoSrc;  
	$('.video-btn').click(function() {
		$videoSrc = $(this).data( "src" );
	});

	// when the modal is opened autoplay it  
	$('#myModal').on('shown.bs.modal', function (e) {

	// set the video src to autoplay and not to show related video. Youtube related video is like a box of chocolates... you never know what you're gonna get
	$("#video").attr('src',$videoSrc + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0" ); 
	})

	// stop playing the youtube video when I close the modal
	$('#myModal').on('hide.bs.modal', function (e) {
	    // a poor man's stop video
	    $("#video").attr('src',$videoSrc); 
	}) 
	
	});
	</script>

	@endsection