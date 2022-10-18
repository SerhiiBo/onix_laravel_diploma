<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Cart extends Model
{
    public $items = null;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'product_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
