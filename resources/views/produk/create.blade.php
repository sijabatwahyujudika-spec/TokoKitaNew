@extends('layouts.app')
@section('title', 'Tambah Produk')

@section('content')
<div class="row justify-content-center py-3">
    <div class="col-lg-8">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-header bg-primary text-white py-3">
                <h4 class="mb-0 fw-bold">Tambah Produk Baru</h4>
            </div>
            <div class="card-body p-4 p-md-5">
                <form action="/produk" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Produk</label>
                        <input type="text" name="nama_produk" value="{{ old('nama_produk') }}" class="form-control rounded-3 @error('nama_produk') is-invalid @enderror" placeholder="Contoh: Sepatu Premium">
                        @error('nama_produk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Harga (Rp)</label>
                            <input type="number" name="harga" value="{{ old('harga') }}" class="form-control rounded-3 @error('harga') is-invalid @enderror" placeholder="150000">
                            @error('harga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Stok Awal</label>
                            <input type="number" name="stok" value="{{ old('stok', 0) }}" class="form-control rounded-3 @error('stok') is-invalid @enderror" placeholder="10">
                            @error('stok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 mt-3">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control rounded-3" rows="4" placeholder="Jelaskan keunggulan produk...">{{ old('deskripsi') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Foto/Gambar Produk</label>
                        <input type="file" name="gambar" class="form-control rounded-3 @error('gambar') is-invalid @enderror">
                        <div class="form-text text-muted">Format yang didukung: JPG, JPEG, PNG. Maksimal 2 MB.</div>
                        @error('gambar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary-custom">Simpan Data</button>
                        <a href="/produk" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection