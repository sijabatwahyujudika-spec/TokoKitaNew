<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PesananController;
use App\Models\Produk;

// ==========================================
// 1. RUTE UMUM / TERBUKA (GUEST & AUTH)
// ==========================================
Route::get('/', function () {
    $produk = Produk::latest()->take(6)->get();
    return view('welcome', compact('produk'));
});
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');


// ==========================================
// 2. RUTE KHUSUS PENGUNJUNG BELUM LOGIN (GUEST)
// ==========================================
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'tampilkanLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'prosesLogin']);
});


// ==========================================
// 3. RUTE TERPROTEKSI LOGIN (WAJIB AUTH)
// ==========================================
Route::middleware(['auth'])->group(function () {
    // Fitur Keluar Akun
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // --- FITUR MODUL 12: CETAK PDF (PRODUK) ---
    Route::get('/produk/cetak-pdf', [ProdukController::class, 'cetakPdf'])->name('produk.pdf');

    // --- FITUR MODUL 13/14: TRANSAKSI LAUNDRY (SISI CUSTOMER) ---
    // Pelanggan bisa membuat pesanan cuci sepatu & melihat riwayat mereka
    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/create', [PesananController::class, 'create'])->name('pesanan.create');
    Route::post('/pesanan', [PesananController::class, 'store'])->name('pesanan.store');


    // ==========================================
    // 4. RUTE KHUSUS HANYA UNTUK ADMIN (IS_ADMIN)
    // ==========================================
    // Menggunakan 'is_admin' agar cocok dengan middleware Modul 10 kamu
    Route::middleware(['auth', 'can:isAdmin'])->group(function () {

        // --- MANAGEMENT DATA PRODUK (CRUD) ---
        Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
        Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');

        // Parameter {id} diletakkan paling bawah agar tidak bentrok
        Route::get('/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
        Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
        Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');

        // --- FITUR MODUL 13/14: MANAGEMENT LAUNDRY (SISI ADMIN) ---
        // Admin bisa melihat seluruh antrean orderan dan mengubah status cucian
        Route::get('/admin/pesanan', [PesananController::class, 'adminIndex'])->name('admin.pesanan.index');
        Route::put('/admin/pesanan/{id}', [PesananController::class, 'updateStatus'])->name('admin.pesanan.update');
    });
});

Route::get('/jalankan-migrasi', function () {
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('storage:link');

    return response()->json([
        'message' => 'Jembatan storage:link berhasil dibuat dan cache dibersihkan.',
        'status' => 'ok',
    ]);
});