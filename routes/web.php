<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeacherController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('ajax', [TeacherController::class, 'index']);
Route::get('/teacher/all', [TeacherController::class, 'allData']);
Route::post('/teacher/store', [TeacherController::class, 'storeData']);
ROute::get('/edit_data/{id}', [TeacherController::class, 'edit_data']);
Route::post('/add_edit_data', [TeacherController::class, 'add_edit_data']);
Route::get('delete_data/{id}', [TeacherController::class, 'delete_data']);