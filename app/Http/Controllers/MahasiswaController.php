<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class mahasiswaController extends Controller
{
    public function index(){
        return"ini adalah halaman daftar semua mahasiswa (dari controller).";
    }
    public function show( $nim){
        return "ini adalah halaman profil mahasiswa dengan NIM:". $nim;
    }
    public function data()
 {
 $data = [
 'nama' => 'Budi Santoso',
 'nim' => '10293847',
 'jurusan' => 'Teknik Informatika'
];
 return response()->json($data);
 }
}