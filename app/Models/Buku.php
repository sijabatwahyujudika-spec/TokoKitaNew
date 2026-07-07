<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'bukus';

    protected $fillable = [
        'judul',
        'pengarang',
        'tahun_terbit',
        'sampul_buku',
    ];
}