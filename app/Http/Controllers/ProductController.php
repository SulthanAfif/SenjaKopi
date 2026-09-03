<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->latest();
        if ($request->filled('q')) {
            $search = trim($request->q);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }
        if ($request->filled('category_id')) $query->where('category_id', $request->category_id);
        if ($request->filled('availability') && in_array($request->availability, ['1', '0'], true)) {
            $query->where('is_available', (bool) $request->availability);
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get();
        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'image_url' => ['nullable', 'url'],
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['is_available'] = $request->boolean('is_available');

        // Handle file upload via file explorer
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image_url'] = Storage::url($path);
        } else {
            $data['image_url'] = $data['image_url'] ?? 'https://placehold.co/800x600/4b2e20/fef3c7?text='.urlencode($data['name']);
        }

        unset($data['image']);
        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'image_url' => ['nullable', 'url'],
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['is_available'] = $request->boolean('is_available');

        // Handle file upload via file explorer
        if ($request->hasFile('image')) {
            // Delete old local image if it was stored in storage
            if ($product->image_url && str_starts_with($product->image_url, '/storage/')) {
                $oldPath = str_replace('/storage/', '', $product->image_url);
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('image')->store('products', 'public');
            $data['image_url'] = Storage::url($path);
        } elseif ($request->filled('image_url')) {
            $data['image_url'] = $data['image_url'];
        }
        // else keep existing

        unset($data['image']);
        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function toggleAvailability(Product $product)
    {
        $product->update(['is_available' => ! $product->is_available]);

        return back()->with('success', $product->name.' sekarang '.($product->is_available ? 'tersedia.' : 'ditandai habis.'));
    }

    public function destroy(Product $product)
    {
        // Delete local image if exists
        if ($product->image_url && str_starts_with($product->image_url, '/storage/')) {
            $oldPath = str_replace('/storage/', '', $product->image_url);
            Storage::disk('public')->delete($oldPath);
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
