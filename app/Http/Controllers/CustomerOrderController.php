<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CustomerOrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::with('orderItems.product')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(8);

        return view('customer.orders', compact('orders'));
    }

    public function show(Order $order): View
    {
        $this->ensureOwnedByCurrentUser($order);
        $order->load('orderItems.product.category');

        return view('customer.order-show', compact('order'));
    }

    public function cancel(Order $order): RedirectResponse
    {
        $this->ensureOwnedByCurrentUser($order);

        if ($order->status !== 'pending') {
            return back()->with('error', 'Pesanan hanya bisa dibatalkan sebelum mulai diproses.');
        }

        $order->update(['status' => 'dibatalkan']);

        return redirect()->route('customer.orders.show', $order)
            ->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function reorder(Order $order): RedirectResponse
    {
        $this->ensureOwnedByCurrentUser($order);
        $order->load('orderItems.product');

        $cart = session()->get('cart', []);
        $added = 0;
        $skipped = 0;

        foreach ($order->orderItems as $item) {
            $product = $item->product;
            if (! $product || ! $product->is_available) {
                $skipped++;
                continue;
            }

            $quantity = min(20, (int) $item->quantity);
            if (isset($cart[$product->id])) {
                $cart[$product->id]['quantity'] = min(20, $cart[$product->id]['quantity'] + $quantity);
            } else {
                $cart[$product->id] = [
                    'name' => $product->name,
                    'quantity' => $quantity,
                    'price' => $product->price,
                    'image' => $product->image_url,
                ];
            }
            $added++;
        }

        session()->put('cart', $cart);

        if ($added === 0) {
            return back()->with('error', 'Menu dari pesanan ini sedang tidak tersedia.');
        }

        $message = 'Menu yang tersedia sudah dimasukkan kembali ke keranjang.';
        if ($skipped > 0) {
            $message .= " {$skipped} item dilewati karena sedang tidak tersedia.";
        }

        return redirect()->route('cart.index')->with('success', $message);
    }

    private function ensureOwnedByCurrentUser(Order $order): void
    {
        abort_unless((int) $order->user_id === (int) Auth::id(), 404);
    }
}
