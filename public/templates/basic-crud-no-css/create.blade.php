@extends('layouts.app')

@section('page-title', 'create')

@section('content')

<form action="{{ route('@@@view@@@.store') }}" method="post">
    @csrf
    
    <div>
        @@@htmlInputs@@@
    </div>

    <button type="submit">Simpan</button>
</form>

@endsection