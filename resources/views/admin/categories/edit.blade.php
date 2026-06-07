@extends('layouts.admin')
@section('title', 'Edit Kategori — Tradivo')
@section('content')
<div class="admin-header"><h1>✏️ Edit Kategori: {{ $category->name }}</h1></div>
<div class="card" style="padding:2rem;max-width:600px;">
    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group">
            <label for="name" class="form-label">Nama Kategori <span class="required">*</span></label>
            <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" class="form-control @error('name') is-invalid @enderror" required>
            @error('name') <div class="form-error">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" id="slug" name="slug" value="{{ old('slug', $category->slug) }}" class="form-control">
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="icon" class="form-label">Icon (emoji)</label>
                <input type="text" id="icon" name="icon" value="{{ old('icon', $category->icon) }}" class="form-control">
            </div>
            <div class="form-group">
                <label for="sort_order" class="form-label">Urutan</label>
                <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}" class="form-control" min="0">
            </div>
        </div>
        <div class="form-group">
            <label for="parent_id" class="form-label">Parent (opsional)</label>
            <select id="parent_id" name="parent_id" class="form-control">
                <option value="">— Tidak ada (kategori utama) —</option>
                @foreach($parentCategories as $cat)
                    <option value="{{ $cat->id }}" {{ old('parent_id', $category->parent_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div style="display:flex;gap:0.75rem;">
            <button type="submit" class="btn btn-primary btn-lg" style="flex:1;">💾 Simpan Perubahan</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary btn-lg">Batal</a>
        </div>
    </form>
</div>
@endsection
