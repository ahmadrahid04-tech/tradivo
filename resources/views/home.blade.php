@extends('layouts.app')

@section('title', 'Tradivo — Jual Beli Online Terpercaya')
@section('meta_description', 'Tradivo adalah platform marketplace terpercaya untuk jual beli barang baru dan bekas. Temukan penawaran terbaik sekarang!')

@section('content')
    {{-- ── HERO SECTION ──────────────── --}}
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h1>Jual Beli Lebih Mudah di <span style="color: var(--accent-400)">Tradivo</span></h1>
                <p>Temukan jutaan barang baru & bekas dengan harga terbaik. Mulai jual barangmu sekarang — gratis, cepat, dan aman.</p>

                <form action="{{ route('listings.index') }}" method="GET" class="search-hero">
                    <input type="text" name="keyword" placeholder="Cari barang, misalnya: iPhone, Motor, Laptop..." aria-label="Cari barang">
                    <button type="submit">🔍 Cari</button>
                </form>

                <div class="hero-stats">
                    <div class="hero-stat">
                        <span class="hero-stat-number">{{ number_format($totalListings) }}+</span>
                        <span class="hero-stat-label">Iklan Aktif</span>
                    </div>
                    <div class="hero-stat">
                        <span class="hero-stat-number">{{ number_format(\App\Models\User::where('role','user')->count()) }}+</span>
                        <span class="hero-stat-label">Pengguna</span>
                    </div>
                    <div class="hero-stat">
                        <span class="hero-stat-number">{{ $categories->count() }}</span>
                        <span class="hero-stat-label">Kategori</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ── CATEGORIES ────────────────── --}}
    <section class="section">
        <div class="container">
            <div class="section-header">
                <div>
                    <h2 class="section-title">Kategori Populer</h2>
                    <p class="section-subtitle">Jelajahi berdasarkan kategori yang tersedia</p>
                </div>
                <a href="{{ route('listings.index') }}" class="btn btn-secondary btn-sm">Lihat Semua →</a>
            </div>

            <div class="category-grid">
                @foreach($categories as $category)
                    <a href="{{ route('listings.index', ['category' => $category->id]) }}" class="category-card">
                        <div class="category-card-icon">
                            {{ $category->icon ?? '📦' }}
                        </div>
                        <span class="category-card-name">{{ $category->name }}</span>
                        <span class="category-card-count">{{ $category->listings_count }} iklan</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── FEATURED LISTINGS ─────────── --}}
    <section class="section" style="background: var(--gray-50); padding-top: 3rem; padding-bottom: 3rem;">
        <div class="container">
            <div class="section-header">
                <div>
                    <h2 class="section-title">Iklan Terbaru</h2>
                    <p class="section-subtitle">Penawaran terbaru dari seluruh pengguna</p>
                </div>
                <a href="{{ route('listings.index') }}" class="btn btn-secondary btn-sm">Lihat Semua →</a>
            </div>

            @if($featuredListings->isEmpty())
                <div class="empty-state">
                    <div class="empty-state-icon">📦</div>
                    <h3>Belum Ada Iklan</h3>
                    <p>Jadilah yang pertama memasang iklan di Tradivo!</p>
                    @auth
                        <a href="{{ route('listings.create') }}" class="btn btn-primary">Pasang Iklan Sekarang</a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-primary">Daftar & Mulai Jual</a>
                    @endauth
                </div>
            @else
                <div class="grid grid-4">
                    @foreach($featuredListings as $listing)
                        @include('components.listing-card', ['listing' => $listing])
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- ── CTA SECTION ───────────────── --}}
    @guest
        <section class="section" style="text-align:center;">
            <div class="container">
                <h2 class="section-title mb-2">Siap Mulai Berjualan?</h2>
                <p class="section-subtitle mb-4">Daftar sekarang dan mulai jual barangmu ke jutaan orang.</p>
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Daftar Gratis 🚀</a>
            </div>
        </section>
    @endguest
@endsection
