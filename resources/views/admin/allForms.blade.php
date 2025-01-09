@extends('admin.layouts.layout')
@section('admin_title_content')
    FeedbackCollection | Dynamic Form
@endsection
@section('admin_css_content')
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection
@section('admin_content_header')
	<div class="col-sm-6">
		<h1 class="m-0">Dynamic Form</h1>
	</div><!-- /.col -->
	@php 
	  $list = json_encode(['Home', 'Form']);
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
        	<div class="col-12">
          	

          	<div class="card">
              	<div class="card-header">
                	<h3 class="card-title">Forms</h3>

                	<a href="{{route('form.create')}}" class="btn btn-primary" style="float: right;" title=""><i class="fas fa-plus"></i>Add</a>
              	</div>
	            <!-- /.card-header -->
	            <div class="card-body">
	                <table id="example1" class="table table-bordered table-striped">
	                  	<thead>
			                <tr>
			                    <th>Title</th>
			                    <th>SubTitle</th>
			                    <th>Status</th>
			                    <th>Action</th>
			                </tr>
	                  	</thead>
	                  	<tbody>
	                  		@forelse($forms as $form)
					                <tr>
				                    	<td>{{$form->formName}}</td>
				                    	<td>{{$form->formSubtitle}}</td>
				                    	
				                    	<td>
				                    		<div class="btn-group">
							                    <button type="button" class="btn @if($form->status == 1) btn-success @else btn-danger @endif dropdown-toggle" data-toggle="dropdown">@if($form->status == 1) Activate @else Deactivate @endif 
							                    	<span class="sr-only">Toggle Dropdown</span>
							                    </button>
							                    <div class="dropdown-menu" role="menu">
								                    <form action="{{route('form.status',$form->id)}}" method="post" id="disable-form-{{$form->id}}" style="display: none;">
				                              			@csrf
				                              			@method('put')
				                              			<input type="hidden" name="status" value="@if($form->status == 1) 0 @else 1 @endif">
						                            </form>
							                      	<a class="dropdown-item" href="#" onclick="
							                            if(confirm('Want to change this form status!'))
							                            {
							                                event.preventDefault();
							                                document.getElementById('disable-form-{{$form->id}}').submit();
							                            }
							                            else
							                            {
							                                event.preventDefault();
							                            }
							                        ">@if($form->status == 1) Deactivate @else Activate @endif</a>
							                    </div>
						                	</div>
								                
				                    	</td>
				                    	
				                    	<td>
				                    		<div class="btn-group">
							                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Options
							                      	<span class="sr-only">Toggle Dropdown</span>
							                    </button>
							                    <div class="dropdown-menu" role="menu">
							                    	<a class="dropdown-item" href="{{route('form.show',$form->id)}}"><i class="fas fa-angle-double-right"></i>View</a>

							                      	<a class="dropdown-item" href="#" onclick="

				                            			if(confirm('Are you Want to Uproot this!'))

							                            {

							                                event.preventDefault();

							                                document.getElementById('delete-form-{{$form->id}}').submit();

							                            }

							                            else

							                            {

							                                event.preventDefault();

							                            }
								                        "><i class="fas fa-angle-double-right"></i>
								                    		{{ __('Delete') }}
								                    </a>
							                    	<form action="{{route('form.destroy',$form->id)}}" method="post" id="delete-form-{{$form->id}}" style="display: none;">
							                      		@csrf
												        @method('delete')
							                        </form>
							                    </div>
						                	</div>
				                    	</td>
					                </tr>
					            @empty
					                	
					            @endforelse
	                  	</tbody>
	                </table>
	            </div>
	            <!-- /.card-body -->
          	</div>
          	<!-- /.card -->
        	</div>
        	<!-- /.col -->
      </div>
      <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
@endsection

@section('admin_js_content')
	<!-- DataTables  & Plugins -->
	<script src="{{asset('admin/plugins/datatables/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
	<script src="{{asset('admin/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
	<script src="{{asset('admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
	<script src="{{asset('admin/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
	<script src="{{asset('admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
	<script src="{{asset('admin/plugins/jszip/jszip.min.js')}}"></script>
	<script src="{{asset('admin/plugins/pdfmake/pdfmake.min.js')}}"></script>
	<script src="{{asset('admin/plugins/pdfmake/vfs_fonts.js')}}"></script>
	<script src="{{asset('admin/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
	<script src="{{asset('admin/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
	<script src="{{asset('admin/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
	<!-- Page specific script -->
	<script>
		$(function () {
		    $("#example1").DataTable({
		      	"responsive": true, "lengthChange": false, "autoWidth": false,
		      	"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
		    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
		    
		});
	</script>
@endsection