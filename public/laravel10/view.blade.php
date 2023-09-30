<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= csrf_token() ?>" />
    <title>Document</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/toastr/toastr.min.css') }}">
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
                                            <button type="button" class="btn btn-primary float-sm-right" data-toggle="modal" data-target="#createModal">
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
                                                    <th>Nama Mukim</th>
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

                <!-- create modal -->
                <div class="modal fade" id="createModal">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Tambah Rekod @@@crudtitle@@@</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ url('./template/update') }}" method="POST">
                                    @csrf
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

                <!-- edit modal  -->
                <div class="modal fade" id="editModal">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Kemaskini Rekod @@@crudtitle@@@</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label class="mb-1">mukim</label>
                                            <input type="text" class="form-control" placeholder="mukimtitle" name="mukim">
                                            <div id="mukim-error" class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    @@@htmlfields@@@

                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-primary" id="updateBtn">Kemaskini</button>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- delete modal -->
                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel">Delete Item</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete this item?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-danger" id="confirm-delete">Delete</button>
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
    <script src="{{ asset('adminlte/plugins/toastr/toastr.min.js') }}"></script>
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

        const aktivitiTable = $('#aktiviti-table').DataTable({
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
                    console.error(xhr.responseText);
                }
            },
            columns: [{
                    data: 'idmukim',
                    className: "text-center",
                },
                {
                    data: 'mukim',
                    className: "text-center",
                },
                {
                    data: null,
                    searchable: false,
                    orderable: false,
                    className: "text-center",
                    render: (data, type, row) => {
                        return `
                        <button type="button" class="btn btn-info editBtn">
                            <i class="fas fa-pencil-alt"></i>
                            Edit
                        </button>

                        <button type="button" class="btn btn-danger deleteBtn" data-toggle="modal" data-target="#deleteModal">
                            <i class="fas fa-trash"></i>
                            Padam 
                        </button>`;
                    }
                },
            ],
        });

        $("#aktiviti-table tbody").on("click", ".editBtn", function() {
            // reset error validation
            $("#editModal form .form-control").removeClass("is-invalid");
            $("#editModal form .invalid-feedback").text("");

            const data = aktivitiTable.row($(this).parents("tr")).data();
            $('#updateBtn').data('id', data.idmukim);

            $.ajax({
                url: "{{ url('./template/getFirst') }}",
                type: "POST",
                data: {
                    id: data.idmukim,
                },
                dataType: "json",
                success: function(res) {
                    $("#editModal").modal('show');

                    $("#editModal").attr("action", `{{ url('./template/${data.idmukim}') }}`);

                    $("#editModal [name='mukim']").val(res.mukim);
                },
                error: (xhr) => {
                    console.error(xhr.responseText);
                }
            });
        });

        $('#updateBtn').click(function() {
            const id = $(this).data('id');
            const fields = $("#editModal form").serializeArray();

            fieldsObject = {};
            for (const field of fields) {
                fieldsObject[field.name] = field.value
            }

            $.ajax({
                url: `{{ url('./template/${id}') }}`,
                type: "POST",
                data: {
                    _method: "PATCH",
                    fields: fieldsObject
                },
                success: function(res) {
                    $("#editModal").modal('hide');
                    toastr.success(res.message)
                    aktivitiTable.ajax.reload();
                },
                error: (xhr) => {
                    if (xhr.status == 422) {
                        const errors = xhr.responseJSON.errors;
                        for (const [key, value] of Object.entries(errors)) {
                            $("#editModal [name='" + key + "']").addClass("is-invalid");
                            $("#editModal #" + key + "-error").text(value);
                        }

                    } else {
                        $("#editModal").modal('hide');
                        console.error(xhr.responseText);
                        toastr.error('Error occured!')
                    }
                }
            });
        });

        $("#aktiviti-table tbody").on('click', '.deleteBtn', function() {
            const data = aktivitiTable.row($(this).parents("tr")).data();
            $('#confirm-delete').data('id', data.idmukim);
        });

        $('#confirm-delete').click(function() {
            const id = $(this).data('id');

            $.ajax({
                url: `{{ url('./template/${id}') }}`,
                type: "POST",
                data: {
                    _method: "DELETE"
                },
                success: function(res) {
                    $("#deleteModal").modal('hide');
                    toastr.success(res.message)
                    aktivitiTable.ajax.reload();
                },
                error: (xhr) => {
                    $("#deleteModal").modal('hide');
                    console.error(xhr.responseText);
                    toastr.error('Error occured!')
                }
            });
        });
    </script>
</body>

</html>