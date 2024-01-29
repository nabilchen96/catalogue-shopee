<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sungky Catalogue</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('skydash/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('skydash/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('skydash/vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('skydash/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('skydash/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('skydash/js/select.dataTables.min.css') }}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('skydash/css/vertical-layout-light/style.css') }}">
    <!-- endinject -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.2.0/dist/select2-bootstrap-5-theme.min.css" />
    
    @stack('meta-description')
    @stack('style')
    <style>
        .btn {
            height: 38px;
            border-radius: 0.25rem;
        }

        .form-control {
            height: 38px;
        }

        .modal .modal-dialog {
            margin-top: 1.75rem;
        }

        .card {
            border-radius: 0.5rem;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #9e9e9e21 !important;
        }

        .table td {
            white-space: unset;
        }

        table td {
            line-height: 1.5 !important;
        }

        .navbar {
            box-shadow: none !important;
        }

        /* style.css */

        .loading-indicator {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            justify-content: center;
            align-items: center;
            font-size: 24px;
            z-index: 1000;
        }
    </style>

    <script language="javascript">
        function getkey(e) {
            if (window.event)
                return window.event.keyCode;
            else if (e)
                return e.which;
            else
                return null;
        }

        function goodchars(e, goods, field) {
            var key, keychar;
            key = getkey(e);
            if (key == null) return true;

            keychar = String.fromCharCode(key);
            keychar = keychar.toLowerCase();
            goods = goods.toLowerCase();

            // check goodkeys
            if (goods.indexOf(keychar) != -1)
                return true;
            // control keys
            if (key == null || key == 0 || key == 8 || key == 9 || key == 27)
                return true;

            if (key == 13) {
                var i;
                for (i = 0; i < field.form.elements.length; i++)
                    if (field == field.form.elements[i])
                        break;
                i = (i + 1) % field.form.elements.length;
                field.form.elements[i].focus();
                return false;
            };
            // else return false
            return false;
        }
    </script>
</head>

<body>
    <div class="loading-indicator" id="loadingIndicator">
        Loading...
    </div>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center"
                style="box-shadow: 0px 5px 21px -5px #CDD1E1;">
                <a class="navbar-brand brand-logo mr-5" style="font-size: 16px; margin-left: 20px;"
                    href="{{ url('/') }}">
                    <h3><i class="bi bi-cart4"></i></h3>
                </a>
                <a class="navbar-brand brand-logo-mini" href="{{ url('/') }}">
                    <i class="bi bi-cart4"></i>
                </a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                <button style="padding-left: 0;" class="navbar-toggler navbar-toggler align-self-center" type="button"
                    data-toggle="minimize">
                    <span class="icon-menu"></span>
                </button>

                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item nav-profile dropdown">
                        <img style="border-radius: 0;" src="{{ url('sahretech.png') }}" alt="">                       
                    </li>

                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                    data-toggle="offcanvas">
                    <span class="icon-menu"></span>
                </button>
            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">

            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li class="nav-item">
                        <a onclick="showLoadingIndicator()" class="nav-link" href="{{ url('/produk') }}/all">
                            <i class="bi bi-box-seam menu-icon"></i>
                            <span class="menu-title">All Data</span>
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a onclick="showLoadingIndicator()" class="nav-link" href="{{ url('/produk') }}">
                            <i class="bi bi-laptop menu-icon"></i>
                            <span class="menu-title">Laptop</span>
                        </a>
                    </li> --}}
                    <li class="nav-item">
                        <a onclick="showLoadingIndicator()" class="nav-link" href="{{ url('/produk') }}/smartphone">
                            <i class="bi bi-phone menu-icon"></i>
                            <span class="menu-title">Smartphone</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a onclick="showLoadingIndicator()" class="nav-link" href="{{ url('/produk') }}/smartwatch">
                            <i class="bi bi-smartwatch menu-icon"></i>
                            <span class="menu-title">Smartwatch</span>
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#mr" aria-expanded="false"
                            aria-controls="ui-basic">
                            <i class="bi bi-cpu menu-icon"></i>
                            <span class="menu-title" style="margin-top: 7px;">Elektronik Lain</span>
                            <i style="margin-top: 7px;" class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="mr">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item">
                                    <a onclick="showLoadingIndicator()" class="nav-link" href="">
                                        <span class="menu-title">TWS</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li> --}}
                    <li class="nav-item">
                        <a onclick="showLoadingIndicator()" class="nav-link" href="{{ url('/produk') }}/tas">
                            <i class="bi bi-handbag menu-icon"></i>
                            <span class="menu-title">Tas</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a onclick="showLoadingIndicator()" class="nav-link" href="{{ url('/produk') }}/sneakers">
                            <i class="bi bi-ui-checks-grid menu-icon"></i>
                            <span class="menu-title">Sneakers</span>
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#fashion" aria-expanded="false"
                            aria-controls="ui-basic">
                            <i class="bi bi-eyeglasses menu-icon"></i>
                            <span class="menu-title" style="margin-top: 7px;">Fashion</span>
                            <i style="margin-top: 7px;" class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="fashion">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item">
                                    <a onclick="showLoadingIndicator()" class="nav-link" href="{{ url('/produk') }}/sneakers">
                                        <span class="menu-title">Sneakers</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a onclick="showLoadingIndicator()" class="nav-link" href="{{ url('/produk') }}/tas">
                                        <span class="menu-title">Tas Wanita</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li> --}}
                </ul>
            </nav>


            <div class="main-panel">
                @yield('hero')
                <div class="content-wrapper">
                    @yield('content')
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                    </div>
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">
                            Developed by <a href="https://porkaone.com">Nabil Putra</a> <br>
                            Ikatan Adhyaksa Dharmakarini Kaur
                        </span>
                    </div>
                </footer>
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    <!-- plugins:js -->

    <script src="{{ asset('skydash/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->

    <script src="{{ asset('skydash/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('skydash/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('skydash/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('skydash/js/dataTables.select.min.js') }}"></script>

    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('skydash/js/off-canvas.js') }}"></script>
    <script src="{{ asset('skydash/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('skydash/js/template.js') }}"></script>
    <script src="{{ asset('skydash/js/settings.js') }}"></script>
    <script src="{{ asset('skydash/js/todolist.js') }}"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="{{ asset('skydash/js/dashboard.js') }}"></script>
    <script src="{{ asset('skydash/js/Chart.roundedBarCharts.js') }}"></script>
    <script src="https://unpkg.com/axios@0.27.2/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.7/dist/sweetalert2.all.min.js"></script>
    <!-- script tambahan  -->

    <!-- End custom js for this page
        -->
    @stack('script')

    <script>
        // script.js

        // Function to show the loading indicator
        function showLoadingIndicator() {
            document.getElementById('loadingIndicator').style.display = 'flex';
        }

        // Function to hide the loading indicator
        function hideLoadingIndicator() {
            document.getElementById('loadingIndicator').style.display = 'none';
        }

        // Event listener for popstate
        window.addEventListener('popstate', function(event) {
            // Show the loading indicator when navigating back
            showLoadingIndicator();

            // You may want to add additional logic here if needed
        });

        // Event listener for pageshow
        window.addEventListener('pageshow', function(event) {
            // Check if the page is being shown from the bfcache (back-forward cache)
            if (event.persisted) {
                // If it's a back-forward navigation, hide the loading indicator
                hideLoadingIndicator();
            }
        });
    </script>
</body>

</html>
