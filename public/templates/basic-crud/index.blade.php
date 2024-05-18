@extends('layouts.app')

@section('page-title', 'index')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Post</h1>
            </div>

            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Post</li>
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
                        <a href="{{ route('posts.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i>
                            Tambah Rekod
                        </a>
                    </header>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <header class="card-header">
                        <h3 class="card-title">Index Post</h3>
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
                                    <th>#</th>
                                    <th>text</th>
                                    <th>number</th>
                                    <th>date</th>
                                    <th>textarea</th>
                                    <th>select</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-post.modals.confirm-delete id="deleteModal" />
</section>
@endsection

@section('js')
<script src="{{ asset('js/datatables_config.js') }}"></script>

<script>
    $('#table').DataTable({
        processing: true,
        serverSide: true,
        layout: datatables_layout,
        language: datatables_language,
        ajax: {
            url: "{{ route('posts.getAll') }}",
            type: "POST",
            error: (xhr) => {
                console.error(JSON.parse(xhr.responseText).error);
            }
        },
        columns: [{
                data: 'DT_RowIndex',
                className: "text-center",
            },
            {
                data: "text",
                className: "text-center",
            },
            {
                data: "number",
                className: "text-center",
            },
            {
                data: "date",
                className: "text-center",
            },
            {
                data: "textarea",
                className: "text-center",
            },
            {
                data: "select",
                className: "text-center",
            },
            {
                data: null,
                searchable: false,
                orderable: false,
                className: "text-center",
                render: (data, type, row) => {
                    const edit = `{{ route('posts.edit', ['id' => ':1']) }}`.replace(':1', row.id);

                    return `
                    <a href="${edit}" class="btn btn-info">
                        <i class="fas fa-pencil-alt"></i>
                        Kemaskini
                    </a>

                    <button type="button" class="btn btn-danger deleteBtn" title="Padam">
                        <i class="fas fa-trash"></i>
                        Padam 
                    </button>`;
                }
            },
        ],
        initComplete: function() {
            this.wrap("<div style='overflow:auto; width:100%;position:relative;'></div>"); // aternative for scrollX:        
        }
    });

    $("#table").on('click', 'tbody .deleteBtn', function() {
        const data = $(this).closest("table").DataTable().row($(this).closest("tr")).data();

        const url = `{{ route('posts.destroy', ['id' => ':1']) }}`.replace(':1', data.id);

        $("#deleteModal form").attr("action", url);

        $("#deleteModal").modal('show');
    });
</script>
@endsection