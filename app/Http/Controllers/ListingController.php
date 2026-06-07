<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreListingRequest;
use App\Http\Requests\UpdateListingRequest;
use App\Models\Category;
use App\Models\Listing;
use App\Models\ListingImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ListingController extends Controller
{
    /**
     * Browse all active listings with search & filter.
     */
    public function index(Request $request)
    {
        $query = Listing::active()
            ->with(['user', 'images', 'category'])
            ->search($request->keyword)
            ->filterCategory($request->category)
            ->filterCondition($request->condition)
            ->filterPriceRange($request->price_min, $request->price_max)
            ->filterLocation($request->location);

        // Sorting
        $sort = $request->sort ?? 'latest';
        $query = match ($sort) {
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'popular'    => $query->orderBy('views_count', 'desc'),
            default      => $query->latest(),
        };

        $listings = $query->paginate(12)->withQueryString();

        $categories = Category::parents()->with('children')->orderBy('sort_order')->get();

        return view('listings.index', compact('listings', 'categories'));
    }

    /**
     * Show a single listing.
     */
    public function show(Listing $listing)
    {
        $listing->load(['user', 'images', 'category']);
        $listing->incrementViews();

        $relatedListings = Listing::active()
            ->where('category_id', $listing->category_id)
            ->where('id', '!=', $listing->id)
            ->with(['images'])
            ->take(4)
            ->get();

        $isWishlisted = $listing->isWishlistedBy(auth()->user());

        return view('listings.show', compact('listing', 'relatedListings', 'isWishlisted'));
    }

    /**
     * Show form to create listing.
     */
    public function create()
    {
        $categories = Category::parents()->with('children')->orderBy('sort_order')->get();
        return view('listings.create', compact('categories'));
    }

    /**
     * Store a new listing.
     */
    public function store(StoreListingRequest $request)
    {
        $listing = Listing::create([
            'user_id'     => auth()->id(),
            'category_id' => $request->category_id,
            'title'       => $request->title,
            'description' => $request->description,
            'price'       => $request->price,
            'location'    => $request->location,
            'condition'   => $request->condition,
        ]);

        // Upload images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('listings', 'public');
                ListingImage::create([
                    'listing_id' => $listing->id,
                    'image_path' => $path,
                    'is_primary' => $index === 0,
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('listings.show', $listing)
            ->with('success', 'Iklan berhasil dipublikasikan!');
    }

    /**
     * Show form to edit listing.
     */
    public function edit(Listing $listing)
    {
        $this->authorize('update', $listing);
        $listing->load('images');
        $categories = Category::parents()->with('children')->orderBy('sort_order')->get();
        return view('listings.edit', compact('listing', 'categories'));
    }

    /**
     * Update a listing.
     */
    public function update(UpdateListingRequest $request, Listing $listing)
    {
        $this->authorize('update', $listing);

        $listing->update($request->only([
            'title', 'description', 'price', 'category_id',
            'location', 'condition', 'status',
        ]));

        // Remove selected images
        if ($request->remove_images) {
            foreach ($request->remove_images as $imageId) {
                $img = ListingImage::where('id', $imageId)
                    ->where('listing_id', $listing->id)
                    ->first();
                if ($img) {
                    Storage::disk('public')->delete($img->image_path);
                    $img->delete();
                }
            }
        }

        // Add new images
        if ($request->hasFile('images')) {
            $maxOrder = $listing->images()->max('sort_order') ?? -1;
            foreach ($request->file('images') as $image) {
                $maxOrder++;
                $path = $image->store('listings', 'public');
                ListingImage::create([
                    'listing_id' => $listing->id,
                    'image_path' => $path,
                    'is_primary' => $listing->images()->count() === 0 && $maxOrder === 0,
                    'sort_order' => $maxOrder,
                ]);
            }
        }

        return redirect()->route('listings.show', $listing)
            ->with('success', 'Iklan berhasil diperbarui!');
    }

    /**
     * Delete a listing.
     */
    public function destroy(Listing $listing)
    {
        $this->authorize('delete', $listing);

        // Delete images from storage
        foreach ($listing->images as $img) {
            Storage::disk('public')->delete($img->image_path);
        }

        $listing->delete();

        return redirect()->route('my-listings')
            ->with('success', 'Iklan berhasil dihapus!');
    }

    /**
     * My listings page.
     */
    public function myListings()
    {
        $listings = Listing::where('user_id', auth()->id())
            ->with(['images', 'category'])
            ->latest()
            ->paginate(12);

        return view('listings.my-listings', compact('listings'));
    }
}
