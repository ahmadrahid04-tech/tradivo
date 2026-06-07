<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ListingController extends Controller
{
    public function index(Request $request)
    {
        $query = Listing::with(['user', 'category', 'images']);

        if ($request->search) {
            $query->where('title', 'LIKE', "%{$request->search}%");
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $listings = $query->latest()->paginate(15)->withQueryString();

        return view('admin.listings.index', compact('listings'));
    }

    public function updateStatus(Request $request, Listing $listing)
    {
        $request->validate([
            'status' => 'required|in:active,sold,inactive,pending',
        ]);

        $listing->update(['status' => $request->status]);

        return back()->with('success', "Status iklan diubah menjadi {$request->status}.");
    }

    public function destroy(Listing $listing)
    {
        foreach ($listing->images as $img) {
            Storage::disk('public')->delete($img->image_path);
        }

        $listing->delete();

        return back()->with('success', 'Iklan berhasil dihapus.');
    }
}
