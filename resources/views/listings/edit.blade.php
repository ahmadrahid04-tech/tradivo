@extends('layouts.app')

@section('title', 'Edit Iklan — Tradivo')

@section('content')
<section class="section" style="padding-top:2rem;">
    <div class="container" style="max-width:720px;">
        <h1 class="section-title mb-4">✏️ Edit Iklan</h1>

        <div class="card" style="padding:2rem;">
            <form action="{{ route('listings.update', $listing) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')

                <div class="form-group">
                    <label for="title" class="form-label">Judul Iklan <span class="required">*</span></label>
                    <input type="text" id="title" name="title" value="{{ old('title', $listing->title) }}" class="form-control @error('title') is-invalid @enderror" required maxlength="200">
                    @error('title') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="category_id" class="form-label">Kategori <span class="required">*</span></label>
                        <select id="category_id" name="category_id" class="form-control" required>
                            @foreach($categories as $cat)
                                <optgroup label="{{ $cat->name }}">
                                    <option value="{{ $cat->id }}" {{ old('category_id', $listing->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                    @foreach($cat->children as $child)
                                        <option value="{{ $child->id }}" {{ old('category_id', $listing->category_id) == $child->id ? 'selected' : '' }}>  └ {{ $child->name }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="condition" class="form-label">Kondisi <span class="required">*</span></label>
                        <select id="condition" name="condition" class="form-control" required>
                            <option value="used" {{ old('condition', $listing->condition) === 'used' ? 'selected' : '' }}>Bekas</option>
                            <option value="new" {{ old('condition', $listing->condition) === 'new' ? 'selected' : '' }}>Baru</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="price-input" class="form-label">Harga (Rp) <span class="required">*</span></label>
                        <input type="number" id="price-input" name="price" value="{{ old('price', $listing->price) }}" class="form-control" required min="0">
                        @error('price') <div class="form-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" name="status" class="form-control">
                            <option value="active" {{ old('status', $listing->status) === 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="sold" {{ old('status', $listing->status) === 'sold' ? 'selected' : '' }}>Terjual</option>
                            <option value="inactive" {{ old('status', $listing->status) === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="location" class="form-label">Lokasi <span class="required">*</span></label>
                    <input type="text" id="location" name="location" value="{{ old('location', $listing->location) }}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">Deskripsi <span class="required">*</span></label>
                    <textarea id="description" name="description" class="form-control" rows="5" required minlength="20">{{ old('description', $listing->description) }}</textarea>
                    @error('description') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                {{-- Existing Images --}}
                @if($listing->images->count() > 0)
                    <div class="form-group">
                        <label class="form-label">Foto Saat Ini</label>
                        <div class="image-preview-grid">
                            @foreach($listing->images as $image)
                                <div class="image-preview-item">
                                    <img src="{{ $image->url }}" alt="Foto">
                                    <label class="image-preview-remove" title="Hapus foto ini">
                                        <input type="checkbox" name="remove_images[]" value="{{ $image->id }}" class="sr-only">
                                        ✕
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <p class="form-text">Klik ✕ pada foto untuk menandai penghapusan.</p>
                    </div>
                @endif

                <div class="form-group">
                    <label class="form-label">Tambah Foto Baru <span class="text-muted text-sm">(opsional)</span></label>
                    <div class="image-upload-area" id="image-upload-area">
                        <div style="font-size:2rem;">📸</div>
                        <p class="text-sm">Klik atau drag & drop foto baru</p>
                    </div>
                    <input type="file" id="image-upload" name="images[]" multiple accept="image/jpeg,image/png,image/webp" class="sr-only">
                    <div id="image-preview-grid" class="image-preview-grid"></div>
                </div>

                <div style="display:flex; gap:0.75rem; margin-top:2rem;">
                    <button type="submit" class="btn btn-primary btn-lg" style="flex:1;">💾 Simpan Perubahan</button>
                    <a href="{{ route('listings.show', $listing) }}" class="btn btn-secondary btn-lg">Batal</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
