<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title')</title>


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- jQuery UI -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ url('assets/admin/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('assets/admin/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="{{ url('assets/admin/fonts/SansPro/SansPro.min.css') }}">
    @if (App::getLocale() == 'ar')
        <link rel="stylesheet" href="{{ url('assets/admin/css/bootstrap_rtl-v4.2.1/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ url('assets/admin/css/bootstrap_rtl-v4.2.1/custom_rtl.css') }}">
    @endif
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ url('assets/admin/css/mycustomstyle.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        @media print {
            .no-print, .admin-footer {
                display: none !important;
            }
        }
    </style>
    <style>
        #map {
            height: 500px;
            width: 100%;
        }
    </style>    
    @yield('css')
</head>
<body class="hold-transition sidebar-mini">
    <?php $user = auth()->user(); ?>
    <div class="wrapper">
        <!-- Navbar -->
        @include('admin.includes.navbar')
        <!-- Main Sidebar Container -->
        @include('admin.includes.sidebar')
        <!-- Content Wrapper. Contains page content -->
        @include('admin.includes.content')
        <!-- Footer -->
        <div class="admin-footer no-print">
            @include('admin.includes.footer')
        </div>

    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- Bootstrap 4 -->
    <script src="{{ url('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ url('assets/admin/dist/js/adminlte.min.js') }}"></script>
    <script src="{{ url('assets/admin/js/general.js') }}"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script type="text/javascript">
      var hotels_service         =  "{{ __('messages.hotels') }}";  
      var visa_service           =  "{{ __('messages.Visa') }}"; 
      var trip_service           =  "{{ __('messages.Trip') }}"; 
      var transport_service      =  "{{ __('messages.Transport') }}"; 
      var ticket_service         =  "{{ __('messages.Ticket') }}"; 
  
    </script>
    @yield('script')
    @yield('js')
    @stack('js')

    <script>
    $(document).ready(function() {
        $('form').on('submit', function(event) {
            $('button').attr('disabled','disabled');
        });
    });
</script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

</body>
</html>
