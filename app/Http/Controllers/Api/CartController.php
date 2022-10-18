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
        $cart = Cart::updateOrCreate(
            ['user_id' => $request->user()->id, 'product_id' => $productId],
            ['quantity' => $request->has('quantity') ? $request->quantity : 1]
        );
        return $cart;
    }

    public function deleteProduct(Request $request, $productId)
    {
        $cart = Cart::where('user_id', $request->user()->id);
        $this->authorize('update', $request->user(), $cart);
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
