@extends('admin.layouts.layout')
@section('admin_title_content')
    FeedbackCollection | Feedback List
@endsection
@section('admin_css_content')
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection
@section('admin_content_header')
	<div class="col-sm-6">
		<h1 class="m-0">Feedback List</h1>
	</div><!-- /.col -->
	@php 
	  $list = json_encode(['Home', 'Feedback List']);
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
                	<h3 class="card-title">Feedbacks</h3>

              	</div>
	            <!-- /.card-header -->
	            <div class="card-body">
	                <table id="example1" class="table table-bordered table-striped">
	                  	<thead>
			                <tr>
			                    <th>No</th>
			                    <th>Data</th>
			                    <th>Action</th>
			                </tr>
	                  	</thead>
	                  	<tbody>
	                  		@foreach($lists as $list)
			                <tr>
		                    	<td>{{$loop->index + 1}}</td>
		                    	
		                    	<td>
		                    		@foreach (json_decode($list->data) as $key => $value)
								        <div>
								            <strong>{{ $labels[$key] ?? ucfirst(str_replace('_', ' ', $key)) }}:</strong>
								            @if (is_array($value))
								                {{ implode(', ', $value) }} <!-- Display array values as a comma-separated list -->
								            @else
								                {{ $value }} <!-- Display single values -->
								            @endif
								        </div>
								    @endforeach
		                    	</td>
		                    	
		                    	
		                    	
		                    	<td>
		                    		<div class="btn-group">
					                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Options
					                      	<span class="sr-only">Toggle Dropdown</span>
					                    </button>
					                    <div class="dropdown-menu" role="menu">
					                    	

					                      	<a class="dropdown-item" href="#" onclick="

		                            			if(confirm('Are you Want to Uproot this!'))

					                            {

					                                event.preventDefault();

					                                document.getElementById('delete-form-{{$list->id}}').submit();

					                            }

					                            else

					                            {

					                                event.preventDefault();

					                            }
					                        "><i class="fas fa-angle-double-right"></i>
					                    		{{ __('Delete') }}
					                    	</a>
					                    	<form action="{{route('submitted_form_delete',$list->id)}}" method="post" id="delete-form-{{$list->id}}" style="display: none;">
					                      		@csrf
										        @method('delete')
				                            </form>
					                      	
					                    </div>
					                </div>
		                    	</td>
			                </tr>
			                @endforeach
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