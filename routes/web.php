<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// 1. Landing Page (Tampilan Umum)
Route::get('/', function () {
    return view('dashboard.indexumum');
});

// 2. Halaman Login (Karena file ada di dashboard/login.blade.php)
Route::get('/login', function () {
    return view('dashboard.login');
})->name('login');

Route::get('/register', function () {
    return view('dashboard.register');
})->name('register');


// Kelompok Menu Dashboard
Route::prefix('dashboard')->group(function () {
    
    // Halaman Utama Dashboard
    Route::get('/', function () {
        return view('dashboard.index');
    })->name('dashboard');

    // Halaman Modal
    Route::get('/modal', function () {
        return view('dashboard.modal');
    })->name('modal');

    // Halaman Penarikan
    Route::get('/penarikan', function () {
        return view('dashboard.penarikan');
    })->name('penarikan');

    // Halaman Cicilan
    Route::get('/cicilan', function () {
        return view('dashboard.cicilan');
    })->name('cicilan');
    
    Route::get('pinjaman', function () {
        return view('dashboard.pinjaman');
    })->name('pinjaman');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/', function () {
    return 'OK';
});