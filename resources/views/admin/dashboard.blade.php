@extends('layouts.admin')
@section('title', 'Dashboard Admin — Tradivo')
@section('content')
<div class="admin-header">
    <h1>📊 Dashboard</h1>
    <span class="text-muted text-sm">Selamat datang, {{ auth()->user()->name }}!</span>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-icon blue">👥</div>
        <div>
            <div class="stat-card-value">{{ $stats['total_users'] }}</div>
            <div class="stat-card-label">Total Pengguna</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon green">📦</div>
        <div>
            <div class="stat-card-value">{{ $stats['active_listings'] }}</div>
            <div class="stat-card-label">Iklan Aktif</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon purple">📋</div>
        <div>
            <div class="stat-card-value">{{ $stats['total_listings'] }}</div>
            <div class="stat-card-label">Total Iklan</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon yellow">✅</div>
        <div>
            <div class="stat-card-value">{{ $stats['sold_listings'] }}</div>
            <div class="stat-card-label">Terjual</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon red">🚩</div>
        <div>
            <div class="stat-card-value">{{ $stats['pending_reports'] }}</div>
            <div class="stat-card-label">Laporan Pending</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon gray">🚫</div>
        <div>
            <div class="stat-card-value">{{ $stats['banned_users'] }}</div>
            <div class="stat-card-label">User Diblokir</div>
        </div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;">
    {{-- Latest Listings --}}
    <div class="table-wrapper">
        <div class="table-header">
            <h3>Iklan Terbaru</h3>
            <a href="{{ route('admin.listings.index') }}" class="btn btn-ghost btn-sm">Lihat Semua</a>
        </div>
        <table>
            <thead><tr><th>Judul</th><th>Penjual</th><th>Harga</th><th>Status</th></tr></thead>
            <tbody>
                @forelse($latestListings as $listing)
                    <tr>
                        <td class="font-semibold">{{ Str::limit($listing->title, 25) }}</td>
                        <td>{{ $listing->user->name }}</td>
                        <td>{{ $listing->formatted_price }}</td>
                        <td><span class="status-badge status-{{ $listing->status }}">{{ ucfirst($listing->status) }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted" style="padding:2rem;">Belum ada iklan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pending Reports --}}
    <div class="table-wrapper">
        <div class="table-header">
            <h3>Laporan Terbaru</h3>
            <a href="{{ route('admin.reports.index') }}" class="btn btn-ghost btn-sm">Lihat Semua</a>
        </div>
        <table>
            <thead><tr><th>Pelapor</th><th>Iklan</th><th>Alasan</th><th>Waktu</th></tr></thead>
            <tbody>
                @forelse($latestReports as $report)
                    <tr>
                        <td>{{ $report->user->name }}</td>
                        <td>{{ Str::limit($report->listing->title ?? '-', 20) }}</td>
                        <td>{{ ucfirst($report->reason) }}</td>
                        <td class="text-muted text-sm">{{ $report->created_at->diffForHumans() }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted" style="padding:2rem;">Tidak ada laporan pending.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
