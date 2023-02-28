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
        <link rel="shortcut icon" href="{{ asset('backend/images/favicon.ico') }}">

        <!-- App css -->
        <link href="{{ asset('backend/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('backend/css/app-creative.min.css') }}" rel="stylesheet" type="text/css" id="light-style" />
        <link href="{{ asset('backend/css/app-creative-dark.min.css') }}" rel="stylesheet" type="text/css" id="dark-style" />
        @stack('css')
    </head>

    <body class="authentication-bg pb-0" data-layout-config='{"darkMode":false}'>

        <div class="auth-fluid">
            <!--Auth fluid left content -->
            <div class="auth-fluid-form-box">
                <div class="align-items-center d-flex h-100">
                    <div class="card-body">

                        <!-- Logo -->
                        <div class="auth-brand text-center text-lg-left">
                            <a href="index.html" class="logo-dark">
                                <span><img src="{{ asset('backend/images/logo-dark.png') }}" alt="" height="18"></span>
                            </a>
                            <a href="index.html" class="logo-light">
                                <span><img src="{{ asset('backend/images/logo.png') }}" alt="" height="18"></span>
                            </a>
                        </div>

                        <!-- title-->
                        @yield('content')

                        <!-- end form-->


                    </div> <!-- end .card-body -->
                </div> <!-- end .align-items-center.d-flex.h-100-->
            </div>
            <!-- end auth-fluid-form-box-->

            <!-- Auth fluid right content -->
            <div class="auth-fluid-right text-center">
                <div class="auth-user-testimonial">
                    <h2 class="mb-3">I love the color!</h2>
                    <p class="lead"><i class="mdi mdi-format-quote-open"></i> It's a elegent templete. I love it very much! . <i class="mdi mdi-format-quote-close"></i>
                    </p>
                    <p>
                        - Hyper Admin User
                    </p>
                </div> <!-- end auth-user-testimonial-->
            </div>
            <!-- end Auth fluid right content -->
        </div>
        <!-- end auth-fluid-->

        <!-- bundle -->
        <script src="{{ asset('backend/js/vendor.min.js') }}"></script>
        <script src="{{ asset('backend/js/app.min.js') }}"></script>

    </body>

</html>
