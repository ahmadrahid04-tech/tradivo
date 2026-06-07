<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'Tradivo — Platform jual beli online terpercaya. Jual dan beli barang baru maupun bekas dengan mudah.')">
    <title>@yield('title', 'Tradivo — Jual Beli Online Terpercaya')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body>
    <a href="#main-content" class="skip-link">Langsung ke konten utama</a>

    {{-- ── NAVBAR ─────────────────────── --}}
    <nav class="navbar" aria-label="Navigasi utama">
        <div class="container">
            <a href="{{ route('home') }}" class="navbar-brand">
                <svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="32" height="32" rx="8" fill="#4f46e5"/>
                    <path d="M8 12h16M8 20h10" stroke="#fff" stroke-width="2.5" stroke-linecap="round"/>
                    <circle cx="24" cy="20" r="3" fill="#34d399"/>
                </svg>
                Tradivo
            </a>

            <ul class="navbar-nav" id="navbar-menu">
                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">🏠 Beranda</a></li>
                <li><a href="{{ route('listings.index') }}" class="{{ request()->routeIs('listings.index') ? 'active' : '' }}">🔍 Jelajahi</a></li>
                @auth
                    <li>
                        <a href="{{ route('conversations.index') }}" class="{{ request()->routeIs('conversations.*') ? 'active' : '' }}">
                            💬 Chat
                            @if(auth()->user()->unreadMessagesCount() > 0)
                                <span class="badge">{{ auth()->user()->unreadMessagesCount() }}</span>
                            @endif
                        </a>
                    </li>
                    <li><a href="{{ route('wishlists.index') }}" class="{{ request()->routeIs('wishlists.*') ? 'active' : '' }}">❤️ Favorit</a></li>
                @endauth
            </ul>

            <div class="navbar-actions">
                @auth
                    <a href="{{ route('listings.create') }}" class="btn btn-primary btn-sm">
                        ➕ Jual Barang
                    </a>

                    <div class="user-dropdown">
                        <button class="user-dropdown-toggle" id="user-dropdown-toggle" aria-expanded="false" aria-haspopup="true">
                            <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}">
                            <span>{{ Str::limit(auth()->user()->name, 12) }}</span>
                            ▾
                        </button>
                        <div class="user-dropdown-menu" id="user-dropdown-menu" role="menu">
                            <a href="{{ route('my-listings') }}" role="menuitem">📦 Iklan Saya</a>
                            <a href="{{ route('profile.edit') }}" role="menuitem">👤 Edit Profil</a>
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" role="menuitem">⚙️ Panel Admin</a>
                            @endif
                            <div class="divider"></div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="text-danger" role="menuitem">🚪 Keluar</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-ghost btn-sm">Masuk</a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Daftar</a>
                @endauth

                <button class="navbar-toggle" id="navbar-toggle" aria-label="Menu navigasi">
                    ☰
                </button>
            </div>
        </div>
    </nav>

    {{-- ── TOAST NOTIFICATIONS ────────── --}}
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

    {{-- ── MAIN CONTENT ──────────────── --}}
    <main id="main-content">
        @yield('content')
    </main>

    {{-- ── FOOTER ────────────────────── --}}
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <a href="{{ route('home') }}" class="footer-brand">Tradivo</a>
                    <p>Platform jual beli online terpercaya. Jual dan beli barang baru maupun bekas dengan mudah, aman, dan cepat.</p>
                </div>
                <div>
                    <h3>Navigasi</h3>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">Beranda</a></li>
                        <li><a href="{{ route('listings.index') }}">Jelajahi</a></li>
                        @auth
                            <li><a href="{{ route('listings.create') }}">Jual Barang</a></li>
                        @endauth
                    </ul>
                </div>
                <div>
                    <h3>Akun</h3>
                    <ul class="footer-links">
                        @auth
                            <li><a href="{{ route('my-listings') }}">Iklan Saya</a></li>
                            <li><a href="{{ route('wishlists.index') }}">Favorit</a></li>
                            <li><a href="{{ route('profile.edit') }}">Pengaturan</a></li>
                        @else
                            <li><a href="{{ route('login') }}">Masuk</a></li>
                            <li><a href="{{ route('register') }}">Daftar</a></li>
                        @endauth
                    </ul>
                </div>
                <div>
                    <h3>Informasi</h3>
                    <ul class="footer-links">
                        <li><a href="#">Tentang Kami</a></li>
                        <li><a href="#">Syarat & Ketentuan</a></li>
                        <li><a href="#">Kebijakan Privasi</a></li>
                        <li><a href="#">Bantuan</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} Tradivo. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
