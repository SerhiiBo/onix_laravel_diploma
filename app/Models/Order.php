<?php

namespace App\Models;

use App\Http\Controllers\Api\CartController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment',
        'status'
    ];

    static public function create($order, $request)
    {
        $user_address = auth()->user()->address_city . ', ' . auth()->user()->address_street . ' ' . auth()->user()->address_house;
        $order->user_id = auth()->user()->id;
        $order->status = 'created';
        $order->comment = $request->comment;
        $order->address = $user_address;
        $order->save();

        $userCart = Cart::where('user_id', $request->user()->id)->get();
        foreach ($userCart as $item) {
            (new OrderItem)->addItem($order, $item);
        }

        Cart::where('user_id', $request->user()->id)->delete();
    }

    public function totalPrice()
    {
        $orderItems = $this->order_items()->get();
        $totalPrice = 0;
        foreach ($orderItems as $orderItem) {
            $totalPrice += $orderItem->quantity * $orderItem->price;
        }
        return $totalPrice;
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function order_items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'order_items')
            ->withPivot('quantity', 'price');

    }
}
