<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageRequest;
use App\Models\Conversation;

class MessageController extends Controller
{
    /**
     * Send a message in a conversation.
     */
    public function store(StoreMessageRequest $request)
    {
        $conversation = Conversation::findOrFail($request->conversation_id);
        $this->authorize('sendMessage', $conversation);

        $conversation->messages()->create([
            'sender_id' => auth()->id(),
            'body'      => $request->body,
        ]);

        $conversation->touch();

        return redirect()->route('conversations.show', $conversation)
            ->with('success', 'Pesan terkirim!');
    }
}
