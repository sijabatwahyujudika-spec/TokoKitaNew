@extends('layouts.app')
@section('title', 'Riwayat Pesanan')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-2">
    <div>
        <h2 class="mb-1 fw-bold">Riwayat Pesanan Saya</h2>
        <p class="text-muted mb-0">Pantau status pesanan Anda dengan lebih jelas.</p>
    </div>
    <a href="/pesanan/create" class="btn btn-primary-custom">Pesanan Baru</a>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID Order</th>
                        <th>Paket & Jumlah</th>
                        <th>Detail Produk</th>
                        <th>Total Biaya</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pesanan as $item)
                    <tr>
                        <td>#ORD-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</td>
                        <td class="text-capitalize">{{ str_replace('_', ' ', $item->paket) }} ({{ $item->jumlah_sepatu }} Psg)</td>
                        <td>
                            @if($item->layanan_tambahan)
                                <ul class="mb-0 ps-3">
                                    @foreach($item->layanan_tambahan as $addon)
                                        <li class="text-capitalize">{{ str_replace('_', ' ', $addon) }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="fw-bold text-success">Rp {{ number_format($item->total_biaya, 0, ',', '.') }}</td>
                        <td>
                            @if($item->status == 'Menunggu Pembayaran')
                                <span class="badge bg-warning text-dark">{{ $item->status }}</span>
                            @elseif($item->status == 'Sedang Dicuci')
                                <span class="badge bg-info">{{ $item->status }}</span>
                            @else
                                <span class="badge bg-success">{{ $item->status }}</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">Silahkan Tambahkan Pesanan Baru</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection