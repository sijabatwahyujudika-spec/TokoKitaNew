<?php

namespace App\Http\Controllers;

use App\Models\Produk;

class ProdukApiController extends Controller
{
    public function index()
    {
        return response()->json(Produk::all());
    }
}
