@extends('layouts.app')

@section('title', 'Profile')

@section('content')

<section>
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <img id="profileImg" src="{{Auth::user()->img_path}}">
      </div>
      <div class="col-md-8">
        <div class="card-block px-3 text-light py-5">
         <div id="txt">
          <h2 class="card-title">{{Auth::user()->name}} {{Auth::user()->lastname}}</h4>
            <h4 class="card-text">
             <small class="border p-1 bg-dark">Email: {{Auth::user()->email}}</small>
             <small class="border p-1 ml-5 bg-dark">Birthday: {{Auth::user()->date_of_birth}}</small>
             <small class="border p-1 ml-5 bg-dark">Gender: {{Auth::user()->gender->name}}</small>
           </h4>
           <strong><p class="card-text mt-4">Bio: {{Auth::user()->description}}</p></strong>
           <p class="card-text my-3"><small>Last updated {{Auth::user()->updated_at->diffForHumans()}}</small></p>
         </div>
         <div>

          <button type="button" class="btn btn-info" data-toggle="modal" data-target="#editModal{{Auth::user()->id}}">
            Edit Profile
          </button>

          <div class="modal fade" id="editModal{{Auth::user()->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title text-dark" id="exampleModalLongTitle">Edit Details : {{Auth::user()->name}} {{Auth::user()->lastname}}</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body text-dark">
                  <p>Fill Up the Form Below To Edit Your Details</p>
                  <form action="/editDetails/{{Auth::user()->id}}" method="post" enctype="multipart/form-data">
                    @csrf {{method_field('POST')}}
                    <div class="form-group row">
                      <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label>
                      <div class="col-md-6">
                        <input id="name" type="text" class="form-control" name="name" value="{{Auth::user()->name}}" autocomplete="name" autofocus>

                        
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="lastname" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>

                      <div class="col-md-6">
                        <input id="lastname" type="text" class="form-control" name="lastname" value="{{Auth::user()->lastname}}" autocomplete="lastname" autofocus>

                        
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                      <div class="col-md-6">
                        <input id="email" type="email" class="form-control" name="email" value="{{Auth::user()->email}}" autocomplete="email">

                        
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="gender_id" class="col-md-4 col-form-label text-md-right">{{ __('Gender') }}</label>

                      <div class="col-md-6">
                        <select name="gender_id" id="gender_id" class="form-control">
                          @foreach(\App\Gender::all() as $gender)
                          <option value="{{$gender->id}}" {{$gender->id == Auth::user()->gender_id ? "selected" : ""}}>{{$gender->name}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="date" class="col-md-4 col-form-label text-md-right">{{ __('Date of Birth') }}</label>

                      <div class="col-md-6">
                        <input id="date" type="date" class="form-control" name="date" value="{{Auth::user()->date_of_birth}}">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                      <div class="col-md-6">
                        <textarea name="description" id="description" rows="6" cols="12" class="form-control">{{Auth::user()->description}}</textarea>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="image" class="col-md-4 col-form-label text-md-right">{{ __('Profile Picture') }}</label>

                      <div class="col-md-6">
                        <input id="image" type="file" class="form-control" name="image">
                      </div>
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
          <a href="/catalog" class="btn btn-warning ml-3">To Catalog</a>
          @php ($filter = DB::table('orders')
            ->where('user_id', '=', Auth::user()->id)
            ->first()
            )
            @if(empty($filter))
            <button type="button" class="btn btn-danger ml-3" data-toggle="modal" data-target="#deleteModal{{Auth::user()->id}}">
              Delete Profile
            </button>
            <div class="modal fade" id="deleteModal{{Auth::user()->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModalTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Warning: Delete Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body p-4">
                    Are You Sure You Want To Permanently Remove Your Profile From Our Database?
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <form action="/deleteProfile/{{Auth::user()->id}}" method="post">
                      @csrf {{method_field('DELETE')}}
                      <button class="btn btn-danger btn-md">Delete</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
</section>

@endsection