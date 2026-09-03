<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user')->latest();

        if ($request->filled('status') && in_array($request->status, ['pending', 'diproses', 'selesai', 'dibatalkan'], true)) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_method') && in_array($request->payment_method, ['qris', 'cash', 'transfer'], true)) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        if ($request->filled('q')) {
            $search = trim($request->q);
            $query->where(function ($q) use ($search) {
                $q->where('queue_number', 'like', "%{$search}%")
                  ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%"));
            });
        }

        $transactions = $query->paginate(12)->withQueryString();
        $todayRevenue = Order::whereDate('created_at', today())->where('status', '!=', 'dibatalkan')->sum('total_price');
        $counts = [
            'pending' => Order::where('status', 'pending')->count(),
            'diproses' => Order::where('status', 'diproses')->count(),
            'selesai' => Order::where('status', 'selesai')->count(),
        ];

        return view('admin.transactions.index', compact('transactions', 'todayRevenue', 'counts'));
    }

    public function show($id)
    {
        $transaction = Order::with(['user', 'orderItems.product'])->findOrFail($id);
        return view('admin.transactions.show', compact('transaction'));
    }

    public function updateStatus(Request $request, $id)
    {
        $data = $request->validate(['status' => ['required', 'in:pending,diproses,selesai,dibatalkan']]);
        $transaction = Order::findOrFail($id);
        $transaction->update(['status' => $data['status']]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
