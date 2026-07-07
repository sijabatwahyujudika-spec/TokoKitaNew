@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h1 class="h3">Daftar Produk Tersedia</h1>
    </div>
</div>

<div class="row">
    @foreach($data_produk as $item)
    <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">{{ $item['nama'] }}</h5>
                <h6 class="card-subtitle mb-2 text-muted">Rp {{ number_format($item['harga'], 0, ',', '.') }}</h6>
                
                @if($item['stok'] > 0)
                    <p class="card-text text-success">Stok: {{ $item['stok'] }} (Tersedia)</p>
                    <a href="#" class="btn btn-primary w-100">Beli Sekarang</a>
                @else
                    <p class="card-text text-danger">Stok Habis</p>
                    <button class="btn btn-secondary w-100" disabled>Beli Sekarang</button>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection