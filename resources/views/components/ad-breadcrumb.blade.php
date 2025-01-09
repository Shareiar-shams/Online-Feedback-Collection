
<div class="col-sm-6">
  	<ol class= "breadcrumb float-sm-right">
  		@foreach(json_decode($list, true) as $key => $value)
	      	<li class='@if ($loop->last) breadcrumb-item active @else breadcrumb-item @endif'><a @if ($loop->last)  @else href='#' @endif >
	      		{{ $value ?? $slot }}
	      	</a></li>
      	@endforeach
  	</ol>
</div><!-- /.col -->
