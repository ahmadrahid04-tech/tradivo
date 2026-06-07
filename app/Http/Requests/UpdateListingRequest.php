<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateListingRequest extends FormRequest
{
    # Mengizinkan user yang memodifikasi untuk melanjutkan request
    public function authorize(): bool
    {
        return true;
    }

    # Aturan validasi untuk mengedit iklan barang
    public function rules(): array
    {
        return [
            # Kategori wajib diisi dan harus ada di tabel 'categories'
            'category_id' => 'required|exists:categories,id',
            
            # Judul iklan wajib diisi, berupa teks, dan maksimal 200 karakter
            'title'       => 'required|string|max:200',
            
            # Deskripsi wajib diisi, minimal 20 karakter
            'description' => 'required|string|min:20',
            
            # Harga wajib diisi, berupa angka positif
            'price'       => 'required|numeric|min:0',
            
