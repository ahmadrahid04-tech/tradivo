@extends('layouts.guest')

@section('title', 'Daftar — Tradivo')
@section('auth_title', 'Buat Akun Baru')
@section('auth_subtitle', 'Bergabunglah dengan Tradivo — gratis!')

@section('content')
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <label for="name" class="form-label">Nama Lengkap <span class="required">*</span></label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Masukkan nama lengkap" required autofocus aria-required="true">
            @error('name')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email" class="form-label">Email <span class="required">*</span></label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="contoh@email.com" required aria-required="true">
            @error('email')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="phone" class="form-label">Nomor Telepon</label>
                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" class="form-control" placeholder="08xxxxxxxxxx">
            </div>
            <div class="form-group">
                <label for="location" class="form-label">Lokasi</label>
                <input type="text" id="location" name="location" value="{{ old('location') }}" class="form-control" placeholder="Kota Anda">
            </div>
        </div>

        <div class="form-group">
            <label for="password" class="form-label">Password <span class="required">*</span></label>
            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimal 8 karakter" required aria-required="true">
            @error('password')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="required">*</span></label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Ulangi password" required aria-required="true">
        </div>

        <button type="submit" class="btn btn-primary btn-block btn-lg">Daftar Sekarang 🚀</button>

        <div class="auth-footer">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
        </div>
    </form>
@endsection
