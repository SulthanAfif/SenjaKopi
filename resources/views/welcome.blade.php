<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SenjaKopi - Teman Santaimu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#fdfbf7] font-sans text-gray-800">

    <!-- Navbar -->
    <nav class="bg-white shadow-sm py-4 px-8 sticky top-0 z-50 border-b border-[#c08246]/20 flex justify-between items-center">
        <a href="/" class="text-3xl font-bold text-[#452b1b] tracking-tighter">
            Senja<span class="text-[#c08246]">Kopi.</span>
        </a>

        <div class="flex items-center gap-6">
            @auth
                <!-- Icon Keranjang (Hanya muncul kalau sudah login) -->
                <a href="{{ route('cart.index') }}" class="relative text-gray-600 hover:text-[#c08246] transition flex items-center gap-2 font-medium">
                    🛒 Keranjang
                    @if(session('cart') && count(session('cart')) > 0)
                        <span class="absolute -top-2 -right-3 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full shadow">
                            {{ count(session('cart')) }}
                        </span>
                    @endif
                </a>

                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="text-[#452b1b] hover:text-[#c08246] font-medium">Panel Admin</a>
                @endif
                
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-red-500 hover:text-red-700 font-medium">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-[#452b1b] font-medium hover:text-[#c08246]">Masuk</a>
                <a href="{{ route('register') }}" class="bg-[#292524] text-white px-5 py-2 rounded-lg font-medium hover:bg-[#c08246] transition">Daftar</a>
            @endauth
        </div>
    </nav>

    <!-- Notifikasi Sukses -->
    @if(session('success'))
        <div class="max-w-6xl mx-auto mt-6 px-6">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- Area Hero Section dengan Background -->
<div class="relative w-full py-32 bg-cover bg-center" style="background-image: url('{{ asset('https://img.pikbest.com/wp/202344/brown-rustic-cozy-autumn-vibes-cappuccino-cup-on-a-paper-background-with-plaid-walnuts-and-acorns-top-view_9934740.jpg!w700wp') }}');">
    
    <!-- Lapisan transparan (Overlay) agar teks tetap terbaca dengan jelas -->
    <div class="absolute inset-0 bg-black/50"></div>
    
    <!-- Teks Utama (Z-Index dinaikkan agar berada di atas overlay) -->
    <div class="relative z-10 flex flex-col items-center justify-center text-center px-4">
        <!-- Teks diubah menjadi warna putih (text-white) agar kontras -->
        <h1 class="text-5xl font-extrabold text-white mb-4">
            Secangkir Kopi,<br>Sejuta Inspirasi.
        </h1>
        <p class="text-lg text-gray-200 max-w-2xl mx-auto">
            Pilih racikan kopi terbaik dari biji pilihan nusantara, diseduh sepenuh hati untuk menemani harimu.
        </p>
    </div>

</div>

    <!-- Menu Section -->
    <main class="max-w-6xl mx-auto px-6 pb-24 mt-10">
        <div class="flex justify-between items-end mb-8">
            <h2 class="text-2xl font-bold text-[#452b1b]">Menu Favorit Kami</h2>
            <!-- Filter Kategori -->
        <div class="hidden md:flex gap-3 overflow-x-auto pb-2">
            <!-- Tombol "Semua" -->
            <a href="{{ route('home') }}" 
               class="{{ !request('category') ? 'bg-[#c08246] text-white shadow-md' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }} px-5 py-1.5 rounded-full text-sm font-medium transition duration-300">
                Semua
            </a>
            
            <!-- Tombol Berdasarkan Kategori Database -->
            @foreach($categories as $category)
                <a href="{{ route('home', ['category' => $category->id]) }}" 
                   class="{{ request('category') == $category->id ? 'bg-[#c08246] text-white shadow-md' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }} px-5 py-1.5 rounded-full text-sm font-medium transition duration-300 whitespace-nowrap">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
        </div>

        <!-- Grid Produk -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-8">
            @forelse($products as $product)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition duration-300 flex flex-col group">
                    
                    <!-- Gambar Kopi -->
                    <div class="relative h-48 overflow-hidden">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <span class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm text-[#452b1b] text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                            {{ $product->category->name ?? 'Kopi' }}
                        </span>
                    </div>

                    <!-- Detail Produk -->
                    <div class="p-5 flex flex-col flex-grow">
                        <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $product->name }}</h3>
                        <p class="text-sm text-gray-500 mb-4 line-clamp-2 flex-grow">{{ $product->description ?? 'Nikmati sensasi rasa kopi spesial dari SenjaKopi.' }}</p>
                        
                        <div class="flex items-center justify-between mt-auto">
                            <span class="text-lg font-extrabold text-[#c08246]">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            
                            <!-- Tombol Masukkan Keranjang -->
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-[#292524] text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-[#c08246] transition shadow-md" title="Tambah ke Keranjang">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 text-gray-500">
                    Belum ada menu kopi yang tersedia.
                </div>
            @endforelse
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-[#292524] text-gray-300 py-8 text-center mt-auto">
        <p>&copy; {{ date('Y') }} SenjaKopi. Dibuat dengan 🤎</p>
    </footer>

</body>
</html>