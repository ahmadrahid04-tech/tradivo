@extends('layouts.app')
@section('title', 'Edit Profil — Tradivo')
@section('content')
<section class="section" style="padding-top:2rem;">
    <div class="container" style="max-width:640px;">
        <h1 class="section-title mb-4">👤 Edit Profil</h1>
        <div class="card" style="padding:2rem;">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="form-group" style="text-align:center;">
                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" style="width:80px;height:80px;border-radius:50%;object-fit:cover;margin:0 auto 0.75rem;">
                    <div>
                        <label for="avatar" class="btn btn-secondary btn-sm" style="cursor:pointer;">📸 Ganti Avatar</label>
                        <input type="file" id="avatar" name="avatar" accept="image/*" class="sr-only">
                    </div>
                    @error('avatar') <div class="form-error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="name" class="form-label">Nama <span class="required">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                    @error('name') <div class="form-error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" value="{{ $user->email }}" class="form-control" disabled style="opacity:0.6;">
                    <p class="form-text">Email tidak bisa diubah.</p>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="phone" class="form-label">Telepon</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control" placeholder="08xxxxxxxxxx">
                    </div>
                    <div class="form-group">
                        <label for="location" class="form-label">Lokasi</label>
                        <input type="text" id="location" name="location" value="{{ old('location', $user->location) }}" class="form-control" placeholder="Kota Anda">
                    </div>
                </div>
                <div class="form-group">
                    <label for="bio" class="form-label">Bio</label>
                    <textarea id="bio" name="bio" class="form-control" rows="3" maxlength="500" placeholder="Ceritakan sedikit tentang diri Anda...">{{ old('bio', $user->bio) }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-block btn-lg">💾 Simpan Profil</button>
            </form>
        </div>

        {{-- Change Password --}}
        <div class="card mt-4" style="padding:2rem;">
            <h2 style="font-size:1.125rem;font-weight:700;margin-bottom:1rem;">🔒 Ganti Password</h2>
            <form action="{{ route('profile.password') }}" method="POST">
                @csrf @method('PUT')
                <div class="form-group">
                    <label for="current_password" class="form-label">Password Saat Ini <span class="required">*</span></label>
                    <input type="password" id="current_password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                    @error('current_password') <div class="form-error">{{ $message }}</div> @enderror
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="new_password" class="form-label">Password Baru <span class="required">*</span></label>
                        <input type="password" id="new_password" name="password" class="form-control @error('password') is-invalid @enderror" required minlength="8">
                        @error('password') <div class="form-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Konfirmasi <span class="required">*</span></label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-secondary btn-block">Ubah Password</button>
            </form>
        </div>
    </div>
</section>
@endsection
