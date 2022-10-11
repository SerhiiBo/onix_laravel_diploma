<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function cart()
    {
        $cart = Session::has('cart' . Auth::id()) ? Session::get('cart' . Auth::id()) : null;
        return response()->json([
            'message' => 'My cart',
            'cart' => $cart
        ]);
    }

    public function addToCart(Request $request, $productId)
    {
        $oldCart = Session::has('cart' . Auth::id()) ? Session::get('cart' . Auth::id()) : null;
        $cart = new Cart($oldCart);
        $cart->add($productId);

        $request->session()->put('cart' . Auth::id(), $cart);
        return response()->json([
            'message' => 'add to cart',
            'user' => $cart,
        ]);
    }

    public function deleteProduct($productId)
    {
        $oldCart = Session::has('cart' . Auth::id()) ? Session::get('cart' . Auth::id()) : null;
        $cart = new Cart($oldCart);
        $cart->delete($productId);
        Session::put('cart' . Auth::id(), $cart);
        return response()->json([
            'message' => 'Product with ID = {$productId} removed from Cart',
            'cart' => $cart
        ]);
    }

    public function clearCart(Request $request)
    {
        $request->session()->forget('cart' . Auth::id());
        return 'Cart cleared';
    }
}
