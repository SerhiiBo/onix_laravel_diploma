<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;


class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'in_stock',
        'price',
    ];

    public function scopeCategory_ids(Builder $query, $category_ids)
    {
        $category_ids = explode(',', trim($category_ids));
        return $query->whereHas('categories', function ($query) use ($category_ids) {
            $query->whereIn('id', $category_ids);
        })->with('categories');
    }

    public function scopeSortByRating(Builder $product)
    {
        return $product->orderBy('rating', 'DESC');
    }

    public function addCategory($product, $category)
    {
        return $product->categories()->sync(explode(",", $category));
    }

    public function product_images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * The categories that belong to the product.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_category');
    }
}
