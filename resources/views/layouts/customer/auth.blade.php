<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">


<!-- Mirrored from themesbrand.com/velzon/html/default/job-landing.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 20 Mar 2023 16:06:05 GMT -->
<head>

        <meta charset="utf-8" />
        <title>@yield('page') | I-Posita</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/iposta/logo.png') }}">

        <!--Swiper slider css-->
        <link href="{{ asset('assets/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />

        <!-- Layout config Js -->
        <script src="{{ asset('assets/js/layout.js') }}"></script>
        <!-- Bootstrap Css -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- custom Css-->
        <link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />

    </head>

    <body data-bs-spy="scroll" data-bs-target="#navbar-example">

        <!-- Begin page -->
        <div class="layout-wrapper landing">
            <nav class="navbar navbar-expand-lg navbar-landing fixed-top job-navbar" id="navbar">
                <div class="container-fluid custom-container">
                    <a class="navbar-brand" href="{{ route('home') }}">
                        <img src="{{ asset('assets/images/iposta/logo.png') }}" class="card-logo card-logo-dark" alt="logo dark" height="40">
                        <img src="{{ asset('assets/images/iposta/logo.png') }}" class="card-logo card-logo-light" alt="logo light" height="40">
                    </a>
                    <button class="navbar-toggler py-0 fs-20 text-body" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="mdi mdi-menu"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mx-auto mt-2 mt-lg-0" id="navbar-example">

                        </ul>

                        <div class="">
                            <a href="{{ route('admin.login') }}" class="btn btn-soft-primary"><i class="ri-user-3-line align-bottom me-1"></i>IPOSTA Staff</a>
                        </div>
                    </div>

                </div>
            </nav>
            <!-- end navbar -->

            @yield('contents')

            <!-- Start footer -->
            <footer class="custom-footer py-2">

               <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0 text-muted">&copy;
                                <script>document.write(new Date().getFullYear())</script> National Post Office - Developed by <a href="#">{{ env('APP_DEVELOPER') }}</a> (TEL : +250 788 672 782)
                            </p>
                        </div>
                    </div>
                </div>
               </div>
            </footer>
            <!-- end footer -->

        </div>
        <!-- end layout wrapper -->


        <!-- JAVASCRIPT -->
        <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
        <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
        <script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
        <script src="{{ asset('assets/js/plugins.js') }}"></script>

        <!--Swiper slider js-->
        <script src="{{ asset('assets/libs/swiper/swiper-bundle.min.js') }}"></script>

        <!--job landing init -->
        <script src="{{ asset('assets/js/pages/job-lading.init.js') }}"></script>
    </body>


<!-- Mirrored from themesbrand.com/velzon/html/default/job-landing.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 20 Mar 2023 16:06:10 GMT -->
</html>
