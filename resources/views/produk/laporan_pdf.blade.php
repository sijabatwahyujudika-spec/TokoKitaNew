<!DOCTYPE html>
<html>
<head>
    <title>Laporan Produk Tokokita</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; margin-bottom: 5px; }
        p { text-align: center; color: #666; margin-top: 0; }
    </style>
</head>
<body>
    <h2>Laporan Data Produk Tokokita</h2>
    <p>Tanggal dicetak: {{ date('d-m-Y H:i') }}</p>
    
    <table>
        <thead>
            <tr>
                <th style="width: 8%">No</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th style="width: 15%">Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach($produk as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->nama_produk }}</td>
                <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                <td>{{ $item->stok }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>