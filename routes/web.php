<?php

use App\Http\Controllers\Categories\CategoriesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Posts\PostsController;
use App\Http\Controllers\Users\EmployeeUsersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::resource('posts', PostsController::class);
    Route::resource('categories', CategoriesController::class);
    Route::resource('employee', EmployeeUsersController::class);
});
