@extends('layouts.customer')
@section('content')
@php
$statusClass = ['pending'=>'bg-amber-50 text-amber-700 ring-amber-200','diproses'=>'bg-blue-50 text-blue-700 ring-blue-200','selesai'=>'bg-emerald-50 text-emerald-700 ring-emerald-200','dibatalkan'=>'bg-red-50 text-red-700 ring-red-200'][$order->status] ?? 'bg-stone-50 text-stone-700 ring-stone-200';
$statusLabel = ['pending'=>'Menunggu konfirmasi','diproses'=>'Sedang dibuat','selesai'=>'Selesai / siap diambil','dibatalkan'=>'Dibatalkan'][$order->status] ?? ucfirst($order->status);
@endphp
<div class="mx-auto max-w-5xl px-4 py-8 sm:px-6 lg:px-8 lg:py-12">
    <a href="{{ route('customer.orders') }}" class="text-sm font-bold text-stone-500 hover:text-stone-900">← Kembali ke pesanan</a>
    <div class="mt-5 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between"><div><p class="text-xs font-bold uppercase tracking-[.18em] text-[#c08246]">Order detail</p><h1 class="mt-1 text-3xl font-black">{{ $order->queue_number }} <span class="text-stone-400">· ORD-{{ str_pad($order->id,5,'0',STR_PAD_LEFT) }}</span></h1><p class="mt-2 text-sm text-stone-500">Dibuat {{ $order->created_at->format('d M Y, H:i') }}</p></div><span class="w-fit rounded-full px-4 py-2 text-sm font-bold ring-1 {{ $statusClass }}">{{ $statusLabel }}</span></div>

    <div class="mt-7 grid gap-6 lg:grid-cols-[1.25fr_.75fr]">
        <section class="sk-card p-5 sm:p-6"><h2 class="text-lg font-black">Item pesanan</h2><div class="mt-5 space-y-4">@foreach($order->orderItems as $item)<div class="flex gap-4 border-b border-stone-100 pb-4 last:border-0"><img src="{{ $item->product->image_url ?? 'https://placehold.co/120' }}" class="h-16 w-16 rounded-2xl object-cover" alt="{{ $item->product->name ?? 'Produk' }}"><div class="min-w-0 flex-1"><p class="font-black">{{ $item->product->name ?? 'Produk tidak tersedia' }}</p><p class="mt-1 text-xs text-stone-500">{{ $item->product->category->name ?? 'Menu' }} · {{ $item->quantity }} × Rp {{ number_format($item->price,0,',','.') }}</p></div><p class="font-black">Rp {{ number_format($item->price*$item->quantity,0,',','.') }}</p></div>@endforeach</div></section>
        <aside class="space-y-5"><div class="sk-card p-5"><h2 class="font-black">Ringkasan</h2><div class="mt-4 space-y-3 text-sm"><div class="flex justify-between gap-4"><span class="text-stone-500">Nomor antrian</span><span class="font-bold">{{ $order->queue_number }}</span></div><div class="flex justify-between gap-4"><span class="text-stone-500">Pembayaran</span><span class="font-bold uppercase">{{ $order->payment_method }}</span></div><div class="flex justify-between gap-4 border-t border-stone-200 pt-3"><span class="font-bold">Total</span><span class="text-xl font-black text-[#c08246]">Rp {{ number_format($order->total_price,0,',','.') }}</span></div></div></div>
            <div class="sk-card p-5"><h2 class="font-black">Aksi</h2><form class="mt-4" action="{{ route('customer.orders.reorder',$order) }}" method="POST">@csrf<button class="sk-btn-primary w-full">Pesan menu ini lagi</button></form>@if($order->status==='pending')<form class="mt-3" action="{{ route('customer.orders.cancel',$order) }}" method="POST">@csrf @method('PATCH')<button onclick="return confirm('Batalkan pesanan ini?')" class="w-full rounded-xl border border-red-200 px-4 py-2.5 text-sm font-bold text-red-600 hover:bg-red-50">Batalkan pesanan</button></form><p class="mt-3 text-xs leading-5 text-stone-400">Pembatalan hanya tersedia selama pesanan belum mulai diproses.</p>@endif</div>
        </aside>
    </div>
</div>
@endsection
