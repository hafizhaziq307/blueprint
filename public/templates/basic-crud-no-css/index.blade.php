@extends('layouts.app')

@section('page-title', 'index')

@section('content')
<table id="table" style="width: 100%">
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

<a href="{{ route('@@@view@@@.create') }}">Tambah Rekod</a>

<!-- delete modal (dialog) -->
<dialog id="deleteModal">
    <form action="" method="post">
        @csrf
        @method('DELETE')
        <div>
            Anda pasti ingin memadam rekod tersebut?
        </div>
        <button type="submit">Padam</button>
    </form>
</dialog>

<!-- delete modal (bootstrap 4 / 5) -->
<!-- <div class="modal fade" id="deleteModal">
    <div class="modal-dialog">
        <form action="" method="post" class="modal-content">
            @csrf
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
</div> -->

@endsection

@section('js')
<script>
    $('#table').DataTable({
        processing: true,
        serverSide: true,
        layout: {
            topStart: {
                pageLength: {
                    text: ' _MENU_ Rekod',
                    menu: [10, 25, 50, 100]
                }
            },
            topEnd: {
                search: {
                    text: 'Carian: _INPUT_',
                }
            },
            bottomStart: {
                info: {
                    text: 'Rekod _START_ hingga _END_ / _TOTAL_ Rekod'
                }
            },
            bottomEnd: {
                paging: {
                    type: 'simple_numbers',
                }
            },
        },
        language: {
            paginate: {
                next: '<i class="fa fa-chevron-right"></i>',
                previous: '<i class="fa fa-chevron-left"></i>'
            },
            emptyTable: "Tiada rekod",
            zeroRecords: "Tiada rekod dijumpai",
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
                    const edit = `{{ route('@@@view@@@.edit', ['id' => ':1']) }}`.replace(':1', row.id);

                    return `
                    <a href="${edit}">
                        <i class="fas fa-pencil-alt"></i>
                        Kemaskini
                    </a>

                    <button type="button" class="deleteBtn" title="Padam">
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

        const destroy = `{{ route('@@@view@@@.destroy', ['id' => ':1']) }}`.replace(':1', data.id);

        $("#deleteModal form").attr("action", destroy);

        $("#deleteModal").showModal(); // <dialog>
        // $("#deleteModal").modal('show'); // bootstrap 4 / 5
    });
</script>
@endsection