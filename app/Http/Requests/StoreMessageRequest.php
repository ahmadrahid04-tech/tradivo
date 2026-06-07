<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMessageRequest extends FormRequest
{
    # Mengizinkan semua user terotentikasi untuk mengirim pesan chat
    public function authorize(): bool
    {
        return true;
    }

    # Aturan validasi untuk mengirim pesan chat baru
    public function rules(): array
    {
        return [
            # ID percakapan/chat wajib diisi dan harus valid terdaftar di tabel 'conversations'
            'conversation_id' => 'required|exists:conversations,id',
            
