@extends('layouts.app')

@section('page-title', 'edit')

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
    <div class="row">
        <div class="col-12">
            <form action="{{ route('posts.update', ['id' => $record->id]) }}" method="post" class="card">
                @csrf
                @method('PATCH')
                <header class="card-header">
                    <h3 class="card-title">Kemaskini Rekod</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </header>

                <div class="card-body">
                    <div class="form-group">
                        <label for="inputName">Title</label>
                        <input type="text" id="inputName" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') ?: $record->title }}">
                    </div>
                    <div class="form-group">
                        <label for="inputDescription">Description</label>
                        <textarea id="inputDescription" name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description') ?: $record->description }}</textarea>
                    </div>
                </div>
                
                <footer class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">Kemaskini</button>
                </footer>
            </form>
        </div>
    </div>
</section>
@endsection