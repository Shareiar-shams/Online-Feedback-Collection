@extends('admin.layouts.layout')
@section('admin_title_content')
    FeedbackCollection | Profile
@endsection
@section('admin_content_header')
	<div class="col-sm-6">
		<h1 class="m-0">Dashboard</h1>
	</div><!-- /.col -->
	@php 
	  $list = json_encode(['Home', 'Profile']);
	@endphp
	<x-ad-breadcrumb :list="$list"/>
@endsection
@section('admin_main_content')
	@if ($errors->any())                 
		@foreach ($errors->all() as $error)
			<div class="alert alert-danger alert-block">
		        <a type="button" class="close" data-dismiss="alert"></a> 
		        <strong>{{ $error }}</strong>
		    </div>
		@endforeach						                   
	@endif
	<div class="container-fluid">
        <div class="row">
	        <div class="col-md-3">

	            <!-- Profile Image -->
	            <div class="card card-primary card-outline">
		            <div class="card-body box-profile">
		                <div class="text-center">
		                  	<form action="{{route('admin.image.update', Auth::guard()->user()->id)}}" method="post" enctype="multipart/form-data">
								{{csrf_field()}}
				            	<p><input type="file" accept="image/*" name="image" id="file"  onchange="loadFile(event)" style="display: none;" required></p>

				            	@if(Auth::guard()->user()->image != 'noimage.jpg')
					              	<label for="file" style="cursor: pointer; display: inline;"><img src="{{Storage::disk('local')->url(Auth::guard()->user()->image)}}" class="profile-user-img img-responsive img-circle" alt="User profile picture" id="output"></label>
					            @else
					              	<label for="file" style="cursor: pointer; display: inline;"><img src="{{asset('admin/dist/img/avatar4.png')}}" class="profile-user-img img-responsive img-circle" alt="User profile picture" id="output"></label>
					            @endif

				              	

								<input type="submit" class="btn btn-primary btn-block" style="font-weight: bold;" value="Change Profile Picture">
							</form>
		                </div>
		                <h3 class="profile-username text-center">{{Auth::guard()->user()->name}}</h3>

				        <p class="text-muted text-center">{{Auth::guard()->user()->position}}</p>
				        <p class="text-muted text-center"> {{Auth::guard()->user()->phone}}</p>

		            </div>
		            <!-- /.card-body -->
	            </div>
	            <!-- /.card -->

	            <!-- About Me Box -->
	            <div class="card card-primary">
		            <div class="card-header">
		                <h3 class="card-title">About Me</h3>
		            </div>
	              	<!-- /.card-header -->
	              	<div class="card-body">
	                	<strong><i class="fas fa-book mr-1"></i> Education</strong>

	                	<p class="text-muted">
	                  		B.S. in Computer Science from the University of Tennessee at Knoxville
	                	</p>

	                	<hr>

	                	<strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

	                	<p class="text-muted">Malibu, California</p>

	                	<hr>

	                	<strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>

		                <p class="text-muted">
		                  	<span class="tag tag-danger">UI Design</span>
		                  	<span class="tag tag-success">Coding</span>
		                  	<span class="tag tag-info">Javascript</span>
		                  	<span class="tag tag-warning">PHP</span>
		                  	<span class="tag tag-primary">Node.js</span>
		                </p>

	                	<hr>

	                	<strong><i class="far fa-file-alt mr-1"></i> Notes</strong>

	               		<p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
	              	</div>
	              	<!-- /.card-body -->
	            </div>
	            <!-- /.card -->
	        </div>
          	<!-- /.col -->
          	<div class="col-md-9">
	            <div class="card">
	              	<div class="card-header p-2">
		                <ul class="nav nav-pills">
		                  	<li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Settings</a></li>
		                  	
		                  	<li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Change Password</a></li>
		                </ul>
	              	</div><!-- /.card-header -->
	              	<div class="card-body">
		                <div class="tab-content">
			                <div class="active tab-pane" id="activity">
			                    <form class="form-horizontal" action="{{route('admin.profile.update',Auth::guard()->user()->id)}}" method="post">
			                    	@csrf
							        @method('put')
				                    <div class="form-group row">

				                    	<x-input-label for="inputName" :value="__('Name')" class="col-sm-2 col-form-label"/>
				                        <div class="col-sm-10">
				                        	<x-text-input id="inputName" name="name" type="text" class="form-control" autocomplete="input-name" placeholder="Name" value="{{Auth::guard()->user()->name}}" required/>

				                        </div>
				                    </div>
				                    <div class="form-group row">

				                    	<x-input-label for="inputPhone" :value="__('Phone')" class="col-sm-2 col-form-label"/>

				                        <div class="col-sm-10">
				                        	<x-text-input id="inputPhone" name="phone" type="text" class="form-control" autocomplete="input-phone" placeholder="Phone" value="{{Auth::guard()->user()->phone}}" required/>
				                        </div>
				                    </div>
				                    <div class="form-group row">
				                    	<x-input-label for="inputPosition" :value="__('Position')" class="col-sm-2 col-form-label"/>
				                        <div class="col-sm-10">
				                        	<x-text-input id="inputPosition" name="position" type="text" class="form-control" autocomplete="input-position" placeholder="Position" value="{{Auth::guard()->user()->position}}" required/>

				                        </div>
				                    </div>
				                    {{-- <div class="form-group row">
				                        <label for="inputExperience" class="col-sm-2 col-form-label">Experience</label>
				                        <div class="col-sm-10">
				                          	<textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
				                        </div>
				                    </div>
				                    <div class="form-group row">
				                        <label for="inputSkills" class="col-sm-2 col-form-label">Skills</label>
				                        <div class="col-sm-10">
				                          	<input type="text" class="form-control" id="inputSkills" placeholder="Skills">
				                        </div>
				                    </div> --}}
				                    {{-- <div class="form-group row">
				                        <div class="offset-sm-2 col-sm-10">
				                          <div class="checkbox">
				                            <label>
				                              <input type="checkbox" required> I agree to the <a href="#">terms and conditions</a>
				                            </label>
				                          </div>
				                        </div>
				                    </div> --}}
			                      	<div class="form-group row">
			                        	<div class="offset-sm-2 col-sm-10">
			                        		<x-primary-button class="btn btn-primary">{{ __('Save') }}</x-primary-button>
			                          		
			                        	</div>
			                      	</div>
			                    </form>
			                </div>
			                <!-- /.tab-pane -->

			                <div class="tab-pane" id="settings">
			                    <form method="post" action="{{ route('admin.password.update', Auth::guard()->user()->id) }}" class="form-horizontal">
			                    	@csrf
							        @method('put')
			                      	<div class="form-group row">
			                      		<x-input-label for="current_password" :value="__('Current Password')" class="col-sm-2 col-form-label"/>
				                        <div class="col-sm-10">
				                        	<x-text-input id="current_password" name="old_password" type="password" class="form-control" autocomplete="current-password" placeholder="Enter Old Password" required/>

				                        </div>
				                    </div>
				                    <div class="form-group row">
				                    	<x-input-label for="password" :value="__('New Password')"  class="col-sm-2 col-form-label"/>
				                        <div class="col-sm-10">
				                        	<x-text-input id="password" name="new_password" type="password" class="form-control" autocomplete="new-password" placeholder="Enter New Password" required/>

				                        </div>
				                    </div>
				                    <div class="form-group row">
				                    	<x-input-label for="password_confirmation" :value="__('Confirm Password')"  class="col-sm-2 col-form-label"/>
				                        <div class="col-sm-10">
				                        	<x-text-input id="password_confirmation" name="c_password" type="password" class="form-control" autocomplete="new-password" placeholder="Retype Password" required/>

				                        </div>
				                    </div>
			                      	<div class="form-group row">
			                        	<div class="offset-sm-2 col-sm-10">
			                        		<x-primary-button class="btn btn-danger">{{ __('Submit') }}</x-primary-button>
			                        	</div>
			                      	</div>
			                    </form>
			                </div>
			                <!-- /.tab-pane -->
		                </div>
		                <!-- /.tab-content -->
	              	</div><!-- /.card-body -->
	            </div>
	            <!-- /.card -->

	            {{-- <iframe width="600" height="315" src="https://youtube.com/embed/playlist?list=PL2DahmvUpeuuCgEC4fpp7GhmEZJqGJD7v" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe> --}}
          	</div>
          	<!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
@endsection

@section('admin_js_content')
	<script>
		var loadFile = function(event) {
			var image = document.getElementById('output');
			image.src = URL.createObjectURL(event.target.files[0]);
		};
	</script>
@endsection