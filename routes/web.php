<?php

use Illuminate\Support\Facades\Route;

// Controller list
use App\Http\Controllers\SchedulerController;

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
    return view('scheduler');
});

Route::prefix('event')->group(function () {
	Route::post('/store', [SchedulerController::class, 'store'])->name('event.store');
	Route::get('/list', [SchedulerController::class, 'show'])->name('event.list');
});