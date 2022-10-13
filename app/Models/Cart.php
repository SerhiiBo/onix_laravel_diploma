<?php

namespace App\Models;


use Illuminate\Support\Facades\Auth;

class Cart
{
    public $items = null;

    public function __construct($oldCart)
    {
        if ($oldCart) {
            $this->items = $oldCart->items;
        }
    }

    public function add($productId)
    {
        $storedProduct = [
            'user_id' => Auth::id(),
            'product_id' => $productId,
            'quantity' => 0
        ];
        if ($this->items) {
            if (array_key_exists($productId, $this->items)) {
                $storedProduct = $this->items[$productId];
            }
        }
        $storedProduct['quantity']++;
        $this->items[$productId] = $storedProduct;
    }

    public function delete($productId)
    {
        if ($this->items) {
            if (array_key_exists($productId, $this->items)) {
                unset($this->items[$productId]);
            }
        }
    }
}
