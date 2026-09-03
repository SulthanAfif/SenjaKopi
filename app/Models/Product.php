<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = ['id'];

    // Relasi: Produk dimiliki oleh 1 Kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}