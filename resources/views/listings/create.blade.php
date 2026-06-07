@extends('layouts.app')

@section('title', 'Pasang Iklan Baru — Tradivo')

@section('content')
<section class="section" style="padding-top:2rem;">
    <div class="container" style="max-width:720px;">
        <h1 class="section-title mb-4">📝 Pasang Iklan Baru</h1>

        <div class="card" style="padding:2rem;">
            <form action="{{ route('listings.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="title" class="form-label">Judul Iklan <span class="required">*</span></label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" class="form-control @error('title') is-invalid @enderror" placeholder="Contoh: iPhone 14 Pro Max 256GB" required maxlength="200">
                    @error('title') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="category_id" class="form-label">Kategori <span class="required">*</span></label>
                        <select id="category_id" name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                            <option value="">Pilih kategori...</option>
                            @foreach($categories as $cat)
                                <optgroup label="{{ $cat->name }}">
                                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                    @foreach($cat->children as $child)
                                        <option value="{{ $child->id }}" {{ old('category_id') == $child->id ? 'selected' : '' }}>  └ {{ $child->name }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        @error('category_id') <div class="form-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label for="condition" class="form-label">Kondisi <span class="required">*</span></label>
                        <select id="condition" name="condition" class="form-control @error('condition') is-invalid @enderror" required>
                            <option value="used" {{ old('condition') === 'used' ? 'selected' : '' }}>Bekas</option>
                            <option value="new" {{ old('condition') === 'new' ? 'selected' : '' }}>Baru</option>
                        </select>
                        @error('condition') <div class="form-error">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="price-input" class="form-label">Harga (Rp) <span class="required">*</span></label>
                    <input type="number" id="price-input" name="price" value="{{ old('price') }}" class="form-control @error('price') is-invalid @enderror" placeholder="0" required min="0">
                    @error('price') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="location" class="form-label">Lokasi <span class="required">*</span></label>
                    <input type="text" id="location" name="location" value="{{ old('location') }}" class="form-control @error('location') is-invalid @enderror" placeholder="Contoh: Jakarta Selatan" required>
                    @error('location') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">Deskripsi <span class="required">*</span></label>
                    <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="5" placeholder="Jelaskan detail barang yang Anda jual: kondisi, kelengkapan, alasan jual, dll." required minlength="20">{{ old('description') }}</textarea>
                    @error('description') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Foto Barang <span class="required">*</span> <span class="text-muted text-sm">(maks 5 foto, masing-masing maks 2MB)</span></label>
                    <div class="image-upload-area" id="image-upload-area">
                        <div style="font-size:2.5rem; margin-bottom:0.5rem;">📸</div>
                        <p class="font-semibold">Klik atau drag & drop foto di sini</p>
                        <p class="text-sm text-muted">Format: JPG, JPEG, PNG, WebP</p>
                    </div>
                    <input type="file" id="image-upload" name="images[]" multiple accept="image/jpeg,image/png,image/webp" class="sr-only" required>
                    <div id="image-preview-grid" class="image-preview-grid"></div>
                    @error('images') <div class="form-error">{{ $message }}</div> @enderror
                    @error('images.*') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div style="display:flex; gap:0.75rem; margin-top:2rem;">
                    <button type="submit" class="btn btn-primary btn-lg" style="flex:1;">🚀 Publikasikan Iklan</button>
                    <a href="{{ route('home') }}" class="btn btn-secondary btn-lg">Batal</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
