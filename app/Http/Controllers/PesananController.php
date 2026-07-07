<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    // 1. Menampilkan daftar pesanan milik pelanggan yang sedang login
    public function index() {
        // Mengambil pesanan user yang sedang login saja
        $pesanan = Pesanan::where('user_id', Auth::id())->latest()->get();
        return view('pesanan.index', compact('pesanan'));
    }

    // 2. Menampilkan form pembuatan pesanan baru
    public function create() {
        return view('pesanan.create');
    }

    // 3. Memproses kalkulasi dan menyimpan pesanan ke database
    public function store(Request $request) {
        $request->validate([
            'paket' => 'required|in:reguler,deep_clean,premium',
            'jumlah_sepatu' => 'required|integer|min:1',
            'layanan_tambahan' => 'nullable|array'
        ]);

        // Kamus Harga Paket
        $hargaPaket = [
            'reguler' => 30000,
            'deep_clean' => 50000,
            'premium' => 100000
        ];

        // Kalkulasi Biaya Dasar
        $biayaDasar = $hargaPaket[$request->paket] * $request->jumlah_sepatu;

        // Kalkulasi Layanan Tambahan (Add-ons)
        $biayaTambahan = 0;
        if ($request->has('layanan_tambahan')) {
            foreach ($request->layanan_tambahan as $layanan) {
                if ($layanan == 'repaint') $biayaTambahan += 80000;
                if ($layanan == 'wangi_premium') $biayaTambahan += 10000;
            }
        }

        // Total Keseluruhan
        $totalBiaya = $biayaDasar + $biayaTambahan;

        Pesanan::create([
            'user_id' => Auth::id(),
            'paket' => $request->paket,
            'jumlah_sepatu' => $request->jumlah_sepatu,
            'layanan_tambahan' => $request->layanan_tambahan, // Otomatis di-cast sebagai JSON jika di Model sudah diset $casts
            'total_biaya' => $totalBiaya,
            'status' => 'Menunggu Pembayaran'
        ]);

        return redirect('/pesanan')->with('success', 'Pesanan berhasil dibuat! Segera lakukan pembayaran.');
    }

    /*
    =======================================================
    BAGIAN 2: FITUR PENGELOLA (ADMINISTRATOR)
    ======================================================= */

    // 4. Menampilkan seluruh pesanan dari semua pelanggan
    public function adminIndex() {
        // with('user') digunakan untuk menarik data nama pelanggan sekaligus (Eager Loading)
        $pesanan = Pesanan::with('user')->latest()->get();
        return view('pesanan.admin', compact('pesanan'));
    }

    // 5. Mengubah status pesanan
    public function updateStatus(Request $request, $id) {
        $request->validate([
            'status' => 'required|in:Menunggu Pembayaran,Sedang Dicuci,Selesai'
        ]);

        $pesanan = Pesanan::findOrFail($id);
        $pesanan->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status pesanan pelanggan berhasil diperbarui!');
    }
}