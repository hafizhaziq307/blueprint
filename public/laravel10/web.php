<?php

use App\Http\Controllers\TemplateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/template', [TemplateController::class, 'template']);
Route::post('/template/getAll', [TemplateController::class, 'getAll']);
Route::post('/template/getFirst', [TemplateController::class, 'getFirst']);
Route::post('/template', [TemplateController::class, 'store']);
Route::patch('/template/{id}', [TemplateController::class, 'update']);
Route::delete('/template/{id}', [TemplateController::class, 'destroy']);
