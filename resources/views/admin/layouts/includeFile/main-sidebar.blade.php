<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
    	
      	<img src="{{asset('admin/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      	<span class="brand-text font-weight-light">{{config('app.name')}}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
	    <!-- Sidebar user panel (optional) -->
	    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
	        <div class="image">
	        	@if(Auth::guard()->user()->image != 'noimage.jpg')

		            <img src="{{Storage::disk('local')->url(Auth::guard()->user()->image)}}"  class="img-circle elevation-2" alt="User Image">
		        @else
	          		<img src="{{asset('admin/dist/img/avatar4.png')}}" class="img-circle elevation-2" alt="User Image">
	          	@endif
	        </div>
	        <div class="info">
	          	<a href="{{route('admin.profile')}}" class="d-block">{{ Auth::guard()->user()->name }}</a>
	        </div>
	    </div>

	    <!-- SidebarSearch Form -->
	    <div class="form-inline">
	        <div class="input-group" data-widget="sidebar-search">
	        	<x-text-input class="form-control form-control-navbar" type="search" name="search" placeholder="Search" aria-label="Search" required autofocus autocomplete="search" />

	          	<div class="input-group-append">
	          		<x-ad-nevigation-button class="btn btn-sidebar">
	                  	<i class="fas fa-search fa-fw"></i>
	                </x-ad-nevigation-button>
		        </div>
	        </div>
	    </div>

	    <!-- Sidebar Menu -->
	    <nav class="mt-2">
	        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
	          	

		        <li class="nav-item">
		        	<x-ad-nav-link href="{{route('dashboard')}}" class="nav-link {{ Route::currentRouteNamed( 'dashboard' ) ?  'active' : '' }}">
		              <i class="nav-icon fas fa-tachometer-alt"></i>
		              <p>
		                Dashboard
		              </p>
		            </x-ad-nav-link>
		        </li>
		        <li class="nav-item">
		           
		            <x-ad-nav-link class="nav-link">
		            	<i  class='fas fa-list-alt'></i>
		              	<p class="pl-2">
		                	Manage Form
		                	<i class="fas fa-angle-left right"></i>
		              	</p>
		            </x-ad-nav-link>
		            <ul class="nav nav-treeview">
		              	<li class="nav-item">
		              		<a href="{{route('show_forms')}}" class="nav-link {{ Route::currentRouteNamed( 'show_forms' ) ?  'active' : '' }}">
		                	
		                  		<i class="far fa-circle nav-icon"></i>
		                  		<p>All Forms</p>
		                	</a>
		              	</li>
		              	<li class="nav-item">
		              		<a href="{{route('form.create')}}" class="nav-link {{ Route::currentRouteNamed( 'form.create' ) ?  'active' : '' }}">
		                	
		                  		<i class="far fa-circle nav-icon"></i>
		                  		<p>Create Form</p>
		                	</a>
		              	</li>
		            </ul>
		        </li>
				<li class="nav-item">
		           
		            <x-ad-nav-link class="nav-link">
		            	<i  class='fas fa-book'></i>
		              	<p class="pl-2">
		                	Manage Course
		                	<i class="fas fa-angle-left right"></i>
		              	</p>
		            </x-ad-nav-link>
		            <ul class="nav nav-treeview">
		              	<li class="nav-item">
		              		<a href="{{ route('course.index') }}" class="nav-link {{ Route::currentRouteNamed( 'course.index' ) ?  'active' : '' }}">
		                	
		                  		<i class="far fa-circle nav-icon"></i>
		                  		<p>All Course</p>
		                	</a>
		              	</li>
		              	<li class="nav-item">
		              		<a href="{{ route('course.create') }}" class="nav-link {{ Route::currentRouteNamed( 'course.create' ) ?  'active' : '' }}">
		                	
		                  		<i class="far fa-circle nav-icon"></i>
		                  		<p>Create Form</p>
		                	</a>
		              	</li>
		            </ul>
		        </li>
		        <li class="nav-item">
		        	<x-ad-nav-link href="{{route('submitted_form_list')}}" class="nav-link {{ Route::currentRouteNamed( 'submitted_form_list' ) ?  'active' : '' }}">
		              <i class="nav-icon fas fa-comments"></i>
		              <p>
		                Feedback List
		              </p>
		            </x-ad-nav-link>
		        </li>
	        </ul>
	    </nav>
	    <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
