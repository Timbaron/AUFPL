<?php

use App\Http\Controllers\SquadController;
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
Route::namespace('Merchant')
    ->prefix('merchant')
    ->name('merchant.')
    ->middleware(['auth'])
    ->group(
        function () {});

Route::get('/select-squad', [SquadController::class, 'select'])->name('squad.select');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
