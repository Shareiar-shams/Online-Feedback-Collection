<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>
    @section('admin_title_content')
      @show
  </title>

  @include('admin.layouts.includeFile.admin-css')
  
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

      <!-- Navbar -->
      @include('admin.layouts.navigation')
      <!-- /.navbar -->

      @include('admin.layouts.includeFile.main-sidebar')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <div class="content-header">
              <div class="container-fluid">
                  <div class="row mb-2">
                      @section('admin_content_header')
                        @show
                      {{-- @include('admin.layouts.includeFile.content-header') --}}
                      
                  </div><!-- /.row -->
              </div><!-- /.container-fluid -->
          </div>
          <!-- /.content-header -->

          <!-- Main content -->
          <section class="content">
              @section('admin_main_content')
                  @show
            
          </section>
          <!-- /.content -->
      </div>
      @include('admin.layouts.includeFile.footer')
      

      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
      </aside>
      <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    @include('admin.layouts.includeFile.admin-js')
    
</body>
</html>
