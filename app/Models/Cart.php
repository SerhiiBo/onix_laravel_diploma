<?php

namespace App\Models;


use Illuminate\Support\Facades\Auth;

class Cart
{
    public $cartProducts = null;

    public function __construct($oldCart)
    {
        if ($oldCart) {
            $this->cartProducts = $oldCart->cartProducts;
        }
    }

    public function add($productId)
    {
        $storedProduct = [
            'user_id' => Auth::id(),
            'product_id' => $productId,
            'quantity' => 0
        ];
        if ($this->cartProducts) {
            if (array_key_exists($productId, $this->cartProducts)) {
                $storedProduct = $this->cartProducts[$productId];
            }
        }
        $storedProduct['quantity']++;
        $this->cartProducts[$productId] = $storedProduct;
    }

    public function delete($productId)
    {
        if ($this->cartProducts) {
            if (array_key_exists($productId, $this->cartProducts)) {
                unset($this->cartProducts[$productId]);
            }
        }
    }
}
