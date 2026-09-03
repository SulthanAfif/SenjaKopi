<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin · SenjaKopi' }}</title>
    <link rel="stylesheet" href="{{ asset('css/senjakopi-fallback.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body x-data="{sidebar:false}" class="min-h-screen bg-[#f7f4ef] text-stone-800">
<div class="min-h-screen md:flex">
    <div x-show="sidebar" x-transition.opacity class="fixed inset-0 z-40 bg-black/30 md:hidden" @click="sidebar=false"></div>
    <aside :class="sidebar ? 'translate-x-0' : '-translate-x-full md:translate-x-0'" class="fixed inset-y-0 left-0 z-50 flex w-72 flex-col bg-[#2f2119] text-white transition-transform duration-200 md:static md:z-auto md:translate-x-0">
        <div class="flex items-center justify-between border-b border-white/10 px-6 py-5">
            <a href="{{ route('admin.dashboard') }}" class="text-2xl font-black">Senja<span class="text-[#d8a06f]">Kopi.</span></a>
            <button class="md:hidden" @click="sidebar=false">✕</button>
        </div>
        <div class="px-4 py-5">
            <p class="px-3 text-[10px] font-bold uppercase tracking-[.2em] text-stone-500">Management</p>
            <nav class="mt-3 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="block rounded-xl px-3 py-3 text-sm font-semibold {{ request()->routeIs('admin.dashboard') ? 'bg-white/10 text-white' : 'text-stone-300 hover:bg-white/5' }}">Dashboard</a>
                <a href="{{ route('admin.products.index') }}" class="block rounded-xl px-3 py-3 text-sm font-semibold {{ request()->routeIs('admin.products.*') ? 'bg-white/10 text-white' : 'text-stone-300 hover:bg-white/5' }}">Produk</a>
                <a href="{{ route('admin.categories.index') }}" class="block rounded-xl px-3 py-3 text-sm font-semibold {{ request()->routeIs('admin.categories.*') ? 'bg-white/10 text-white' : 'text-stone-300 hover:bg-white/5' }}">Kategori</a>
                <a href="{{ route('admin.transactions.index') }}" class="block rounded-xl px-3 py-3 text-sm font-semibold {{ request()->routeIs('admin.transactions.*') ? 'bg-white/10 text-white' : 'text-stone-300 hover:bg-white/5' }}">Transaksi</a>
            </nav>
        </div>
        <div class="mt-auto border-t border-white/10 p-4">
            <a href="{{ route('home') }}" class="mb-2 block rounded-xl px-3 py-3 text-sm font-semibold text-stone-300 hover:bg-white/5">← Lihat toko</a>
            <form method="POST" action="{{ route('logout') }}">@csrf
                <button class="w-full rounded-xl bg-red-500/10 px-3 py-3 text-left text-sm font-semibold text-red-300 hover:bg-red-500/20">Keluar</button>
            </form>
        </div>
    </aside>
    <div class="min-w-0 flex-1">
        <header class="sticky top-0 z-30 border-b border-stone-200 bg-[#f7f4ef]/95 backdrop-blur">
            <div class="flex items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                <button class="rounded-xl bg-white p-2 shadow-sm ring-1 ring-stone-200 md:hidden" @click="sidebar=true">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div class="md:hidden"><span class="font-black">Admin<span class="text-[#c08246]">.</span></span></div>
                <div class="ml-auto flex items-center gap-3">
                    <div class="hidden text-right sm:block">
                        <p class="text-sm font-bold">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-stone-500">Administrator</p>
                    </div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#3b281e] text-sm font-black text-white">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
                </div>
            </div>
        </header>
        <main class="p-4 sm:p-6 lg:p-8">
            @if(session('success') || session('error'))
            <div class="mb-5 rounded-2xl border px-4 py-3 text-sm font-semibold {{ session('success') ? 'border-emerald-200 bg-emerald-50 text-emerald-700' : 'border-red-200 bg-red-50 text-red-700' }}">
                {{ session('success') ?? session('error') }}
            </div>
            @endif
            @yield('content')
        </main>
    </div>
</div>
@stack('scripts')
</body>
</html>
