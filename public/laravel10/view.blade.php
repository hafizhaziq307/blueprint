<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Document</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css?v=3.2.0') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
</head>

<body class="hold-transition sidebar-mini text-sm layout-fixed">

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

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <header class="card-header text-right">
                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                        data-target="#addModal">
                                        <span class="mr-1">Tambah Rekod Baru</span>
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </header>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card">
                                <header class="card-header">
                                    <h3 class="card-title">@@@crudtitle@@@</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                            title="Collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </header>
                                
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="table" class="table table-sm table-striped table-hover table-bordered nowrap" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    @@@thead@@@
                                                    <th>Action</th>
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
                <div class="modal fade" id="addModal">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <header class="modal-header">
                                <h4 class="modal-title">Add</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </header>
                            <div class="modal-body">
                                <form>
                                    @@@htmlInputs@@@

                                    <div class="text-right">
                                        <button type="button" class="btn btn-primary" id="saveBtn">Save</button>
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
                            <header class="modal-header">
                                <h4 class="modal-title">Update</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </header>
                            <div class="modal-body">
                                <form>
                                    @method('PATCH')

                                    @@@htmlInputs@@@

                                    <div class="text-right">
                                        <button type="button" class="btn btn-primary" id="updateBtn">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- delete modal -->
                <div class="modal fade" id="deleteModal">
                    <div class="modal-dialog" role="document">
                        <form class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Delete Item</h5>
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
                        </form>
                    </div>
                </div>
            </section>

        </div>

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 1.0.0
            </div>
            <strong>Copyright &copy; 2023 <a href="#">System name</a>.</strong> All rights reserved.
        </footer>
    </div>

    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
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

        const tbl = $('#table').DataTable({
            processing: true,
            serverSide: true,
            language: {
                search: "Search:",
                lengthMenu: "Total Record/ Page: _MENU_",
                info: "Record _START_ to _END_ / _TOTAL_ Records",
                paginate: {
                    next: '<i class="fas fa-arrow-right"></i>',
                    previous: '<i class="fas fa-arrow-left"></i>'
                },
                emptyTable: "No Records."
            },
            ajax: {
                url: "{{ route('@@@folderviewname@@@.getAll') }}",
                type: "POST",
                error: (xhr) => {
                    console.error(xhr.responseText);
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    className: "text-center",
                },
                @@@tbody@@@
                {
                    data: null,
                    searchable: false,
                    orderable: false,
                    className: "text-center",
                    render: () => {
                        return `
                        <button type="button" class="btn btn-sm btn-info editBtn">
                            <i class="fas fa-pencil-alt"></i>
                            Edit
                        </button>

                        <button type="button" class="btn btn-sm btn-danger deleteBtn" data-toggle="modal" data-target="#deleteModal">
                            <i class="fas fa-trash"></i>
                            Delete 
                        </button>`;
                    }
                },
            ],
        });

        $('#saveBtn').click(function() {
            const formData = new FormData(document.querySelector("#addModal form"));

            $.ajax({
                url: `{{ route('@@@folderviewname@@@.store') }}`,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: (res) => {
                    $("#addModal").modal('hide');
                    toastr.success(res.message);
                    tbl.ajax.reload();
                },
                error: (xhr) => {
                    if (xhr.status == 422) {
                        const errors = xhr.responseJSON.errors;
                        for (const [key, value] of Object.entries(errors)) {
                            $(`#addModal [name="${key}"]`).addClass("is-invalid");
                            $(`#addModal #${key}-error`).text(value);
                        }
                        return;
                    } 
                    $("#addModal").modal('hide');
                    console.error(xhr.responseText);
                    toastr.error('Error occured!');
                }
            });
        });

        $("#table tbody").on("click", ".editBtn", function() {
            // reset error validation
            $("#editModal form .form-control").removeClass("is-invalid");
            $("#editModal form .invalid-feedback").text("");

            const data = tbl.row($(this).parents("tr")).data();
            $('#updateBtn').data('id', data.@@@primarykey@@@);

            $.ajax({
                url: "{{ route('@@@folderviewname@@@.getFirst') }}",
                type: "POST",
                data: {
                    id: data.@@@primarykey@@@,
                },
                dataType: "json",
                success: (res) => {
                    $("#editModal").modal('show');

                    @@@editInputs@@@
                },
                error: (xhr) => {
                    console.error(xhr.responseText);
                }
            });
        });

        $('#updateBtn').click(function() {
            const id = $(this).data('id');
            const formData = new FormData(document.querySelector("#editModal form"));

            $.ajax({
                url: `{{ route('@@@folderviewname@@@.update', ['id' => ':1']) }}`.replace(':1', id),
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: (res) => {
                    $("#editModal").modal('hide');
                    toastr.success(res.message);
                    tbl.ajax.reload();
                },
                error: (xhr) => {
                    if (xhr.status == 422) {
                        const errors = xhr.responseJSON.errors;
                        for (const [key, value] of Object.entries(errors)) {
                            $(`#editModal [name="${key}"]`).addClass("is-invalid");
                            $(`#editModal #${key}-error`).text(value);
                        }
                        return;
                    } 
                    $("#editModal").modal('hide');
                    console.error(xhr.responseText);
                    toastr.error('Error occured!');
                }
            });
        });

        $("#table tbody").on('click', '.deleteBtn', function() {
            const data = tbl.row($(this).parents("tr")).data();

            $("#deleteModal").modal('show');

            $('#deleteModal #confirm-delete').click(function() {
                $.ajax({
                    url: `{{ route('@@@folderviewname@@@.destroy', ['id' => ':1']) }}`.replace(':1', data.@@@primarykey@@@),
                    type: "POST",
                    success: (res) => {
                        $("#deleteModal").modal('hide');
                        toastr.success(res.message);
                        tbl.ajax.reload();
                    },
                    error: (xhr) => {
                        $("#deleteModal").modal('hide');
                        console.error(xhr.responseText);
                        toastr.error('Error occured!');
                    }
                });
            });
        });
    </script>
</body>

</html>