<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = ['id']; // Mengizinkan semua kolom diisi kecuali ID

    // Relasi: 1 Kategori punya Banyak Produk
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}