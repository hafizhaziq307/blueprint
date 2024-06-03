<?php

use App\Http\Controllers\@@@controller@@@;
use Illuminate\Support\Facades\Route;

Route::prefix('@@@view@@@')->controller(@@@controller@@@::class)->name('@@@view@@@.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::get('/{id}/edit', 'edit')->name('edit');
    Route::post('/getAll', 'getAll')->name('getAll');
    Route::post('/', 'store')->name('store');
    Route::patch('/{id}', 'update')->name('update');
    Route::delete('/{id}', 'destroy')->name('destroy');
});