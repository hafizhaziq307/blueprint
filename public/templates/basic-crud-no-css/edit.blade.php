@extends('layouts.app')

@section('page-title', 'edit')

@section('content')

<form action="{{ route('@@@view@@@.update', ['id' => $@@@variable@@@->@@@primarykey@@@]) }}" method="post">
    @csrf
    @method('PATCH')

    <div>
        @@@htmlInputs@@@
    </div>
    
    <button type="submit">Kemaskini</button>
</form>

@endsection