<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanans';

    protected $fillable = [
        'user_id',
        'paket',
        'jumlah_sepatu',
        'layanan_tambahan',
        'total_biaya',
        'status',
    ];

    protected $casts = [
        'layanan_tambahan' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}