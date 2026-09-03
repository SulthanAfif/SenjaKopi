@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto admin-card p-5 sm:p-7 mt-4 sm:mt-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Kategori</h1>
        <a href="{{ route('admin.categories.index') }}" class="text-gray-500 hover:text-gray-700">← Kembali</a>
    </div>

    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2">Nama Kategori</label>
            <input type="text" name="name" value="{{ $category->name }}" class="sk-input" required>
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="w-full sk-btn-primary w-full py-3">
            Update Kategori
        </button>
    </form>
</div>
@endsection