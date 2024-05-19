<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('page-title')</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css?v=3.2.0') }}">
    <!-- <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}"> -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap4.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">

        <nav class="main-header navbar navbar-expand navbar-white navbar-light">

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">

            <a href="#" class="brand-link">
                <span class="brand-text font-weight-light">System Name</span>
            </a>

            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <i class="fas fa-user-circle text-gray img-circle elevation-2" style="font-size: 34px;"></i>
                    </div>

                    <div class="info">
                        <a href="#" class="d-block">Hafiz Haziq</a>
                    </div>
                </div>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- add your directories... -->
                    </ul>
                </nav>
            </div>

        </aside>

        <div class="content-wrapper">
            @yield('content')
        </div>

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Versi</b> 1.0.0
            </div>
            <strong>Hakcipta Terpelihara &copy; {{ now()->year }} <a href="#">System name</a>.</strong>
        </footer>
    </div>

    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/toastr/toastr.min.js') }}"></script>
    <!-- <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script> -->
    <!-- <script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script> -->
    <script type="text/javascript" src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap4.js"></script>
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js?v=3.2.0') }}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        toastr.options = {
            "positionClass": "toast-top-center",
            "newestOnTop": true,
        };

        if (@json(session('success'))) {
            toastr.success(@json(session('success')));
        }
    </script>

    @yield('js')
</body>

</html>