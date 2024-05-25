<?php

use App\Http\Controllers\@@@controllername@@@;
use Illuminate\Support\Facades\Route;

Route::prefix('@@@folderviewname@@@')->controller(@@@controllername@@@::class)->group(function () {
    Route::get('/', 'index')->name('@@@folderviewname@@@.index');
    Route::get('/create', 'create')->name('@@@folderviewname@@@.create');
    Route::get('/{id}/edit', 'edit')->name('@@@folderviewname@@@.edit');
    Route::post('/getAll', 'getAll')->name('@@@folderviewname@@@.getAll');
    Route::post('/', 'store')->name('@@@folderviewname@@@.store');
    Route::patch('/{id}', 'update')->name('@@@folderviewname@@@.update');
    Route::delete('/{id}', 'destroy')->name('@@@folderviewname@@@.destroy');
});