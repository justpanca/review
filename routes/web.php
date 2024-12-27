<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\IndexController;


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

Route::get('/', [IndexController::class, "homeaja"]);
Route::get('/register', [AuthController::class, "registeraja"]);
Route::post('/send', [AuthController::class, "signup"]);
Route::get('/data-table', [IndexController::class, "tableaja"]);


// create data
// menampilkan form
Route::get('/book/create', [BookController::class, 'create']);
// menyimpan ke database
Route::post('/book', [BookController::class, 'store']);


// route menampilkan semua data
// menampilkan semua data ke table
Route::get('/book', [BookController::class, 'index']);
// route bedasarkan id
Route::get('/book{book_id}', [BookController::class, 'show']);

//update data
// route ke form edit
Route::get('/book/{book_id}/edit', [BookController::class, 'edit']);
// update data berdasarkan id
Route::put('/book/{book_id}', [BookController::class, 'update']);

//delet data berdasarkan params id
Route::delete('/book/{book_id}', [BookController::class, 'destroy']);




