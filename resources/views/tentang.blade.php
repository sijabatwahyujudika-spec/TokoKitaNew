@extends('layouts.app')

@section('title', 'Tentang Kami')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow border-0 mt-4">
            <div class="card-header bg-primary text-white text-center py-3">
                <h4 class="mb-0">Profil Pengembang Aplikasi</h4>
            </div>
            <div class="card-body text-center p-4">
                <!-- Gunakan inisial atau avatar placeholder -->
                <div class="bg-light rounded-circle d-inline-flex align-content-center justify-content-center mb-3" style="width: 100px; height: 100px; font-size: 2.5rem; line-height: 100px; color: #0d6efd; font-weight: bold;">
                    I
                </div>
                <h5 class="card-title fs-4 mb-1">Ika</h5>
                <p class="text-muted mb-3">Sistem Informasi (SI-B)</p>
                <hr>
                <p class="card-text text-secondary">
                    "Halo! Saya adalah mahasiswa Sistem Informasi di Universitas Methodist Indonesia. Aplikasi <strong>TokoKitaNew</strong> ini dikembangkan sebagai bagian dari tugas praktikum pemrograman web menggunakan framework Laravel 12 dan Bootstrap 5."
                </p>
            </div>
            <div class="card-footer bg-light text-center py-3">
                <span class="badge bg-success">Status: Mahasiswa Aktif</span>
            </div>
        </div>
    </div>
</div>
@endsection