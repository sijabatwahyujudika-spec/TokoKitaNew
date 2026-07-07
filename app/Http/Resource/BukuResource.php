<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BukuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_buku' => $this->id,
            'judul_buku' => $this->judul,
            'pengarang_buku' => $this->pengarang,
            'tahun_terbit' => 'Tahun ' . $this->tahun_terbit,
        ];
    }
}