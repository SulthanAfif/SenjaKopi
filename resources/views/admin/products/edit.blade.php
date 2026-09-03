@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto admin-card p-5 sm:p-7 mt-5">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Produk</h1>
        <a href="{{ route('admin.products.index') }}" class="text-gray-500 hover:text-gray-700">← Kembali</a>
    </div>

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-gray-700 font-medium mb-2">Nama Produk</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-[#c08246]" required>
                @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Kategori</label>
                <select name="category_id" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-[#c08246]" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Harga (Rp)</label>
                <input type="number" name="price" value="{{ old('price', $product->price) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-[#c08246]" required>
                @error('price') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Ganti Foto Produk</label>
                <input type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" class="w-full border border-gray-300 rounded-lg px-4 py-2 file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-[#c08246] file:text-white file:cursor-pointer hover:file:bg-[#a06a38]">
                <p class="text-xs text-gray-500 mt-1">Pilih file baru dari komputer (max 2MB). Kosongkan jika tidak ingin mengganti.</p>
                @error('image') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Preview gambar saat ini -->
        @if($product->image_url)
        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2">Foto Saat Ini</label>
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-40 w-auto object-cover rounded-lg border border-gray-200">
        </div>
        @endif

        <!-- URL Gambar (opsional) -->
        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2">Atau URL Gambar (opsional)</label>
            <input type="url" name="image_url" value="{{ old('image_url', $product->image_url) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-[#c08246]">
            <p class="text-xs text-gray-500 mt-1">Isi URL jika ingin memakai link eksternal (prioritas file upload lebih tinggi).</p>
            @error('image_url') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2">Deskripsi</label>
            <textarea name="description" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-[#c08246]">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="mb-6 flex items-center">
            <input type="checkbox" name="is_available" id="is_available" value="1" {{ old('is_available', $product->is_available) ? 'checked' : '' }} class="w-5 h-5 text-[#c08246] rounded">
            <label for="is_available" class="ml-2 text-gray-700 font-medium">Produk Tersedia (Bisa Dipesan)</label>
        </div>

        <button type="submit" class="w-full bg-[#292524] hover:bg-[#c08246] text-white px-6 py-3 rounded-lg font-bold transition">Update Produk</button>
    </form>
</div>
@endsection
