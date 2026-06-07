@extends('layouts.app')

@section('title', $listing->title . ' — Tradivo')
@section('meta_description', Str::limit($listing->description, 160))

@section('content')
<section class="section" style="padding-top:1.5rem;">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ route('home') }}">Beranda</a></li>
            <li class="separator">›</li>
            <li><a href="{{ route('listings.index') }}">Iklan</a></li>
            @if($listing->category)
                <li class="separator">›</li>
                <li><a href="{{ route('listings.index', ['category' => $listing->category_id]) }}">{{ $listing->category->name }}</a></li>
            @endif
            <li class="separator">›</li>
            <li class="current">{{ Str::limit($listing->title, 40) }}</li>
        </ul>

        <div class="listing-detail">
            {{-- Left: Gallery & Description --}}
            <div>
                <div class="gallery card">
                    <div class="gallery-main">
                        @if($listing->images->count() > 0)
                            <img id="gallery-main-img" src="{{ $listing->images->first()->url }}" alt="{{ $listing->title }}">
                        @else
                            <img src="{{ asset('images/no-image.png') }}" alt="Tidak ada gambar">
                        @endif
                    </div>
                    @if($listing->images->count() > 1)
                        <div class="gallery-thumbnails">
                            @foreach($listing->images as $index => $image)
                                <div class="gallery-thumb {{ $index === 0 ? 'active' : '' }}" data-src="{{ $image->url }}" data-alt="{{ $listing->title }} - Foto {{ $index + 1 }}">
                                    <img src="{{ $image->url }}" alt="Thumbnail {{ $index + 1 }}">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Description --}}
                <div class="card mt-4" style="padding:1.5rem;">
                    <h2 style="font-size:1.125rem; font-weight:700; margin-bottom:1rem;">Deskripsi</h2>
                    <div style="color:var(--text-secondary); line-height:1.8; white-space:pre-line;">{{ $listing->description }}</div>
                </div>

                {{-- Views counter --}}
                <p class="text-muted text-sm mt-3">👁️ Dilihat {{ $listing->views_count }} kali · Diposting {{ $listing->created_at->diffForHumans() }}</p>
            </div>

            {{-- Right: Seller & Actions --}}
            <div>
                <div class="seller-card">
                    <div class="listing-price-detail">{{ $listing->formatted_price }}</div>
                    <h1 style="font-size:1.25rem; font-weight:700; margin-bottom:1rem; line-height:1.4;">{{ $listing->title }}</h1>

                    <ul class="listing-meta-list">
                        <li><strong>Kondisi</strong> {{ $listing->condition === 'new' ? 'Baru' : 'Bekas' }}</li>
                        <li><strong>Kategori</strong> {{ $listing->category?->name ?? '-' }}</li>
                        <li><strong>Lokasi</strong> 📍 {{ $listing->location }}</li>
                        <li><strong>Status</strong>
                            <span class="status-badge status-{{ $listing->status }}">{{ ucfirst($listing->status) }}</span>
                        </li>
                    </ul>

                    {{-- Actions --}}
                    <div style="display:flex; flex-direction:column; gap:0.5rem; margin-bottom:1.5rem;">
                        @auth
                            @if($listing->user_id !== auth()->id() && $listing->status === 'active')
                                <form action="{{ route('conversations.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="listing_id" value="{{ $listing->id }}">
                                    <input type="hidden" name="message" value="Halo, saya tertarik dengan {{ $listing->title }}. Apakah masih tersedia?">
                                    <button type="submit" class="btn btn-primary btn-block btn-lg">💬 Chat Penjual</button>
                                </form>

                                <form action="{{ route('wishlist.toggle', $listing) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn {{ $isWishlisted ? 'btn-danger' : 'btn-secondary' }} btn-block">
                                        {{ $isWishlisted ? '♥ Hapus dari Favorit' : '♡ Simpan ke Favorit' }}
                                    </button>
                                </form>
                            @elseif($listing->user_id === auth()->id())
                                <a href="{{ route('listings.edit', $listing) }}" class="btn btn-secondary btn-block">✏️ Edit Iklan</a>
                                <form action="{{ route('listings.destroy', $listing) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-block" data-confirm="Yakin ingin menghapus iklan ini?">🗑️ Hapus Iklan</button>
                                </form>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary btn-block btn-lg">Masuk untuk Chat</a>
                        @endauth
                    </div>

                    {{-- Seller Info --}}
                    <div style="border-top:1px solid var(--border-light); padding-top:1rem;">
                        <p style="font-size:0.8rem; color:var(--text-muted); margin-bottom:0.75rem; text-transform:uppercase; letter-spacing:0.05em; font-weight:700;">Penjual</p>
                        <a href="{{ route('user.profile', $listing->user) }}" class="seller-info" style="text-decoration:none; color:inherit;">
                            <img src="{{ $listing->user->avatar_url }}" alt="{{ $listing->user->name }}" class="seller-avatar">
                            <div>
                                <div class="seller-name">{{ $listing->user->name }}</div>
                                <div class="seller-joined">Bergabung {{ $listing->user->created_at->diffForHumans() }}</div>
                            </div>
                        </a>
                    </div>

                    {{-- Report --}}
                    @auth
                        @if($listing->user_id !== auth()->id())
                            <div style="border-top:1px solid var(--border-light); padding-top:1rem; margin-top:1rem;">
                                <button class="btn btn-ghost btn-sm w-full" id="report-btn">🚩 Laporkan Iklan</button>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
        </div>

        {{-- Related Listings --}}
        @if($relatedListings->isNotEmpty())
            <div class="section" style="padding-top:3rem;">
                <h2 class="section-title mb-4">Iklan Serupa</h2>
                <div class="grid grid-4">
                    @foreach($relatedListings as $related)
                        @include('components.listing-card', ['listing' => $related])
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>

{{-- Report Modal --}}
@auth
<div class="modal-backdrop" id="report-modal">
    <div class="modal">
        <div class="modal-header">
            <h3>🚩 Laporkan Iklan</h3>
            <button class="modal-close" id="report-modal-close">&times;</button>
        </div>
        <form action="{{ route('reports.store', $listing) }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Alasan Laporan <span class="required">*</span></label>
                    <select name="reason" class="form-control" required>
                        <option value="">Pilih alasan...</option>
                        <option value="spam">Spam / Iklan berulang</option>
                        <option value="prohibited">Barang terlarang</option>
                        <option value="fraud">Penipuan</option>
                        <option value="duplicate">Duplikat</option>
                        <option value="other">Lainnya</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Deskripsi Tambahan</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Jelaskan lebih detail (opsional)..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="report-modal-close">Batal</button>
                <button type="submit" class="btn btn-danger">Kirim Laporan</button>
            </div>
        </form>
    </div>
</div>
@endauth
@endsection
