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
                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addModal">
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
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </header>
                                
                                <div class="card-body">
                                    <table id="table" class="table table-sm table-striped table-hover table-bordered nowrap" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>Bil.</th>
                                                @@@thead@@@
                                                <th>Tindakan</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- create modal -->
                <div class="modal fade" id="addModal">
                    <div class="modal-dialog modal-xl">
                        <form class="modal-content">
                            <header class="modal-header">
                                <h5 class="modal-title">Tambah Rekod</h5>
                                <button type="button" class="close" data-dismiss="modal">
                                    &times;
                                </button>
                            </header>
                            
                            <div class="modal-body">
                                @@@htmlInputs@@@
                            </div>
                            
                            <footer class="modal-footer">
                                <button type="button" class="btn btn-primary">Simpan</button>
                            </footer>
                        </form>
                    </div>
                </div>

                <!-- edit modal -->
                <div class="modal fade" id="editModal">
                    <div class="modal-dialog modal-xl">
                        <form class="modal-content">
                            @method('PATCH')
                            <header class="modal-header">
                                <h5 class="modal-title">Kemaskini Rekod</h5>
                                <button type="button" class="close" data-dismiss="modal">
                                    &times;
                                </button>
                            </header>

                            <div class="modal-body">
                                @@@htmlInputs@@@
                            </div>
                            
                            <footer class="modal-footer">
                                <button type="submit" class="btn btn-primary">Kemaskini</button>
                            </footer>
                        </form>
                    </div>
                </div>

                <!-- delete modal -->
                <div class="modal fade" id="deleteModal">
                    <div class="modal-dialog">
                        <form class="modal-content">
                            @method('DELETE')
                            <header class="modal-header">
                                <h5 class="modal-title">Padam Rekod</h5>
                                <button type="button" class="close" data-dismiss="modal">
                                    &times;
                                </button>
                            </header>

                            <div class="modal-body">
                                Anda pasti ingin memadam rekod tersebut?
                            </div>

                            <footer class="modal-footer">
                                <button type="submit" class="btn btn-danger">Padam</button>
                            </footer>
                        </form>
                    </div>
                </div>
            </section>

        </div>

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 1.0.0
            </div>
            <strong>Hakcipta Terpelihara &copy; {{ now()->year }} <a href="#">System name</a>.</strong>
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
            buttons: ['pageLength'],
            processing: true,
            serverSide: true,
            lengthChange: false,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'Semua']
            ],
            language: {
                search: "Carian Rekod:",
                lengthMenu: "Jumlah Rekod / Page: _MENU_",
                buttons: {
                    pageLength: {
                        _: "Papar %d rekod",
                        '-1': "Papar semua rekod"
                    }
                },
                info: "Rekod _START_ hingga _END_ / _TOTAL_ Rekod",
                paginate: {
                    next: '<i class="fas fa-arrow-right"></i>',
                    previous: '<i class="fas fa-arrow-left"></i>'
                },
                emptyTable: "Tiada rekod."
            },
            ajax: {
                url: "{{ route('@@@view@@@.getAll') }}",
                type: "POST",
                error: (xhr) => {
                    console.error(JSON.parse(xhr.responseText).error);
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
                            Kemaskini
                        </button>

                        <button type="button" class="btn btn-sm btn-danger deleteBtn" data-toggle="modal" data-target="#deleteModal">
                            <i class="fas fa-trash"></i>
                            Padam 
                        </button>`;
                    }
                },
            ],
            initComplete: function () {
                this.api().buttons().container().appendTo('#table_wrapper .col-md-6:eq(0)'); // alternative for dom:
                this.wrap("<div style='overflow:auto; width:100%;position:relative;'></div>"); // aternative for scrollX:        
            }
        });

        $("#addModal form").on('submit', function() {
            const formData = new FormData($("#addModal form"));

            $.ajax({
                url: `{{ route('@@@view@@@.store') }}`,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: (res) => {
                    toastr.success(res.message);
                    tbl.ajax.reload();
                },
                error: (xhr) => {
                    if (xhr.status == 422) {
                        $(".is-invalid").removeClass("is-invalid");

                        const errors = xhr.responseJSON.errors;
                        for (const [key, value] of Object.entries(errors)) {
                            $(`#addModal [name="${key}"]`).addClass("is-invalid");
                            $(`#addModal #${key}-error`).text(value);
                        }
                        return;
                    } 
                    console.error(JSON.parse(xhr.responseText).error);
                    toastr.error('Error occured!');
                },
                complete: () => {
                    $("#addModal").modal('hide');
                }
            });
        });

        $("#table tbody").on("click", ".editBtn", function() {
            // reset error validation
            $("#editModal form .form-control").removeClass("is-invalid");
            $("#editModal form .invalid-feedback").text("");

            const data = tbl.row($(this).parents("tr")).data();

            $.ajax({
                url: "{{ route('@@@view@@@.getFirst') }}",
                type: "POST",
                data: {
                    id: data.@@@primarykey@@@,
                },
                dataType: "json",
                success: (res) => {
                    $("#editModal").modal('show');

                    @@@editInputs@@@
                    
                    $("#editModal form").on('submit', function() {
                        const formData = new FormData($("#editModal form"));

                        $.ajax({
                            url: `{{ route('@@@view@@@.update', ['id' => ':1']) }}`.replace(':1', data.@@@primarykey@@@),
                            type: "POST",
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: (sub_res) => {
                                toastr.success(sub_res.message);
                                tbl.ajax.reload();
                            },
                            error: (xhr) => {
                                if (xhr.status == 422) {
                                    $(".is-invalid").removeClass("is-invalid");
            
                                    const errors = xhr.responseJSON.errors;
                                    for (const [key, value] of Object.entries(errors)) {
                                        $(`#editModal [name="${key}"]`).addClass("is-invalid");
                                        $(`#editModal #${key}-error`).text(value);
                                    }
                                    return;
                                } 
                                console.error(JSON.parse(xhr.responseText).error);
                                toastr.error('Error occured!');
                            },
                            complete: () => {
                                $("#editModal").modal('hide');
                            }
                        });
                    });
                },
                error: (xhr) => {
                    console.error(JSON.parse(xhr.responseText).error);
                }
            });
        });

        $("#table tbody").on('click', '.deleteBtn', function() {
            const data = tbl.row($(this).parents("tr")).data();

            $("#deleteModal").modal('show');

            $("#deleteModal form").on('submit', function() {
                const formData = new FormData($("#deleteModal form"));

                $.ajax({
                    url: `{{ route('@@@view@@@.destroy', ['id' => ':1']) }}`.replace(':1', data.@@@primarykey@@@),
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: (res) => {
                        toastr.success(res.message);
                        tbl.ajax.reload();
                    },
                    error: (xhr) => {
                        console.error(JSON.parse(xhr.responseText).error);
                        toastr.error('Error occured!');
                    },
                    complete: () => {
                        $("#deleteModal").modal('hide');
                    }
                });
            });
        });
    </script>
</body>

</html>