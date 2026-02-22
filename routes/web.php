<?php

use App\Http\Controllers\RamadhanController;
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



Route::get('/', [RamadhanController::class, 'index'])->name('home');


Route::get('/dzikir', [RamadhanController::class, 'dzikir'])->name('dzikir');


Route::get('/profile', [RamadhanController::class, 'profile'])->name('profile');

Route::get('/change-language/{lang}', [RamadhanController::class, 'changeLanguage']);