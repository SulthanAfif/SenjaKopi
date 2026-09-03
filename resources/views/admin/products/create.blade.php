@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto admin-card p-5 sm:p-7 mt-5">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Tambah Produk Baru</h1>
        <a href="{{ route('admin.products.index') }}" class="text-gray-500 hover:text-gray-700">← Kembali</a>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Nama Produk -->
            <div>
                <label class="block text-gray-700 font-medium mb-2">Nama Produk</label>
                <input type="text" name="name" value="{{ old('name') }}" class="sk-input" required placeholder="Caffe Latte">
                @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Kategori -->
            <div>
                <label class="block text-gray-700 font-medium mb-2">Kategori</label>
                <select name="category_id" class="sk-input" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Harga -->
            <div>
                <label class="block text-gray-700 font-medium mb-2">Harga (Rp)</label>
                <input type="number" name="price" value="{{ old('price') }}" class="sk-input" required placeholder="25000">
                @error('price') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Upload Foto (File Explorer) -->
            <div>
                <label class="block text-gray-700 font-medium mb-2">Foto Produk</label>
                <input type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" class="sk-input file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-[#c08246] file:text-white file:cursor-pointer hover:file:bg-[#a06a38]">
                <p class="text-xs text-gray-500 mt-1">Pilih file gambar dari komputer (max 2MB, format: jpg, png, gif, webp)</p>
                @error('image') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- URL Gambar (opsional, jika tidak upload file) -->
        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2">Atau URL Gambar (opsional)</label>
            <input type="url" name="image_url" value="{{ old('image_url') }}" class="sk-input" placeholder="https://contoh.com/gambar.jpg">
            <p class="text-xs text-gray-500 mt-1">Isi URL jika tidak mengunggah file. Jika keduanya kosong, akan memakai placeholder.</p>
            @error('image_url') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Deskripsi -->
        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2">Deskripsi</label>
            <textarea name="description" rows="3" class="sk-input" placeholder="Deskripsi rasa atau bahan...">{{ old('description') }}</textarea>
        </div>

        <!-- Status Tersedia -->
        <div class="mb-6 flex items-center">
            <input type="checkbox" name="is_available" id="is_available" value="1" {{ old('is_available', true) ? 'checked' : '' }} class="w-5 h-5 text-[#c08246] focus:ring-[#c08246] border-gray-300 rounded">
            <label for="is_available" class="ml-2 text-gray-700 font-medium">Produk Tersedia (Bisa Dipesan)</label>
        </div>

        <button type="submit" class="w-full bg-[#292524] hover:bg-[#c08246] text-white px-6 py-3 rounded-lg font-bold transition">Simpan Produk</button>
    </form>
</div>
@endsection
