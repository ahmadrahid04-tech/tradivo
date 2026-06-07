<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Show user's wishlisted listings.
     */
    public function index()
    {
        $wishlists = Wishlist::where('user_id', auth()->id())
            ->with(['listing.images', 'listing.user', 'listing.category'])
            ->latest()
            ->paginate(12);

        return view('wishlists.index', compact('wishlists'));
    }

    /**
     * Toggle wishlist for a listing.
     */
    public function toggle(Listing $listing)
    {
        $existing = Wishlist::where('user_id', auth()->id())
            ->where('listing_id', $listing->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $message = 'Iklan dihapus dari favorit.';
            $wishlisted = false;
        } else {
            Wishlist::create([
                'user_id'    => auth()->id(),
                'listing_id' => $listing->id,
            ]);
            $message = 'Iklan ditambahkan ke favorit!';
            $wishlisted = true;
        }

        if (request()->ajax()) {
            return response()->json(['wishlisted' => $wishlisted, 'message' => $message]);
        }

        return back()->with('success', $message);
    }
}
