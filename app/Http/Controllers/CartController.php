<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request, $id)
    {
        $product = Product::where('is_available', true)->findOrFail($id);
        $quantity = max(1, min((int) $request->input('quantity', 1), 20));
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = min(20, $cart[$id]['quantity'] + $quantity);
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'quantity' => $quantity,
                'price' => $product->price,
                'image' => $product->image_url,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', $product->name.' berhasil masuk ke keranjang.');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate(['quantity' => ['required', 'integer', 'min:1', 'max:20']]);
        $cart = session()->get('cart', []);

        if (!isset($cart[$id])) {
            return redirect()->route('cart.index');
        }

        $cart[$id]['quantity'] = $data['quantity'];
        session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'Jumlah pesanan diperbarui.');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'Menu dihapus dari keranjang.');
    }

    public function checkout(Request $request)
    {
        $data = $request->validate([
            'payment_method' => ['required', 'in:qris,cash,transfer'],
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjangmu masih kosong.');
        }

        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');
        foreach ($cart as $id => $item) {
            if (! isset($products[$id]) || ! $products[$id]->is_available) {
                return redirect()->route('cart.index')->with('error', ($item['name'] ?? 'Salah satu menu').' sedang tidak tersedia. Hapus dari keranjang untuk melanjutkan.');
            }
        }

        $totalPrice = collect($cart)->sum(fn ($item) => $item['price'] * $item['quantity']);

        $order = DB::transaction(function () use ($cart, $totalPrice, $data) {
            $todayOrders = Order::whereDate('created_at', today())->lockForUpdate()->count();
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_price' => $totalPrice,
                'status' => 'pending',
                'queue_number' => 'A-'.str_pad($todayOrders + 1, 3, '0', STR_PAD_LEFT),
                'payment_method' => $data['payment_method'],
            ]);

            foreach ($cart as $id => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            return $order;
        });

        session()->forget('cart');
        return redirect()->route('customer.orders')->with('success', 'Pesanan berhasil dibuat. Nomor antrianmu '.$order->queue_number.'.');
    }
}
