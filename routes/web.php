<?php

use App\Exports\UsersExport;
use App\Exports\KeuanganExport;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KeluargaController;
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

        Route::resource('bendahara', BendaharaController::class);

        Route::get('bendahara/register', [BendaharaController::class, 'register'])->name('bendahara.register');

        Route::post('bendahara/registrasi', [BendaharaController::class, 'registrasi'])->name('bendahara.registrasi');

        Route::get('/export-keuangan', function () {
            return Excel::download(new KeuanganExport, 'keuangan.xlsx');
        });

        Route::post('/keuangan/import', [BendaharaController::class, 'import'])->name('keuangan.import');

        Route::resource('keluarga', KeluargaController::class);

        Route::get('users', [BendaharaController::class, 'index3'])->name('bendahara.index3');

        Route::delete('users/{id}', [BendaharaController::class, 'destroyuser'])->name('bendahara.destroyuser');

    });
