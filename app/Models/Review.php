<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'rating',
        'product_id',
        'user_id',
    ];

    public function users()
    {
        return $this->hasOne(User::class);
    }

    public function products()
    {
        return $this->belongsTo(Product::class);
    }
}
