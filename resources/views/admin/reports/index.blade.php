@extends('layouts.admin')
@section('title', 'Laporan — Tradivo')
@section('content')
<div class="admin-header">
    <h1>🚩 Laporan Iklan</h1>
</div>
<div class="table-wrapper">
    <div class="table-header">
        <div style="display:flex;gap:0.5rem;">
            <a href="{{ route('admin.reports.index') }}" class="btn btn-sm {{ !request('status') ? 'btn-primary' : 'btn-secondary' }}">Pending</a>
            <a href="{{ route('admin.reports.index', ['status'=>'reviewed']) }}" class="btn btn-sm {{ request('status')==='reviewed' ? 'btn-primary' : 'btn-secondary' }}">Reviewed</a>
            <a href="{{ route('admin.reports.index', ['status'=>'resolved']) }}" class="btn btn-sm {{ request('status')==='resolved' ? 'btn-primary' : 'btn-secondary' }}">Resolved</a>
        </div>
    </div>
    <table>
        <thead><tr><th>Pelapor</th><th>Iklan</th><th>Alasan</th><th>Status</th><th>Waktu</th><th>Aksi</th></tr></thead>
        <tbody>
            @forelse($reports as $report)
                <tr>
                    <td class="font-semibold">{{ $report->user->name }}</td>
                    <td><a href="{{ route('listings.show', $report->listing_id) }}">{{ Str::limit($report->listing->title ?? 'Dihapus', 25) }}</a></td>
                    <td>{{ ucfirst($report->reason) }}</td>
                    <td><span class="status-badge status-{{ $report->status }}">{{ ucfirst($report->status) }}</span></td>
                    <td class="text-muted text-sm">{{ $report->created_at->diffForHumans() }}</td>
                    <td style="display:flex;gap:0.375rem;">
                        <a href="{{ route('admin.reports.show', $report) }}" class="btn btn-sm btn-secondary">👁️</a>
                        <form action="{{ route('admin.reports.update', $report) }}" method="POST" style="display:flex;gap:0.25rem;">
                            @csrf @method('PATCH')
                            <select name="status" class="form-control" style="font-size:0.75rem;padding:0.25rem 0.5rem;" onchange="this.form.submit()">
                                <option value="pending" {{ $report->status==='pending'?'selected':'' }}>Pending</option>
                                <option value="reviewed" {{ $report->status==='reviewed'?'selected':'' }}>Reviewed</option>
                                <option value="resolved" {{ $report->status==='resolved'?'selected':'' }}>Resolved</option>
                            </select>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted" style="padding:2rem;">Tidak ada laporan.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-3">{{ $reports->links() }}</div>
@endsection
