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
    ];

    static public function create($order, $request)
    {
        $user_address = $request->user()->address_city . ', ' . $request->user()->address_street . ' ' . $request->user()->address_house;
        $order->user_id = $request->user()->id;
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

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function order_items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
