@extends('layouts.customer')

@section('content')
<section class="relative overflow-hidden">
    <div class="mx-auto grid max-w-7xl items-center gap-10 px-4 pb-10 pt-12 sm:px-6 md:grid-cols-[1.2fr_.8fr] md:pb-16 md:pt-16 lg:px-8">
        <div>
            <span class="inline-flex rounded-full bg-[#f3e5d7] px-3 py-1 text-xs font-bold uppercase tracking-[.18em] text-[#7a4b2d]">Freshly brewed daily</span>
            <h1 class="mt-5 max-w-3xl text-4xl font-black leading-tight tracking-tight text-[#3b281e] sm:text-5xl lg:text-6xl">Seduh yang enak,<br><span class="text-[#c08246]">jalani hari dengan tenang.</span></h1>
            <p class="mt-5 max-w-2xl text-base leading-7 text-stone-500 sm:text-lg">Temukan kopi favoritmu, pesan tanpa ribet, dan pantau nomor antrian langsung dari ponsel maupun desktop.</p>
            <div class="mt-7 flex flex-col gap-3 sm:flex-row"><a href="#menu" class="sk-btn-primary px-5 py-3">Lihat Menu</a><a href="{{ auth()->check() ? route('customer.orders') : route('register') }}" class="sk-btn-soft px-5 py-3">{{ auth()->check() ? 'Pantau Pesanan' : 'Buat Akun' }}</a></div>
            <div class="mt-7 grid max-w-xl grid-cols-3 gap-4 text-center sm:text-left"><div><p class="text-2xl font-black text-stone-900">30+</p><p class="text-xs text-stone-500">Pilihan menu</p></div><div><p class="text-2xl font-black text-stone-900">09–22</p><p class="text-xs text-stone-500">Jam layanan</p></div><div><p class="text-2xl font-black text-stone-900">100%</p><p class="text-xs text-stone-500">Order terpantau</p></div></div>
        </div>
        <div class="relative hidden md:block"><div class="absolute -inset-4 rounded-[3rem] bg-[#f3e5d7]"></div><img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&w=1000&q=85" alt="Kopi SenjaKopi" class="relative h-[430px] w-full rounded-[2.5rem] object-cover shadow-2xl"></div>
    </div>
</section>

<section id="menu" class="mx-auto max-w-7xl px-4 pb-16 sm:px-6 lg:px-8">
    <div class="sk-card p-4 sm:p-6">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div><p class="text-xs font-bold uppercase tracking-[.16em] text-[#c08246]">Our menu</p><h2 class="mt-1 text-2xl font-black text-stone-900 sm:text-3xl">Pilih favoritmu</h2></div>
            <form class="flex w-full max-w-xl gap-2" method="GET" action="{{ route('home') }}"><input class="sk-input" type="search" name="q" value="{{ request('q') }}" placeholder="Cari kopi, latte, camilan..."><input type="hidden" name="category" value="{{ $selectedCategory }}"><button class="sk-btn-primary whitespace-nowrap">Cari</button></form>
        </div>
        <div class="mt-5 flex gap-2 overflow-x-auto pb-1 [scrollbar-width:none]">
            <a href="{{ route('home', request('q') ? ['category'=>'all','q'=>request('q')] : ['category'=>'all']) }}" class="whitespace-nowrap rounded-full px-4 py-2 text-sm font-bold {{ $selectedCategory === 'all' ? 'bg-[#3b281e] text-white' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}">Semua</a>
            @foreach($categories as $category)
                <a href="{{ route('home', array_filter(['category'=>$category->slug,'q'=>request('q')])) }}" class="whitespace-nowrap rounded-full px-4 py-2 text-sm font-bold {{ $selectedCategory === $category->slug ? 'bg-[#3b281e] text-white' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}">{{ $category->name }}</a>
            @endforeach
        </div>
    </div>

    <div class="mt-8 flex items-end justify-between"><div><p class="text-sm text-stone-500">{{ $products->total() }} menu tersedia</p></div></div>
    @if($products->count())
        <div class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-2 sm:gap-5 lg:grid-cols-3 xl:grid-cols-4">
            @foreach($products as $product)
                <article class="group overflow-hidden rounded-3xl border border-stone-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                    <a href="{{ route('product.show', $product->slug) }}" class="block overflow-hidden"><img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-40 w-full object-cover transition duration-500 group-hover:scale-105 sm:h-52"></a>
                    <div class="p-4 sm:p-5"><div class="flex items-center justify-between gap-2"><span class="rounded-full bg-[#f6ede5] px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-[#7a4b2d]">{{ $product->category->name }}</span><span class="text-xs text-emerald-600">Tersedia</span></div><a href="{{ route('product.show', $product->slug) }}" class="mt-3 block text-base font-black leading-snug text-stone-900 sm:text-lg">{{ $product->name }}</a><p class="mt-2 hidden text-sm leading-5 text-stone-500 sm:line-clamp-2 sm:block">{{ $product->description }}</p><div class="mt-4 flex items-center justify-between gap-2"><span class="text-sm font-black text-stone-900 sm:text-base">Rp {{ number_format($product->price,0,',','.') }}</span>@auth<form action="{{ route('cart.add',$product->id) }}" method="POST">@csrf<button class="rounded-full bg-[#7a4b2d] p-2.5 text-white transition hover:bg-[#5f3922]" title="Tambah ke keranjang"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m7-7H5"/></svg></button></form>@else<a href="{{ route('login') }}" class="rounded-full bg-[#7a4b2d] px-3 py-2 text-xs font-bold text-white">Pesan</a>@endauth</div></div>
                </article>
            @endforeach
        </div>
        <div class="mt-8">{{ $products->links() }}</div>
    @else
        <div class="mt-8 rounded-3xl border border-dashed border-stone-300 bg-white px-6 py-16 text-center"><p class="text-lg font-bold text-stone-800">Menu tidak ditemukan</p><p class="mt-2 text-sm text-stone-500">Coba kata kunci atau kategori lain.</p><a href="{{ route('home') }}" class="sk-btn-primary mt-5">Reset pencarian</a></div>
    @endif
</section>
@endsection
