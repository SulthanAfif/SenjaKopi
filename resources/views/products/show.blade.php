@extends('layouts.customer')
@section('content')
<div class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8 lg:py-12">
    <a href="{{ route('home') }}" class="text-sm font-bold text-stone-500 hover:text-stone-900">← Kembali ke menu</a>
    <div class="mt-6 grid gap-8 lg:grid-cols-2 lg:items-center">
        <div class="overflow-hidden rounded-[2rem] bg-stone-100"><img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="aspect-square w-full object-cover sm:aspect-[4/3]"></div>
        <div class="sk-card p-6 sm:p-8">
            <span class="rounded-full bg-[#f6ede5] px-3 py-1 text-xs font-bold uppercase tracking-[.14em] text-[#7a4b2d]">{{ $product->category->name }}</span>
            <h1 class="mt-4 text-3xl font-black tracking-tight text-stone-900 sm:text-4xl">{{ $product->name }}</h1>
            <p class="mt-4 text-2xl font-black text-[#c08246]">Rp {{ number_format($product->price,0,',','.') }}</p>
            <p class="mt-5 leading-7 text-stone-500">{{ $product->description }}</p>
            @auth
                <form class="mt-7" action="{{ route('cart.add',$product->id) }}" method="POST">@csrf<div class="flex flex-col gap-3 sm:flex-row"><div class="w-full sm:w-32"><label class="mb-2 block text-sm font-bold">Jumlah</label><input class="sk-input" type="number" name="quantity" min="1" max="20" value="1"></div><button class="sk-btn-primary flex-1 self-end py-3">Tambah ke Keranjang</button></div></form>
            @else
                <a href="{{ route('login') }}" class="sk-btn-primary mt-7 w-full py-3">Masuk untuk Memesan</a>
            @endauth
            <div class="mt-7 grid grid-cols-3 gap-3 border-t border-stone-200 pt-5 text-center"><div><p class="text-xs text-stone-500">Status</p><p class="mt-1 text-sm font-bold text-emerald-600">Tersedia</p></div><div><p class="text-xs text-stone-500">Kategori</p><p class="mt-1 text-sm font-bold text-stone-800">{{ $product->category->name }}</p></div><div><p class="text-xs text-stone-500">Pengolahan</p><p class="mt-1 text-sm font-bold text-stone-800">Fresh</p></div></div>
        </div>
    </div>
</div>
@endsection
