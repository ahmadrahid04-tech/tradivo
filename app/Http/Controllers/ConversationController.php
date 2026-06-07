<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Listing;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    /**
     * List user's conversations.
     */
    public function index()
    {
        $userId = auth()->id();

        $conversations = Conversation::where('buyer_id', $userId)
            ->orWhere('seller_id', $userId)
            ->with(['listing.images', 'buyer', 'seller', 'latestMessage'])
            ->latest('updated_at')
            ->paginate(20);

        return view('conversations.index', compact('conversations'));
    }

    /**
     * Show conversation detail (chat).
     */
    public function show(Conversation $conversation)
    {
        $this->authorize('view', $conversation);

        $conversation->load(['listing.images', 'buyer', 'seller', 'messages.sender']);
        $conversation->markAsReadFor(auth()->user());

        return view('conversations.show', compact('conversation'));
    }

    /**
     * Start or resume a conversation about a listing.
     */
    public function store(Request $request)
    {
        $request->validate([
            'listing_id' => 'required|exists:listings,id',
            'message'    => 'required|string|max:2000',
        ]);

        $listing = Listing::findOrFail($request->listing_id);

        // Cannot chat with yourself
        if ($listing->user_id === auth()->id()) {
            return back()->with('error', 'Anda tidak bisa chat dengan diri sendiri.');
        }

        // Find or create conversation
        $conversation = Conversation::firstOrCreate([
            'listing_id' => $listing->id,
            'buyer_id'   => auth()->id(),
            'seller_id'  => $listing->user_id,
        ]);

        // Create the first message
        $conversation->messages()->create([
            'sender_id' => auth()->id(),
            'body'      => $request->message,
        ]);

        $conversation->touch();

        return redirect()->route('conversations.show', $conversation)
            ->with('success', 'Pesan berhasil dikirim!');
    }
}
