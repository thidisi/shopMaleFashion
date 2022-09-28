<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('backend/images/favicon.ico') }}" />

    <!-- third party css -->
    {{-- <link href="{{ asset('backend/css/vendor/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css" /> --}}
    <!-- third party css end -->
    <link href="{{ asset('backend/css/vendor/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/css/vendor/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="{{ asset('backend/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/css/app-creative.min.css') }}" rel="stylesheet" type="text/css" id="light-style" />
    <link href="{{ asset('backend/css/app-creative-dark.min.css') }}" rel="stylesheet" type="text/css"
        id="dark-style" />
    @stack('css')
</head>

<body class="loading"
    data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
    <!-- Begin page -->
    <div class="wrapper">
        <!-- ========== Left Sidebar Start ========== -->
        @include('backend.partials.LSidebar')
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">
                <!-- Topbar Start -->
                @include('backend.partials.Topbar')
                <!-- end Topbar -->

                <!-- Start Content-->
                @yield('container')
                {{-- <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                            </div>
                        </div>
                    </div> --}}
                <!-- container -->

            </div>
            <!-- content -->
            @include('backend.partials.footer')
            <!-- Footer Start -->

            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


    </div>
    <!-- END wrapper -->

    <!-- Right Sidebar -->
    @include('backend.partials.RSidebar')
    <!-- /Right-bar -->

    <!-- bundle -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('backend/js/vendor.min.js') }}"></script>
    <script src="{{ asset('backend/js/app.min.js') }}"></script>
    <script src="{{ asset('backend/js/helper.js') }}"></script>

    <!-- third party js -->
    {{-- <script src="{{ asset('backend/js/vendor/apexcharts.min.js') }}"></script>
        <script src="{{ asset('backend/js/vendor/jquery-jvectormap-1.2.2.min.js') }}"></script>
        <script src="{{ asset('backend/js/vendor/jquery-jvectormap-world-mill-en.js') }}"></script> --}}

    <!-- demo app -->
    {{-- <script src="{{ asset('backend/js/pages/demo.dashboard.js') }}"></script> --}}
    <!-- end demo js-->
    <script type="text/javascript">
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>
    @stack('js')
</body>

</html>
