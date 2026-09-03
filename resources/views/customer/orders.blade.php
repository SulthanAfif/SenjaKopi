@extends('layouts.customer')
@section('content')
<div class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8 lg:py-12">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div><p class="text-xs font-bold uppercase tracking-[.18em] text-[#c08246]">My orders</p><h1 class="text-3xl font-black text-stone-900">Pesanan Saya</h1><p class="mt-1 text-sm text-stone-500">Pantau status, cek detail, atau pesan ulang menu favoritmu.</p></div>
        <a href="{{ route('home') }}" class="sk-btn-soft">+ Pesan lagi</a>
    </div>
    <div class="mt-7 space-y-5">
        @forelse($orders as $order)
            @php
                $statusClass = ['pending'=>'border-amber-200 bg-amber-50 text-amber-700','diproses'=>'border-blue-200 bg-blue-50 text-blue-700','selesai'=>'border-emerald-200 bg-emerald-50 text-emerald-700','dibatalkan'=>'border-red-200 bg-red-50 text-red-700'][$order->status] ?? 'border-stone-200 bg-stone-50 text-stone-700';
                $statusLabel = ['pending'=>'Menunggu konfirmasi','diproses'=>'Sedang dibuat','selesai'=>'Selesai / siap diambil','dibatalkan'=>'Dibatalkan'][$order->status] ?? ucfirst($order->status);
            @endphp
            <article class="sk-card overflow-hidden">
                <div class="flex flex-col gap-4 border-b border-stone-200 p-4 sm:flex-row sm:items-center sm:justify-between sm:p-5">
                    <div class="flex items-center gap-4">
                        <div class="min-w-[76px] rounded-2xl bg-[#3b281e] px-3 py-3 text-center text-white"><p class="text-[10px] font-bold uppercase tracking-wide text-stone-300">Antrian</p><p class="text-xl font-black">{{ $order->queue_number ?? '-' }}</p></div>
                        <div><p class="font-black text-stone-900">ORD-{{ str_pad($order->id,5,'0',STR_PAD_LEFT) }}</p><p class="mt-1 text-xs text-stone-500">{{ $order->created_at->format('d M Y · H:i') }} · {{ strtoupper($order->payment_method ?? '-') }}</p></div>
                    </div>
                    <span class="w-fit rounded-full border px-3 py-1.5 text-xs font-bold {{ $statusClass }}">{{ $statusLabel }}</span>
                </div>
                <div class="p-4 sm:p-5">
                    <div class="space-y-3">
                        @foreach($order->orderItems->take(3) as $item)
                            <div class="flex items-center justify-between gap-3 text-sm">
                                <div class="flex min-w-0 items-center gap-3"><img src="{{ $item->product->image_url ?? 'https://placehold.co/80' }}" class="h-11 w-11 rounded-xl object-cover" alt="{{ $item->product->name ?? 'Produk' }}"><div class="min-w-0"><p class="truncate font-bold text-stone-800">{{ $item->quantity }}× {{ $item->product->name ?? 'Produk tidak tersedia' }}</p><p class="text-xs text-stone-500">Rp {{ number_format($item->price,0,',','.') }}</p></div></div>
                                <p class="shrink-0 font-bold">Rp {{ number_format($item->price*$item->quantity,0,',','.') }}</p>
                            </div>
                        @endforeach
                        @if($order->orderItems->count() > 3)<p class="text-xs font-semibold text-stone-400">+ {{ $order->orderItems->count()-3 }} item lainnya</p>@endif
                    </div>
                    <div class="mt-5 flex flex-col gap-4 border-t border-stone-200 pt-4 sm:flex-row sm:items-center sm:justify-between">
                        <div><p class="text-xs text-stone-500">Total pesanan</p><p class="text-xl font-black text-[#c08246]">Rp {{ number_format($order->total_price,0,',','.') }}</p></div>
                        <div class="flex flex-col gap-2 xs:flex-row sm:flex-row"><a href="{{ route('customer.orders.show',$order) }}" class="sk-btn-soft">Lihat detail</a><form action="{{ route('customer.orders.reorder',$order) }}" method="POST">@csrf<button class="sk-btn-primary w-full">Pesan lagi</button></form></div>
                    </div>
                </div>
            </article>
        @empty
            <div class="rounded-3xl bg-white px-5 py-20 text-center ring-1 ring-stone-200"><h2 class="text-xl font-black">Belum ada pesanan</h2><p class="mt-2 text-sm text-stone-500">Pesanan yang kamu buat akan muncul di sini.</p><a href="{{ route('home') }}" class="sk-btn-primary mt-5">Mulai Pesan</a></div>
        @endforelse
    </div>
    <div class="mt-8">{{ $orders->links() }}</div>
</div>
@endsection
