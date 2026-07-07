<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk; 
use Barryvdh\DomPDF\Facade\Pdf;

class ProdukController extends Controller
{
    public function index() 
    {
        $data_produk = Produk::all();
        return view('produk.index', compact('data_produk'));
    }

    public function create()
    {
        return view('produk.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_produk' => 'required|string|min:3',
            'harga'       => 'required|numeric|min:1000',
            'stok'        => 'required|integer|min:0',
            'deskripsi'   => 'nullable|string',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('gambar')) {
            $validatedData['gambar'] = $request->file('gambar')->store('produk_images', 'public');
        }

        Produk::create($validatedData);
        return redirect('/produk')->with('success', 'Produk berhasil disimpan!');
    }

    public function edit($id)  
    { 
        $produk = Produk::findOrFail($id);  
        return view('produk.edit', compact('produk')); 
    } 

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama_produk' => 'required|string|min:3',
            'harga'       => 'required|numeric|min:1000',
            'stok'        => 'required|integer|min:0',
            'deskripsi'   => 'nullable|string',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $produk = Produk::findOrFail($id);

        if ($request->hasFile('gambar')) {
            $validatedData['gambar'] = $request->file('gambar')->store('produk_images', 'public');
        }

        $produk->update($validatedData);
        return redirect('/produk')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Produk::findOrFail($id)->delete();
        return redirect('/produk')->with('success', 'Produk berhasil dihapus!');
    }

    public function cetakPdf()
    {
        $produk = Produk::all();
        $pdf = Pdf::loadView('produk.laporan_pdf', compact('produk'));
        return $pdf->download('Laporan-Inventaris-TokoKita.pdf');
    }
}