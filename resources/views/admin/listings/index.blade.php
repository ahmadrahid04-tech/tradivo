@extends('layouts.admin')
@section('title', 'Kelola Iklan — Tradivo')
@section('content')
<div class="admin-header">
    <h1>📦 Kelola Iklan</h1>
</div>
<div class="table-wrapper">
    <div class="table-header">
        <form action="{{ route('admin.listings.index') }}" method="GET" style="display:flex;gap:0.5rem;">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari iklan..." style="max-width:250px;">
            <select name="status" class="form-control" style="max-width:150px;" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="active" {{ request('status')==='active'?'selected':'' }}>Aktif</option>
                <option value="sold" {{ request('status')==='sold'?'selected':'' }}>Terjual</option>
                <option value="inactive" {{ request('status')==='inactive'?'selected':'' }}>Nonaktif</option>
                <option value="pending" {{ request('status')==='pending'?'selected':'' }}>Pending</option>
            </select>
            <button type="submit" class="btn btn-primary btn-sm">Cari</button>
        </form>
    </div>
    <table>
        <thead><tr><th>Foto</th><th>Judul</th><th>Penjual</th><th>Harga</th><th>Kategori</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
            @forelse($listings as $listing)
                <tr>
                    <td>
                        <img src="{{ $listing->primary_image_url }}" alt="" style="width:48px;height:48px;border-radius:var(--radius-sm);object-fit:cover;">
                    </td>
                    <td class="font-semibold"><a href="{{ route('listings.show', $listing) }}">{{ Str::limit($listing->title, 30) }}</a></td>
                    <td>{{ $listing->user->name }}</td>
                    <td>{{ $listing->formatted_price }}</td>
                    <td>{{ $listing->category?->name ?? '-' }}</td>
                    <td><span class="status-badge status-{{ $listing->status }}">{{ ucfirst($listing->status) }}</span></td>
                    <td style="display:flex;gap:0.375rem;">
                        <form action="{{ route('admin.listings.status', $listing) }}" method="POST" style="display:flex;gap:0.25rem;">
                            @csrf @method('PATCH')
                            <select name="status" class="form-control" style="font-size:0.75rem;padding:0.25rem 0.5rem;min-width:90px;" onchange="this.form.submit()">
                                <option value="active" {{ $listing->status==='active'?'selected':'' }}>Aktif</option>
                                <option value="sold" {{ $listing->status==='sold'?'selected':'' }}>Terjual</option>
                                <option value="inactive" {{ $listing->status==='inactive'?'selected':'' }}>Nonaktif</option>
                                <option value="pending" {{ $listing->status==='pending'?'selected':'' }}>Pending</option>
                            </select>
                        </form>
                        <form action="{{ route('admin.listings.destroy', $listing) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-ghost text-danger" data-confirm="Hapus iklan ini?">🗑️</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted" style="padding:2rem;">Tidak ada iklan.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-3">{{ $listings->links() }}</div>
@endsection
