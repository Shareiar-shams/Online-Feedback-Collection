@extends('admin.layouts.layout')
@section('admin_title_content')
    FeedbackCollection | Dashboard
@endsection
@section('admin_content_header')
  <div class="col-sm-6">
    <h1 class="m-0">Dashboard</h1>
  </div><!-- /.col -->
  @php 
    $list = json_encode(['Home', 'Dashboard']);
  @endphp
  <x-ad-breadcrumb :list="$list"/>
@endsection
@section('admin_css_content')
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{asset('admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{asset('admin/plugins/jqvmap/jqvmap.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{asset('admin/plugins/daterangepicker/daterangepicker.css')}}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('admin/plugins/summernote/summernote-bs4.min.css')}}">
@endsection
@section('admin_main_content')
    @php
        use Carbon\Carbon;
        $totalSubmissions = App\Models\User\FormSubmission::count();
        $todaySubmissions = App\Models\User\FormSubmission::whereDate('created_at', Carbon::today())->count();
        $thisMonthSubmissions = App\Models\User\FormSubmission::whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->count();
    @endphp
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ isset($totalSubmissions) ? $totalSubmissions : 0}}</h3>

                        <p>Total Feedback</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        {{-- <h3>53<sup style="font-size: 20px">%</sup></h3> --}}
                        <h3>{{ isset($todaySubmissions) ? $todaySubmissions : 0}}</h3>

                        <p>Today Feedback</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ isset($thisMonthSubmissions) ? $thisMonthSubmissions : 0}}</h3>

                        <p>This Month Total Feedback</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                </div>
            </div>
            

        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
            
            <section class="col-lg-12 connectedSortable">
                <!-- LINE CHART -->
                <div class="card card-info">
                  <div class="card-header">
                    <h3 class="card-title">Feedback Report</h3>

                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="chart">
                      <canvas id="lineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </section>

            <section class="col-lg-12 connectedSortable">
              
              <!-- TABLE: LATEST ORDERS -->
              <div class="card">
                <div class="card-header border-transparent">
                  <h3 class="card-title">Recent Form</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table m-0">
                      <thead>
                      <tr>
                        <th>Title</th>
                        <th>SubTitle</th>
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
                  <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                 
                  <a href="{{route('show_forms')}}" class="btn btn-sm btn-secondary float-right">View All Forms</a>
                </div>
                <!-- /.card-footer -->
              </div>
              <!-- /.card -->
            </section>
            <!-- /.Left col -->
        </div>
        <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
    
@endsection
@section('admin_js_content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- ChartJS -->
    <script src="{{asset('admin/plugins/chart.js/Chart.min.js')}}"></script>
    <!-- Sparkline -->
    <script src="{{asset('admin/plugins/sparklines/sparkline.js')}}"></script>
    <!-- JQVMap -->
    <script src="{{asset('admin/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
    <script src="{{asset('admin/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{asset('admin/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
    <!-- daterangepicker -->
    <script src="{{asset('admin/plugins/moment/moment.min.js')}}"></script>
    <script src="{{asset('admin/plugins/daterangepicker/daterangepicker.js')}}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{asset('admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
    <!-- Summernote -->
    <script src="{{asset('admin/plugins/summernote/summernote-bs4.min.js')}}"></script>
    <!-- overlayScrollbars -->
    <script src="{{asset('admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{asset('admin/dist/js/pages/dashboard.js')}}"></script>
    <script type="text/javascript">
        $(function () {

            // Define functions to fetch and format data
            function getTodayFeedbackCount() {
                return $.ajax({ // Return the promise
                    url: "{{ route('getTodayFeedbackCount') }}", 
                    type: 'GET'
                }).then(function(response) {
                    return response.count; // Resolve with the count
                }).catch(function() {
                    return 0; // Resolve with 0 in case of an error
                });
            }

            function getThisMonthFeedbackCount() {
                return $.ajax({ // Return the promise
                    url: "{{ route('getThisMonthFeedbackCount') }}", 
                    type: 'GET'
                }).then(function(response) {
                    return response.count; // Resolve with the count
                }).catch(function() {
                    return 0; // Resolve with 0 in case of an error
                });
            }

            // Fetch data using the defined functions
            Promise.all([getTodayFeedbackCount(), getThisMonthFeedbackCount()])
                .then(function(results) {
                    var todayCount = results[0];
                    var thisMonthCount = results[1];

                    // Prepare data for Chart.js
                    var lineChartData = {
                        labels: ['Today', 'This Month'],
                        datasets: [{
                            label: 'Feedback Count',
                            backgroundColor: 'rgba(60,141,188,0.9)',
                            borderColor: 'rgba(60,141,188,0.8)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: [todayCount, thisMonthCount]
                        }]
                    };

                    // Create the chart
                    var lineChartCanvas = $('#lineChart').get(0).getContext('2d');
                    var lineChartOptions = {
                        maintainAspectRatio: false,
                        responsive: true,
                        legend: {
                            display: false
                        },
                        scales: {
                            xAxes: [{
                                gridLines: {
                                    display: false
                                }
                            }],
                            yAxes: [{
                                gridLines: {
                                    display: false
                                }
                            }]
                        }
                    };

                    var lineChart = new Chart(lineChartCanvas, {
                        type: 'line',
                        data: lineChartData,
                        options: lineChartOptions
                    });

                })
                .catch(function(error) {
                    console.error('Error fetching data:', error);
                });
        });

    </script>
@endsection 
