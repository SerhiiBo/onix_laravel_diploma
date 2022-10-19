<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Policies\CartPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{

    public function cart(Request $request)
    {
        $this->authorize('view', $request->user());
        $cart = Cart::where('user_id', $request->user()->id)->get();
        return $cart;
    }

    public function addToCart(Request $request, $productId)
    {
        $this->authorize('create', $request->user());
        $in_stock = Product::find($productId)->in_stock;
        if ($request->quantity <= $in_stock) {
            $cart = Cart::updateOrCreate(
                ['user_id' => $request->user()->id, 'product_id' => $productId],
                ['quantity' => $request->has('quantity') ? $request->quantity : 1]
            );
            Product::find($productId)->decrement('in_stock', $request->quantity);
        } else {
            return "Quantity in stock is less. Available to order: {$in_stock}";
        }
        return $cart;
    }

    public function deleteProduct(Request $request, $productId)
    {
        $cart = Cart::where('user_id', $request->user()->id);
        $this->authorize('update', $request->user(), $cart);
        $productCart = $cart->where('product_id', $productId)->first();
        Product::find($productId)->increment('in_stock', $productCart->quantity);
        $cart->where('product_id', $productId)->delete();
        return 'Product deleted from cart';
    }

    public function clearCart(Request $request)
    {
        $cart = Cart::where('user_id', $request->user()->id)->delete();
        $this->authorize('update', $request->user(), $cart);
        return 'Cart cleared';
    }
}
