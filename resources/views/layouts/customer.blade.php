<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'SenjaKopi' }}</title>
    <link rel="stylesheet" href="{{ asset('css/senjakopi-fallback.css') }}"><script src="https://cdn.tailwindcss.com"></script>@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#fdfbf7]">
    @php($cartCount = collect(session('cart', []))->sum('quantity'))
    <header x-data="{open:false}" class="sticky top-0 z-50 border-b border-stone-200/80 bg-[#fdfbf7]/95 backdrop-blur">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="text-2xl font-black tracking-tight text-[#4b2e20]">Senja<span class="text-[#c08246]">Kopi.</span></a>
            <nav class="hidden items-center gap-6 md:flex">
                <a href="{{ route('home') }}" class="text-sm font-semibold {{ request()->routeIs('home') ? 'text-[#7a4b2d]' : 'text-stone-500 hover:text-stone-900' }}">Menu</a>
                @auth
                    <a href="{{ route('customer.orders') }}" class="text-sm font-semibold {{ request()->routeIs('customer.orders*') ? 'text-[#7a4b2d]' : 'text-stone-500 hover:text-stone-900' }}">Pesanan</a>
                    <a href="{{ route('profile.edit') }}" class="text-sm font-semibold {{ request()->routeIs('profile.edit') ? 'text-[#7a4b2d]' : 'text-stone-500 hover:text-stone-900' }}">Profil</a>
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="text-sm font-semibold text-stone-500 hover:text-stone-900">Admin</a>
                    @endif
                    <a href="{{ route('cart.index') }}" class="relative rounded-full bg-white p-2.5 text-stone-700 shadow-sm ring-1 ring-stone-200" aria-label="Keranjang">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 4h2l1.6 10.2a2 2 0 0 0 2 1.7h7.9a2 2 0 0 0 2-1.7L20 8H7M10 20a1 1 0 1 1-2 0 1 1 0 0 1 2 0Zm8 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0Z"/></svg>
                        @if($cartCount)<span class="absolute -right-1 -top-1 min-w-5 rounded-full bg-[#c08246] px-1 text-center text-[10px] font-bold text-white">{{ $cartCount }}</span>@endif
                    </a>
                    <form method="POST" action="{{ route('logout') }}">@csrf<button class="text-sm font-semibold text-stone-500 hover:text-red-600">Keluar</button></form>
                @else
                    <a href="{{ route('login') }}" class="sk-btn-primary text-sm">Masuk</a>
                    <a href="{{ route('register') }}" class="text-sm font-semibold text-stone-500 hover:text-stone-900">Daftar</a>
                @endauth
            </nav>
            <button @click="open=!open" class="rounded-xl bg-white p-2 ring-1 ring-stone-200 md:hidden" aria-label="Buka menu">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path x-show="!open" stroke="currentColor" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/><path x-show="open" stroke="currentColor" stroke-width="2" d="m6 6 12 12M18 6 6 18"/></svg>
            </button>
        </div>
        <div x-show="open" x-collapse class="border-t border-stone-200 bg-white md:hidden">
            <div class="space-y-1 px-4 py-4">
                <a href="{{ route('home') }}" class="block rounded-xl px-3 py-2 font-semibold hover:bg-stone-50">Menu</a>
                @auth
                    <a href="{{ route('customer.orders') }}" class="block rounded-xl px-3 py-2 font-semibold hover:bg-stone-50">Pesanan Saya</a>
                    <a href="{{ route('cart.index') }}" class="block rounded-xl px-3 py-2 font-semibold hover:bg-stone-50">Keranjang @if($cartCount)({{ $cartCount }})@endif</a>
                    <a href="{{ route('profile.edit') }}" class="block rounded-xl px-3 py-2 font-semibold hover:bg-stone-50">Profil</a>
                    @if(auth()->user()->role === 'admin')<a href="{{ route('admin.dashboard') }}" class="block rounded-xl px-3 py-2 font-semibold hover:bg-stone-50">Admin Panel</a>@endif
                    <form method="POST" action="{{ route('logout') }}">@csrf<button class="block w-full rounded-xl px-3 py-2 text-left font-semibold text-red-600 hover:bg-red-50">Keluar</button></form>
                @else
                    <a href="{{ route('login') }}" class="block rounded-xl px-3 py-2 font-semibold hover:bg-stone-50">Masuk</a>
                    <a href="{{ route('register') }}" class="block rounded-xl px-3 py-2 font-semibold hover:bg-stone-50">Daftar</a>
                @endauth
            </div>
        </div>
    </header>

    @if(session('success') || session('error'))
        <div class="mx-auto max-w-7xl px-4 pt-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl border px-4 py-3 text-sm font-semibold {{ session('success') ? 'border-emerald-200 bg-emerald-50 text-emerald-700' : 'border-red-200 bg-red-50 text-red-700' }}">
                {{ session('success') ?? session('error') }}
            </div>
        </div>
    @endif

    <main>@yield('content')</main>

    <footer class="mt-20 border-t border-stone-200 bg-[#2f2119] text-stone-200">
        <div class="mx-auto grid max-w-7xl gap-8 px-4 py-10 sm:grid-cols-2 sm:px-6 lg:grid-cols-3 lg:px-8">
            <div><p class="text-xl font-black">Senja<span class="text-[#d9a06d]">Kopi.</span></p><p class="mt-3 max-w-sm text-sm leading-6 text-stone-400">Kopi, non-kopi, dan camilan untuk menemani ritme harimu.</p></div>
            <div><p class="font-bold">Navigasi</p><div class="mt-3 space-y-2 text-sm text-stone-400"><a class="block hover:text-white" href="{{ route('home') }}">Menu</a>@auth<a class="block hover:text-white" href="{{ route('customer.orders') }}">Pesanan Saya</a>@endauth</div></div>
            <div><p class="font-bold">Jam Layanan</p><p class="mt-3 text-sm text-stone-400">Setiap hari · 09.00–22.00</p></div>
        </div>
    </footer>
</body>
</html>
