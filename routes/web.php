<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TbpinjamanController;
use App\Http\Controllers\TbmodalController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| 1. LANDING PAGE
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('dashboard.indexumum');
});


/*
|--------------------------------------------------------------------------
| 2. DASHBOARD USER
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:user'])->group(function () {

    // Dashboard utama user
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    // Prefix dashboard/*
    Route::prefix('dashboard')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | MODAL (FIX: pakai controller)
        |--------------------------------------------------------------------------
        */
        Route::get('/modal', [TbmodalController::class, 'index'])->name('modal');

        Route::post('/modal', [TbmodalController::class, 'store'])->name('modal.store');
        Route::put('/modal/{id}', [TbmodalController::class, 'update'])->name('modal.update');
        Route::delete('/modal/{id}', [TbmodalController::class, 'destroy'])->name('modal.destroy');


        /*
        |--------------------------------------------------------------------------
        | MENU LAIN
        |--------------------------------------------------------------------------
        */
        Route::get('/penarikan', function () {
            return view('dashboard.penarikan');
        })->name('penarikan');

        Route::get('/cicilan', function () {
            return view('dashboard.cicilan');
        })->name('cicilan');


        /*
        |--------------------------------------------------------------------------
        | PINJAMAN
        |--------------------------------------------------------------------------
        */
        Route::get('/pinjaman', [TbpinjamanController::class, 'dashboard'])->name('pinjaman');

        Route::get('/pinjaman/{id}/edit', [TbpinjamanController::class, 'edit'])->name('pinjaman.edit');
        Route::put('/pinjaman/{id}', [TbpinjamanController::class, 'update'])->name('pinjaman.update');
        Route::delete('/pinjaman/{id}', [TbpinjamanController::class, 'destroy'])->name('pinjaman.destroy');

        Route::get('/pinjaman/riwayat', [TbpinjamanController::class, 'index'])->name('pinjaman.riwayat');
        Route::get('/pinjaman/pengajuan', [TbpinjamanController::class, 'create'])->name('pinjaman.pengajuan');
        Route::post('/pinjaman', [TbpinjamanController::class, 'store'])->name('pinjaman.store');
    });
});


/*
|--------------------------------------------------------------------------
| 3. DASHBOARD ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin/dashboard', function (Request $request) {

        $search = $request->input('search');

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


    // Update role
    Route::patch('/admin/users/{user}/role', function (Request $request, User $user) {

        if ($user->id == 1) {
            return back()->with('error', 'Super Admin tidak bisa diubah!');
        }

        $user->update([
            'role' => trim($request->role)
        ]);

        return back()->with('status', 'Role berhasil diperbarui!');
    })->name('admin.users.updateRole');


    // Hapus user
    Route::delete('/admin/users/{user}', function (User $user) {

        if ($user->id == auth()->id() || $user->id == 1) {
            return back()->with('error', 'Tidak bisa menghapus akun utama atau diri sendiri!');
        }

        $user->delete();

        return back()->with('status', 'Anggota berhasil dihapus!');
    })->name('admin.users.destroy');
});


/*
|--------------------------------------------------------------------------
| 4. PROFILE (BREEZE)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/profile/upload-foto', [ProfileController::class, 'uploadFoto'])
        ->name('profile.uploadFoto');
});


require __DIR__.'/auth.php';