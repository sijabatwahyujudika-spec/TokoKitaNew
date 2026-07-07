<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('pesanans')) {
            Schema::create('pesanans', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('paket');
                $table->integer('jumlah_sepatu');
                $table->json('layanan_tambahan')->nullable();
                $table->integer('total_biaya');
                $table->string('status')->default('Menunggu Pembayaran');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
