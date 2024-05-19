<div class="modal fade" id="{{ $id }}">
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
</div>