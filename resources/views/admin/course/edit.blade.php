@extends('admin.layouts.layout')
@section('admin_title_content')
    FeedbackCollection | Course
@endsection
@section('admin_css_content')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <style>
        .content-block{
            margin: 10px auto;
            margin-bottom: 30px;
            padding: 10px 15px;
            background-color: #f3f4f8;
            box-shadow: 0 0 10px;
            border-radius: 10px;
        }
    </style>
@endsection
@section('admin_content_header')
    <div class="col-sm-6">
        <h1 class="m-0">Edit Course</h1>
    </div><!-- /.col -->
    @php 
      $list = json_encode(['Home', 'Course']);
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
                    <form action="{{ route('course.update', $course->id) }}" id="courseForm" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <!-- /.card-header -->
                        <div class="card-body">
                            
                            <div class="form-group">
                                <label for="{{ $course->title }}">Title *</label>

                                <input type="text" id="title" placeholder="Enter the title" value="{{ $course->title }}" name="title" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="{{ $course->level }}">Level *</label>

                                <input type="text" id="level" placeholder="Enter the level" name="level" value="{{ $course->level }}" class="form-control">
                            </div>
                            <div class="form-group">
                                
                                <label for="{{ $course->price }}">Price *</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-dollar-sign"></i>
                                        </span>
                                    </div>
                                    <input type="text" id="price" placeholder="Enter price" name="price" value="{{ $course->price }}" class="form-control">
                                </div>
                                
                            </div>

                        </div>
                        <!-- /.card-body -->

                        <!-- /.card-header -->
		                <div class="card-body">
                            @if($course->featured_image)
                                <img src="{{ Storage::disk('local')->url($course->featured_image) }}" class="profile-user-img img-responsive" alt="Selected Featured Image" id="output">
                            @endif
		                	
			                <div class="form-group">
			                    <label for="featured_image">Featured Image *</label>
			                    <div class="input-group">
				                    <div class="custom-file">
				                        <input type="file" accept="image/*" onchange="loadFile(event)" name="featured_image" class="custom-file-input" id="FeaturedImageInputFile">
				                        <label class="custom-file-label" for="exampleInputFile">Upload Image</label>
				                    </div>
			                    </div>
			                </div>
		                    <small style="color: blue;">Image Size Should Be 800 x 800. or square size</small>
		                </div>
		                <!-- /.card-body -->

                        <div class="card-body">
                            <input type="button" id="add_more" class="btn btn-primary" value="Add More Module"/>
                            <div id="module-container">

                                @php
                                    $totalContentCount = 0;
                                    foreach ($course->modules as $module) {
                                        $totalContentCount += $module->contents->count();
                                    }
                                @endphp
                                @forelse ($course->modules as $module)
                                    @php
                                        $moduleId = $loop->index + 1;
                                    @endphp
                                    <div class="module-wrapper">

                                        <div class="card card-default module" data-module-id="{{ $moduleId }}">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="module_title_{{ $moduleId }}">Module Title *</label>
                                                    <input type="text" id="module_title_{{ $moduleId }}" name="modules[{{ $moduleId }}][title]" value="{{ $module->title }}" class="form-control" required>
                                                </div>
                                                <input type="hidden" id="module_id_{{ $moduleId }}" name="modules[{{ $moduleId }}][id]" value="{{ $module->id }}" class="form-control">
                                                <button type="button" class="btn btn-success add-content" data-module-id="{{ $moduleId }}">Add Content</button>
                                                <button type="button" class="btn btn-danger remove-module" data-modules-id="{{ $module->id }}">Remove Module</button>
                                                <div class="content-container-{{ $moduleId }} mt-3">
                                                    
                                                    @forelse ($module->contents as $content)
                                                        @php
                                                            $contentId = $loop->index;
                                                        @endphp
                                                        <div class="content-block">
                                                            <hr>
                                                            <input type="hidden" name="modules[{{ $moduleId }}][content][{{ $contentId }}][id]" value="{{ $content->id }}">
                                                            <div class="form-group">
                                                                <label>Title *</label>
                                                                <input type="text" name="modules[{{ $moduleId }}][content][{{ $contentId }}][title]" value="{{ $content->title }}" class="form-control" required>
                                                            </div>
                                                            @forelse (json_decode($content->data, true) as $name => $value)
                                                                <div class="form-group">
                                                                    <label>{{ ucfirst($name) }}*</label>
                                                                    <input type="text" name="modules[{{ $moduleId }}][content][{{ $contentId }}][{{ $name }}]" value="{{ $value }}" class="form-control" required>
                                                                </div>
                                                            @empty
                                                            @endforelse
                                                            <button type="button" class="btn btn-sm btn-danger remove-content" data-content-id="{{ $content->id }}">Remove Content</button>
                                                        </div>
                                                          
                                                    @empty
                                                    @endforelse
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                @endforelse
                        
                            </div>
                        
                        </div>

                        <!-- general form elements -->
                        <div class="card card-default">
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button id="saveFormButton" class="btn btn-primary">Save</button>
                            </div>
                            <!-- /.card-footer -->
                        </div>
                        <!-- /.card -->
                    </form>
                    
                </div>
                <!-- /.card -->
            </div>
        </div>

    </div><!-- /.container-fluid -->

