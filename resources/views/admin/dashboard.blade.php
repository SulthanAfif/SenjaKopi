@extends('layouts.admin')

@section('content')
<div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
    <div>
        <p class="text-xs font-bold uppercase tracking-[.18em] text-[#c08246]">Overview</p>
        <h1 class="text-3xl font-black text-stone-900">Dashboard</h1>
        <p class="mt-1 text-sm text-stone-500">Pantau performa toko, produk, dan pesanan terbaru.</p>
    </div>
    <a href="{{ route('admin.transactions.index') }}" class="sk-btn-primary">Lihat transaksi</a>
</div>

{{-- Stats cards --}}
<div class="mt-7 grid grid-cols-2 gap-3 lg:grid-cols-3 xl:grid-cols-6">
    @foreach([
        ['Produk', $stats['totalProducts'], '📦'],
        ['Tersedia', $stats['availableProducts'], '✅'],
        ['Kategori', $stats['totalCategories'], '☕'],
        ['Total Order', $stats['totalOrders'], '🧾'],
        ['Order Aktif', $stats['pendingOrders'], '⏳'],
        ['Pendapatan Hari Ini', 'Rp '.number_format($stats['todayRevenue'], 0, ',', '.'), '💰']
    ] as [$label, $value, $icon])
    <div class="admin-card p-4 sm:p-5">
        <div class="flex items-center justify-between">
            <p class="text-xs font-bold text-stone-500">{{ $label }}</p>
            <span>{{ $icon }}</span>
        </div>
        <p class="mt-3 break-words text-xl font-black text-stone-900 sm:text-2xl">{{ $value }}</p>
    </div>
    @endforeach
</div>

{{-- Grafik Penjualan --}}
<div class="mt-7 admin-card p-5 sm:p-6">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-5">
        <div>
            <h2 class="font-black text-lg">Grafik Penjualan</h2>
            <p class="text-xs text-stone-500 mt-0.5">Pendapatan & jumlah order 7 hari terakhir</p>
        </div>
        <div class="flex flex-wrap gap-4 text-sm">
            <div class="flex items-center gap-2">
                <span class="inline-block h-3 w-3 rounded-full bg-[#c08246]"></span>
                <span class="text-stone-600">Pendapatan 7 hari: <strong class="text-stone-900">Rp {{ number_format($weekRevenue, 0, ',', '.') }}</strong></span>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-block h-3 w-3 rounded-full bg-[#3b281e]"></span>
                <span class="text-stone-600">Total order: <strong class="text-stone-900">{{ $weekOrders }}</strong></span>
            </div>
        </div>
    </div>
    <div class="relative h-64 sm:h-80">
        <canvas id="salesChart"></canvas>
    </div>
</div>

{{-- Main content grid --}}
<div class="mt-7 grid gap-6 xl:grid-cols-[1.35fr_.65fr]">
    <div class="admin-card overflow-hidden">
        <div class="flex items-center justify-between border-b border-stone-200 px-5 py-4">
            <div>
                <h2 class="font-black">Pesanan terbaru</h2>
                <p class="text-xs text-stone-500">Order masuk terakhir</p>
            </div>
            <a href="{{ route('admin.transactions.index') }}" class="text-xs font-bold text-[#c08246]">Semua transaksi →</a>
        </div>
        <div class="divide-y divide-stone-200">
            @forelse($recentOrders as $order)
            <a href="{{ route('admin.transactions.show', $order->id) }}" class="flex items-center justify-between gap-4 px-5 py-4 hover:bg-stone-50">
                <div class="min-w-0">
                    <p class="truncate font-bold">{{ $order->queue_number }} · {{ $order->user->name ?? 'Guest' }}</p>
                    <p class="text-xs text-stone-500">{{ $order->created_at->format('d M Y · H:i') }}</p>
                </div>
                <div class="shrink-0 text-right">
                    <p class="font-black">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                    <p class="text-xs font-bold {{ $order->status === 'selesai' ? 'text-emerald-600' : ($order->status === 'diproses' ? 'text-blue-600' : ($order->status === 'dibatalkan' ? 'text-red-600' : 'text-amber-600')) }}">
                        {{ ucfirst($order->status) }}
                    </p>
                </div>
            </a>
            @empty
            <div class="px-5 py-12 text-center text-sm text-stone-500">Belum ada order.</div>
            @endforelse
        </div>
    </div>

    <div class="space-y-6">
        <div class="admin-card p-5">
            <h2 class="font-black">Menu terlaris</h2>
            <div class="mt-4 space-y-3">
                @forelse($popularProducts as $item)
                <div class="flex items-center justify-between gap-3">
                    <div class="min-w-0">
                        <p class="truncate text-sm font-bold">{{ $item->product->name ?? 'Produk dihapus' }}</p>
                        <p class="text-xs text-stone-500">{{ $item->total_qty }} item terjual</p>
                    </div>
                    <span class="text-sm font-black text-[#c08246]">#{{ $loop->iteration }}</span>
                </div>
                @empty
                <p class="text-sm text-stone-500">Belum ada data penjualan.</p>
                @endforelse
            </div>
        </div>
        <div class="admin-card p-5">
            <h2 class="font-black">Aksi cepat</h2>
            <div class="mt-4 grid gap-3">
                <a href="{{ route('admin.products.create') }}" class="rounded-2xl bg-[#f6ede5] p-4 font-bold text-[#6a4028] hover:bg-[#efdfd0]">+ Tambah produk</a>
                <a href="{{ route('admin.categories.create') }}" class="rounded-2xl bg-stone-100 p-4 font-bold hover:bg-stone-200">+ Tambah kategori</a>
                <a href="{{ route('admin.transactions.index', ['status' => 'pending']) }}" class="rounded-2xl bg-amber-50 p-4 font-bold text-amber-800 hover:bg-amber-100">Kelola order pending</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('salesChart');
    if (!ctx) return;

    const labels = @json($chartLabels);
    const revenueData = @json($chartRevenue);
    const ordersData = @json($chartOrders);

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Pendapatan (Rp)',
                    data: revenueData,
                    backgroundColor: 'rgba(192, 130, 70, 0.75)',
                    borderColor: 'rgba(192, 130, 70, 1)',
                    borderWidth: 1,
                    borderRadius: 6,
                    yAxisID: 'y',
                },
                {
                    label: 'Jumlah Order',
                    data: ordersData,
                    type: 'line',
                    borderColor: '#3b281e',
                    backgroundColor: 'rgba(59, 40, 30, 0.15)',
                    borderWidth: 2.5,
                    tension: 0.3,
                    pointBackgroundColor: '#3b281e',
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    yAxisID: 'y1',
                    fill: false,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 16,
                        font: { size: 12, weight: '600' }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) label += ': ';
                            if (context.dataset.yAxisID === 'y') {
                                label += 'Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y);
                            } else {
                                label += context.parsed.y + ' order';
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 11 } }
                },
                y: {
                    type: 'linear',
                    position: 'left',
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Pendapatan (Rp)',
                        font: { size: 11 }
                    },
                    ticks: {
                        callback: function(value) {
                            if (value >= 1000000) return (value / 1000000) + 'jt';
                            if (value >= 1000) return (value / 1000) + 'rb';
                            return value;
                        }
                    },
                    grid: { color: 'rgba(0,0,0,0.05)' }
                },
                y1: {
                    type: 'linear',
                    position: 'right',
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah Order',
                        font: { size: 11 }
                    },
                    grid: { drawOnChartArea: false },
                    ticks: { stepSize: 1 }
                }
            }
        }
    });
});
</script>
@endpush
