@extends('layouts.app')
@section('title', 'Chat — Tradivo')
@section('content')
<section class="section" style="padding-top:2rem;">
    <div class="container" style="max-width:800px;">
        <h1 class="section-title mb-4">💬 Pesan</h1>
        <div class="card">
            @if($conversations->isEmpty())
                <div class="empty-state">
                    <div class="empty-state-icon">💬</div>
                    <h3>Belum Ada Percakapan</h3>
                    <p>Mulai percakapan dengan menghubungi penjual di halaman iklan.</p>
                    <a href="{{ route('listings.index') }}" class="btn btn-primary">Jelajahi Iklan</a>
                </div>
            @else
                <div class="chat-list">
                    @foreach($conversations as $conversation)
                        @php $other = $conversation->getOtherParticipant(auth()->user()); @endphp
                        <a href="{{ route('conversations.show', $conversation) }}" class="chat-item {{ $conversation->unreadCountFor(auth()->user()) > 0 ? 'unread' : '' }}">
                            <img src="{{ $other->avatar_url }}" alt="{{ $other->name }}" class="chat-item-avatar">
                            <div class="chat-item-content">
                                <div class="chat-item-header">
                                    <span class="chat-item-name">{{ $other->name }}</span>
                                    <span class="chat-item-time">
                                        {{ $conversation->latestMessage?->created_at?->diffForHumans() ?? '' }}
                                    </span>
                                </div>
                                <div class="chat-item-preview" style="margin-bottom:0.25rem;">
                                    📦 {{ Str::limit($conversation->listing->title, 35) }}
                                </div>
                                <div class="chat-item-preview">
                                    @if($conversation->latestMessage)
                                        {{ $conversation->latestMessage->sender_id === auth()->id() ? 'Anda: ' : '' }}{{ Str::limit($conversation->latestMessage->body, 50) }}
                                    @endif
                                </div>
                            </div>
                            @if($conversation->unreadCountFor(auth()->user()) > 0)
                                <span class="badge" style="align-self:center;">{{ $conversation->unreadCountFor(auth()->user()) }}</span>
                            @endif
                        </a>
                    @endforeach
                </div>
                <div class="mt-3" style="padding:1rem;">{{ $conversations->links() }}</div>
            @endif
        </div>
    </div>
</section>
@endsection
