<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BukuResource;
use App\Models\Buku;
use Illuminate\Http\Request;

class BukuApiController extends Controller
{
    public function index()
    {
        $bukus = Buku::all();

        return response()->json([
            'status' => 'success',
            'message' => 'Data semua buku berhasil diambil',
            'data' => BukuResource::collection($bukus),
        ], 200);
    }
}