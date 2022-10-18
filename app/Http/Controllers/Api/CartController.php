<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function cart(Request $request)
    {
        $cart = Cart::where('user_id', $request->user()->id)->get();
        return $cart;
    }

    public function addToCart(Request $request, $productId)
    {
        $cart = Cart::updateOrCreate(
            ['user_id' => $request->user()->id, 'product_id' => $productId],
            ['quantity' => $request->quantity]
        );
        return $cart;
    }

    public function deleteProduct(Request $request, $productId)
    {
        $cart = Cart::where('user_id', $request->user()->id);
        $cart->where('product_id', $productId)->delete();
        return 'Product deleted';
    }

    public function clearCart(Request $request)
    {
        Cart::where('user_id', $request->user()->id)->delete();
        return 'Cart cleared';
    }
}
