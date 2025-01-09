@extends('admin.layouts.layout')
@section('admin_title_content')
    FeedbackCollection | Dynamic Form
@endsection
@section('admin_css_content')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection
@section('admin_content_header')
    <div class="col-sm-6">
        <h1 class="m-0">Create Form</h1>
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
            <div class="col-md-12 col-sm-12">

                <!-- general form elements -->
                <div class="card card-default">
                    <div class="card-header">

                        <div class="card-tools">
                          <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                          </button>
                          
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Form Title *</label>

                            <input type="text" id="formName" placeholder="Enter the title" name="formName" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Form Sub Title *</label>

                            <input type="text" id="formSubtitle" placeholder="Enter the subtitle" name="formSubtitle" class="form-control">
                        </div>
                        <div class="form-group">
                            <div id="form-builder"></div>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <!-- general form elements -->
                    <div class="card card-default">
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button id="saveFormButton" class="btn btn-primary">Save</button>
                        </div>
                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.card -->
            </div>
        </div>

    </div><!-- /.container-fluid -->
@endsection

@section('admin_js_content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>
    <script src="https://formbuilder.online/assets/js/form-render.min.js"></script>

    <script>
        // jQuery(function($) {
        //     $(document.getElementById('form-builder')).formBuilder();
        // });
    </script>
    
    <script>
        $(document).ready(function () {
            // Initialize the form builder
            const formBuilder = $('#form-builder').formBuilder();

            // Save form schema and name when the button is clicked
            $('#saveFormButton').click(function () {
                const formName = $('#formName').val();
                const formSubtitle = $('#formSubtitle').val();
                const formData = formBuilder.actions.getData('json'); // Get form schema in JSON format

                // Validate form name
                if (!formName) {
                    alert('Please enter a form title.');
                    return;
                }

                // Make an AJAX request to save form schema
                $.ajax({
                    url: '{{ route('create_from') }}', // Laravel route
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // Include CSRF token
                        formName: formName,
                        formSubtitle: formSubtitle,
                        formData: formData, // Pass the form schema
                    },
                    success: function (response) {
                        if (response.success) {
                            toastr.success('Form saved successfully!');
                            window.location.href = "{{ route('show_forms') }}";
                        } else {
                            alert('Error saving form: ' + response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        alert('Error saving form.'); // General error message
                        console.error(xhr.responseText); // Log error for debugging
                    }
                });
            });
        });
    </script>

@endsection
