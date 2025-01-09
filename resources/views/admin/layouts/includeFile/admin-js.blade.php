<!-- jQuery -->
<script src="{{asset('admin/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('admin/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

@section('admin_js_content')
    @show
<!-- AdminLTE App -->
<script src="{{asset('admin/dist/js/adminlte.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('admin/dist/js/demo.js')}}"></script>

<!-- Page specific script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>


<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
{{-- <script type="text/javascript">
      var notificationsWrapper   = $('.dropdown-notifications');
      var notificationsToggle    = notificationsWrapper.find('a[data-toggle]');
      var notificationsCountElem = notificationsToggle.find('i[data-count]');
      var notificationsCount     = parseInt(notificationsCountElem.data('count'));
      var notifications          = notificationsWrapper.find('.dropdown-test');

      if (notificationsCount <= 0) {
        notificationsWrapper.hide();
      }

      // Enable pusher logging - don't include this in production
      Pusher.logToConsole = true;

        var pusher = new Pusher('27ba8f62752f1bae1ffc', {
            cluster: 'ap2',
            encrypted: true,
        });

        var channel = pusher.subscribe('notifications');

        // Listen for the subscription succeeded event
        channel.bind('pusher:subscription_succeeded', function() {
            console.log('Successfully subscribed to the channel: notifications');
        });

        channel.bind('new-form-submission', function(data) {
            console.log('Event received:', data);

            var notificationsWrapper = $('.dropdown-notifications');
            var notifications = notificationsWrapper.find('.dropdown-test');
            var notificationsCountElem = notificationsWrapper.find('i[data-count]');
            var notificationsCount = parseInt(notificationsCountElem.data('count'));

            var newNotificationHtml = `
                <a href="{{route('submitted_form_list')}}" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i> A new feedback is registered
                    <span class="float-right text-muted text-sm">Just now</span>
                </a>
                <div class="dropdown-divider"></div>
            `;

            notifications.prepend(newNotificationHtml);

            notificationsCount += 1;
            notificationsCountElem.attr('data-count', notificationsCount);
            notificationsWrapper.find('.notif-count').text(notificationsCount);
            notificationsWrapper.show();
        });
</script> --}}

<script>
    Pusher.logToConsole = true;
    var pusher = new Pusher('27ba8f62752f1bae1ffc', {
        cluster: 'ap2',
        encrypted: true,
    });
    var channel = pusher.subscribe('feedback');
    channel.bind('new-feedback-submission', function(data) {
        if (data) {
            toastr.success('New Feedback submitted', {
                timeOut: 500,  
                extendedTimeOut: 0,  
            });
        } else {
            console.error('Invalid data structure received:', data);
        }
    });

    
</script>

<script>
    var preloader = document.getElementById("loader");
    function myFunction(){
            preloader.style.display = 'none';
    };
    @if(Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        switch(type){
            case 'info':
                toastr.info("{{ Session::get('message') }}");
                break;
            
            case 'warning':
                toastr.warning("{{ Session::get('message') }}");
                break;

            case 'success':
                toastr.success("{{ Session::get('message') }}");
                break;

            case 'error':
                toastr.error("{{ Session::get('message') }}");
                break;
        }
    @endif
</script>