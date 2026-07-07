@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tokokita - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0f172a 0%, #2563eb 100%);
            color: #fff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px 20px;
        }
        .hero-card {
            background: rgba(255,255,255,0.12);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 24px;
            padding: 40px;
            max-width: 900px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.25);
        }
        .badge-custom {
            background: rgba(255,255,255,0.18);
            border: 1px solid rgba(255,255,255,0.25);
        }
        .btn-custom {
            background: white;
            color: #1d4ed8;
            font-weight: 700;
            border: none;
            padding: 10px 18px;
            border-radius: 999px;
        }
        .btn-custom:hover {
            background: #eff6ff;
            color: #1d4ed8;
        }
        .product-panel {
            background: rgba(255,255,255,0.10);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.18);
            border-radius: 24px;
            padding: 24px;
            margin-top: -20px;
        }
        .product-card {
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.14);
        }
    </style>
</head>
<body>
    <div class="hero">
        <div class="hero-card text-center">
            <span class="badge badge-custom px-3 py-2 rounded-pill mb-3">Toko Kita</span>
            <h1 class="display-5 fw-bold mb-3">Selamat datang di sistem toko digital</h1>
            <p class="lead mb-4">Kelola produk, pesanan, dan stok dengan tampilan yang lebih rapi.</p>
            <div class="d-flex gap-2 justify-content-center flex-wrap">
                <a href="/produk" class="btn btn-custom">Lihat Produk</a>
                @can('isAdmin')
                    <a href="/produk/create" class="btn btn-outline-light">Tambah Produk</a>
                @else
                    <a href="/login" class="btn btn-outline-light">Login</a>
                @endcan
            </div>
            <div class="mt-4 text-white-100 small">
                <div>Nama: Wahyu Sijabat</div>
                <div>NIM: 224520041</div>
            </div>
        </div>
    </div>

    <div class="container pb-5">
        <div class="product-panel">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <div>
                    <h2 class="h4 fw-bold mb-1">Produk Terbaru</h2>
                    <p class="text-white-50 mb-0">Tambahkan, ubah, atau hapus produk langsung dari sini.</p>
                </div>
                @can('isAdmin')
                    <a href="/produk/create" class="btn btn-custom">Tambah Produk</a>
                @endcan
            </div>

            @if($produk->isNotEmpty())
                <div class="row g-4">
                    @foreach($produk as $item)
                        <div class="col-md-4">
                            <div class="card product-card h-100 shadow-sm">
                                <div class="card-body">
                                    @if ($item->gambar)
                                        @if (Str::startsWith($item->gambar, ['http://', 'https://']))
                                            <img src="{{ $item->gambar }}" class="card-img-top mb-3 rounded-3" alt="Foto Produk" style="height: 180px; object-fit: cover;">
                                        @else
                                            <img src="{{ asset('storage/' . $item->gambar) }}" class="card-img-top mb-3 rounded-3" alt="Foto Produk" style="height: 180px; object-fit: cover;">
                                        @endif
                                    @else
                                        <img src="https://placehold.co/600x400?text=No+Image" class="card-img-top mb-3 rounded-3" alt="No Image" style="height: 180px; object-fit: cover;">
                                    @endif

                                    <h5 class="fw-bold">{{ $item->nama_produk }}</h5>
                                    <p class="text-muted mb-2">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                                    <p class="small text-white-50">{{ Str::limit($item->deskripsi ?? 'Produk yang siap dijual', 80) }}</p>

                                    @can('isAdmin')
                                        <div class="d-flex gap-2 mt-3">
                                            <a href="/produk/{{ $item->id }}/edit" class="btn btn-outline-warning btn-sm flex-grow-1">Edit</a>
                                            <form action="/produk/{{ $item->id }}" method="POST" class="flex-grow-1" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-outline-danger btn-sm w-100">Hapus</button>
                                            </form>
                                        </div>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-4 text-white-50">
                    Belum ada produk yang ditambahkan. Silakan tambahkan produk baru melalui tombol di atas.
                </div>
            @endif
        </div>
    </div>
</body>
</html>