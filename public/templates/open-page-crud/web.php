<?php

use App\Http\Controllers\@@@controller@@@;
use Illuminate\Support\Facades\Route;

Route::prefix('@@@view@@@')->controller(@@@controller@@@::class)->group(function () {
    Route::get('/', 'index')->name('@@@view@@@.index');
    Route::post('/getAll', 'getAll')->name('@@@view@@@.getAll');
    Route::post('/getFirst', 'getFirst')->name('@@@view@@@.getFirst');
    Route::post('/', 'store')->name('@@@view@@@.store');
    Route::patch('/{id}', 'update')->name('@@@view@@@.update');
    Route::delete('/{id}', 'destroy')->name('@@@view@@@.destroy');
});
