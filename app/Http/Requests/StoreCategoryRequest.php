<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    # Mengizinkan request kategori (khusus admin, diatur lewat middleware)
    public function authorize(): bool
    {
        return true;
    }

    # Aturan validasi untuk tambah atau edit kategori barang
    public function rules(): array
    {
        return [
            # Nama kategori wajib diisi, berupa teks, dan maksimal 255 karakter
            'name'       => 'required|string|max:255',
            
            # Icon (emoji/ikon kategori) opsional, maksimal 255 karakter
            'icon'       => 'nullable|string|max:255',
