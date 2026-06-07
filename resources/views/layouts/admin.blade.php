<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin — Tradivo')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="admin-layout">
        {{-- ── SIDEBAR ───────────────── --}}
        <aside class="admin-sidebar" id="admin-sidebar">
            <div class="admin-sidebar-brand">
                Tradivo <small>Admin</small>
            </div>

            <ul class="admin-nav">
                <li class="admin-nav-section">Menu Utama</li>
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        📊 Dashboard
                    </a>
                </li>

                <li class="admin-nav-section">Manajemen</li>
                <li>
                    <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        👥 Pengguna
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.listings.index') }}" class="{{ request()->routeIs('admin.listings.*') ? 'active' : '' }}">
                        📦 Iklan
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        📂 Kategori
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.reports.index') }}" class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                        🚩 Laporan
                        @php $pendingReports = \App\Models\Report::pending()->count(); @endphp
                        @if($pendingReports > 0)
                            <span class="nav-badge">{{ $pendingReports }}</span>
                        @endif
                    </a>
                </li>

                <li class="admin-nav-section">Lainnya</li>
                <li>
                    <a href="{{ route('home') }}">
                        🌐 Lihat Website
                    </a>
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" style="all:unset;cursor:pointer;display:flex;align-items:center;gap:0.75rem;padding:0.625rem 1.5rem;color:var(--gray-400);font-size:0.875rem;font-weight:500;width:100%;border-left:3px solid transparent;">
                            🚪 Keluar
                        </button>
                    </form>
                </li>
            </ul>
        </aside>

        {{-- ── MAIN CONTENT ──────────── --}}
        <div class="admin-content">
            {{-- Mobile toggle --}}
            <button class="btn btn-secondary btn-sm mb-3" id="admin-sidebar-toggle" style="display:none;">
                ☰ Menu
            </button>

            {{-- Toast --}}
            <div id="toast-container" class="toast-container">
                @foreach(['success', 'error', 'warning'] as $type)
                    @if(session($type))
                        <div class="toast toast-{{ $type }}">
                            <span>{{ session($type) }}</span>
                            <button class="toast-close" aria-label="Tutup">&times;</button>
                        </div>
                    @endif
                @endforeach
            </div>

            @yield('content')
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')

    <style>
        @media (max-width: 768px) {
            #admin-sidebar-toggle { display: inline-flex !important; }
        }
    </style>
</body>
</html>
