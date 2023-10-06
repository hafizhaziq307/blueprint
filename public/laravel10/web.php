<?php

use App\Http\Controllers\@@@controllername@@@;
use Illuminate\Support\Facades\Route;

Route::prefix('@@@folderviewname@@@')->controller(@@@controllername@@@::class)->group(function () {
    Route::get('/', 'index')->name('@@@folderviewname@@@.index');
    Route::post('/getAll', 'getAll')->name('@@@folderviewname@@@.getAll');
    Route::post('/getFirst', 'getFirst')->name('@@@folderviewname@@@.getFirst');
    Route::post('/', 'store')->name('@@@folderviewname@@@.store');
    Route::patch('/{id}', 'update')->name('@@@folderviewname@@@.update');
    Route::delete('/{id}', 'destroy')->name('@@@folderviewname@@@.destroy');
});
