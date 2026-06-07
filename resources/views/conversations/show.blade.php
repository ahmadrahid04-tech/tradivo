@extends('layouts.app')
@section('title', 'Chat — Tradivo')
@section('content')
<section class="section" style="padding-top:1.5rem;">
    <div class="container" style="max-width:800px;">
        <a href="{{ route('conversations.index') }}" class="btn btn-ghost btn-sm mb-3">← Kembali ke Pesan</a>

        {{-- Listing info --}}
        <div class="card mb-3" style="padding:1rem;">
            <div style="display:flex;align-items:center;gap:0.75rem;">
                @if($conversation->listing->images->count() > 0)
                    <img src="{{ $conversation->listing->primary_image_url }}" alt="" style="width:56px;height:56px;border-radius:var(--radius-md);object-fit:cover;">
                @endif
                <div style="flex:1;">
                    <a href="{{ route('listings.show', $conversation->listing) }}" class="font-bold" style="font-size:0.9375rem;">{{ $conversation->listing->title }}</a>
                    <div class="text-sm text-primary font-bold">{{ $conversation->listing->formatted_price }}</div>
                </div>
            </div>
        </div>

        @php $other = $conversation->getOtherParticipant(auth()->user()); @endphp

        {{-- Chat header --}}
        <div class="card" style="overflow:hidden;">
            <div style="padding:1rem;border-bottom:1px solid var(--border-light);display:flex;align-items:center;gap:0.75rem;">
                <img src="{{ $other->avatar_url }}" alt="{{ $other->name }}" style="width:40px;height:40px;border-radius:50%;object-fit:cover;">
                <div>
                    <a href="{{ route('user.profile', $other) }}" class="font-bold">{{ $other->name }}</a>
                    <div class="text-xs text-muted">{{ $conversation->buyer_id === auth()->id() ? 'Penjual' : 'Pembeli' }}</div>
                </div>
            </div>

            {{-- Messages --}}
            <div class="chat-messages" id="chat-messages">
                @forelse($conversation->messages as $message)
                    <div class="chat-bubble {{ $message->sender_id === auth()->id() ? 'sent' : 'received' }}">
                        {{ $message->body }}
                        <div class="chat-bubble-time">{{ $message->created_at->format('H:i') }}</div>
                    </div>
                @empty
                    <div class="empty-state" style="padding:2rem;">
                        <p class="text-muted">Belum ada pesan. Mulai percakapan!</p>
                    </div>
                @endforelse
            </div>

            {{-- Send Message --}}
            <form action="{{ route('messages.store') }}" method="POST" class="chat-input">
                @csrf
                <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
                <input type="text" name="body" class="form-control" placeholder="Ketik pesan..." required maxlength="2000" autofocus autocomplete="off">
                <button type="submit" class="btn btn-primary">Kirim</button>
            </form>
        </div>
    </div>
</section>
@endsection
