<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BukuController extends Controller
{
    // soalno2 bagian a
    public function index(){
        return "Selamat datang di Katalog Buku Utama.";
    }
    // soalno2 bagian b
     public function detail($id){
        return "Anda sedang melihat detail buku dengan ID : " . $id;
    }
    // soalno3 bagian c
     public function kategori($genre){
        return "menampilkan dafta buku dengan kategori: " . $genre;
     }
}