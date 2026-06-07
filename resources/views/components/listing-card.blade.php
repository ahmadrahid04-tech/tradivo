<article class="card listing-card">
    <div class="listing-card-image">
        <a href="{{ route('listings.show', $listing) }}">
            <img src="{{ $listing->primary_image_url }}" alt="{{ $listing->title }}" loading="lazy">
        </a>
        <span class="listing-card-badge {{ $listing->condition === 'new' ? 'badge-new' : 'badge-used' }}">
            {{ $listing->condition === 'new' ? 'Baru' : 'Bekas' }}
        </span>
        @auth
            @if($listing->user_id !== auth()->id())
                <button
                    class="listing-card-wishlist wishlist-toggle {{ $listing->isWishlistedBy(auth()->user()) ? 'active' : '' }}"
                    data-url="{{ route('wishlist.toggle', $listing) }}"
                    aria-label="Tambah ke favorit"
                >
                    <span>{{ $listing->isWishlistedBy(auth()->user()) ? '♥' : '♡' }}</span>
                </button>
            @endif
        @endauth
    </div>
    <div class="listing-card-body">
        <div class="listing-card-price">{{ $listing->formatted_price }}</div>
        <h3 class="listing-card-title">
            <a href="{{ route('listings.show', $listing) }}">{{ $listing->title }}</a>
        </h3>
        <div class="listing-card-meta">
            <span>📍 {{ Str::limit($listing->location, 20) }}</span>
            <span>🕐 {{ $listing->created_at->diffForHumans() }}</span>
        </div>
    </div>
</article>
