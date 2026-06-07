<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreListingRequest extends FormRequest
{
    # Mengizinkan semua user yang login untuk melakukan request ini
    public function authorize(): bool
    {
        return true;
    }

    # Aturan validasi untuk form upload barang/iklan baru
    public function rules(): array
    {
        return [
            # Kategori wajib diisi dan id-nya harus ada di tabel 'categories'
            'category_id' => 'required|exists:categories,id',
            
            # Judul iklan wajib diisi, berupa teks, dan maksimal 200 karakter
            'title'       => 'required|string|max:200',
            
            # Deskripsi wajib diisi, berupa teks, dan minimal 20 karakter agar jelas bagi pembeli
            'description' => 'required|string|min:20',
            
