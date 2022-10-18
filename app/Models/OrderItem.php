<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    public function addItem($order, $item)
    {
        $this->order_id = $order->id;
        $this->product_id = $item->product_id;
        $this->price = Product::find($item->product_id)->price;
        $this->quantity = $item->quantity;
        $this->save();
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
