@extends('layouts.app')
@section('title', 'Login Pengguna')

@section('content')
<div class="row justify-content-center py-4">
    <div class="col-lg-5 col-md-7">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <h2 class="fw-bold">Masuk ke Tokokita</h2>
                    <p class="text-muted mb-0">Silakan login untuk mengakses fitur lengkap.</p>
                </div>

                <form action="/login" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Alamat Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control form-control-lg rounded-3 @error('email') is-invalid @enderror" placeholder="nama@email.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Kata Sandi</label>
                        <input type="password" name="password" class="form-control form-control-lg rounded-3 @error('password') is-invalid @enderror" placeholder="••••••••">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary-custom btn-lg w-100 rounded-3">Masuk Sekarang</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection