@extends('layouts.app')

@section('title', 'Jelajahi Iklan — Tradivo')

@section('content')
<section class="section" style="padding-top:2rem;">
    <div class="container">
        <div class="section-header">
            <div>
                <h1 class="section-title">Jelajahi Iklan</h1>
                <p class="section-subtitle">Temukan barang yang Anda cari</p>
            </div>
        </div>

        <div class="browse-layout">
            {{-- Filter Sidebar --}}
            <aside class="filter-sidebar">
                <form action="{{ route('listings.index') }}" method="GET">
                    @if(request('keyword'))
                        <input type="hidden" name="keyword" value="{{ request('keyword') }}">
                    @endif

                    <div class="filter-section">
                        <h3>Kategori</h3>
                        @foreach($categories as $cat)
                            <label class="filter-option">
                                <input type="radio" name="category" value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'checked' : '' }}>
                                {{ $cat->name }}
                            </label>
                            @foreach($cat->children as $child)
                                <label class="filter-option" style="padding-left:1.25rem;">
                                    <input type="radio" name="category" value="{{ $child->id }}" {{ request('category') == $child->id ? 'checked' : '' }}>
                                    {{ $child->name }}
                                </label>
                            @endforeach
                        @endforeach
                        <label class="filter-option">
                            <input type="radio" name="category" value="" {{ !request('category') ? 'checked' : '' }}>
                            Semua Kategori
                        </label>
                    </div>

                    <div class="filter-section">
                        <h3>Kondisi</h3>
                        <label class="filter-option">
                            <input type="radio" name="condition" value="" {{ !request('condition') ? 'checked' : '' }}>
                            Semua
                        </label>
                        <label class="filter-option">
                            <input type="radio" name="condition" value="new" {{ request('condition') === 'new' ? 'checked' : '' }}>
                            Baru
                        </label>
                        <label class="filter-option">
                            <input type="radio" name="condition" value="used" {{ request('condition') === 'used' ? 'checked' : '' }}>
                            Bekas
                        </label>
                    </div>

                    <div class="filter-section">
                        <h3>Rentang Harga</h3>
                        <div class="price-range">
                            <input type="number" name="price_min" value="{{ request('price_min') }}" class="form-control" placeholder="Min">
                            <span>—</span>
                            <input type="number" name="price_max" value="{{ request('price_max') }}" class="form-control" placeholder="Max">
                        </div>
                    </div>

                    <div class="filter-section">
                        <h3>Lokasi</h3>
                        <input type="text" name="location" value="{{ request('location') }}" class="form-control" placeholder="Cari lokasi...">
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Terapkan Filter</button>
                    <a href="{{ route('listings.index') }}" class="btn btn-ghost btn-block mt-2" style="text-align:center;">Reset Filter</a>
                </form>
            </aside>

            {{-- Listings Grid --}}
            <div>
                <div class="search-bar">
                    <form action="{{ route('listings.index') }}" method="GET" style="display:flex; gap:0.5rem; width:100%;">
                        <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control" placeholder="Cari barang..." aria-label="Cari barang">
                        <button type="submit" class="btn btn-primary">🔍 Cari</button>
                    </form>
                </div>

                <div class="sort-controls">
                    <label>Urutkan:</label>
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'latest']) }}" class="btn btn-sm {{ request('sort', 'latest') === 'latest' ? 'btn-primary' : 'btn-secondary' }}">Terbaru</a>
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}" class="btn btn-sm {{ request('sort') === 'price_asc' ? 'btn-primary' : 'btn-secondary' }}">Termurah</a>
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}" class="btn btn-sm {{ request('sort') === 'price_desc' ? 'btn-primary' : 'btn-secondary' }}">Termahal</a>
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'popular']) }}" class="btn btn-sm {{ request('sort') === 'popular' ? 'btn-primary' : 'btn-secondary' }}">Populer</a>
                    <span class="results-count">{{ $listings->total() }} hasil</span>
                </div>

                @if($listings->isEmpty())
                    <div class="empty-state">
                        <div class="empty-state-icon">🔍</div>
                        <h3>Tidak Ada Hasil</h3>
                        <p>Coba ubah kata kunci atau filter pencarian Anda.</p>
                        <a href="{{ route('listings.index') }}" class="btn btn-secondary">Reset Pencarian</a>
                    </div>
                @else
                    <div class="grid grid-3">
                        @foreach($listings as $listing)
                            @include('components.listing-card', ['listing' => $listing])
                        @endforeach
                    </div>

                    <div class="mt-4">
                        {{ $listings->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
