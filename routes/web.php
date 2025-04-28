<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\BendaharaController;

    Route::get('/', function () {
        return view('auth.login');
    });

    Route::middleware('auth')->group(function () {

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    });

    require __DIR__.'/auth.php';

    //RUTE USER
    Route::middleware(['auth','userMiddleware'])->group(function(){

        Route::get('/dashboard',[UserController::class, 'index'])->name('dashboard');

        Route::resource('user', UserController::class);

        Route::resource('keuangan', KeuanganController::class);

    });

    //RUTE BENDAHARA
    Route::middleware(['auth','bendaharaMiddleware'])->group(function(){

        Route::get('bendahara/dashboard', [BendaharaController::class, 'index'])->name('bendahara.dashboard');

    });
