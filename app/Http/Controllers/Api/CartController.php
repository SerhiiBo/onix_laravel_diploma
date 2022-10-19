<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function show(Request $request)
    {
        $this->authorize('view', Cart::class);
        $cart = Cart::where('user_id', $request->user()->id)->get();
        return $cart;
    }

    public function create(Request $request, $productId)
    {
        $this->authorize('create', Cart::class);
//        Узнаем сколько на складе продукта
        $in_stock = Product::find($productId)->in_stock;
//        Добавляем в корзину и уменьшаем количество на складе
        if ($request->quantity <= $in_stock) {
            $cart = Cart::updateOrCreate(
                ['user_id' => $request->user()->id, 'product_id' => $productId],
                ['quantity' => $request->quantity]
            );
            Product::find($productId)->decrement('in_stock', $request->quantity);
        } else {

            return "Quantity in stock is less. Available to order: {$in_stock}";
        }
        return $cart;
    }

    public function deleteProduct(Request $request, int $productId)
    {
        // находим корзину пользователя и удаляемый продукт
        $cart = Cart::where('user_id', $request->user()->id);
        $deleteProduct = $cart->where('product_id', $productId)->first();

        // Находим и уменьшаем количество данного продукта на складе
        $this->authorize('update', [Cart::class, $deleteProduct]);
        Product::find($productId)->increment('in_stock', $deleteProduct->quantity);

        // Удаляем продукт из корзины
        $cart->where('product_id', $productId)->delete();
        return 'Product deleted from cart';
    }

    public function destroy(Request $request)
    {
        $this->authorize('delete', Cart::class);
        $cart = Cart::where('user_id', $request->user()->id);

        foreach ($cart->get() as $cartItem) {
            Product::find($cartItem->product_id)->increment('in_stock', $cartItem->quantity);
        }
        $cart->delete();
        return 'Cart cleared';
    }
}
