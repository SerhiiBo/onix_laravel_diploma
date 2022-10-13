<?php

namespace App\Models;

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

    static public function create($user, $order, $request)
    {
        $user_address = $user->address_city . ', ' . $user->address_street . ' ' . $user->address_house;
        $order->user_id = $user->id;
        $order->status = 'created';
        $order->comment = $request->comment;
        $order->address = $user_address;
        $order->save();

        $userCart = Session::get('cart' . Auth::id());
        foreach ($userCart->items as $item) {
            (new OrderItem)->addItem($order, $item);
        }

        $request->session()->forget('cart' . Auth::id());
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
