<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [TaskController::class, 'taskView']);
Route::post('/add-task',[TaskController::class, 'createTask'])->name('create.task');
Route::post('/update-task',[TaskController::class, 'updateTask'])->name('update.task');
Route::post('/delete-task',[TaskController::class, 'deleteTask'])->name('delete.task');
Route::post('/sort-task',[TaskController::class, 'sortTask'])->name('sort.task');
