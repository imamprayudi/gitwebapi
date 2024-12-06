<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PoController;
use App\Http\Controllers\PocController;
use App\Http\Controllers\OrdbalController;

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

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/', [LoginController::class, 'login']);

Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');
Route::get('/po', [PoController::class,'index'])->name('po');
Route::get('/poc', [PocController::class,'index'])->name('poc');
Route::get('/ordbal', [OrdbalController::class,'index'])->name('ordbal');

Route::get('/forms', function () {
    return view('pages.forms.index');
});

Route::get('/buttons', function () {
    return view('pages.ui-features.buttons.index');
});

Route::get('/dropdowns', function () {
    return view('pages.ui-features.dropdowns.index');
});

Route::get('/typography', function () {
    return view('pages.ui-features.typography.index');
});

Route::get('/chart', function () {
    return view('pages.chart.index');
});

Route::get('/table', function () {
    return view('pages.table.index');
});

Route::get('/icons', function () {
    return view('pages.icons.index');
});


Route::get('/register', function () {
    return view('pages.user-pages.register.index');
});

Route::get('/erro404', function () {
    return view('pages.error-pages.404.index');
});

Route::get('/erro500', function () {
    return view('pages.error-pages.500.index');
});