@endsection

@section('admin_js_content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>

    <script>


        var loadFile = function(event){
 
            var image = document.getElementById('output');
            image.src = URL.createObjectURL(event.target.files[0]);
        }

        let moduleCount = {{ optional($course->modules)->count() ?? 0 }};
        let contentTitleCount = {{ $totalContentCount ?? 0 }};

        document.getElementById('add_more').addEventListener('click', function() {
            moduleCount++;
            const moduleDiv = document.createElement('div');
            moduleDiv.classList.add('module-wrapper');
            moduleDiv.innerHTML = `
                <div class="card card-default module" data-module-id="${moduleCount}">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="module_title_${moduleCount}">Module Title *</label>
                            <input type="text" id="module_title_${moduleCount}" name="modules[${moduleCount}][title]" class="form-control" required>
                        </div>
                        <button type="button" class="btn btn-success add-content" data-module-id="${moduleCount}">Add Content</button>
                        <button type="button" class="btn btn-danger remove-module" data-module-id="${moduleCount}">Remove Module</button>
                        <div class="content-container-${moduleCount} mt-3">
                            </div>
                    </div>
                </div>
            `;
            document.getElementById('module-container').appendChild(moduleDiv);
        });

        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('add-content')) {
                const moduleId = event.target.dataset.moduleId;
                const fieldCount = parseInt(prompt("How many input fields do you want to add?"));
                
                if (isNaN(fieldCount) || fieldCount <= 0){
                    alert("Enter Number only");
                }
                
                const contentBlock = document.createElement('div');
                contentBlock.classList.add('content-block');

                let contentFields = `
                    <hr>
                    <div class="form-group">
                        <label>Title *</label>
                        <input type="text" name="modules[${moduleId}][content][${contentTitleCount}][title]" class="form-control" required>
                    </div>
                `;

                const fieldNamesArray = [];

                for (let i = 0; i < fieldCount; i++) {
                    let fieldName = prompt("Enter the name of input field " + (i + 1));
                    while (!fieldName || fieldName.trim() === '') {
                        alert("Please enter a valid field name.");
                        fieldName = prompt("Enter the name of input field " + (i + 1));
                    }
                    fieldNamesArray.push(fieldName.trim());
                }

                fieldNamesArray.forEach((name) => {
                    contentFields += `
                        <div class="form-group">
                            <label>${name} *</label>
                            <input type="text" name="modules[${moduleId}][content][${contentTitleCount}][${name}]" class="form-control" required>
                        </div>
                    `;
                });

                contentFields += `
                    <button type="button" class="btn btn-sm btn-danger remove-content">Remove Content</button>
                `;
                contentBlock.innerHTML = contentFields;

                const contentWrapper = document.querySelector(`.content-container-${moduleId}`);
                contentWrapper.appendChild(contentBlock);

                contentTitleCount++;
            }

            if (event.target.classList.contains('remove-content')) {
                const contentId = event.target.dataset.contentId;
                
                if (contentId) {
                    $.ajax({
                        url: '{{ url("module/content/delete/") }}/' + contentId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response){
                            if(response.success){
                                toastr.success(response.message);
                            }else{
                                alert(response.message);
                            }
                        },
                        error: function (xhr, status, error) {
                            if (xhr.status === 404) {
                                toastr.error('Requested URL not found!');
                            } else {
                                toastr.error('Something went wrong: ' + error);
                            }
                            console.error(xhr.responseText); 
                        }
                    });
                }
                const contentBlock = event.target.closest('.content-block');
                contentBlock.remove();
            }

            if (event.target.classList.contains('remove-module')) {
                const moduleId = event.target.dataset.modulesId;
                
                if (moduleId) {
                    $.ajax({
                        url: '{{ url("module/delete/") }}/'+moduleId, 
                        type: 'delete',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response){
                            if(response.success){
                                toastr.success(response.message);
                            }else{
                                alert(response.message);
                            }
                        },
                        error: function (xhr, status, error) {
                            if (xhr.status === 404) {
                                toastr.error('Requested URL not found!');
                            } else {
                                toastr.error('Something went wrong: ' + error);
                            }
                            console.error(xhr.responseText); 
                        }
                    });
                }
                const moduleWrapper = event.target.closest('.module-wrapper');
                moduleWrapper.remove();
            }
        });

        $(document).ready(function (){
            var form = $('#courseForm');
            form.submit(function (e){
                e.preventDefault();
                let formData = new FormData(form[0]);
                formData.append('_method', 'PUT');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: form.attr('action'),
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false, 
                    success: function(response){
                        if(response.success){
                            toastr.success('Course Updated Successfully!');
                            // console.log(response.formData);
                            window.location.href = "{{ route('course.index') }}";
                        }else{
                            alert(response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        if (xhr.status === 404) {
                            toastr.error('Requested URL not found!');
                        } else {
                            toastr.error('Something went wrong: ' + error);
                        }
                        console.error(xhr.responseText); 
                    }
                });
            });
        });
    </script>

@endsection
