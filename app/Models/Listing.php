<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'price',
        'location',
        'condition',
        'status',
        'views_count',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'views_count' => 'integer',
        ];
    }

    /* ── Accessors ───────────────────────── */

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getPrimaryImageUrlAttribute(): string
    {
        $primary = $this->images()->where('is_primary', true)->first();
        if ($primary) {
            return filter_var($primary->image_path, FILTER_VALIDATE_URL)
                ? $primary->image_path
                : asset('storage/' . $primary->image_path);
        }
        $first = $this->images()->first();
        if ($first) {
            return filter_var($first->image_path, FILTER_VALIDATE_URL)
                ? $first->image_path
                : asset('storage/' . $first->image_path);
        }
        return asset('images/no-image.png');
    }

    /* ── Relationships ───────────────────── */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ListingImage::class)->orderBy('sort_order');
    }

    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    /* ── Scopes ──────────────────────────── */

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeSearch($query, ?string $keyword)
    {
        if ($keyword) {
            return $query->where(function ($q) use ($keyword) {
                $q->where('title', 'LIKE', "%{$keyword}%")
                  ->orWhere('description', 'LIKE', "%{$keyword}%");
            });
        }
        return $query;
    }

    public function scopeFilterCategory($query, $categoryId)
    {
        if ($categoryId) {
            return $query->where('category_id', $categoryId);
        }
        return $query;
    }

    public function scopeFilterCondition($query, $condition)
    {
        if ($condition && in_array($condition, ['new', 'used'])) {
            return $query->where('condition', $condition);
        }
        return $query;
    }

    public function scopeFilterPriceRange($query, $min, $max)
    {
        if ($min) {
            $query->where('price', '>=', $min);
        }
        if ($max) {
            $query->where('price', '<=', $max);
        }
        return $query;
    }

    public function scopeFilterLocation($query, $location)
    {
        if ($location) {
            return $query->where('location', 'LIKE', "%{$location}%");
        }
        return $query;
    }

    /* ── Helpers ─────────────────────────── */

    public function isOwnedBy(User $user): bool
    {
        return $this->user_id === $user->id;
    }

    public function isWishlistedBy(?User $user): bool
    {
        if (!$user) return false;
        return $this->wishlists()->where('user_id', $user->id)->exists();
    }

    public function incrementViews(): void
    {
        $this->increment('views_count');
    }
}
