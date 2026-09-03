<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'totalProducts' => Product::count(),
            'availableProducts' => Product::where('is_available', true)->count(),
            'totalCategories' => Category::count(),
            'totalOrders' => Order::count(),
            'todayRevenue' => Order::whereDate('created_at', today())->where('status', '!=', 'dibatalkan')->sum('total_price'),
            'pendingOrders' => Order::whereIn('status', ['pending', 'diproses'])->count(),
        ];

        $recentOrders = Order::with('user')->latest()->limit(8)->get();
        $popularProducts = OrderItem::query()
            ->selectRaw('product_id, SUM(quantity) as total_qty')
            ->whereHas('order', fn ($q) => $q->where('status', '!=', 'dibatalkan'))
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        // Data grafik penjualan 7 hari terakhir
        $chartLabels = [];
        $chartRevenue = [];
        $chartOrders = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartLabels[] = $date->translatedFormat('d M');

            $chartRevenue[] = (int) Order::whereDate('created_at', $date)
                ->where('status', '!=', 'dibatalkan')
                ->sum('total_price');

            $chartOrders[] = (int) Order::whereDate('created_at', $date)
                ->where('status', '!=', 'dibatalkan')
                ->count();
        }

        $weekRevenue = array_sum($chartRevenue);
        $weekOrders = array_sum($chartOrders);

        return view('admin.dashboard', compact(
            'stats',
            'recentOrders',
            'popularProducts',
            'chartLabels',
            'chartRevenue',
            'chartOrders',
            'weekRevenue',
            'weekOrders'
        ));
    }
}
