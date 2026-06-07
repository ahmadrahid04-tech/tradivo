@extends('layouts.app')
@section('title', $user->name . ' — Tradivo')
@section('content')
<section class="section" style="padding-top:2rem;">
    <div class="container">
        <div class="profile-header">
            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="profile-avatar-lg">
            <div>
                <h1 class="profile-name">{{ $user->name }}</h1>
                @if($user->bio)<p class="profile-bio">{{ $user->bio }}</p>@endif
                <div class="profile-meta">
                    @if($user->location)<span>📍 {{ $user->location }}</span>@endif
                    <span>📅 Bergabung {{ $user->created_at->format('M Y') }}</span>
                    <span>📦 {{ $listings->total() }} iklan aktif</span>
                </div>
            </div>
        </div>
        <h2 class="section-title mb-4">Iklan dari {{ $user->name }}</h2>
        @if($listings->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">📦</div>
                <h3>Belum Ada Iklan</h3>
                <p>Pengguna ini belum memasang iklan.</p>
            </div>
        @else
            <div class="grid grid-4">
                @foreach($listings as $listing)
                    @include('components.listing-card', ['listing' => $listing])
                @endforeach
            </div>
            <div class="mt-4">{{ $listings->links() }}</div>
        @endif
    </div>
</section>
@endsection
