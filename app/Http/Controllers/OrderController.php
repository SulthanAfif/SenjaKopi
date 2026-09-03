<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('orderItems.product')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(8);

        return view('customer.orders', compact('orders'));
    }
}
