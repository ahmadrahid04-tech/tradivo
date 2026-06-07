@extends('layouts.app')
@section('title', 'Favorit — Tradivo')
@section('content')
<section class="section" style="padding-top:2rem;">
    <div class="container">
        <h1 class="section-title mb-4">❤️ Favorit Saya</h1>
        @if($wishlists->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">❤️</div>
                <h3>Belum Ada Favorit</h3>
                <p>Simpan iklan yang Anda suka agar mudah ditemukan kembali.</p>
                <a href="{{ route('listings.index') }}" class="btn btn-primary">Jelajahi Iklan</a>
            </div>
        @else
            <div class="grid grid-4">
                @foreach($wishlists as $wishlist)
                    @if($wishlist->listing)
                        @include('components.listing-card', ['listing' => $wishlist->listing])
                    @endif
                @endforeach
            </div>
            <div class="mt-4">{{ $wishlists->links() }}</div>
        @endif
    </div>
</section>
@endsection
