@extends('layouts.app')
@section('title', 'Buat Pesanan Baru')

@section('content')
<div class="container max-w-lg py-4">
    <div class="mb-4">
        <a href="{{ route('pesanan.index') }}" class="text-decoration-none text-muted">← Kembali ke Riwayat</a>
        <h2 class="fw-bold mt-2">Buat Pesanan Baru</h2>
        <p class="text-muted">Silakan isi formulir di bawah untuk memesan layanan laundry sepatu.</p>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('pesanan.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="paket" class="form-label fw-semibold">Pilih Paket Cuci</label>
                    <select name="paket" id="paket" class="form-select @error('paket') is-invalid @enderror" required>
                        <option value="" selected disabled>-- Pilih Paket --</option>
                        <option value="reguler">Reguler (Rp 30.000)</option>
                        <option value="deep_clean">Deep Clean (Rp 50.000)</option>
                        <option value="premium">Premium (Rp 100.000)</option>
                    </select>
                    @error('paket')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="jumlah_sepatu" class="form-label fw-semibold">Jumlah Sepatu (Pasang)</label>
                    <input type="number" name="jumlah_sepatu" id="jumlah_sepatu" class="form-control @error('jumlah_sepatu') is-invalid @enderror" min="1" value="1" required>
                    @error('jumlah_sepatu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold d-block">Layanan Tambahan (Opsional)</label>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="layanan_tambahan[]" value="repaint" id="addon_repaint">
                        <label class="form-check-label" for="addon_repaint">
                            Repaint / Cat Ulang (+Rp 80.000)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="layanan_tambahan[]" value="wangi_premium" id="addon_wangi">
                        <label class="form-check-label" for="addon_wangi">
                            Parfum Wangi Premium (+Rp 10.000)
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2.5 rounded-3 fw-bold">
                    Konfirmasi & Buat Pesanan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection