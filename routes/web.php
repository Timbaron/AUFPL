<?php

use App\Http\Controllers\AufplSettingsController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ClubController;
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

            Route::get('admin/players/points', [PlayerPointController::class, 'edit'])->name('admin.players.points');
            Route::post('admin/players/points/update', [PlayerPointController::class, 'update'])->name('admin.players.update.points');
            Route::get('admin/players/all', [PlayerController::class, 'index'])->name('admin.players.all');
            Route::get('admin/players/add', [PlayerController::class, 'add'])->name('admin.players.add');
            Route::post('admin/players/store', [PlayerController::class, 'store'])->name('admin.players.store');
            Route::get('admin/players/edit/{id}', [PlayerController::class, 'edit'])->name('admin.players.edit');
            Route::put('admin/players/update/{id}', [PlayerController::class, 'update'])->name('admin.players.update');
            Route::delete('admin/players/delete', [PlayerController::class, 'destroy'])->name('admin.players.delete');
            Route::get('admin/clubs/all', [ClubController::class, 'index'])->name('admin.clubs.all');
            Route::get('admin/clubs/add', [ClubController::class, 'add'])->name('admin.clubs.add');
            Route::post('admin/clubs/store', [ClubController::class, 'store'])->name('admin.clubs.store');
            Route::get('admin/clubs/edit/{id}', [ClubController::class, 'edit'])->name('admin.clubs.edit');
            Route::put('admin/clubs/update/{id}', [ClubController::class, 'update'])->name('admin.clubs.update');
            Route::delete('admin/clubs/delete', [ClubController::class, 'destroy'])->name('admin.clubs.delete');
            Route::get('admin/settings', [AufplSettingsController::class, 'index'])->name('admin.settings');
            Route::post('admin/settings/update', [AufplSettingsController::class, 'update'])->name('admin.settings.update');
        }
    );


Auth::routes(['logout' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
