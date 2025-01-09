@extends('admin.layouts.layout')
@section('admin_title_content')
    FeedbackCollection | Dynamic Form
@endsection
@section('admin_css_content')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection
@section('admin_content_header')
    <div class="col-sm-6">
        <h1 class="m-0">{{$form->formName}}</h1>
    </div><!-- /.col -->
    @php 
      $list = json_encode(['Home', 'Form']);
    @endphp
    <x-ad-breadcrumb :list="$list"/>
@endsection

@section('admin_main_content')
    
    <div class="container-fluid">
        <div class="row">
        	<div class="col-md-12">
        		<!-- general form elements -->
	            <div class="card card-primary">
	              	<div class="card-header">
	                	<h3 class="card-title">{{$form->formName}}</h3>
	              	</div>
		            <!-- /.card-header -->
		            <!-- form start -->
		            @php
						$fields = json_decode($form->data); // Decode the JSON string

					@endphp
		            <form>

		            	<div class="card-body">
		            	@foreach ($fields as $field)
				            @switch($field->type)
				            	@case('header')
                                
	                                <{{$field->subtype}} class="{{ isset($field->className) ? $field->className : '' }}">{{ $field->label }}</{{$field->subtype}}> 
	                                @break
				                @case('text')
				                    <div class="form-group">
				                        <label for="{{ $field->name }}">{{ $field->label }}</label>
				                        <input type="{{ $field->type }}" class="{{ $field->className }}" id="{{ $field->name }}" name="{{ $field->name }}" placeholder="{{ $field->placeholder }}" value="{{ isset($field->value) ? $field->value : ''}}" 
				                        @if($field->required) required @endif 
				                        @if(isset($field->subtype) && $field->subtype == 'email') type="email" @endif
			                           	@if(isset($field->subtype) && $field->subtype == 'tel') type="tel" @endif
			                           	@if(isset($field->subtype) && $field->subtype == 'color') type="color" @endif
			                           	@if(isset($field->subtype) && $field->subtype == 'password') type="password" @endif
			                           	@if(isset($field->maxlength)) maxlength="{{ $field->maxlength }}" @endif
				                        >
				                    </div>
				                    @break
				                @case('autocomplete')
				                    <div class="form-group">
				                        <label for="{{ $field->name }}">{{ $field->label }}</label>
				                        <input type="text" class="{{ $field->className }}" id="{{ $field->name }}" name="{{ $field->name }}" placeholder="{{ $field->placeholder }}" 
				                               @if($field->required) required @endif> 
				                    </div>
				                    @break
				                @case('date')
				                    <div class="form-group">
				                        <label for="{{ $field->name }}">{{ $field->label }}</label>
				                        <input class="{{ $field->className }}" id="{{ $field->name }}" name="{{ $field->name }}" min="{{ $field->min }}" max="{{ $field->max }}" step="{{ $field->step }}" @if($field->required) required @endif
				                        		@if(isset($field->subtype) && $field->subtype == 'date') type="date" @endif
					                           	@if(isset($field->subtype) && $field->subtype == 'time') type="time" @endif
					                           	@if(isset($field->subtype) && $field->subtype == 'datetime-local') type="datetime-local" @endif
					                           	
				                               >
				                    </div>
				                    @break

				                @case('file')
				                    <div class="form-group">
				                        <label for="{{ $field->name }}">{{ $field->label }}</label>
				                        <input type="file" class="{{ $field->className }}" id="{{ $field->name }}" name="{{ $field->name }}" 
				                               @if($field->required) required @endif
				                               @if($field->multiple) multiple @endif>
				                    </div>
				                    @break
				                @case('textarea')
				                    <div class="form-group">
				                        <label for="{{ $field->name }}">{{ strip_tags($field->label) }}</label>
				                        <textarea class="{{ $field->className }}" id="{{ $field->name }}" name="{{ $field->name }}" rows="{{ isset($field->rows) ? $field->rows : 3 }}" value="{{ isset($field->value) ? $field->value : ''}}" placeholder="{{ $field->placeholder }}" @if($field->required) required @endif></textarea>
				                    </div>
				                    @break

				                @case('number')
		                            <div class="form-group">
		                                <label for="{{ $field->name }}">{{ $field->label }}</label>
		                                <input type="number" class="{{ $field->className }}" id="{{ $field->name }}" name="{{ $field->name }}" 
		                                       min="{{ $field->min }}" max="{{ $field->max }}" 
		                                       @if($field->required) required @endif>
		                            </div>
		                            @break

		                        @case('paragraph')
	                                @if ($field->subtype == 'blockquote')
	                                    <blockquote class={{ isset($field->className) ? $field->className : '' }}>{{ $field->label }}</blockquote>
	                                @elseif ($field->subtype == 'blockquote')
	                                    <address class={{ isset($field->className) ? $field->className : '' }}>{{ $field->label }}</address>
	                                @elseif ($field->subtype == 'blockquote')
	                                    <canvas class={{ isset($field->className) ? $field->className : '' }}>{{ $field->label }}</canvas>
	                                @elseif ($field->subtype == 'blockquote')
	                                    <output class={{ isset($field->className) ? $field->className : '' }}>{{ $field->label }}</output>
	                                @else
	                                    <p class={{ isset($field->className) ? $field->className : '' }}>{{ $field->label }}</p>
	                                @endif
	                                @break
				                @case('select')
					                <label for="{{ $field->name }}">{{ strip_tags($field->label) }}</label>
				                    <select id="{{ $field->name }}" 
				                            name="{{ $field->name }}" 
				                            class="{{ $field->className }}" 
				                            @if($field->required) required @endif
				                            @if($field->multiple) multiple @endif>
				                        @foreach ($field->values as $option)
				                            <option value="{{ $option->value }}" 
				                                @if($option->selected) selected @endif>
				                                {{ $option->label }}
				                            </option>
				                        @endforeach
				                    </select>
				                    @break
				                @case('radio-group')
				                	<label for="{{ $field->name }}">{{ strip_tags($field->label) }}</label>
				                    <div class="form-group">
				                        @foreach ($field->values as $option)
				                            <div class="form-check">
				                                <input class="{{ $field->className }}" 
				                                       type="radio" 
				                                       name="{{ $field->name }}" 
				                                       id="{{ $field->name }}-{{ $loop->index }}" 
				                                       value="{{ $option->value }}" 
				                                       @if($option->selected) checked @endif>
				                                <label class="form-check-label" 
				                                       for="{{ $field->name }}-{{ $loop->index }}">
				                                    {{ $option->label }}
				                                </label>
				                            </div>
				                        @endforeach
				                    </div>
					                @break
				                @case('checkbox-group')
				                	<label for="{{ $field->name }}">{{ strip_tags($field->label) }}</label>
				                	
				                    <div class="form-group">
				                        @foreach ($field->values as $option)
				                        	<div class="form-check">
					                          	<input class="{{ isset($field->className) ? $field->className : 'form-check-input'}}" 
					                          		type="checkbox" 
					                          		id="{{ $field->name }}-{{ $loop->index }}" 
					                          		name="{{ $field->name }}[]" 
					                          		value="{{ $option->value }}"
					                          		@if($field->required) required @endif
									                @if($option->selected) checked @endif
									            >
					                          	<label class="form-check-label" for="{{ $field->name }}-{{ $loop->index }}">
									                {{ $option->label }}
									            </label>
				                        	</div>

				                        @endforeach
				                    </div>
					                @break
				                @case('button')
				                	<div class="card-footer">
					                    <button type="type" value="{{ isset($field->value) ? $field->value : ''}}" class="{{ $field->className }}">{{ $field->label }}</button>
					                </div>
				                    @break
				                @default
				                    {{-- Handle other field types if necessary --}}
				            @endswitch
				        @endforeach
				        </div>
		                
		            </form>
	            </div>
	            <!-- /.card -->
        	</div>
        </div>
    </div><!-- /.container-fluid -->
@endsection

@section('admin_js_content')
@endsection