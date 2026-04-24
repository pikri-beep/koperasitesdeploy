<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Http\Request;

// 1. Landing Page (Tampilan Umum Kelompok 2)
Route::get('/', function () {
    return view('dashboard.indexumum');
});

// 2. Grup Rute untuk Dashboard Anggota (User Biasa)
Route::middleware(['auth', 'role:user'])->group(function () {
    
    // Halaman Utama Dashboard User
    Route::get('/dashboard', function () {
        return view('dashboard.index'); 
    })->name('dashboard');

    // Sub-menu Kelompok 2
    Route::prefix('dashboard')->group(function () {
        Route::get('/modal', function () {
            return view('dashboard.modal');
        })->name('modal');

        Route::get('/penarikan', function () {
            return view('dashboard.penarikan');
        })->name('penarikan');

        Route::get('/cicilan', function () {
            return view('dashboard.cicilan');
        })->name('cicilan');
        
        Route::get('/pinjaman', function () {
            return view('dashboard.pinjaman');
        })->name('pinjaman');
    });
});

// 3. Grup Rute untuk Admin (Tugas Kelompok 3)
Route::middleware(['auth', 'role:admin'])->group(function () {
    
    Route::get('/admin/dashboard', function (Request $request) {
        $search = $request->input('search');

        // Mengambil data dengan pencarian dan pagination (10 data per halaman)
        $users = User::when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('email', 'like', "%{$search}%");
            })
            ->paginate(10)
            ->withQueryString();

        return view('admin.dashboard', [
            'users' => $users,
            'totalAnggota' => User::where('role', 'user')->count(),
            'totalAdmin' => User::where('role', 'admin')->count()
        ]);
    })->name('admin.dashboard');

    // Fitur Ganti Role (Ditingkatkan dengan trim untuk mencegah error "enter")
    Route::patch('/admin/users/{user}/role', function (Request $request, User $user) {
        if ($user->id == 1) {
            return back()->with('error', 'Super Admin tidak bisa diubah!');
        }

        $user->update([
            'role' => trim($request->role)
        ]);

        return back()->with('status', 'Role berhasil diperbarui!');
    })->name('admin.users.updateRole');

    // Fitur Hapus User
    Route::delete('/admin/users/{user}', function (User $user) {
        if ($user->id == auth()->id() || $user->id == 1) {
            return back()->with('error', 'Tidak bisa menghapus akun utama atau diri sendiri!');
        }
        
        $user->delete();
        return back()->with('status', 'Anggota berhasil dihapus!');
    })->name('admin.users.destroy');
});

// 4. Rute Profil Bawaan Breeze
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/upload-foto', [ProfileController::class, 'uploadFoto'])->name('profile.uploadFoto');
});

require __DIR__.'/auth.php';