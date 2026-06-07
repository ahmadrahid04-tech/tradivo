<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReportRequest extends FormRequest
{
    # Mengizinkan semua user terotentikasi untuk melaporkan iklan bermasalah
    public function authorize(): bool
    {
        return true;
    }

    # Aturan validasi untuk mengirim laporan iklan
    public function rules(): array
    {
        return [
            # Alasan pelaporan wajib diisi, berupa teks, dan maksimal 255 karakter
            'reason'      => 'required|string|max:255',
            
