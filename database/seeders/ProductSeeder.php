<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Kategori
        $katKopi = Category::create(['name' => 'Kopi', 'slug' => 'kopi']);
        $katNonKopi = Category::create(['name' => 'Non-Kopi', 'slug' => 'non-kopi']);
        $katSnack = Category::create(['name' => 'Camilan', 'slug' => 'camilan']);

        // 2. Data 30 Produk
        $products = [
            // --- 12 MENU KOPI ---
            ['cat' => $katKopi->id, 'name' => 'Espresso Single Shot', 'price' => 15000],
            ['cat' => $katKopi->id, 'name' => 'Americano Hot', 'price' => 20000],
            ['cat' => $katKopi->id, 'name' => 'Iced Americano', 'price' => 22000],
            ['cat' => $katKopi->id, 'name' => 'Cappuccino', 'price' => 28000],
            ['cat' => $katKopi->id, 'name' => 'Cafe Latte', 'price' => 28000],
            ['cat' => $katKopi->id, 'name' => 'Kopi Susu Gula Aren', 'price' => 25000],
            ['cat' => $katKopi->id, 'name' => 'Caramel Macchiato', 'price' => 32000],
            ['cat' => $katKopi->id, 'name' => 'Hazelnut Latte', 'price' => 30000],
            ['cat' => $katKopi->id, 'name' => 'Vanilla Latte', 'price' => 30000],
            ['cat' => $katKopi->id, 'name' => 'Mochaccino', 'price' => 32000],
            ['cat' => $katKopi->id, 'name' => 'Cold Brew Signature', 'price' => 35000],
            ['cat' => $katKopi->id, 'name' => 'Affogato', 'price' => 28000],

            // --- 12 MENU NON-KOPI ---
            ['cat' => $katNonKopi->id, 'name' => 'Matcha Latte', 'price' => 28000],
            ['cat' => $katNonKopi->id, 'name' => 'Taro Latte', 'price' => 25000],
            ['cat' => $katNonKopi->id, 'name' => 'Red Velvet Latte', 'price' => 28000],
            ['cat' => $katNonKopi->id, 'name' => 'Signature Chocolate', 'price' => 25000],
            ['cat' => $katNonKopi->id, 'name' => 'Thai Tea', 'price' => 20000],
            ['cat' => $katNonKopi->id, 'name' => 'Lychee Tea', 'price' => 22000],
            ['cat' => $katNonKopi->id, 'name' => 'Peach Tea', 'price' => 22000],
            ['cat' => $katNonKopi->id, 'name' => 'Lemon Tea', 'price' => 18000],
            ['cat' => $katNonKopi->id, 'name' => 'Earl Grey Hot', 'price' => 20000],
            ['cat' => $katNonKopi->id, 'name' => 'Cookies & Cream Frappe', 'price' => 35000],
            ['cat' => $katNonKopi->id, 'name' => 'Strawberry Smoothies', 'price' => 30000],
            ['cat' => $katNonKopi->id, 'name' => 'Virgin Mojito', 'price' => 28000],

            // --- 6 MENU CAMILAN (Tambahan agar pas 30) ---
            ['cat' => $katSnack->id, 'name' => 'Butter Croissant', 'price' => 25000],
            ['cat' => $katSnack->id, 'name' => 'Almond Croissant', 'price' => 32000],
            ['cat' => $katSnack->id, 'name' => 'Pain au Chocolat', 'price' => 30000],
            ['cat' => $katSnack->id, 'name' => 'French Fries', 'price' => 20000],
            ['cat' => $katSnack->id, 'name' => 'Mix Platter', 'price' => 45000],
            ['cat' => $katSnack->id, 'name' => 'Brownies Fudgy', 'price' => 22000],
        ];

        foreach ($products as $p) {
            Product::create([
                'category_id' => $p['cat'],
                'name' => $p['name'],
                'slug' => Str::slug($p['name']),
                'description' => 'Nikmati kelezatan ' . $p['name'] . ' dengan bahan berkualitas.',
                'price' => $p['price'],
                // Menggunakan placeholder image API
                'image_url' => 'https://placehold.co/400x300/292524/f5f5f4?text='.urlencode($p['name']), 
                'is_available' => true,
            ]);
        }
    }
}
