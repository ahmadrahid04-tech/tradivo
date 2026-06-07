@extends('layouts.admin')
@section('title', 'Detail Laporan — Tradivo')
@section('content')
<div class="admin-header">
    <h1>🚩 Detail Laporan #{{ $report->id }}</h1>
    <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary btn-sm">← Kembali</a>
</div>
<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;max-width:900px;">
    <div class="card" style="padding:1.5rem;">
        <h3 style="font-weight:700;margin-bottom:1rem;">Informasi Laporan</h3>
        <ul class="listing-meta-list">
            <li><strong>Pelapor</strong> {{ $report->user->name }}</li>
            <li><strong>Alasan</strong> {{ ucfirst($report->reason) }}</li>
            <li><strong>Status</strong> <span class="status-badge status-{{ $report->status }}">{{ ucfirst($report->status) }}</span></li>
            <li><strong>Tanggal</strong> {{ $report->created_at->format('d M Y H:i') }}</li>
        </ul>
        @if($report->description)
            <div style="margin-top:1rem;padding:1rem;background:var(--gray-50);border-radius:var(--radius-md);">
                <p class="text-sm font-bold mb-2">Deskripsi:</p>
                <p class="text-sm" style="line-height:1.6;">{{ $report->description }}</p>
            </div>
        @endif
        <form action="{{ route('admin.reports.update', $report) }}" method="POST" class="mt-4" style="display:flex;gap:0.5rem;">
            @csrf @method('PATCH')
            <select name="status" class="form-control">
                <option value="pending" {{ $report->status==='pending'?'selected':'' }}>Pending</option>
                <option value="reviewed" {{ $report->status==='reviewed'?'selected':'' }}>Reviewed</option>
                <option value="resolved" {{ $report->status==='resolved'?'selected':'' }}>Resolved</option>
            </select>
            <button type="submit" class="btn btn-primary btn-sm">Update</button>
        </form>
    </div>
    <div class="card" style="padding:1.5rem;">
        <h3 style="font-weight:700;margin-bottom:1rem;">Iklan Dilaporkan</h3>
        @if($report->listing)
            <div style="display:flex;gap:0.75rem;align-items:start;">
                @if($report->listing->images->count() > 0)
                    <img src="{{ $report->listing->primary_image_url }}" alt="" style="width:80px;height:80px;border-radius:var(--radius-md);object-fit:cover;">
                @endif
                <div>
                    <a href="{{ route('listings.show', $report->listing) }}" class="font-bold">{{ $report->listing->title }}</a>
                    <div class="text-sm text-primary font-bold mt-1">{{ $report->listing->formatted_price }}</div>
                    <div class="text-xs text-muted mt-1">Oleh: {{ $report->listing->user->name }}</div>
                </div>
            </div>
            <div class="mt-3" style="display:flex;gap:0.5rem;">
                <form action="{{ route('admin.listings.status', $report->listing) }}" method="POST">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="inactive">
                    <button type="submit" class="btn btn-danger btn-sm" data-confirm="Nonaktifkan iklan ini?">🚫 Nonaktifkan Iklan</button>
                </form>
                <form action="{{ route('admin.listings.destroy', $report->listing) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-ghost btn-sm text-danger" data-confirm="Hapus iklan ini secara permanen?">🗑️ Hapus</button>
                </form>
            </div>
        @else
            <p class="text-muted">Iklan sudah dihapus.</p>
        @endif
    </div>
</div>
@endsection
