<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\PlayerPointController;
use App\Http\Controllers\SquadController;
use App\Http\Controllers\TeamController;
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
Route::middleware(['auth'])
    ->group(
        function () {
            Route::post('/logout', function () {
                Auth::logout();
                return view('welcome');
            })->name('logout');

            Route::get('/transfer', [SquadController::class, 'transfer'])->name('transfer');
            Route::get('/select-squad', [SquadController::class, 'select'])->name('squad.select');
            Route::post('/select-confirm', [SquadController::class, 'confirm_selections'])->name('select.confirm');
            Route::post('cart/add', [CartController::class, 'cardAdd'])->name('cart.add');
            Route::post('cart/remove', [CartController::class, 'cardRemove'])->name('cart.remove');
            Route::get('/cart', [CartController::class, 'cart'])->name('cart');
            Route::post('player/search', [PlayerController::class, 'search'])->name('player.search');
            Route::post('tranfer/complete', [TeamController::class, 'create'])->name('transfer.complete');
            Route::get('points', [PlayerPointController::class, 'index'])->name('points');
        }
    );


Auth::routes(['logout' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
