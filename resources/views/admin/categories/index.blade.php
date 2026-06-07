@extends('layouts.admin')
@section('title', 'Kelola Kategori — Tradivo')
@section('content')
<div class="admin-header">
    <h1>📂 Kelola Kategori</h1>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">➕ Tambah Kategori</a>
</div>
<div class="table-wrapper">
    <table>
        <thead><tr><th>Icon</th><th>Nama</th><th>Slug</th><th>Parent</th><th>Iklan</th><th>Urutan</th><th>Aksi</th></tr></thead>
        <tbody>
            @forelse($categories as $category)
                <tr>
                    <td style="font-size:1.25rem;">{{ $category->icon ?? '📦' }}</td>
                    <td class="font-semibold">{{ $category->name }}</td>
                    <td class="text-muted text-sm">{{ $category->slug }}</td>
                    <td>—</td>
                    <td>{{ $category->listings_count }}</td>
                    <td>{{ $category->sort_order }}</td>
                    <td style="display:flex;gap:0.375rem;">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-secondary">✏️</a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-ghost text-danger" data-confirm="Hapus kategori {{ $category->name }}?">🗑️</button>
                        </form>
                    </td>
                </tr>
                @foreach($category->children as $child)
                    <tr style="background:var(--gray-50);">
                        <td style="padding-left:2rem;font-size:1.1rem;">{{ $child->icon ?? '📎' }}</td>
                        <td class="font-semibold" style="padding-left:2rem;">└ {{ $child->name }}</td>
                        <td class="text-muted text-sm">{{ $child->slug }}</td>
                        <td class="text-sm">{{ $category->name }}</td>
                        <td>{{ $child->listings_count ?? 0 }}</td>
                        <td>{{ $child->sort_order }}</td>
                        <td style="display:flex;gap:0.375rem;">
                            <a href="{{ route('admin.categories.edit', $child) }}" class="btn btn-sm btn-secondary">✏️</a>
                            <form action="{{ route('admin.categories.destroy', $child) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-ghost text-danger" data-confirm="Hapus sub-kategori {{ $child->name }}?">🗑️</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @empty
                <tr><td colspan="7" class="text-center text-muted" style="padding:2rem;">Belum ada kategori.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
