@extends('layouts.app')

@section('title', 'Iklan Saya — Tradivo')

@section('content')
<section class="section" style="padding-top:2rem;">
    <div class="container">
        <div class="section-header">
            <div>
                <h1 class="section-title">📦 Iklan Saya</h1>
                <p class="section-subtitle">Kelola semua iklan yang Anda pasang</p>
            </div>
            <a href="{{ route('listings.create') }}" class="btn btn-primary">➕ Pasang Iklan Baru</a>
        </div>

        @if($listings->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">📦</div>
                <h3>Belum Ada Iklan</h3>
                <p>Anda belum memasang iklan apapun. Mulai jual barangmu sekarang!</p>
                <a href="{{ route('listings.create') }}" class="btn btn-primary">Pasang Iklan Pertama</a>
            </div>
        @else
            <div class="grid grid-4">
                @foreach($listings as $listing)
                    <article class="card listing-card">
                        <div class="listing-card-image">
                            <a href="{{ route('listings.show', $listing) }}">
                                <img src="{{ $listing->primary_image_url }}" alt="{{ $listing->title }}" loading="lazy">
                            </a>
                            <span class="listing-card-badge {{ $listing->status === 'sold' ? 'badge-sold' : ($listing->condition === 'new' ? 'badge-new' : 'badge-used') }}">
                                @if($listing->status === 'sold') Terjual
                                @elseif($listing->status === 'inactive') Nonaktif
                                @else {{ $listing->condition === 'new' ? 'Baru' : 'Bekas' }}
                                @endif
                            </span>
                        </div>
                        <div class="listing-card-body">
                            <div class="listing-card-price">{{ $listing->formatted_price }}</div>
                            <h3 class="listing-card-title"><a href="{{ route('listings.show', $listing) }}">{{ $listing->title }}</a></h3>
                            <div class="listing-card-meta">
                                <span>👁️ {{ $listing->views_count }}×</span>
                                <span>🕐 {{ $listing->created_at->diffForHumans() }}</span>
                            </div>
                            <div style="display:flex;gap:0.5rem;margin-top:0.75rem;">
                                <a href="{{ route('listings.edit', $listing) }}" class="btn btn-secondary btn-sm" style="flex:1;">✏️ Edit</a>
                                <form action="{{ route('listings.destroy', $listing) }}" method="POST" style="flex:1;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm w-full" data-confirm="Hapus iklan ini?">🗑️</button>
                                </form>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-4">{{ $listings->links() }}</div>
        @endif
    </div>
</section>
@endsection
