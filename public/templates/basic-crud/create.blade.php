@extends('layouts.app')

@section('page-title', 'create')

@section('content')
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
    <div class="row">
        <div class="col-12">
            <form action="{{ route('@@@view@@@.store') }}" method="post" class="card">
                @csrf
                <header class="card-header">
                    <h3 class="card-title">Tambah Rekod</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </header>

                <div class="card-body">
                    @@@htmlInputs@@@
                </div>

                <footer class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </footer>
            </form>
        </div>
    </div>
</section>
@endsection