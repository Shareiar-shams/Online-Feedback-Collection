<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>
		    @section('user_title_content')
		      @show
		</title>

		@include('user.layout.includeFile.user-css')
        
    </head>

    <body id="page-top">
        {{-- <!-- Navigation-->
        <a class="menu-toggle rounded" href="#"><i class="fas fa-bars"></i></a>
        @include('user.layout.includeFile.nav') --}}
        

        @section('user_main_content')
          	@show
        
        @include('user.layout.includeFile.footer')
        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>
        @include('user.layout.includeFile.js')
    </body>
</html>