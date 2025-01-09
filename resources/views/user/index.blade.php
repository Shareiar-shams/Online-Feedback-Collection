@extends('user.layout.layout')
@section('user_title_content')
    FeedbackCollection 
@endsection
@section('user_css_content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <style type="text/css" media="screen">
        .form-wrapper{
            background-color: #ffffff;
            width: 100%;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            animation: fadeIn 1s ease-out;
        }
        .title{
            font-size: 28px;
            text-align: center;
            color: #333;
            margin-bottom: 10px;
        }
        .subtitle{
            text-align: center;
            color: #666;
            font-size: 16px;
            margin-bottom: 30px;
        }
        .contact-form{
            width: 100%;
        }

        .form-row{
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 20px;
        }
        .form-column{
            flex: 1;
            min-width: 250px;
        }
        .form-label{
            display: block;
            color: #333;
            font-size: 14px;
            margin-bottom: 5px;
        }
        .form-input,
        .form-textarea{
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
            transition: border-color 0.3s, transform 0.3s;
        }
        .form-input:focus,
        .form-textarea:focus{
            border-color: #6f6df4;
            outline: none;
            transform: scale(1.02);
        }
        .form-textarea{
            resize: none;
        }
        .submit-button{
            display: block;
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #6f6df4, #4c46f5);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s, transform 0.3s;
        }
        .submit-button:hover{
            background: linear-gradient(135deg, #4c46f5, #6f6df4);
            transform: scale(1.05);
        }

        @keyframes fadeIn{
            from{
                opacity: 0;
                transform: translateY(-20px);
            }
            to{
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px){
            .form-wrapper{
                padding: 30px;
            }
            .title{
                font-size: 24px;
            }
            .subtitle{
                font-size: 14px;
            }
            .form-row{
                flex-direction: column;
            }
        }

        @media (max-width: 540px){
            .form-wrapper{
                padding: 20px;
            }
            .title{
                font-size: 20px;
            }
            .subtitle{
                font-size: 12px;
            }
            .form-row{
                flex-direction: column;
                gap: 15px;
            }
            .form-column{
                min-width: 100%;
            }
            .form-label{
                font-size: 12px;
            }
            .form-input,
            .form-textarea{
                padding: 10px;
            }
            .submit-button{
                padding: 10px;
                font-size: 14px;
            }
        }

        .gatewaySuccess h1 {
            color: #88B04B;
            font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
            font-weight: 900;
            font-size: 30px;
            margin-bottom: 10px;
        }
        .gatewaySuccess p {
            color: #404F5E;
            font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
            font-size:24px;
            margin: 0;
            text-align: center;
        }
        .gatewaySuccess .checkmarkDiv{
            border-radius:200px; 
            height:100px; 
            width:100px; 
            background: #F8FAF5; 
            margin:0px auto;
            margin-top: -30px;
        }
        .gatewaySuccess i {
            color: #9ABC66;
            font-size: 50px;
            line-height: 80px;
            margin-left: 30px;
        }
        .gatewaySuccess {
            background: white;
            padding: 60px;
            border-radius: 4px;
            box-shadow: 0 2px 3px #C8D0D8;
            display: inline-block;
            margin: 0 auto;
            width: 100%;
        }

        @media (max-width: 992px) {
          .gatewaySuccess .checkmarkDiv{
            height:100px; 
            width:100px; 
            background: #F8FAF5; 
            margin:0px auto;
            margin-top: -30px;
          }
        }
    </style>
@endsection

@section('user_main_content')

    <!-- Header-->
    <header class="masthead d-flex align-items-center">
        <div class="container px-4 px-lg-5 text-center">
            <h1 class="mb-1">Online Feedback Collection</h1>
            <h3 class="mb-5"><em>This site use for collect valuable Feedback from user.</em></h3>
            <a class="btn btn-primary btn-xl" href="#form" role="button" data-toggle="modal">Give Your Feedback</a>
        </div>
    </header>

     
    <!-- feedback form-->
    <section class="content-section" id="form">
        <div class="container px-4 px-lg-5">
            <div class="form-wrapper">
                <h1 class="title">{{$form->formName}}</h1>
                <p class="subtitle">{{ isset($form->formSubtitle) ? $form->formSubtitle : ''}}</p>
                @php
                    $fields = json_decode($form->data); // Decode the JSON string

                @endphp
                <form class="contact-form" id="dynamicForm" enctype="multipart/form-data">
                    @csrf
                    @foreach ($fields as $field)
                        @switch($field->type)
                            @case('header')
                                
                                <{{$field->subtype}} class="{{ isset($field->className) ? $field->className : '' }}">{{ $field->label }}</{{$field->subtype}}>
                                @break

                            @case('text')
                                <div class="form-row">
                                    <div class="form-column">
                                        <label for="{{ $field->name }}" class="form-label">{{ $field->label }}</label>
                                        <input class="{{ $field->className }}" id="{{ $field->name }}" name="{{ $field->name }}" placeholder="{{ $field->placeholder }}" value="{{ isset($field->value) ? $field->value : ''}}"
                                          @if($field->required) required @endif 
                                          @if(isset($field->subtype) && $field->subtype == 'email')   type="{{$field->subtype}}" 
                                          @elseif(isset($field->subtype) && $field->subtype == 'tel')   type="number" 
                                          @elseif(isset($field->subtype) && $field->subtype == 'color') 
                                              type="{{$field->subtype}}" 
                                          @elseif(isset($field->subtype) && $field->subtype == 'password') 
                                              type="{{$field->subtype}}" 
                                          @else
                                              type="{{$field->type}}"
                                          @endif
                                          @if(isset($field->maxlength)) maxlength="{{ $field->maxlength }}" @endif
                                        >
                                    </div>
                                </div>
                                @break
                            @case('autocomplete')
                                <div class="form-row">
                                    <div class="form-column">
                                        <label for="{{ $field->name }}">{{ $field->label }}</label>
                                        <input type="text" class="{{ $field->className }}" id="{{ $field->name }}" name="{{ $field->name }}" placeholder="{{ $field->placeholder }}" 
                                            @if($field->required) required @endif> 
                                    </div>
                                </div>
                                @break
                            @case('file')
                                <div class="form-row">
                                    <div class="form-column">
                                        <label for="{{ $field->name }}">{{ $field->label }}</label>
                                        <input type="file" class="{{ $field->className }}" id="{{ $field->name }}" name="{{ $field->name }}" 
                                               @if($field->required) required @endif
                                               @if($field->multiple) multiple @endif>
                                    </div>
                                </div>
                                @break
                            @case('date')
                                <div class="form-row">
                                    <div class="form-column">
                                        <label for="{{ $field->name }}">{{ $field->label }}</label>
                                        <input class="{{ $field->className }}" id="{{ $field->name }}" name="{{ $field->name }}" min="{{ $field->min }}" max="{{ $field->max }}" step="{{ $field->step }}" @if($field->required) required @endif
                                            @if(isset($field->subtype) && $field->subtype == 'date') type="date" @endif
                                            @if(isset($field->subtype) && $field->subtype == 'time') type="time" @endif
                                            @if(isset($field->subtype) && $field->subtype == 'datetime-local') type="datetime-local" @endif
                                            
                                        >
                                    </div>
                                </div>
                                @break
                            @case('file')
                                <div class="form-row">
                                    <div class="form-column">
                                        <label for="{{ $field->name }}">{{ $field->label }}</label>
                                        <input type="file" class="{{ $field->className }}" id="{{ $field->name }}" name="{{ $field->name }}" 
                                               @if($field->required) required @endif
                                               @if($field->multiple) multiple @endif>
                                    </div>
                                </div>
                                @break
                            @case('textarea')
                                <div class="form-row">
                                    <div class="form-column">
                                        <label for="{{ $field->name }}" class="form-label">{{ strip_tags($field->label) }}</label>
                                        <textarea class="{{ $field->className }}" id="{{ $field->name }}" value="{{ isset($field->value) ? $field->value : ''}}" name="{{ $field->name }}" rows="{{ isset($field->rows) ? $field->rows : 4 }}" placeholder="{{ $field->placeholder }}" @if($field->required) required @endif></textarea>
                                    </div>
                                </div>
                                @break
                            @case('number')
                                <div class="form-row">
                                    <div class="form-column">
                                        <label for="{{ $field->name }}">{{ $field->label }}</label>
                                        <input type="number" class="{{ $field->className }}" id="{{ $field->name }}" name="{{ $field->name }}" 
                                               min="{{ $field->min }}" max="{{ $field->max }}" 
                                               @if($field->required) required @endif>
                                    </div>
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
                                <div class="form-row">
                                    <div class="form-column">
                                        <label for="{{ $field->name }}" class="form-label">{{ strip_tags($field->label) }}</label>
                                        <select id="{{ $field->name }}" 
                                                name="{{ $field->name }}@if($field->multiple) [] @endif" 
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
                                    </div>
                                </div>
                                @break
                            @case('radio-group')
                                  <label for="{{ $field->name }}" class="form-label">{{ strip_tags($field->label) }}</label>
                                  <div class="form-row">
                                    <div class="form-column">
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
                                  </div>
                              @break
                            @case('checkbox-group')
                                <label for="{{ $field->name }}" class="form-label">{{ strip_tags($field->label) }}</label>
                              
                                <div class="form-row">
                                  <div class="form-column">
                                    @foreach ($field->values as $option)
                                      <div class="form-check">
                                          <input class="{{ isset($field->className) ? $field->className : 'form-check-input'}}" 
                                            type="checkbox" 
                                            id="{{ $field->name }}-{{ $loop->index }}" 
                                            name="{{ $field->name }}[]" 
                                            value="{{ $option->value }}"
                                            @if($field->required) required @endif
                                            @if($option->selected) checked @endif>
                                          <label class="form-check-label" for="{{ $field->name }}-{{ $loop->index }}">
                                              {{ $option->label }}
                                          </label>
                                      </div>

                                    @endforeach
                                  </div>
                                </div>
                              @break
                            @case('button')
                                <button class="{{ $field->className }}"
                                  @if(isset($field->subtype) && $field->subtype == 'submit')   
                                    type="{{$field->subtype}}" 
                                  @elseif(isset($field->subtype) && $field->subtype == 'button')
                                    type="{{$field->subtype}}"
                                  @elseif(isset($field->subtype) && $field->subtype == 'reset')
                                    type="{{$field->subtype}}" 
                                  @else
                                      type="submit"
                                  @endif
                                >{{ $field->label }}</button>
                                @break
                            @default
                                {{-- Handle other field types if necessary --}}
                        @endswitch
                    @endforeach
                    
                </form>
            </div>
        </div>
    </section>
    
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Success!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="gatewaySuccess">
                        <div class="checkmarkDiv">
                            <i class="checkmark">✓</i>
                        </div>
                        <p>Your form has been submitted successfully.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('user_js_content')

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> 
    <script>
        $(document).ready(function() {
            $('#dynamicForm').on('submit', function(event) {
                event.preventDefault(); 

                $.ajax({
                    url: "{{ route('dynamic.submit') }}",
                    method: "POST",
                    data: $(this).serialize(), // Serialize form data
                    success: function(response) {
                        if (response.success) {

                            $('#successModal').modal('show');

                            setTimeout(function() {
                              $('#dynamicForm')[0].reset(); 
                            }, 500);
                        } else {
                            alert('Form submission failed.'); // Handle server-side validation errors
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('An error occurred during submission.'); // Handle general errors
                        console.error(xhr.responseText); // Debug the error in the browser console
                    }
                });
            });
        });
    </script>


@endsection