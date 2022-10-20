<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::created(function (Review $review) {
            $avgRating = (integer) Review::where('product_id', $review->product_id)->avg('rating');
            $product = Product::firstWhere('id', $review->product_id);
            $product->update(['rating' => $avgRating]);
        });
    }

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
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
