<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Admin Tadimedia</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="MyraStudio" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('admin-theme/assets/images/favicon.ico') }}">

    <!-- App css -->
    <link href="{{ asset('admin-theme/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin-theme/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin-theme/assets/css/theme.min.css') }}" rel="stylesheet" type="text/css" />

    <style>
        .btn-submit {
            height: 40px;
            width: 90px
        }

        /*.main-content {*/
        /*    max-width: 800px;*/
        /*}*/
        .page-content {
            padding-top: 20px
        }
        .main-content {
            margin-left: 0px
        }
    </style>
</head>

<body>
    <?php $routeName = request()->route()->getName(); ?>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
            <div class="container">
               
                <div class="collapse navbar-collapse order-3" id="navbarCollapse">

                    <ul class="navbar-nav">
                        <li class="nav-item {{ in_array($routeName, ['sale.home']) ? 'active' : '' }}">
                            <a href="{{ route('sale.home') }}" class="nav-link">Dashboard</a>
                        </li>
                        <li class="nav-item {{ in_array($routeName, ['sale.order']) ? 'active' : '' }}">
                            <a href="{{ route('sale.order') }}" class="nav-link">Orders</a>
                        </li>
                        <li class="nav-item {{ in_array($routeName, ['sale.product']) ? 'active' : '' }}">
                            <a href="{{ route('sale.product') }}" class="nav-link">Products</a>
                        </li>
                    </ul>

             
                </div>

          
            </div>
        </nav>
      
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        @yield('content')
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Overlay-->
    <div class="menu-overlay"></div>


    <!-- jQuery  -->
    <script src="{{ asset('admin-theme/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('admin-teme/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin-theme/assets/js/metismenu.min.js') }}"></script>
    <script src="{{ asset('admin-theme/assets/js/waves.js') }}"></script>
    <script src="{{ asset('admin-theme/assets/js/simplebar.min.js') }}"></script>

    <!-- Morris Js-->
    <script src="{{ asset('admin-theme/plugins/morris-js/morris.min.js') }}'"></script>
    <!-- Raphael Js-->
    <script src="{{ asset('admin-theme/plugins/raphael/raphael.min.js') }}'"></script>

    <!-- Morris Custom Js-->
    <script src="{{ asset('admin-theme/assets/pages/dashboard-demo.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('admin-theme/assets/js/theme.js') }}"></script>

</body>

</html>
