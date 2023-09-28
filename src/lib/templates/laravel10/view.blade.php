<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= csrf_token() ?>" />
    <title>Document</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css?v=3.2.0') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
</head>

<body class="hold-transition sidebar-mini">

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
                <span class="brand-text font-weight-light">Efert</span>
            </a>

            <div class="sidebar">

                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="info">
                        <a href="#" class="d-block">Alexander Pierce</a>
                    </div>
                </div>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    </ul>
                </nav>

            </div>

        </aside>

        <div class="content-wrapper">

            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>@@@crudtitle@@@</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">@@@crudtitle@@@</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <!-- NEW -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header my-1 py-1">
                                    <div class="row">
                                        <div class="col-sm-10 mt-2">
                                            <h3 class="card-title">@@@crudtitle@@@</h3>
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="button" class="btn btn-primary float-sm-right" data-toggle="modal" data-target="#add-tablename-modal">
                                                <i class="fas fa-plus"></i>
                                                <span>Add</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">

                                    <div class="table-responsive">
                                        <table id="aktiviti-table" class="table table-striped table-bordered nowrap" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th>Bil</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- add modal -->
                <div class="modal fade" id="add-tablename-modal">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Tambah Rekod @@@crudtitle@@@</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ url('./template/update') }}" method="post">
                                    <!-- <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label class="mb-1">@@@fieldname@@@</label>
                                        <input type="text" class="form-control" placeholder="@@@fieldname@@@">
                                    </div>
                                </div> -->

                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- update modal -->
                <div class="modal fade" id="add-tablename-modal">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Kemaskini Rekod @@@crudtitle@@@</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ url('./template/update') }}" method="post">
                                    <!-- <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label class="mb-1">@@@fieldname@@@</label>
                                            <input type="text" class="form-control" placeholder="@@@fieldname@@@">
                                        </div>
                                    </div> -->
                                    @@@htmlfields@@@

                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 1.0.0
            </div>
            <strong>Copyright &copy; 2023 <a href="#">system_name</a>.</strong> All rights
            reserved.
        </footer>
    </div>

    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('adminlte/dist/js/adminlte.min.js?v=3.2.0') }}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const aktiviti_table = $('#aktiviti-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            language: {
                search: "Carian Rekod:",
                lengthMenu: "Jumlah Rekod / Halaman: _MENU_",
                info: "Rekod _START_ hingga _END_ / _TOTAL_ Rekod",
                paginate: {
                    next: '<i class="fas fa-arrow-right"></i>',
                    previous: '<i class="fas fa-arrow-left"></i>'
                },
                emptyTable: "Tiada rekod."
            },
            ajax: {
                url: "{{ url('/template/getAll') }}",
                type: "POST",
                error: (xhr) => {
                    console.error(JSON.parse(xhr.responseText).error);
                }
            },
            columns: [{
                    data: null,
                    className: "text-center",
                },
                {
                    data: null,
                    searchable: false,
                    orderable: false,
                    className: "text-center",
                    render: () => {
                        return `
                        <button type="button" class="btn btn-info edit-button">
                            <i class="fas fa-pencil-alt"></i>
                            Edit
                        </button>
                        <a class="btn btn-danger" href="#">
                            <i class="fas fa-trash"></i>
                            Delete
                        </a>`;
                    }
                },
            ],
        });

        $("#aktiviti-table tbody").on("click", ".edit-button", function() {
            const data = aktiviti_table.row($(this).parents("tr")).data();
           
            $.ajax({
                url: "{{ url('./template/getFirst') }}",
                type: "POST",
                data: {
                    id: data.idmukim,
                },
                dataType: "json",
                success: function(res) {
                    console.log(res);
                },
                error: (xhr) => {
                    console.error(JSON.parse(xhr.responseText).error);
                }
            });
        });

    </script>
</body>

</html>