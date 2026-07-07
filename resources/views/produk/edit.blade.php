@extends('layouts.app')
@section('title', 'Edit Produk')

@section('content')
<div class="row justify-content-center py-3">
    <div class="col-lg-8">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-header bg-warning text-dark py-3">
                <h4 class="mb-0 fw-bold">Edit Produk</h4>
            </div>
            <div class="card-body p-4 p-md-5">
                <form action="/produk/{{ $produk->id }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Produk</label>
                        <input type="text" name="nama_produk" value="{{ old('nama_produk', $produk->nama_produk) }}" class="form-control rounded-3 @error('nama_produk') is-invalid @enderror">
                        @error('nama_produk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Harga (Rp)</label>
                            <input type="number" name="harga" value="{{ old('harga', $produk->harga) }}" class="form-control rounded-3 @error('harga') is-invalid @enderror">
                            @error('harga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Stok</label>
                            <input type="number" name="stok" value="{{ old('stok', $produk->stok) }}" class="form-control rounded-3 @error('stok') is-invalid @enderror">
                            @error('stok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 mt-3">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control rounded-3" rows="4">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Foto/Gambar Produk</label>
                        <input type="file" name="gambar" class="form-control rounded-3 @error('gambar') is-invalid @enderror">
                        <div class="form-text text-muted">Format yang didukung: JPG, JPEG, PNG. Maksimal 2 MB. Kosongkan jika tidak ingin mengubah gambar.</div>

                        @if($produk->gambar)
                            <div class="mt-2">
                                <small class="text-muted">Gambar saat ini: <strong>{{ $produk->gambar }}</strong></small>
                            </div>
                        @endif

                        @error('gambar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning">Perbarui Data</button>
                        <a href="/produk" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection