@extends('layouts.guest')

@section('title', 'Masuk — Tradivo')
@section('auth_title', 'Selamat Datang Kembali')
@section('auth_subtitle', 'Masuk ke akun Tradivo Anda')

@section('content')
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label for="email" class="form-label">Email <span class="required">*</span></label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="contoh@email.com" required autofocus aria-required="true">
            @error('email')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password" class="form-label">Password <span class="required">*</span></label>
            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password" required aria-required="true">
            @error('password')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group" style="display:flex; align-items:center; gap:0.5rem;">
            <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
            <label for="remember" style="font-size:0.875rem; color:var(--text-secondary); margin:0;">Ingat saya</label>
        </div>

        <button type="submit" class="btn btn-primary btn-block btn-lg">Masuk</button>

        <div class="auth-footer">
            Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
        </div>
    </form>
@endsection
