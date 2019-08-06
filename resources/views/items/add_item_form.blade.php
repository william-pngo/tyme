@extends('layouts.app')

@section('title', 'Add Item')

@section('content')

<div class="container">
	<div class="d-flex align-items-center">
		<div class="text-center mx-auto">
			<h1 class="text-light">Add Item</h1>
			<form action="/admin/addItem" method="post" enctype="multipart/form-data"> 
				@csrf

				<div class="form-group">
					<input type="text" name="name" id="name" placeholder="Item Name" class="form-control @error('name') is-invalid @enderror">

					@error('name')
					<span class="invalid-feedback" style="color: pink;" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>


				<div class="form-group">
					<textarea name="description" id="description" rows="3" class="form-control" placeholder="Description"></textarea>
				</div>


				<div class="form-group">
					<input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" placeholder="Image">

					@error('image')
					<span class="invalid-feedback" style="color: pink;" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>


				<div class="form-group">
					<input type="url" name="url" id="url" class="form-control @error('url') is-invalid @enderror" placeholder="Youtube Video Link (Embed Form)">
					@error('url')
					<span class="invalid-feedback" style="color: pink;" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>



				<div class="form-group">
					<select name="genre_id" id="genre_id" class="form-control">
						<option class="placeholder" selected value="">Select Genre</option>
						@foreach(\App\Genre::all() as $indiv_genre)
						<option value="{{$indiv_genre->id}}">{{$indiv_genre->name}}</option>
						@endforeach
					</select>
				</div>


				<div class="form-group">
					<select name="country_id" id="country_id" class="form-control">
						<option class="placeholder" selected value="">Select Country</option>
						@foreach(\App\Country::all() as $indiv_country)
						<option value="{{$indiv_country->id}}">{{$indiv_country->name}}</option>
						@endforeach
					</select>
				</div>
				<br>

				<button type="submit" class="btn btn-info form-control text-center">Upload</button>

			</form>
		</div>
	</div>
</div>


@endsection