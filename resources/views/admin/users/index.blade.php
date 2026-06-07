@extends('layouts.admin')
@section('title', 'Kelola Pengguna — Tradivo')
@section('content')
<div class="admin-header">
    <h1>👥 Kelola Pengguna</h1>
</div>
<div class="table-wrapper">
    <div class="table-header">
        <form action="{{ route('admin.users.index') }}" method="GET" style="display:flex;gap:0.5rem;">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari user..." style="max-width:250px;">
            <select name="status" class="form-control" style="max-width:150px;" onchange="this.form.submit()">
                <option value="">Semua</option>
                <option value="active" {{ request('status')==='active'?'selected':'' }}>Aktif</option>
                <option value="banned" {{ request('status')==='banned'?'selected':'' }}>Diblokir</option>
            </select>
            <button type="submit" class="btn btn-primary btn-sm">Cari</button>
        </form>
    </div>
    <table>
        <thead><tr><th>Nama</th><th>Email</th><th>Lokasi</th><th>Iklan</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td class="font-semibold">{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->location ?? '-' }}</td>
                    <td>{{ $user->listings_count }}</td>
                    <td>
                        @if($user->is_banned)
                            <span class="status-badge status-banned">Diblokir</span>
                        @else
                            <span class="status-badge status-active">Aktif</span>
                        @endif
                    </td>
                    <td style="display:flex;gap:0.375rem;">
                        <form action="{{ route('admin.users.ban', $user) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-sm {{ $user->is_banned ? 'btn-accent' : 'btn-danger' }}" data-confirm="{{ $user->is_banned ? 'Aktifkan kembali user ini?' : 'Blokir user ini?' }}">
                                {{ $user->is_banned ? '✅ Unban' : '🚫 Ban' }}
                            </button>
                        </form>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-ghost text-danger" data-confirm="Yakin hapus user {{ $user->name }}? Semua data akan hilang.">🗑️</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted" style="padding:2rem;">Tidak ada pengguna ditemukan.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-3">{{ $users->links() }}</div>
@endsection
